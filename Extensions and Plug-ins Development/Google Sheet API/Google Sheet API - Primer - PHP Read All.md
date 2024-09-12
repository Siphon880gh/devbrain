Requirement:
- Make sure you've setup the necessary items at Google Sheet. Refer to [[Google Sheet API - _PRIMER]].


@  SETUP: PHP access

Status: Tested succeeds
Pay attention to Google sheet ID, service account private json path, AND tab ID (spreadsheet tab name must match)

- Get the connection details
	- Get the sheet ID
	  
	  **The spreadsheet-id can be found in the URL of the spreadsheet**. Example URL: https://docs.google.com/spreadsheets/d/abc123-8910hij/edit#gid=0 - in this URL, the `abc123-8910hij` is the spreadsheet-id.
    
	- Get the sheet tab name
    
	- Have your account service credentials json file ready

- Setup the PHP
	- Have composer installed.
	- Run `composer init` on your app folder
	- Install the necessary libraries either by editing your composer.json into a “require” field, then running `composer install`:
		- `google/apiclient": "^2.12.1"`
		- Or, running `composer require google/apiclient`
	- Have the PHP Google API Client connect to their Google Sheets API, authorize you via the json file, and connect to the proper spreadsheet and the proper spreadsheet tab:
	```
	// Load in Composer libraries
	require_once '/vendor/autoload.php';

	// Setup creds
	$client = new \Google_Client();
	$client->setApplicationName('Google Sheets API');
	$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
	$client->setAccessType('offline');
	$client->setAuthConfig($credsGsheetJSONFile);

	// Setup spreadsheet
	$service = new \Google_Service_Sheets($client);
	$spreadsheetId = $connectToSpreadSheetUrlId;
	// From spreadsheet: https://docs.google.com/spreadsheets/d/abc123-8910hij/
	$range = $connectToTab; // here we use the name of the Sheet to get all the rows
	$response = $service->spreadsheets_values->get($spreadsheetId, $range);

	// OFF|on: Get values tested
	$values = $response->getValues();
	// var_dump($values);

	// Setup render
	$json = json_encode($values);
	$json = str_replace("`","\\`", $json); // escape backticks
	```

	^ Note $credsGsheetJSONFile is the relative path to your credentials JSON file
	^ Note $connectToSpreadSheetUrlId and $connectToTab

That's it. It'll simply read and dump all the values. For writing, etc to Google Sheet refer to the PHP API reference below