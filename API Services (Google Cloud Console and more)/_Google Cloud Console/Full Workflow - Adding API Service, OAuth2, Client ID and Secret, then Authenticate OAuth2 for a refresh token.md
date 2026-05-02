Requirement: You've created a project at Google Cloud Console already

Setup your appropriate API (eg. Google Custom Search API) at google cloud:
[https://console.cloud.google.com/](https://console.cloud.google.com/)

On the left drawer menu, go to API & Services -> Enabled APIs & services
![[Pasted image 20250607025157.png]]

Search for the desired API Service:
![[Pasted image 20250607025243.png]]

Now you can enable/install the API service if it hasn't been enabled yet.

You need to publish the app or whitelist yourself as one of the internal email addresses (even if your email is the one that created the Google API's Project and the one that enabled the API):
![[Pasted image 20260501153721.png]]


---

Make sure to configure the OAuth consent screen so that it exists to authenticate your app (regardless if it's just one user authentication needed to keep a cli or process running 24/7 or many users signing in to use your app)

And create an OAuth 2.0 Client ID, which will produce the client ID AND a client secret. You setup your app with these client id and secret at its .env file:

However when it comes to env configuration you should have everything you need except refresh token (that is generated upon successful OAuth2 authentication):
```
apiClientId="<YOUR_GOOGLE_OAUTH_CLIENT_ID>"
apiClientSecret="<YOUR_GOOGLE_OAUTH_CLIENT_SECRET>"
refreshToken="MISSING"
# Optional for desktop token helper (defaults to http://127.0.0.1:53682/oauth2callback)
redirectUri="http://127.0.0.1:53682/oauth2callback"
```

The thinking here is that two entities get authenticated:
- your app gets authenticated (via client id and secret)
- the user (whether it's a master user for a cli or process that runs 24/7 or a user of many users who sign into your app) and they get validated by signing in with email and password at the OAuth2 screen

You'll get a long lived refresh token (7 days on testing phase or permanent for published production app) which gives you the access token. That access token expires in 1 hour. This separation makes it less likely a token for API endpoint access gets leaked and taken advantage of for more than 1 hour. Refresh tokens are supposed to be stored for the user session at server side and never exposed to the client.

---

Now let’s try authenticating with OAuth2.

Your app connects to Google using a **Client ID** and **Client Secret**, then generates a URL for the Google OAuth2 consent screen.

In this example, the app only needs **one Google user** to sign in for everything to work because it's a backend cli. The master account signs into the backend cli then it will work 24/7. However the same process works for public users signing in to use your app.

The code does two main things:

1. Generates the OAuth2 consent screen URL.
2. Starts a local API endpoint that waits for Google to redirect back to your custom callback URL.

In our app, we run the script (`npm run oauth:desktop`) to begins the OAuth2 login flow because it will output the OAuth2 URL into the terminal:

Copy/paste and visit the OAuth2 in the web browser:

![[Pasted image 20260501163348.png]]

If you had published or added yourself as a test user, then visiting that OAuth2 URL so you can sign in and obtain a refresh token would show a roadblock:
![[Pasted image 20260501021625.png]]

Which is funny because it's treating you like another user that is asking for permission, however even if it's gated behind a cli or process, you are still treated as another user that needs to grant consent, which falls in line with OAuth2 guidelines

If you had properly published or added your email address, consent at OAuth2 would become possible. Just looks frightening. Go ahead and proceed:
![[Pasted image 20260501153915.png]]
->

![[Pasted image 20260501153947.png]]

![[Pasted image 20260501160934.png]]

Once approved, the final destination is the callback URL pointing to a local API endpoint running on your machine, such as:

```txt
http://localhost:3000/oauth/callback
```

The full callback URL is actually:
```
http://localhost:3000/oauth/callback?code=abc123&scope=...
```

The page can say something like "Success! You can close the window now."

But more importantly, your backend that delivers that webpage also intercepts the authorization code in the url query. Then your code exchanges it for a refresh token.

With our app example, we console log the refresh token
![[Pasted image 20260501163612.png]]

From that point on, your server stores the refresh token safely. It's used to generate the access token that allows authorized api endpoints to Google's specific API.

Recall that:
- A **refresh token** is the longer-lived token. It is used to request new **access tokens**.
- An **access token** is the short-lived token. It is what your app actually sends to the API when making requests.

However, when it comes to env configuration you should have everything needed now:
```
apiClientId="<YOUR_GOOGLE_OAUTH_CLIENT_ID>"
apiClientSecret="<YOUR_GOOGLE_OAUTH_CLIENT_SECRET>"
refreshToken="<YOUR_GOOGLE_OAUTH_REFRESH_TOKEN>"
# Optional for desktop token helper (defaults to http://127.0.0.1:53682/oauth2callback)
redirectUri="http://127.0.0.1:53682/oauth2callback"
```