
**Backend**: JWT can be implemented in any language. If using Python Flask, refer to this boilerplate at [[JWT Backend Implementation (Python Flask)]]

**Backend util**: It’s recommend you create a utils folder that has the JWT functions / methods. Then you import the JWT functions into the backend in order to perform token generation, validation, etc. This util can create a json web token with expiration time from now and with payload information such as user id.

**Backend API Endpoints**: You may protect all your api endpoints requiring a valid json web token each endpoint however if you’re still developing your api endpoints or backend, you may want to consider an alternate secret word or phrase in place of the json web token for the unstable api endpoints so that it automatically passes when you have to test newly developed endpoints. The older API endpoints can use actual json web token. More information at [[JWT during development - Production ready api endpoints with developing api endpoints]]

**When logging in:**

- Fetch POST to a login API endpoint
- Backend checks if username with password found. If found, generate the json web token (with the backend secret key) and save it to user at database. Send response to client that includes the token
- Frontend callback detects a successful login, then saves the token to localStorage

```
localStorage.setItem("companyname_jwt", resource.jwt);
```

**When signing up**:

- Fetch POST to a signup API endpoint
- Backend checks if username is a duplicate. If okay, generate the json web token (with the backend secret key) and save it to the new user at database. Send response to client that includes the token
- Frontend callback detects a successful signup, then saves the token to localStorage

```
localStorage.setItem("companyname_jwt", resource.jwt);
```

**When logging out**:

- Optionally, fetch POST to a signout API endpoint that clears the token from that user at the database
- On frontend, remove the token from localStorage

```
localStorage.removeItem("companyname_jwt", resource.jwt);
```

- You may want to redirect to a logged out page (window.location.href or similar) or perform a hard reload without cache `window.location.reload(true)` ;  
      
    

**For user navigating back and forth**:

```
window.addEventListener("popstate", function (e) {
  var jwt = localStorage.getItem("vlai_jwt");
  if (jwt) {
    mainController.auth.loginWithJWT({jwt});
  }
```

**For user reaching front page or opening a page directly from bookmarks**:

```
window.addEventListener("DOMContentLoaded", function (e) {
    var jwt = localStorage.getItem("vlai_jwt");
    if (jwt) {
      window.parent.mainController.auth.loginWithJWT({jwt});
    }
  })
```

^ If reached frontpage, see if you need to redirect to a logged in page or user dashboard (window.location.href or similar).