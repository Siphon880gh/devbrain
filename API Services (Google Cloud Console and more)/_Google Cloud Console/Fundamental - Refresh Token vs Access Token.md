After successful authentication involving client id and client secret (app authorization) and OAuth2 (user authorization):

You'll get a long lived refresh token (7 days on testing phase or permanent for published production app) which gives you the access token. That access token expires in 1 hour. This separation makes it less likely a token for API endpoint access gets leaked and taken advantage of for more than 1 hour. Refresh tokens are supposed to be stored for the user session at server side and never exposed to the client.

Summary of Refresh Token vs Access Token:
- A **refresh token** is the longer-lived token. It is used to request new **access tokens**.
- An **access token** is the short-lived token. It is what your app actually sends to the API when making requests.

Once you obtain a refresh token, you have enough for your app's env configuration:
```
apiClientId="<YOUR_GOOGLE_OAUTH_CLIENT_ID>"
apiClientSecret="<YOUR_GOOGLE_OAUTH_CLIENT_SECRET>"
refreshToken="<YOUR_GOOGLE_OAUTH_REFRESH_TOKEN>"
# Optional for desktop token helper (defaults to http://127.0.0.1:53682/oauth2callback)
redirectUri="http://127.0.0.1:53682/oauth2callback"
```

Because the other env variables are obtained during the process of adding api service, enabling the api, designing the Oauth2 consent screen, and adding client id per [[Full Workflow - Adding API Service, OAuth2, Client ID and Secret, then Authenticate OAuth2 for a refresh token]]

No need to store access token in env because that's supposed to be updated every hour for a particular user's session. The refresh token is saved server side only.