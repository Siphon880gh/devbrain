Lets you read from or set your Google Sheets in code (PHP/NodeJS/etc)

It is also free with unlimited uses as of 3/24/23: "All use of the Google Sheets API is available at no additional cost. Exceeding the quota request limits doesn't incur extra charges and your account is not billed."

Scalability: Sheets API has per-minute quotas, and they're refilled every minute. For example, there's a read request limit of 300 per minute per project. If your app sends 350 requests in one minute, the additional 50 requests exceed the quota and generates a `429: Too many requests` HTTP status code response. If this happens, you should use an [exponential backoff algorithm](https://developers.google.com/sheets/api/limits#exponential). After 1 minute, you can execute requests again. Users can submit multiple requests at the same time, as long as they're within the quota limit.

^+Request a quota increase

Depending on your project's resource usage, you might want to request a quota increase. API calls by a service account are considered to be utilizing a single account, so you might need a higher per-user, per-project quota in that scenario. Applying for an increased quota doesn't guarantee approval. Large quota increases can take longer to be approved

**@ Setup:**

@ SETUP: Google Profile:
Setup a Google Sheet App at Google Cloud Console

- Go to console [https://console.cloud.google.com](https://console.cloud.google.com/welcome?project=firebase-mytrialapp)
- Check top right is the correct google account logged in that has the Google Sheet you will interact with
    

@ SETUP: Developer Console.. Enabling the API... Geting a Service Account... Getting a private key aka credentials json file

- If you see a top banner that says "Start your Free Trial with $300 in credit. Don’t worry—you won’t be charged if you run out of credits. Learn more.", then click "ACTIVATE" at top right. That's for their other services and the top banner persists annoyingly.
- Go to Enabled APIs & services  
    [https://console.cloud.google.com/apis/dashboard?authuser=3&project=***](https://console.cloud.google.com/apis/dashboard?authuser=3&project=***)
- Check top right avatar that you’re still in the correct Google account. Google Cloud likes to keep switching profiles even in 9/2024

![](https://i.imgur.com/nSFnhsE.png)

- Add Google Sheets API. Don't click "TRY THIS API" because then you lose the opportunity to create credentials

- Click "CREATE CREDENTIALS"

![](https://i.imgur.com/QLJoNAQ.png)


- Create a Service Account.
	- [https://console.cloud.google.com/iam-admin/iam](https://console.cloud.google.com/iam-admin/iam)
	- Check top right avatar that you’re still in the correct Google account. Google Cloud likes to keep switching profiles even in 9/2024
	- You want to create a Service Account. You are **NOT** creating API Key or OAuth
	    
	    FYI: Why not API Key? May seem a simpler way but API Keys only allow reading public spreadsheet and private spreadsheets are not supported. If you go with API Key, there's a separate restful API that you use ([https://developers.google.com/sheets/api/reference/rest](https://developers.google.com/sheets/api/reference/rest))

![](https://i.imgur.com/NRxbLcz.png)


- At IAM & Admin, go to Service Accounts to get your credential JSON file
	- Service Accounts -> Keys -> ADD KEY -> Create new key -> JSON  
    Or click “Actions ...” on your service account → Manage Keys → Add key → Create new key → JSON

![](https://i.imgur.com/WYHLF2J.png)

- Download the PRIVATE KEY to a proper place (it might have auto-download as soon as you created it)
	- Then rename it to credentials.json or however fits your filenaming convention for the code
	- If will be pushing to an online repository, make sure NOT to push your credentials.json file unless you know what you're doing
	- This is technically a public-private key pairing. You don't have to worry about the public key because that would be on Google's side and managed automatically.

![](https://i.imgur.com/Mye5ynn.png)


- Get your service account's client email to give it permission to that specific spreadsheet
	- Either open the private JSON key or go to Credentials at the API dashboard (Not the IAM dashboard). See blurred in screenshot - that’s the email address
	  [https://console.cloud.google.com/apis/credentials?project=*](https://console.cloud.google.com/apis/credentials?project=temporal-fx-381723&authuser=1)**
	
	![](https://i.imgur.com/8ez2JCh.png)
	  
	- If you opened the JSON file, your service account's client email is at the key "client_email"
	    
	- Go to your Google Sheet (making sure the top right Google User is the correct one)
	
	- Make sure your google sheet is google sheet and not an .xlsx
		![](https://i.imgur.com/b4rYP54.png)
	
	
		- Google Sheet API doesnt work with .xlsx even if it’s on Google Drive and can be opened with Google Sheet app. It has to be a Google Sheet file.
		- Here’s how you find out which type it is:  
			- **Google Sheets**: It has a green spreadsheet icon with a grid.
			- **Excel Files**: It has a green `X` icon, indicating it's an Excel file (usually `.xlsx` or `.xls`).

	- After confirming is a Google Sheet, share to your service account email address:
		
		![](https://i.imgur.com/91Mj7pv.png)

---

You are now ready to code the script. Before coding, make sure to note that

@ Different implementations follow for NodeJS, Python, PHP. You will need:

- **The spreadsheet-id can be found in the URL of the spreadsheet**. Example URL: [https://docs.google.com/spreadsheets/d/1W2S4re7zNaPk9vqv6_CqOpPdm_mDEqmLmzjVe7Nb9WM/edit#gid=0](https://docs.google.com/spreadsheets/d/1W2S4re7zNaPk9vqv6_CqOpPdm_mDEqmLmzjVe7Nb9WM/edit#gid=0) - in this URL, the **1W2S4re7zNaPk9vqv6_CqOpPdm_mDEqmLmzjVe7Nb9WM** is the spreadsheet-id.
- service account private json path
- name of the tab. 

- For nodejs and python, Sheet1 is where you replace the tab name: `const RANGE = 'Sheet1!A1';`

@ Note how append works:
With the `append` method, it appends data starting from the specified cell (e.g., `A1`) and looks for the **first available empty row** to insert the new data. It does **not overwrite** existing data; it adds the data after the last filled row in the specified range.

@ Now jump to nodejs, python, or php implementation in same tutorial folder