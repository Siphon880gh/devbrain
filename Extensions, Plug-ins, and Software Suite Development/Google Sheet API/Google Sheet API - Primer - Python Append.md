Requirement:
- Make sure you've setup the necessary items at Google Sheet. Refer to [[Google Sheet API - _PRIMER]].

@ SETUP Python

Status: Untested
Pay attention to Google sheet ID, service account private json path, AND tab ID (spreadsheet tab name must match)

Libraries:
```
pip install --upgrade google-api-python-client google-auth-httplib2 google-auth-oauthlib
```

Code to append to spreadsheet:
```
import json  
import os  
from google.oauth2.service_account import Credentials  
from googleapiclient.discovery import build  
  
# Path to the service account JSON key file  
SERVICE_ACCOUNT_FILE = 'path/to/your/service_account_key.json'  
  
# Define the required scopes  
SCOPES = ['https://www.googleapis.com/auth/spreadsheets']  
  
# Set up credentials  
creds = Credentials.from_service_account_file(SERVICE_ACCOUNT_FILE, scopes=SCOPES)  
  
# Create the Sheets API client  
service = build('sheets', 'v4', credentials=creds)  
  
# The ID of the Google Sheet  
SPREADSHEET_ID = 'your-spreadsheet-id'  
  
# Data to be added (each inner list represents a row)  
new_values = [  
    ['Column 1', 'Column 2', 'Column 3'],  
    ['Value A', 'Value B', 'Value C']  
]  
  
# The range where you want to insert the data (e.g., after existing data)  
RANGE = 'Sheet1!A1:C1'  # Modify the range according to your sheet  
  
# The body to send to the API  
body = {  
    'values': new_values  
}  
  
# Use the Sheets API to append the data  
result = service.spreadsheets().values().append(  
    spreadsheetId=SPREADSHEET_ID,  
    range=RANGE,  
    valueInputOption='RAW',  
    insertDataOption='INSERT_ROWS',  
    body=body  
).execute()  
  
print(f'{result.get("updates").get("updatedRows")} rows added.')
```

