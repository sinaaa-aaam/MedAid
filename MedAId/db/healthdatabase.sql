-- Drop dependent tables first
DROP TABLE IF EXISTS health_metrics;
DROP TABLE IF EXISTS reminders;
DROP TABLE IF EXISTS user_settings;
DROP TABLE IF EXISTS predictions;

-- Drop the `users` table
DROP TABLE IF EXISTS users;

-- Recreate the `users` table with health-related information
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    age INT NOT NULL CHECK(age >= 1 AND age <= 120),
    gender ENUM('male', 'female', 'other') NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    user_role ENUM('superadmin', 'regular') DEFAULT 'regular',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Recreate the `health_metrics` table to store health data like steps, sleep, heart rate, and calories
CREATE TABLE health_metrics (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    steps INT,
    sleep INT,
    heart_rate INT,
    calories INT,
    date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);




-- Recreate the `reminders` table to store health-related reminders (e.g., medication)
CREATE TABLE reminders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    reminder_time TIME,
    reminder_type VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Recreate the `user_settings` table to store preferences (e.g., units of measurement)
CREATE TABLE user_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    units VARCHAR(20) DEFAULT 'metric',
    goal VARCHAR(100),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Recreate the `predictions` table to store health risk predictions
CREATE TABLE predictions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    prediction_type VARCHAR(100),
    risk_level VARCHAR(50),
    advice VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
