# AI-Powered Personal Health Assistant

## Overview
The **AI-Powered Personal Health Assistant** is a web-based application designed to help users monitor their health metrics, receive personalized insights, and track potential health risks. This project integrates PHP for backend operations, a responsive frontend, and machine learning for basic predictions, ensuring users can manage their health goals effectively.  

---

## Features
### 1. **User Authentication**
   - Secure user registration and login system.
   - Passwords are hashed for safety using PHP's `password_hash()` function.
   - Session-based authentication for user authorization.  

### 2. **Data Collection**
   - Users can manually input health metrics such as:
     - **Steps** (daily step count)
     - **Sleep** (hours of sleep)
     - **Heart Rate** (beats per minute)
     - **Calories** (calories consumed or burned)
   - All data is stored with timestamps for historical analysis.

### 3. **Personalized Insights**
   - Tailored health advice provided based on user data patterns.
   - Advice is dynamically selected from a predefined dataset to mimic AI behavior.

### 4. **Health Risk Predictions**
   - Basic predictions for potential health risks (e.g., "Hypertension" or "Diabetes") with categorized risk levels such as "Low", "Medium", or "High".
   - Predictions are generated using a lightweight ML model.

### 5. **Reminders and Recommendations**
   - Users can schedule reminders for activities such as:
     - Hydration
     - Exercise
     - Sleep
   - Personalized recommendations to improve health habits.

### 6. **User Preferences**
   - Users can set preferences for:
     - Measurement units (metric or imperial).
     - Health goals (e.g., "Lose Weight", "Increase Steps").

---

## Tech Stack
- **Frontend**: HTML, CSS, JavaScript (or React for dynamic interactivity).
- **Backend**: PHP (CRUD operations and logic).
- **Database**: MySQL (data storage and relationships).
- **Machine Learning**: Lightweight models built with scikit-learn/TensorFlow/Keras.
- **Deployment**: XAMPP (local development) or FileZilla (live deployment).

---
