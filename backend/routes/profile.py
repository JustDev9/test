from flask import Blueprint, request, jsonify
import sys
import os
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from utils import init_supabase, token_required, hash_password, verify_password

# Get Supabase client
supabase = init_supabase()

profile_bp = Blueprint('profile', __name__)

@profile_bp.route('/', methods=['GET'])
@token_required
def get_profile():
    # User data is already set in the token_required decorator
    return jsonify({
        'user': {
            'id': request.user['id'],
            'email': request.user['email'],
            'name': request.user['name'],
            'role': request.user['role']
        }
    }), 200

@profile_bp.route('/', methods=['PUT'])
@token_required
def update_profile():
    data = request.json
    
    # Create update object
    update_data = {}
    
    # Update name if provided
    if 'name' in data:
        update_data['name'] = data['name']
    
    # Update email if provided
    if 'email' in data and data['email'] != request.user['email']:
        # Check if email is already taken
        existing_user = supabase.table('users').select('*').eq('email', data['email']).execute()
        if existing_user.data:
            return jsonify({'error': 'Email is already taken'}), 400
        
        update_data['email'] = data['email']
    
    # Check if there's anything to update
    if not update_data:
        return jsonify({'message': 'No changes provided'}), 400
    
    # Update user in database
    result = supabase.table('users').update(update_data).eq('id', request.user['id']).execute()
    
    if not result.data:
        return jsonify({'error': 'Failed to update profile'}), 500
    
    return jsonify({
        'message': 'Profile updated successfully',
        'user': {
            'id': result.data[0]['id'],
            'email': result.data[0]['email'],
            'name': result.data[0]['name'],
            'role': result.data[0]['role']
        }
    }), 200

@profile_bp.route('/password', methods=['PUT'])
@token_required
def update_password():
    data = request.json
    
    # Validate required fields
    required_fields = ['current_password', 'new_password']
    for field in required_fields:
        if field not in data:
            return jsonify({'error': f'{field} is required'}), 400
    
    # Verify current password
    if not verify_password(request.user['password'], data['current_password']):
        return jsonify({'error': 'Current password is incorrect'}), 400
    
    # Hash new password
    hashed_password = hash_password(data['new_password'])
    
    # Update password in database
    result = supabase.table('users').update({
        'password': hashed_password
    }).eq('id', request.user['id']).execute()
    
    if not result.data:
        return jsonify({'error': 'Failed to update password'}), 500
    
    return jsonify({
        'message': 'Password updated successfully'
    }), 200
