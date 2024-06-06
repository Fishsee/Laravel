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
    x = np.arange(len(test_data['acidity']))
    margin = 0.5
    predicted_values = {}

    for column_name, column_data in test_data.items():
        y = np.array(column_data)
        correlation_type, best_params, y_pred = fit_models(x, y, margin)

        if correlation_type:
            future_x = np.arange(len(y), len(y) + 12)
            if correlation_type == "linear":
                future_y_pred = linear_model(future_x, *best_params)
            else:
                future_y_pred = exponential_model(future_x, *best_params)

            # Apply threshold of 100 for turbidity
            if column_name == 'turbidity':
                future_y_pred = np.minimum(future_y_pred, 100)

            predicted_values[column_name] = {
                'predicted_values': future_y_pred.round(2).tolist(),
                'correlation_type': correlation_type
            }

            # Check against thresholds
            if thresholds and column_name in thresholds:
                if isinstance(thresholds[column_name], dict):  # For low and high thresholds
                    low_threshold = thresholds[column_name]['low']
                    high_threshold = thresholds[column_name]['high']
                    low_exceeded_indices = np.where(future_y_pred < low_threshold)[0]
                    high_exceeded_indices = np.where(future_y_pred > high_threshold)[0]

                    if np.any(y < low_threshold):
                        predicted_values[column_name]['warning'] = f"The low threshold for {column_name} has already been exceeded."
                    elif np.any(y > high_threshold):
                        predicted_values[column_name]['warning'] = f"The high threshold for {column_name} has already been exceeded."
                    elif len(low_exceeded_indices) > 0:
                        first_exceeded_index = low_exceeded_indices[0] + 1
                        predicted_values[column_name]['warning'] = f"The low threshold for {column_name} is going to be exceeded in approximately {first_exceeded_index} hours."
                    elif len(high_exceeded_indices) > 0:
                        first_exceeded_index = high_exceeded_indices[0] + 1
                        predicted_values[column_name]['warning'] = f"The high threshold for {column_name} is going to be exceeded in approximately {first_exceeded_index} hours."
                else:  # For single threshold
                    threshold = thresholds[column_name]
                    exceeded_indices = np.where(future_y_pred > threshold)[0]
                    if np.any(y > threshold):
                        predicted_values[column_name]['warning'] = f"The threshold for {column_name} has already been exceeded."
                    elif len(exceeded_indices) > 0:
                        first_exceeded_index = exceeded_indices[0] + 1
                        predicted_values[column_name]['warning'] = f"The threshold for {column_name} is going to be exceeded in approximately {first_exceeded_index} hours."

        else:
            predicted_values[column_name] = None

    return predicted_values

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

# Main execution
if __name__ == "__main__":
    input_data = json.loads(sys.argv[1])
    thresholds = json.loads(sys.argv[2])
    result = fit_and_predict(input_data, thresholds)
    print(json.dumps(result))
