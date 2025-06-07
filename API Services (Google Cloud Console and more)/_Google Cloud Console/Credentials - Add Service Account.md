Why needed: You're implementing an app that uses an API service from Google Cloud Console, and you have to code in a service account file. Or you're using a service that integrates with that API, and you have to the service account email and private key. 
- For example, n8n adding a Google Sheet node for appending rows will requires your Google credentials in either forms:
	- Service account email and private key.
	- OR OAuth2.

At your project, go to Credentials to create a new service account:
![[Pasted image 20250607035640.png]]

Specifically, you click "+ Create credentials" -> Service account:
![[Pasted image 20250607033712.png]]

Copy your service email account (The blurred yellow region)
![[Pasted image 20250607033741.png]]

You can see all the service accounts created:
![[Pasted image 20250607034052.png]]

Open the service account and switch to "Keys" tab:
![[Pasted image 20250607034125.png]]

Add key → Create new key
![[Pasted image 20250607034139.png]]

Choose json. it will download to your computer.
![[Pasted image 20250607034225.png]]

Open the downloaded JSON file and copy the "private_key"'s value:
![[Pasted image 20250607034508.png]]

Finally, make sure you share the Google Doc / Google Sheet / etc with the service account's email address and make them an editor.