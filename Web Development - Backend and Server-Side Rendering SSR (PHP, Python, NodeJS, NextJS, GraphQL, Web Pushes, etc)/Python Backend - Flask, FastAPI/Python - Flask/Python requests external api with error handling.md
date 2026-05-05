
In general
```
import requests

  try:
    response = requests.post(url, json=data, headers=headers)

    # Check if the request was successful
    if response.status_code == 200:
        return "Success"

    else:
        # Handle the error with information
        error_info = response.json() if response.headers.get('Content-Type') == 'application/json' else response.text
        return "Failed", f"Request failed with status code {response.status_code}: {error_info}"

  except Exception as e:
    # Handle any exception that may occur
    return "Failed", f"An error occurred: {e}"
```

Saving audio file:
```
import requests

  try:
    response = requests.post(url, json=data, headers=headers)

    # Check if the request was successful
    if response.status_code == 200:
        # Save the file
        with open(filename, 'wb') as f:
            for chunk in response.iter_content(chunk_size=CHUNK_SIZE):
                if chunk:
                    f.write(chunk)
        return "Success", f"Audio content written to {filename}"

    else:
        # Handle the error with information
        error_info = response.json() if response.headers.get('Content-Type') == 'application/json' else response.text
        return "Failed", f"Request failed with status code {response.status_code}: {error_info}"

  except Exception as e:
    # Handle any exception that may occur
    return "Failed", f"An error occurred: {e}"
```