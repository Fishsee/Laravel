import requests
import pandas as pd
import numpy as np
from scipy.optimize import curve_fit
import json

url = 'http://fishsee.test/api/get-data'
response = requests.get(url)
data = response.json()

df = pd.DataFrame(data)

column_names = ['acidity', 'turbidity']

def linear_model(x, a, b):
    return a * x + b

def exponential_model(x, a, b):
    return a * np.exp(b * x)

margin = 0.5

predicted_values = {}

for column_name in column_names:
    y = df[column_name].values
    x = np.arange(len(y))

    linear_params, _ = curve_fit(linear_model, x, y)
    y_linear_pred = linear_model(x, *linear_params)

    residuals = np.abs(y - y_linear_pred)
    within_margin = np.all(residuals <= margin)

    if within_margin:
        correlation_type = "linear"
        best_params = linear_params
        print(f"The data for {column_name} shows a linear correlation within the margin.")
    else:
        exponential_params, _ = curve_fit(exponential_model, x, y)
        y_exponential_pred = exponential_model(x, *exponential_params)

        r_squared_linear = 1
        r_squared_exponential = calculate_r_squared(y, y_exponential_pred)

        correlation_type = "exponential"
        best_params = exponential_params
        print(f"The data for {column_name} shows an exponential correlation.")

    future_x = np.arange(len(y), len(y) + 10)
    if correlation_type == "linear":
        future_y_pred = linear_model(future_x, *best_params)
    else:
        future_y_pred = exponential_model(future_x, *best_params)

    predicted_values[column_name] = list(future_y_pred)

feedback_url = 'http://fishsee.test/predicted-values'
feedback_data = json.dumps(predicted_values)
headers = {'Content-Type': 'application/json'}
response = requests.post(feedback_url, data=feedback_data, headers=headers)
print("Feedback sent to the Laravel application.")