from flask import Blueprint, request, jsonify
import sys
import os
import uuid
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from utils import init_supabase, token_required, admin_required

# Get Supabase client
supabase = init_supabase()

applications_bp = Blueprint('applications', __name__)

@applications_bp.route('/', methods=['GET'])
@token_required
def get_applications():
    # Admin can see all applications, users can only see their own
    if request.user_role == 'admin':
        result = supabase.table('adoption_applications').select('*').execute()
    else:
        result = supabase.table('adoption_applications').select('*').eq('email', request.user['email']).execute()
    
    return jsonify({
        'applications': result.data
    }), 200

@applications_bp.route('/<uuid:application_id>', methods=['GET'])
@token_required
def get_application(application_id):
    # Get application
    result = supabase.table('adoption_applications').select('*').eq('id', application_id).execute()
    
    if not result.data:
        return jsonify({'error': 'Application not found'}), 404
    
    application = result.data[0]
    
    # Check permissions (admin can see all, users can only see their own)
    if request.user_role != 'admin' and application['email'] != request.user['email']:
        return jsonify({'error': 'Unauthorized'}), 403
    
    return jsonify({
        'application': application
    }), 200

@applications_bp.route('/', methods=['POST'])
@token_required
def create_application():
    data = request.json
    
    # Validate required fields
    required_fields = ['pet_id', 'full_name', 'email', 'phone', 'address', 'appointment_date', 'appointment_time']
    for field in required_fields:
        if field not in data:
            return jsonify({'error': f'{field} is required'}), 400
    
    # Verify pet exists
    pet_check = supabase.table('pets').select('*').eq('id', data['pet_id']).execute()
    if not pet_check.data:
        return jsonify({'error': 'Pet not found'}), 404
    
    # Create application object
    new_application = {
        'pet_id': data['pet_id'],
        'full_name': data['full_name'],
        'email': data['email'],
        'phone': data['phone'],
        'address': data['address'],
        'appointment_date': data['appointment_date'],
        'appointment_time': data['appointment_time'],
        'notes': data.get('notes', ''),
        'status': 'Pending'  # Default status
    }
    
    # Insert application into database
    result = supabase.table('adoption_applications').insert(new_application).execute()
    
    if not result.data:
        return jsonify({'error': 'Failed to create application'}), 500
    
    # Update pet status to pending
    supabase.table('pets').update({'status': 'Pending'}).eq('id', data['pet_id']).execute()
    
    return jsonify({
        'message': 'Application submitted successfully',
        'application': result.data[0]
    }), 201

@applications_bp.route('/<uuid:application_id>/status', methods=['PUT'])
@token_required
@admin_required
def update_application_status(application_id):
    data = request.json
    
    # Validate required fields
    if 'status' not in data:
        return jsonify({'error': 'Status is required'}), 400
    
    # Check if application exists
    app_check = supabase.table('adoption_applications').select('*').eq('id', application_id).execute()
    if not app_check.data:
        return jsonify({'error': 'Application not found'}), 404
    
    application = app_check.data[0]
    new_status = data['status']
    
    # Update application status
    result = supabase.table('adoption_applications').update({
        'status': new_status
    }).eq('id', application_id).execute()
    
    # Update pet status based on application status
    pet_id = application['pet_id']
    if new_status == 'Approved':
        supabase.table('pets').update({'status': 'Adopted'}).eq('id', pet_id).execute()
    elif new_status == 'Rejected':
        # Check if there are other pending applications for this pet
        other_pending = supabase.table('adoption_applications').select('count').eq('pet_id', pet_id).eq('status', 'Pending').not_.eq('id', application_id).execute()
        
        if other_pending.count == 0:
            # If no other pending applications, set pet status back to Available
            supabase.table('pets').update({'status': 'Available'}).eq('id', pet_id).execute()
    
    return jsonify({
        'message': 'Application status updated successfully',
        'application': result.data[0]
    }), 200
