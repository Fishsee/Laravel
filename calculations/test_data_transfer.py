import requests
import json
import urllib3

# Disable SSL warnings for local development
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

def test_fetch_data():
    url = 'http://127.0.0.1:8000/api/get-data'
    try:
        response = requests.get(url)
        response.raise_for_status()
        data = response.json()
        assert isinstance(data, list), "Data should be a list"
        print("Fetch data test passed: Data fetched successfully and is a list.")
    except requests.RequestException as e:
        print(f"Fetch data test failed: {e}")
    except AssertionError as e:
        print(f"Fetch data test failed: {e}")

def test_send_feedback():
    url = 'http://127.0.0.1:8000/api/export-from-python'
    data = {
        "acidity": [6.3, 6.4, 6.5, 6.6, 6.7],
        "turbidity": [2.1, 2.2, 2.3, 2.4, 2.5]
    }
    headers = {'Content-Type': 'application/json'}
    try:
        response = requests.post(url, data=json.dumps(data), headers=headers)
        response.raise_for_status()
        assert response.json().get("message") == "predicted values received and processed correctly", "Unexpected response message"
        print("Send feedback test passed: Feedback sent successfully and received correct response.")
    except requests.RequestException as e:
        print(f"Send feedback test failed: {e}")
    except AssertionError as e:
        print(f"Send feedback test failed: {e}")

# Run tests
test_fetch_data()
test_send_feedback()
