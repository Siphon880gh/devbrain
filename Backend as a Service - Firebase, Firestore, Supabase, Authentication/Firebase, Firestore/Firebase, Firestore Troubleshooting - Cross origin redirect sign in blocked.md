Cross origin redirect sign-in on Google Chrome M115+ is no longer supported, and will stop working on June 24, 2024.

Migrate to an alternative solution before June 24, 2024
End-users can continue to sign in to your app until June 24, 2024
This is already required on Firefox 109+ and Safari 16.1+

---

Explanation:
If you use the method "signInWithRedirect()" or any other similar method, Chrome will block you.

Fix:
Use Sign-in flow popup instead of redirect

In the firebaseui config:
'signInFlow': 'popup', // default is 'redirect'