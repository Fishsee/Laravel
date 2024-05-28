import unittest
import requests_mock
import numpy as np
from calculations import fetch_data, fit_models, send_feedback, linear_model, exponential_model, calculate_r_squared

class TestModelFitting(unittest.TestCase):
    
    @requests_mock.Mocker()
    def test_fetch_data(self, mocker):
        data_url = 'http://fishsee.test/api/get-data'
        mock_data = {'acidity': [7.0, 7.2, 7.1, 7.3, 7.4], 'turbidity': [3.0, 3.1, 3.0, 3.2, 3.3]}
        mocker.get(data_url, json=mock_data)
        
        data = fetch_data(data_url)
        self.assertEqual(data, mock_data)

    def test_linear_model(self):
        x = np.array([0, 1, 2, 3, 4])
        y = linear_model(x, 2, 1)
        np.testing.assert_array_equal(y, np.array([1, 3, 5, 7, 9]))

    def test_exponential_model(self):
        x = np.array([0, 1, 2, 3, 4])
        y = exponential_model(x, 2, 0.5)
        expected_y = 2 * np.exp(0.5 * x)
        np.testing.assert_array_almost_equal(y, expected_y, decimal=3)

    def test_calculate_r_squared(self):
        y = np.array([1, 2, 3, 4, 5])
        y_pred = np.array([1, 2, 3, 4, 5])
        r_squared = calculate_r_squared(y, y_pred)
        self.assertEqual(r_squared, 1.0)
        
        y_pred = np.array([1, 2, 2, 4, 5])
        r_squared = calculate_r_squared(y, y_pred)
        self.assertLess(r_squared, 1.0)

    def test_fit_models(self):
        x = np.array([0, 1, 2, 3, 4])
        y_linear = np.array([1, 3, 5, 7, 9])
        y_exponential = np.array([2, 3.297, 5.436, 8.979, 14.778])

        # Test linear fit
        correlation_type, best_params, _ = fit_models(x, y_linear, margin=0.5)
        self.assertEqual(correlation_type, "linear")

        # Test exponential fit
        correlation_type, best_params, _ = fit_models(x, y_exponential, margin=0.5)
        self.assertEqual(correlation_type, "exponential")

    @requests_mock.Mocker()
    def test_send_feedback(self, mocker):
        feedback_url = 'http://fishsee.test/predicted-values'
        mocker.post(feedback_url, text='Feedback sent')

        predicted_values = {'acidity': [7.5, 7.6, 7.7, 7.8, 7.9], 'turbidity': [3.4, 3.5, 3.6, 3.7, 3.8]}
        send_feedback(feedback_url, predicted_values)
        self.assertTrue(mocker.called)
        self.assertEqual(mocker.last_request.json(), predicted_values)

if __name__ == '__main__':
    unittest.main()
