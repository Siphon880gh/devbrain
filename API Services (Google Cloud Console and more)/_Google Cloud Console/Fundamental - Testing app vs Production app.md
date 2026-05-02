You'll get a long lived refresh token (**7 days on testing phase** or **permanent for published production app**) which gives you the access token. That access token expires in 1 hour. 

This separation makes it less likely a token for API endpoint access gets leaked and taken advantage of for more than 1 hour. Refresh tokens are supposed to be stored for the user session at server side and never exposed to the client.

However, after every 7 days, you would need to re-authorize the app by going through the OAuth2 consent screen again.

The flow looks like this:

1. Your app connects to Google using the **Client ID** and **Client Secret**.
2. Google returns an **OAuth2 authorization URL**.
3. You open that URL and sign in with your Google account.
4. After authorization finishes, Google redirects to your custom callback URL.
5. That callback URL includes an **authorization code** in the URL query.
6. Your backend exchanges that authorization code for a new **refresh token** and **access token**.

After that, for the next 7 days, your backend can keep using the **refresh token** to request a new **access token** whenever needed. The access token usually expires every hour, but the refresh token lets your app keep generating new access tokens without requiring you to sign in again until the refresh token expires.


---

If you had put the app in **production mode**, the refresh token would be permanent. Don't treat it as 100% permanent.

Google says your production code should still expect a refresh token to stop working in cases like:
- the user revokes access (At https://myaccount.google.com/u/3/connections)
- the token is unused for 6 months
- the user changes their password
- too many refresh tokens have been issued for the same user/app