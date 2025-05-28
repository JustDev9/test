# Pawfect Flask Backend

This Flask application serves as the backend for the Pawfect pet adoption platform, connecting to a Supabase database.

## Setup Instructions

### Prerequisites
- Python 3.8+ installed
- Supabase account and project set up with the schema from `supabase_schema.sql`

### Installation

1. Create a virtual environment:
   ```
   python -m venv venv
   ```

2. Activate the virtual environment:
   - Windows: `venv\Scripts\activate`
   - MacOS/Linux: `source venv/bin/activate`

3. Install dependencies:
```

### Step 2: Set Up Python Virtual Environment

#### Windows
```bash
python -m venv venv
venv\Scripts\activate
```

#### macOS/Linux
```bash
python3 -m venv venv
source venv/bin/activate
```

### Step 3: Install Dependencies

```bash
pip install -r requirements.txt
```

The main dependencies include:
- Flask - Web framework
- Flask-CORS - Cross-Origin Resource Sharing
- supabase-py - Supabase Python client
- python-dotenv - Environment variable management
- PyJWT - JSON Web Token implementation
- bcrypt - Password hashing

### Step 4: Running the Backend

1. **Make sure you're in the backend directory**:
   ```bash
   cd path/to/backend
   ```

2. **Start the Flask development server**:
   ```bash
   python app.py
   ```
   On Windows PowerShell, you may need to use:
   ```powershell
   cd e:\test\backend; python app.py
   ```

3. **Verify the server is running**:
   - You should see output indicating the server is running on http://127.0.0.1:5000
   - The Flask debug mode is enabled by default
   - You can test the API by visiting http://127.0.0.1:5000/api/health in your browser

4. **Troubleshooting**:
   - If you encounter "No module found" errors, make sure your virtual environment is activated
   - If you get port conflicts, modify the port in your .env file
   - For database connection issues, verify your Supabase credentials in the .env file
- Werkzeug - WSGI utilities

### Step 4: Set Up Supabase

1. Create a Supabase account at [https://supabase.com](https://supabase.com)
2. Create a new project
3. Get your Supabase URL and API keys from the project dashboard (Project Settings → API)
4. Run the SQL schema in the Supabase SQL Editor:
   - Open `supabase_schema.sql` from this repository
   - Copy and run the SQL statements in the Supabase SQL Editor

### Step 5: Configure Environment Variables

Create a `.env` file in the backend directory with the following variables:

```
# Flask configuration
FLASK_DEBUG=True
FLASK_HOST=0.0.0.0
FLASK_PORT=5000

# Supabase configuration
SUPABASE_URL=https://your-project-id.supabase.co
# Use the service_role key from your Supabase dashboard
SUPABASE_KEY=your-supabase-service-role-key

# Security
SECRET_KEY=your-secret-key-for-jwt
```

**Important Security Notes:**
- For development, using the service_role key allows bypassing RLS (Row Level Security)
- For production, implement proper RLS policies and use the anon key
- Generate a strong SECRET_KEY (you can use `python -c "import secrets; print(secrets.token_hex(32))"`)  

### Step 6: Run the Application

```bash
python app.py
```

The server will start at `http://localhost:5000`

### Step 7: Verify Setup

Test the API using a tool like Postman, curl, or the frontend application:

```bash
curl http://localhost:5000/api/health
```

You should receive a JSON response indicating the API is running.

## API Endpoints

### Authentication
- `POST /api/auth/register` - Register a new user
- `POST /api/auth/login` - Login a user
- `POST /api/auth/logout` - Logout a user

### Pets
- `GET /api/pets` - Get all pets
- `GET /api/pets/:id` - Get a specific pet
- `POST /api/pets` - Create a new pet (admin only)
- `PUT /api/pets/:id` - Update a pet (admin only)
- `DELETE /api/pets/:id` - Delete a pet (admin only)

### Applications
- `GET /api/applications` - Get all applications (admin only)
- `GET /api/applications/:id` - Get a specific application
- `POST /api/applications` - Create a new application
- `PUT /api/applications/:id/status` - Update application status (admin only)

### Profile
- `GET /api/profile` - Get user profile
- `PUT /api/profile` - Update user profile
- `PUT /api/profile/password` - Update user password

## Project Structure

```
backend/
├── app.py              # Main application file
├── utils.py            # Utility functions and services
├── .env                # Environment variables
├── requirements.txt    # Dependencies
├── supabase_schema.sql # Database schema for Supabase
├── routes/
│   ├── __init__.py
│   ├── auth.py         # Authentication routes
│   ├── pets.py         # Pet management routes
│   ├── applications.py # Application management routes
│   └── profile.py      # User profile routes
```

## Troubleshooting

### Common Issues

1. **Circular Import Errors**
   - Solution: Ensure you're importing from the utils module properly
   - Check app.py and route files for circular dependencies

2. **Row Level Security (RLS) Errors**
   - Solution: Use the service_role key or properly set up RLS policies
   - Verify that RLS policies match your application needs

3. **JWT Token Size Issues**
   - Solution: Ensure the token field in the user_tokens table is VARCHAR(500)
   - Check for token validation errors in the logs

4. **CORS Errors**
   - Solution: Verify the CORS configuration in app.py
   - Ensure frontend and backend origins are correctly set up

## Security

This application uses JWT tokens for authentication. Best practices:

1. Use HTTPS in production
2. Keep your SECRET_KEY secure and unique
3. Store the .env file outside of version control
4. Regularly rotate your JWT secret key
5. Implement proper token expiration and refresh logic

## Deployment

For production deployment, consider using Gunicorn as a WSGI server:

```bash
pip install gunicorn
gunicorn -w 4 -b 0.0.0.0:5000 app:app
```

For a more robust setup, consider using a process manager like Supervisor and a reverse proxy like Nginx.

## Development and Contributing

1. Create a feature branch
2. Make your changes
3. Write or update tests
4. Submit a pull request

## License

This project is licensed under the MIT License - see the LICENSE file for details.
