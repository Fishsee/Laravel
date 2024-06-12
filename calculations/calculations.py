import json
import numpy as np
import sys
from scipy.optimize import curve_fit

# Define functions for linear and exponential models
def linear_model(x, a, b):
    return a * x + b

def exponential_model(x, a, b):
    return a * np.exp(b * x)

# Define a function to fit models and calculate predicted values
def fit_and_predict(test_data, thresholds=None):
    try:
        x = np.arange(len(test_data['data']['acidity']))
        margin = 0.5
        predicted_values = {}

        for column_name, column_data in test_data['data'].items():
            y = np.array(column_data)
            correlation_type, best_params, y_pred = fit_models(x, y, margin)

            if correlation_type:
                future_x = np.arange(len(y), len(y) + 12)
                if correlation_type == "linear":
                    future_y_pred = linear_model(future_x, *best_params)
                else:
                    future_y_pred = exponential_model(future_x, *best_params)

                # Apply threshold for turbidity
                if column_name == 'turbidity':
                    future_y_pred = np.minimum(future_y_pred, thresholds[column_name])

                predicted_values[column_name] = {
                    'predicted_values': future_y_pred.round(2).tolist(),
                    'correlation_type': correlation_type
                }

                # Check against thresholds
                if thresholds and column_name in thresholds:
                    if isinstance(thresholds[column_name], dict):  # For low and high thresholds
                        low_threshold = thresholds[column_name]['low']
                        high_threshold = thresholds[column_name]['high']
                        if np.any(future_y_pred < low_threshold):
                            predicted_values[column_name]['warning'] = f"The low threshold for {column_name} is going to be exceeded."
                        elif np.any(future_y_pred > high_threshold):
                            predicted_values[column_name]['warning'] = f"The high threshold for {column_name} is going to be exceeded."
                    else:  # For single threshold
                        threshold = thresholds[column_name]
                        if column_name == 'turbidity':
                            if np.any(future_y_pred > threshold):
                                predicted_values[column_name]['warning'] = f"The threshold for {column_name} is going to be exceeded."
                        if column_name == 'flow':
                            if np.any(future_y_pred < threshold):
                                predicted_values[column_name]['warning'] = f"The threshold for {column_name} is going to be exceeded."

            else:
                predicted_values[column_name] = None

        return predicted_values

    except Exception as e:
        return {"error": str(e)}

# Define a function to fit models
def fit_models(x, y, margin):
    try:
        linear_params, _ = curve_fit(linear_model, x, y)
        y_linear_pred = linear_model(x, *linear_params)
        residuals = np.abs(y - y_linear_pred)
        within_margin = np.all(residuals <= margin)
        if within_margin:
            return "linear", linear_params, y_linear_pred
    except RuntimeError:
        pass

    try:
        exponential_params, _ = curve_fit(exponential_model, x, y)
        return "exponential", exponential_params, None
    except RuntimeError as e:
        raise RuntimeError(f"Failed to fit models: {str(e)}")

    return None, None, None

# Main execution
if __name__ == "__main__":
    try:
        if len(sys.argv) != 3:
            raise ValueError("Invalid arguments. Usage: script.py <input_data> <thresholds>")

        input_data = json.loads(sys.argv[1])
        thresholds = json.loads(sys.argv[2])

        result = fit_and_predict(input_data, thresholds)
        print(json.dumps(result))
    except IndexError as e:
        print(json.dumps({"error": "Missing input data or thresholds. Ensure both are provided."}))
    except json.JSONDecodeError as e:
        print(json.dumps({"error": f"Failed to decode JSON input: {str(e)}"}))
    except Exception as e:
        print(json.dumps({"error": str(e)}))
