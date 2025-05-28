from flask import Flask
from flask_cors import CORS
import os
from dotenv import load_dotenv

# Load environment variables
load_dotenv()

# Initialize Flask app
app = Flask(__name__)
CORS(app)

# Configuration
UPLOAD_FOLDER = os.path.join(os.path.dirname(os.path.abspath(__file__)), "uploads")
app.config['UPLOAD_FOLDER'] = UPLOAD_FOLDER

# Create uploads directory if it doesn't exist
os.makedirs(UPLOAD_FOLDER, exist_ok=True)

# Import utilities after app is created - this avoids circular imports
from utils import register_routes, setup_error_handlers, init_supabase

# Initialize Supabase client
init_supabase()

# Register API routes
register_routes(app)

# Setup error handlers
setup_error_handlers(app)

# Run app
if __name__ == "__main__":
    app.run(debug=os.getenv("FLASK_DEBUG", "True") == "True",
            host=os.getenv("FLASK_HOST", "0.0.0.0"),
            port=int(os.getenv("FLASK_PORT", 5000)))
