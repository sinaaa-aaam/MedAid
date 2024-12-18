import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.ensemble import RandomForestClassifier
from sklearn.metrics import accuracy_score
import pickle

# Mock dataset for demonstration
data = {
    'age': [25, 45, 35, 60, 50],
    'gender': [0, 1, 1, 0, 0],  # male=0, female=1
    'steps': [10000, 2000, 5000, 3000, 4000],
    'sleep': [7, 5, 6, 4, 8],
    'heart_rate': [70, 90, 80, 100, 85],
    'calories': [2500, 1500, 2000, 1800, 1600],
    'risk_level': [0, 2, 1, 2, 0]  # 0=Low, 1=Moderate, 2=High
}

# Create DataFrame
df = pd.DataFrame(data)

# Features and target
X = df.drop(columns=['risk_level'])
y = df['risk_level']

# Train-Test Split
X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

# Model Training
model = RandomForestClassifier()
model.fit(X_train, y_train)

# Evaluate Model
y_pred = model.predict(X_test)
print("Model Accuracy:", accuracy_score(y_test, y_pred))

# Save the Model
with open('health_risk_model.pkl', 'wb') as f:
    pickle.dump(model, f)
