Why needed: You're implementing an app that uses an API service from Google Cloud Console, and you have to authorize the user so that you can act on their behalf (the user sees OAuth2 screen). Or you're using a service that integrates with that API, and it needs to act on your behalf (you will see OAuth2 screen). 
- For example, n8n adding a Google Sheet node for appending rows will requires your Google credentials in either forms:
	- Service account email and private key.
	- OR OAuth2.

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
  

Add the URI that you want the OAuth2 page to redirect back to after user finishes completing the OAuth2 pages. It's usually your app's URL that can take the url search parameter `?code=` for the purposes of keeping the user logged in at your own database. Or if you're using a service that integrates with an API service at Google Cloud Console, that service usually provides you a redirect URI
![[Pasted image 20250607040256.png]]

Could look like:
![[Pasted image 20250607040424.png]]

You'll be provided the client id and client secret. Make sure to copy them right away here. In the future (6/2025), you won't be able to copy these values anywhere else after the modal is closed:
![[Pasted image 20250607040639.png]]

Your app or service will require the client id and client secret, and require the user to go through the OAuth2 pages. After the user finishes the OAuth2 pages, it redirects to a url where your app will handle the url search parameter `?code=` to manage your user's session by deriving a unique Google ID from code. Of course, if it's a service like n8n that needs the Google OAuth2, their code already handles it. Here's the detailed flow for handling `?code=` in your own application:
1. Your app: **Needs the Google OAuth2 `client_id` and `client_secret`.**
2. **Redirects the user to Google's OAuth2 consent screen**, where they log in and approve access.
3. **After approval**, Google **redirects back to your app's `redirect_uri`** with a query parameter:
    ```
    ?code=AUTH_CODE_HERE
    ```
4. Your app **handles that `code` server-side** by exchanging it for `tokens` object that is an intermediate data point to get to the user's unique Google ID. There are two approaches to exchange the `code` for the `tokens` object:
	- Approach A: Making a `POST` request to:
	    ```
	    https://oauth2.googleapis.com/token
	    ```
	    with parameters:
	    - `code`
	    - `client_id`
	    - `client_secret`
	    - `redirect_uri` (must match the one in the original request)
	    - `grant_type=authorization_code`
	- Approach B: Using Google Auth SDK.
	  
5. Google responds with a **`tokens` object**, which includes:
    - `access_token`
    - `id_token` (a JWT)
    - optionally `refresh_token` (if offline access was requested)
      
6. You can **decode `id_token` using `jwt.decode(id_token)`**(from a JWT library like `jsonwebtoken` in Node.js) to get:
    - `decoded.email` — the user’s email address (if `email` scope was included)
    - `decoded.sub` — the user's **unique and stable Google ID**
    - (and optionally name, picture, etc. if `profile` scope was included)

Note if you want an extra precautionary step of verifying the authenticity in production, `jwt.decode()` does not verify the `id_token`. For that, you want to use `jwt.verify()` or a Google library.