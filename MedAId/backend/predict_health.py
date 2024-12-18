import sys
import pickle
import numpy as np

# Load the model
with open('health_risk_model.pkl', 'rb') as f:
    model = pickle.load(f)

# Accept input from PHP
age = int(sys.argv[1])
gender = int(sys.argv[2])  # Male=0, Female=1
steps = int(sys.argv[3])
sleep = int(sys.argv[4])
heart_rate = int(sys.argv[5])
calories = int(sys.argv[6])

# Create input array
input_features = np.array([[age, gender, steps, sleep, heart_rate, calories]])

# Predict
risk_prediction = model.predict(input_features)[0]

# Risk Level Mapping
risk_map = {0: "Low", 1: "Moderate", 2: "High"}
advice_map = {
    0: "Keep up the good work! Maintain your activity and healthy lifestyle.",
    1: "You're doing okay, but try to improve your sleep and increase activity.",
    2: "High risk! Consult a health professional, and focus on exercise and balanced nutrition."
}

# Output Prediction and Advice
print(f"{risk_map[risk_prediction]}|{advice_map[risk_prediction]}")
