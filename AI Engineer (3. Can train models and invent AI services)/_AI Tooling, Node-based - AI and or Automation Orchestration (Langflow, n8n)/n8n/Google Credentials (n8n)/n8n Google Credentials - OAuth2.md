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

At Google Cloud Console, go setup a new OAuth2 credential at your project's app at Google Cloud Console.

Here's how:
Go to the Google Cloud Console:
[https://console.cloud.google.com/](https://console.cloud.google.com/)

Visit your project/app. If you do not have a project/app, create one:
Eg. n8n-Google-Search
![[Pasted image 20250702153642.png]]

Search for and enable your specific API service that your n8n node needs: 

At your project, go to Credentials to create a new OAuth2:
![[Pasted image 20250607035418.png]]

^ If you have a message to Configure consent screen, go ahead and configure the consent screen first.

Continuing... Click "+ Create credentials" -> OAuth2:
![[Pasted image 20250607035545.png]]

Configure the Project details so that the user can see more information about your project at their OAuth2 consent page:
![[Pasted image 20250607035914.png]]

You then create an OAuth client which will ask for the type of app:
- 1 of 2:
  ![[Pasted image 20250607040008.png]]
- 2 of 2:
  ![[Pasted image 20250607040059.png]]
  

Add the URI that you want the OAuth2 page to redirect back to after user finishes completing the OAuth2 pages. It's usually your app's URL that can take the url search parameter `?code=` for the purposes of keeping the user logged in at your own database. But since you are using a service that integrates with an API service at Google Cloud Console, that service provides you a redirect URI

Copy the `OAuth Redirect URL` from **n8n Google Credentials** settings into the OAuth2 credential at **Google Cloud Console**.
- 1 of 3:
  ![[Pasted image 20250702154336.png]]
- 2 of 3:
  ![[Pasted image 20250607040256.png]]
- 3 of 3: Could look like:
  ![[Pasted image 20250607040424.png]]

Upon "Create" button clicked, you'll be provided the client id and client secret. Make sure to copy them right away here. In the future (6/2025), you won't be able to copy these values anywhere else after the modal is closed:
![[Pasted image 20250607040639.png]]

Your app or service will require the client id and client secret, and require the user to go through the OAuth2 pages. After the user finishes the OAuth2 pages, it redirects to a url where your app will handle the url search parameter `?code=` to manage your user's session by deriving a unique Google ID from code. Of course, since you are using OAuth2 for n8n that needs the Google OAuth2, their code already handles this, and instead of a visitor user going through the OAuth2 screen flow, you the n8n user will be the one to do so.

Copy the `Client ID` and `Client Secret` from the OAuth2 credential at Google Cloud Console into n8n's node credential:
![[Pasted image 20250607032932.png]]

Then make sure to click the "Sign in with Google" that takes you through the OAuth2 screen flow. You won't have to authorize again later:
![[Pasted image 20250702154507.png]]

---

This is also covered outside the context of n8n at [[Credentials - Add OAuth2]]