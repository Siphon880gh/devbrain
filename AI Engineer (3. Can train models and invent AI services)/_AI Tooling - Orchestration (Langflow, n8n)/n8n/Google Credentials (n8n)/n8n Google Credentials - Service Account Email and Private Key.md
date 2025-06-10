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

At Google Cloud Console:

Setup a new Service Account credential at your project's app at Google Cloud Console.

You can get the service account email at the Credentials page on Google Cloud Console under your service account. You will need to share the Google Sheet, Google Doc, etc to that service account's email address and make it an editor (not just a viewer).

To get the Private key, you create a public/private key at the service account's settings at Google Cloud Console. It will download a JSON file to your computer. Open the JSON file then copy the value at the key "private_key"

If you don't know the basics of getting/adding service account at Google Cloud Console, refer to [[Credentials - Add Service Account]]

---

Then add the Google Credential details to the **n8n Google Credential** settings:

![[Pasted image 20250607033051.png]]
