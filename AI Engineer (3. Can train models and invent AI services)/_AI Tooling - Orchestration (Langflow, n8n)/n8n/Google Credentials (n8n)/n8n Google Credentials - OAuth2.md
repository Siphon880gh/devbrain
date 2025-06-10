At n8n, setup a google credential at the Personal → Credentials:
1. Open Personal (this is one way to create credentials):
   ![[Pasted image 20250610035513.png]]

2. Top right expand "Create Workflow to access "Create Credential"
	![[Pasted image 20250610033004.png]]

3. Select an OAuth2 service, for example:
   ![[Pasted image 20250610035603.png]]

When done creating credential:
![[Pasted image 20250610040230.png]]

---

At Google Cloud Console:

Setup a new OAuth2 credential at your project's app at Google Cloud Console.

Make sure to paste the `OAuth Redirect URL` from **n8n Google Credentials** settings into the OAuth2 credential at Google Cloud Console.

Copy the `Client ID` and `Client Secret` from the OAuth2 credential at Google Cloud Console for later.

If you don't know the basics of adding OAuth2 at Google Cloud Console, refer to [[Credentials - Add OAuth2]]

---

Then add to the Google Credential details to the **n8n Google Credential** settings:

![[Pasted image 20250607032932.png]]

Then make sure to click the "Sign in with Google" that takes you through the OAuth2 page. You won't have to authorize again later.