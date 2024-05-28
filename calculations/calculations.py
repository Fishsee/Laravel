import requests
import pandas as pd
import numpy as np
from scipy.optimize import curve_fit
import json

def fetch_data(url):
    try:
        response = requests.get(url)
        response.raise_for_status()
        data = response.json()
        return data
    except requests.RequestException as e:
        print(f"Error fetching data: {e}")
        return None

def linear_model(x, a, b):
    return a * x + b

def exponential_model(x, a, b):
    return a * np.exp(b * x)

def calculate_r_squared(y, y_pred):
    residuals = y - y_pred
    ss_res = np.sum(residuals ** 2)
    ss_tot = np.sum((y - np.mean(y)) ** 2)
    r_squared = 1 - (ss_res / ss_tot)
    return r_squared

def fit_models(x, y, margin):
    try:
        linear_params, _ = curve_fit(linear_model, x, y)
        y_linear_pred = linear_model(x, *linear_params)
    except RuntimeError as e:
        print(f"Error fitting linear model: {e}")
        return None, None, None

    residuals = np.abs(y - y_linear_pred)
    within_margin = np.all(residuals <= margin)

    if within_margin:
        return "linear", linear_params, y_linear_pred

    try:
        exponential_params, _ = curve_fit(exponential_model, x, y)
        y_exponential_pred = exponential_model(x, *exponential_params)
        r_squared_exponential = calculate_r_squared(y, y_exponential_pred)
        return "exponential", exponential_params, y_exponential_pred
    except RuntimeError as e:
        print(f"Error fitting exponential model: {e}")
        return None, None, None

def send_feedback(url, data):
    try:
        headers = {'Content-Type': 'application/json'}
        response = requests.post(url, data=json.dumps(data), headers=headers)
        response.raise_for_status()
        print("Feedback sent to the Laravel application.")
    except requests.RequestException as e:
        print(f"Error sending feedback: {e}")

# Main execution
data_url = 'http://fishsee.test/api/import-to-python'
data = fetch_data(data_url)

if data:
    df = pd.DataFrame(data)
    column_names = ['acidity', 'turbidity']  # Update these with actual column names

    margin = 0.5
    predicted_values = {}

    for column_name in column_names:
        if column_name in df:
            y = df[column_name].values
            x = np.arange(len(y))

            correlation_type, best_params, _ = fit_models(x, y, margin)

            if correlation_type:
                future_x = np.arange(len(y), len(y) + 10)
                if correlation_type == "linear":
                    future_y_pred = linear_model(future_x, *best_params)
                else:
                    future_y_pred = exponential_model(future_x, *best_params)

                predicted_values[column_name] = list(future_y_pred)
                print(f"The data for {column_name} shows a {correlation_type} correlation.")
            else:
                print(f"No suitable model found for {column_name}.")
        else:
            print(f"Column {column_name} not found in data.")

    feedback_url = 'http://fishsee.test/export-from-python'
    send_feedback(feedback_url, predicted_values)
else:
    print("Failed to fetch data.")
