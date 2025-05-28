from flask import Blueprint, request, jsonify
import sys
import os
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from utils import init_supabase, token_required, admin_required, allowed_file
from werkzeug.utils import secure_filename
import uuid

# Get Supabase client
supabase = init_supabase()

# Get upload folder
UPLOAD_FOLDER = os.path.join(os.path.dirname(os.path.dirname(os.path.abspath(__file__))), "uploads")

pets_bp = Blueprint('pets', __name__)

@pets_bp.route('/', methods=['GET'])
def get_pets():
    # Get query parameters
    status = request.args.get('status')
    type = request.args.get('type')
    breed = request.args.get('breed')
    
    # Build query
    query = supabase.table('pets').select('*')
    
    # Apply filters if provided
    if status:
        query = query.eq('status', status)
    if type:
        query = query.eq('type', type)
    if breed:
        query = query.ilike('breed', f'%{breed}%')
    
    # Execute query
    result = query.order('created_at', desc=True).execute()
    
    return jsonify({
        'pets': result.data
    }), 200

@pets_bp.route('/<uuid:pet_id>', methods=['GET'])
def get_pet(pet_id):
    result = supabase.table('pets').select('*').eq('id', pet_id).execute()
    
    if not result.data:
        return jsonify({'error': 'Pet not found'}), 404
    
    return jsonify({
        'pet': result.data[0]
    }), 200

@pets_bp.route('/', methods=['POST'])
@token_required
@admin_required
def create_pet():
    data = request.form.to_dict()
    
    # Validate required fields
    required_fields = ['name', 'type', 'breed', 'age', 'description', 'status']
    for field in required_fields:
        if field not in data:
            return jsonify({'error': f'{field} is required'}), 400
    
    # Handle photo upload
    photo_url = None
    if 'photo' in request.files:
        photo = request.files['photo']
        
        if photo and allowed_file(photo.filename):
            # Generate unique filename
            filename = secure_filename(photo.filename)
            unique_filename = f"{uuid.uuid4()}_{filename}"
            file_path = os.path.join(UPLOAD_FOLDER, unique_filename)
            
            # Save file
            photo.save(file_path)
            
            # Set photo URL
            photo_url = f"/uploads/{unique_filename}"
    
    # Create pet object
    new_pet = {
        'name': data['name'],
        'type': data['type'],
        'breed': data['breed'],
        'age': int(data['age']),
        'description': data['description'],
        'status': data['status']
    }
    
    if photo_url:
        new_pet['photo'] = photo_url
    
    # Insert pet into database
    result = supabase.table('pets').insert(new_pet).execute()
    
    if not result.data:
        return jsonify({'error': 'Failed to create pet'}), 500
    
    return jsonify({
        'message': 'Pet created successfully',
        'pet': result.data[0]
    }), 201

@pets_bp.route('/<uuid:pet_id>', methods=['PUT'])
@token_required
@admin_required
def update_pet(pet_id):
    data = request.form.to_dict()
    
    # Check if pet exists
    pet_check = supabase.table('pets').select('*').eq('id', pet_id).execute()
    if not pet_check.data:
        return jsonify({'error': 'Pet not found'}), 404
    
    # Create update object
    update_data = {}
    
    # Update only provided fields
    updatable_fields = ['name', 'type', 'breed', 'age', 'description', 'status']
    for field in updatable_fields:
        if field in data:
            if field == 'age':
                update_data[field] = int(data[field])
            else:
                update_data[field] = data[field]
    
    # Handle photo upload
    if 'photo' in request.files:
        photo = request.files['photo']
        
        if photo and allowed_file(photo.filename):
            # Generate unique filename
            filename = secure_filename(photo.filename)
            unique_filename = f"{uuid.uuid4()}_{filename}"
            file_path = os.path.join(UPLOAD_FOLDER, unique_filename)
            
            # Save file
            photo.save(file_path)
            
            # Set photo URL
            update_data['photo'] = f"/uploads/{unique_filename}"
    
    # Update pet in database
    result = supabase.table('pets').update(update_data).eq('id', pet_id).execute()
    
    if not result.data:
        return jsonify({'error': 'Failed to update pet'}), 500
    
    return jsonify({
        'message': 'Pet updated successfully',
        'pet': result.data[0]
    }), 200

@pets_bp.route('/<uuid:pet_id>', methods=['DELETE'])
@token_required
@admin_required
def delete_pet(pet_id):
    # Check if pet exists
    pet_check = supabase.table('pets').select('*').eq('id', pet_id).execute()
    if not pet_check.data:
        return jsonify({'error': 'Pet not found'}), 404
    
    # Delete pet from database
    result = supabase.table('pets').delete().eq('id', pet_id).execute()
    
    return jsonify({
        'message': 'Pet deleted successfully'
    }), 200
