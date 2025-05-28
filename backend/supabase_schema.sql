-- Supabase Schema for Pawfect Application

-- Enable UUID extension
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Create custom types
CREATE TYPE user_role AS ENUM ('user', 'admin');
CREATE TYPE pet_type AS ENUM ('Dog', 'Cat', 'Bird', 'Other');
CREATE TYPE pet_status AS ENUM ('Available', 'Pending', 'Adopted');
CREATE TYPE application_status AS ENUM ('Pending', 'Approved', 'Rejected');

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(100) NOT NULL,
    role user_role DEFAULT 'user',
    created_at TIMESTAMPTZ DEFAULT NOW(),
    updated_at TIMESTAMPTZ DEFAULT NOW()
);

-- Enable Row Level Security
ALTER TABLE users ENABLE ROW LEVEL SECURITY;

-- Create policies for users
CREATE POLICY "Users can view their own data" ON users
    FOR SELECT USING (auth.uid() = id);
    
CREATE POLICY "Admin can view all user data" ON users
    FOR SELECT USING (auth.jwt() ->> 'role' = 'admin');
    
CREATE POLICY "Allow insert to users" ON users
    FOR INSERT WITH CHECK (true);
    
CREATE POLICY "Users can update their own data" ON users
    FOR UPDATE USING (auth.uid() = id);
    
CREATE POLICY "Admin can update all user data" ON users
    FOR UPDATE USING (auth.jwt() ->> 'role' = 'admin');
    
CREATE POLICY "Users can delete their own data" ON users
    FOR DELETE USING (auth.uid() = id);
    
CREATE POLICY "Admin can delete all user data" ON users
    FOR DELETE USING (auth.jwt() ->> 'role' = 'admin');

-- Create user_tokens table for session management
CREATE TABLE IF NOT EXISTS user_tokens (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    user_id UUID NOT NULL,
    token VARCHAR(500) NOT NULL UNIQUE,
    created_at TIMESTAMPTZ DEFAULT NOW(),
    expires_at TIMESTAMPTZ DEFAULT (NOW() + INTERVAL '24 hours'),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create index for faster token lookups
CREATE INDEX idx_token ON user_tokens(token);

-- Enable Row Level Security
ALTER TABLE user_tokens ENABLE ROW LEVEL SECURITY;

-- Create pets table
CREATE TABLE IF NOT EXISTS pets (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type pet_type NOT NULL,
    breed VARCHAR(100) NOT NULL,
    age INT NOT NULL,
    description TEXT NOT NULL,
    status pet_status NOT NULL DEFAULT 'Available',
    photo VARCHAR(255),
    created_at TIMESTAMPTZ DEFAULT NOW(),
    updated_at TIMESTAMPTZ DEFAULT NOW()
);

-- Enable Row Level Security
ALTER TABLE pets ENABLE ROW LEVEL SECURITY;

-- Create policy for pets
CREATE POLICY "Anyone can view available pets" ON pets
    FOR SELECT USING (true);
    
CREATE POLICY "Admin can manage pets" ON pets
    USING (auth.jwt() ->> 'role' = 'admin');

-- Create adoption_applications table
CREATE TABLE IF NOT EXISTS adoption_applications (
    id UUID DEFAULT uuid_generate_v4() PRIMARY KEY,
    pet_id UUID NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    address TEXT NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    notes TEXT,
    status application_status DEFAULT 'Pending',
    created_at TIMESTAMPTZ DEFAULT NOW(),
    FOREIGN KEY (pet_id) REFERENCES pets(id)
);

-- Enable Row Level Security
ALTER TABLE adoption_applications ENABLE ROW LEVEL SECURITY;

-- Create policy for applications
CREATE POLICY "Users can view their own applications" ON adoption_applications
    FOR SELECT USING (email = auth.jwt() ->> 'email');
    
CREATE POLICY "Admin can manage all applications" ON adoption_applications
    USING (auth.jwt() ->> 'role' = 'admin');

-- Create function to handle updated_at timestamps
CREATE OR REPLACE FUNCTION handle_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = NOW();
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

-- Create triggers for updated_at
CREATE TRIGGER users_updated_at
BEFORE UPDATE ON users
FOR EACH ROW
EXECUTE FUNCTION handle_updated_at();

CREATE TRIGGER pets_updated_at
BEFORE UPDATE ON pets
FOR EACH ROW
EXECUTE FUNCTION handle_updated_at();

-- Insert a test admin user (password: admin123)
-- Note: In production, you should use Supabase Auth instead of storing passwords
INSERT INTO users (email, password, name, role)
VALUES ('admin@pawfect.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin User', 'admin')
ON CONFLICT (email) DO NOTHING;
