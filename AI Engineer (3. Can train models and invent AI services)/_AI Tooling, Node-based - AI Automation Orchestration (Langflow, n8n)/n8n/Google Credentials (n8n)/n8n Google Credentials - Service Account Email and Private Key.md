At n8n, setup a google credential at the Personal → Credentials:
1. Open Personal (this is one way to create credentials):
   ![[Pasted image 20250610035513.png]]

2. Top right expand "Create Workflow to access "Create Credential"
	![[Pasted image 20250610033004.png]]

3. Add Google Service Account
   - FYI: There is no specific service account credentials for specific Google API's (eg. Google Sheet API). You would have scoped the service account credentials to the specific API service at Google Cloud Console
   ![[Pasted image 20250610035813.png]]

When done creating credential:
![[Pasted image 20250610033101.png]]

---

At Google Cloud Console, go setup a new Service Account credential at your project's app at Google Cloud Console.

Here's how:
Go to the Google Cloud Console:
[https://console.cloud.google.com/](https://console.cloud.google.com/)

Visit your project/app. If you do not have a project/app, create one:
Eg. n8n-Google-Search
![[Pasted image 20250702153642.png]]

Search for and enable your specific API service that your n8n node needs: 
Eg. Google Sheets API

- 1 of 2: Search
![[Pasted image 20250702151548.png]]

- 2 of 2: Google Sheets API
![[Pasted image 20250702151430.png]]

^ Make sure to enable the Google Sheets API!

Go into the project's API dashboard -> Credentials:

![[Pasted image 20250607035640.png]]

Create a service account:

![[Pasted image 20250607033712.png]]

  
Once done creating the service account, go **copy your service email account** (The blurred yellow region)

![[Pasted image 20250607033741.png]]

Go back to the screen with all the credentials created:

![[Pasted image 20250607034052.png]]

Open the service account and switch to "Keys" tab:

![[Pasted image 20250607034125.png]]

  
Add key → Create new key

![[Pasted image 20250607034139.png]]

  

Choose json. it will download to your computer.
![[Pasted image 20250607034225.png]]


Open the downloaded JSON file and copy the "private_key":
![[Pasted image 20250607034508.png]]

Finally, make sure you **share** the Google Sheet with the service account's email address and make them an editor (not just a viewer).

- 1 of 2:
![[Pasted image 20250702153015.png]]

- 2 of 2:
![[Pasted image 20250702153038.png]]

Now copy the service account email and private key back into n8n's Google Sheet Service Account credentials modal:

![[Pasted image 20250607033051.png]]
---

This is also covered outside the context of n8n at [[Credentials - Add Service Account]]