import os
import jwt
import uuid
import bcrypt
import datetime
from flask import request, jsonify
from supabase import create_client, Client
from werkzeug.utils import secure_filename

# Configure Supabase
supabase_url = os.getenv("SUPABASE_URL")
supabase_key = os.getenv("SUPABASE_KEY")
supabase = None

# Initialize Supabase client
def init_supabase():
    global supabase
    if supabase is None and supabase_url and supabase_key:
        supabase = create_client(supabase_url, supabase_key)
    return supabase

# File handling utilities
ALLOWED_EXTENSIONS = {'png', 'jpg', 'jpeg', 'gif'}
def allowed_file(filename):
    return '.' in filename and filename.rsplit('.', 1)[1].lower() in ALLOWED_EXTENSIONS

# Authentication utilities
SECRET_KEY = os.getenv("SECRET_KEY", "your_secret_key")

def generate_token(user_id, role):
    payload = {
        'user_id': user_id,
        'role': role,
        'exp': datetime.datetime.utcnow() + datetime.timedelta(days=1)
    }
    return jwt.encode(payload, SECRET_KEY, algorithm='HS256')

def hash_password(password):
    return bcrypt.hashpw(password.encode('utf-8'), bcrypt.gensalt()).decode('utf-8')

def verify_password(stored_password, provided_password):
    return bcrypt.checkpw(provided_password.encode('utf-8'), stored_password.encode('utf-8'))

# Authentication decorators
def token_required(f):
    from functools import wraps
    @wraps(f)
    def decorated(*args, **kwargs):
        token = None
        
        # Get token from header
        if 'Authorization' in request.headers:
            auth_header = request.headers['Authorization']
            if auth_header.startswith('Bearer '):
                token = auth_header.split(' ')[1]
        
        if not token:
            return jsonify({'message': 'Token is missing!'}), 401
        
        try:
            # Decode token
            payload = jwt.decode(token, SECRET_KEY, algorithms=['HS256'])
            # Get user from database
            client = init_supabase()
            user = client.table('users').select('*').eq('id', payload['user_id']).execute()
            
            if not user.data:
                return jsonify({'message': 'Invalid token!'}), 401
                
            # Set current user
            request.user = user.data[0]
            request.user_role = payload['role']
            
        except Exception as e:
            return jsonify({'message': 'Invalid token!', 'error': str(e)}), 401
            
        return f(*args, **kwargs)
    return decorated

def admin_required(f):
    from functools import wraps
    @wraps(f)
    def decorated(*args, **kwargs):
        if not hasattr(request, 'user_role') or request.user_role != 'admin':
            return jsonify({'message': 'Admin privileges required!'}), 403
        return f(*args, **kwargs)
    return decorated

# Route registration
def register_routes(app):
    from routes.auth import auth_bp
    from routes.pets import pets_bp
    from routes.applications import applications_bp
    from routes.profile import profile_bp
    
    # Root route
    @app.route('/')
    def index():
        return jsonify({"message": "Welcome to Pawfect API"})
    
    # Register blueprints
    app.register_blueprint(auth_bp, url_prefix='/api/auth')
    app.register_blueprint(pets_bp, url_prefix='/api/pets')
    app.register_blueprint(applications_bp, url_prefix='/api/applications')
    app.register_blueprint(profile_bp, url_prefix='/api/profile')

# Error handlers
def setup_error_handlers(app):
    @app.errorhandler(404)
    def not_found(e):
        return jsonify({"error": "Not found"}), 404

    @app.errorhandler(500)
    def server_error(e):
        return jsonify({"error": "Server error", "message": str(e)}), 500
