If you dont want to fully implement the app that will open the OAuth2 link, intercept the callback url's authorization code, reach out to get refresh token, and every hour get access token for user's web browser to make requests to authorized api endpoints

But.. your Google Cloud Platform is setup correctly so that implementing your app is the next step.

Then you can use the Playground to imitate going through the OAuth2 screen, getting authorized code, and exchanging it for refresh token, and the refresh token every hour exchanging it for the access token, first make sure that the Google Cloud Platform is correctly setup already:

At Google Cloud Console, make sure:
- The Gmail API, or the Google API you need, has been added in Google Cloud Console.
- The API has been enabled for your Google Cloud project.
- You have designed the OAuth2 Consent screen
	- Your OAuth client is configured with the correct callback/redirect URL.
- You have created a client id (and that comes with the client secret)


---

Let's open [OAuth 2.0 Playground](https://developers.google.com/oauthplayground/)

Click settings gear at the top. Enable "Use your own OAuth credentials". This imitates your app connecting to google with the client id and client secret, then gets the OAuth2 link. It further imitates you opening up the OAuth2 screen.

Paste your client ID and client secret

![[Pasted image 20260501194248.png]]

---

Next, select scope `https://mail.google.com/` or whatever API you're using (in this case it's Gmail API)

Click "Authorize APIs" button. This authorizes going through the OAuth2 screen to the end, filling in your Google credentials.

![[Pasted image 20260501193528.png]]

---

Click the button to exchange authorization code for refresh token and access tokens (on the left). This is equivalent to the OAuth2 screen opening the callback URL that's been configured at Google Cloud Platform.

That callback URL is usually back to your website. This imitates your backend serving a "Thank you. Connected. You can close this" webpage to the user and also intercepting the authorization code in the url query.

And because this also gives you the refresh token and access token, this step also imitates your backend taking that authorzation code and exchanging it for the refresh token and access token.

![[Pasted image 20260501192651.png]]

Your server would securely keep the refresh tokens. Click "Refresh access token" button to get a new access token. This is the equivalent of 1 hour passing and we needing a new access token. The access token is sent with API requests. The user's web browser has access to the access token.

That access token expires in 1 hour. This separation makes it less likely a token for API endpoint access gets leaked and taken advantage of for more than 1 hour. Refresh tokens remains safely secured in the server from exposure.