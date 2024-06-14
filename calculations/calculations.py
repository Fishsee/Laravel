import json
import numpy as np
from scipy.optimize import curve_fit
import sys

# Define functions for linear and exponential models
def linear_model(x, a, b):
    return a * x + b

def exponential_model(x, a, b):
    return a * np.exp(b * x)

# Define a function to fit models and calculate predicted values
def fit_and_predict(test_data, thresholds):
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

                # Prepare the predicted values dictionary
                predicted_values[column_name] = {
                    'predicted_values': future_y_pred.round(2).tolist(),
                    'correlation_type': correlation_type
                }

                # Check against thresholds
                if column_name in thresholds:
                    if isinstance(thresholds[column_name], dict):  # For low and high thresholds
                        low_threshold = thresholds[column_name].get('low')
                        high_threshold = thresholds[column_name].get('high')
                        if low_threshold is not None and np.any(future_y_pred < low_threshold):
                            predicted_values[column_name]['warning'] = f"The low threshold for {column_name} is going to be exceeded."
                        elif high_threshold is not None and np.any(future_y_pred > high_threshold):
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
        if len(y) < 2:
            return None, None, None
        
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
        # Ensure the correct number of arguments are provided
        expected_arguments = 2  # We expect 2 arguments: script name, and aquarium ID
        actual_arguments = len(sys.argv)
        
        if actual_arguments != expected_arguments:
            raise ValueError(f"Invalid number of arguments. Expected {expected_arguments}, but got {actual_arguments}. Usage: python script.py <aquarium_id>")
        
        # Read aquarium ID from command-line argument
        aquarium_id = sys.argv[1]

        # Construct file name based on aquarium ID
        file_name = f"../storage/aquarium_data_{aquarium_id}.json"
        
        # Read input data and thresholds from JSON file
        with open(file_name, 'r') as f:
            data = json.load(f)
            input_data = data['data']
            thresholds = data['thresholds']
        
        # Perform operations with input_data and thresholds
        result = fit_and_predict(input_data, thresholds)
        
        # Print the result as JSON
        print(json.dumps(result))
        
        # Write result to a JSON file
        output_file_name = f"../storage/predicted_values_{aquarium_id}.json"
        with open(output_file_name, 'w') as output_file:
            json.dump(result, output_file, indent=4)
        
        print(f"Predicted values saved to {output_file_name}")

    except ValueError as ve:
        print(json.dumps({"error": str(ve)}))
    except Exception as e:
        print(json.dumps({"error": str(e)}))
