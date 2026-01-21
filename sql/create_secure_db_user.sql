-- Create Least-Privilege Database User for Secure Version
-- This script creates a restricted user that can only SELECT, INSERT, UPDATE
-- Even if SQL injection occurs, DROP TABLE and other destructive commands will fail

-- Run as root user:
-- mysql -u root < create_secure_db_user.sql

-- Create the limited user
CREATE USER IF NOT EXISTS 'alkicorp_app'@'localhost' IDENTIFIED BY 'secure_password_here';

-- Grant only necessary permissions (NO DELETE for extra safety, or add it if needed)
GRANT SELECT, INSERT, UPDATE ON alkicorp.* TO 'alkicorp_app'@'localhost';

-- Apply changes
FLUSH PRIVILEGES;

-- Verify permissions
SHOW GRANTS FOR 'alkicorp_app'@'localhost';
