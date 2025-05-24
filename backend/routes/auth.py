from flask import Blueprint, request, jsonify
import sys
import os
import uuid
sys.path.append(os.path.dirname(os.path.dirname(os.path.abspath(__file__))))
from utils import init_supabase, generate_token, hash_password, verify_password

# Get Supabase client
supabase = init_supabase()

auth_bp = Blueprint('auth', __name__)

@auth_bp.route('/register', methods=['POST'])
def register():
    data = request.json
    
    # Validate required fields
    required_fields = ['email', 'password', 'name']
    for field in required_fields:
        if field not in data:
            return jsonify({'error': f'{field} is required'}), 400
    
    # Check if user already exists
    existing_user = supabase.table('users').select('*').eq('email', data['email']).execute()
    if existing_user.data:
        return jsonify({'error': 'User with this email already exists'}), 400
    
    # Hash password
    hashed_password = hash_password(data['password'])
    
    # Create user
    new_user = {
        'email': data['email'],
        'password': hashed_password,
        'name': data['name'],
        'role': 'user'  # Default role
    }
    
    # Insert user into database
    result = supabase.table('users').insert(new_user).execute()
    
    if not result.data:
        return jsonify({'error': 'Failed to create user'}), 500
    
    user = result.data[0]
    
    # Generate JWT token
    token = generate_token(user['id'], user['role'])
    
    return jsonify({
        'message': 'User registered successfully',
        'user': {
            'id': user['id'],
            'email': user['email'],
            'name': user['name'],
            'role': user['role']
        },
        'token': token
    }), 201

@auth_bp.route('/login', methods=['POST'])
def login():
    data = request.json
    
    # Validate required fields
    if 'email' not in data or 'password' not in data:
        return jsonify({'error': 'Email and password are required'}), 400
    
    # Find user by email
    result = supabase.table('users').select('*').eq('email', data['email']).execute()
    
    if not result.data:
        return jsonify({'error': 'Invalid credentials'}), 401
    
    user = result.data[0]
    
    # Verify password
    if not verify_password(user['password'], data['password']):
        return jsonify({'error': 'Invalid credentials'}), 401
    
    # Generate JWT token
    token = generate_token(user['id'], user['role'])
    
    # Store token in user_tokens table
    supabase.table('user_tokens').insert({
        'user_id': user['id'],
        'token': token
    }).execute()
    
    return jsonify({
        'success': True,
        'message': 'Login successful',
        'user': {
            'id': user['id'],
            'email': user['email'],
            'name': user['name'],
            'role': user['role']
        },
        'token': token
    }), 200

@auth_bp.route('/logout', methods=['POST'])
def logout():
    auth_header = request.headers.get('Authorization')
    if not auth_header or not auth_header.startswith('Bearer '):
        return jsonify({'message': 'Already logged out'}), 200
    
    token = auth_header.split(' ')[1]
    
    # Delete token from user_tokens table
    supabase.table('user_tokens').delete().eq('token', token).execute()
    
    return jsonify({'message': 'Logout successful'}), 200
