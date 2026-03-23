

https://github.com/Siphon880gh/weng-teaches-react-express-jwt-json-web-token/tree/main

We are assuming your folder structure is ./client, ./server and that you have package.json at the root, client, and server.

Install for client:
```
    "jwt-decode": "^2.2.0"
```

Add utilities for client that verify json web token to check if you should be logged out on the next visit of the website either because the token expired or there's no token, that when logging out helps clear the json web token that's saved to your localhost (unless you use another method of persisting the json web token on frontend), and that when logging in helps save the json web token from the backend response into localhost or another mechanism. Other utilities may exist such as deciphering the token into stored user identification information:

```
import decode from 'jwt-decode';

class AuthService {
    getProfile() {
        // Decrypt the hashed token into meaningful data, for example, { data: { username, email, _id }
        return decode(this.getToken());
    }
    loggedIn() {
        // Checks if there is a saved token and it's still valid
        const token = this.getToken();
        return !!token && !this.isTokenExpired(token); // handwaiving here
    }
    isTokenExpired(token) {
        try {
            const decoded = decode(token);
            if (decoded?.exp < Date.now() / 1000) {
                return true;
            } else {
                return false;
            }
        } catch (err) {
            return false;
        }
    }
    getToken() {
        // Retrieves the user token from localStorage
        return localStorage.getItem('id_token');
    }
    login(idToken) {
        // Saves user token to localStorage
        localStorage.setItem('id_token', idToken);
        window.location.assign('/');
    }
    logout() {
        // Clear user token and profile data from localStorage
        localStorage.removeItem('id_token');
        // This will reload the page and reset the state of the application
        window.location.assign('/');
    }
}
export default new AuthService();
```

Install for server:
```
    "jsonwebtoken": "^8.5.1"
```

Add utilities for server that checks protected routes as a middleware if it's an authorized resource because user is logged in or not, and for creating a token upon signing in successfully (remember server checks database against log in credentials)
```
const jwt = require('jsonwebtoken');

// Usually you want this in .env file though:
const secret = 'MyAppJWTSecretShh';
const expiration = '2h';

module.exports = {
  authMiddleware: function(req,res,next) {
    // Allows token to be sent via req.body, req.query, or headers. Respectively:
    // body: JSON.stringify({token:...})
    // URL?token=..
    // headers: { "Authorization": "Bearer ..."}
    let token = req?.body?.token || req?.query?.token || req?.headers?.authorization;

    // If not working, uncomment to help debug if your fetch is valid
    // console.log({req_body:req?.body})
    // console.log({req_query:req?.query})
    // console.log({req_headers:req?.headers})

    // By splitting authorization header into an array and popping, you get the right most value which is the token.
    // ["Bearer", "<tokenvalue>"]
    if (req?.headers?.authorization) {
      token = req.headers.authorization.split(' ').pop().trim();
    }

    try {
      // Decrypt back the original object about the user entity that was encrypted with signToken
      const { data } = jwt.verify(token, secret, { maxAge: expiration });
      // Then merge the user entity object with req.user. At the route, you will verify this object is not undefined to prove authorization
      req.user = data;
    } catch {
      console.log('Invalid token');
    }

    next();
  },
  signToken: function({ username, email, _id }) {
    const payload = { username, email, _id };

    return jwt.sign({ data: payload }, secret, { expiresIn: expiration });
  }
};
```


Using in component level with the logistics of json web token:
```
import { useState, useEffect} from "react";
import logo from './logo.svg';
import './App.css';

import Auth from './utils/auth';


function App() {

  const [formUsername, setFormUsername] = useState('')
  const [formPassword, setFormPassword] = useState('');
  const [loggedIn, setLoggedIn] = useState(false);

  useEffect(()=>{
    if(Auth.loggedIn())
      setLoggedIn(true);
    else
      setLoggedIn(false);
  }, [])

  const handleLogin = async () => {

    try {
      const response = await fetch("/login", {
        method: "POST",
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({username:formUsername, password:formPassword})
      });

      if (response.ok) {
        var {userPasswordFound, token} = await response.json();
        if(userPasswordFound) {
          setLoggedIn(true); // Visual feedback you're logged in
          Auth.login(token); // Save to localStorage the token generated from backend's Auth.signToken()
          console.log("Login successful");
        } else {
          alert("Access Denied! Incorrect credentials")
          Auth.logout();
          setLoggedIn(false); // Visual feedback you're logged out
          console.error("Error incorrect credentials");
        }
      } else {
        console.error("Error authenticating user other than incorrect credentials");
      }

    } catch (error) {
      console.error(error);
    }
  } // handleLogin

  function handleProfileView() {
    // All authorized routes must be passed the json web token
    let token = Auth?.getToken()?Auth.getToken():"Not_Found";

    fetch("/profile", {
      method: "GET",
      headers: {
        "Authorization": `Bearer ${token}`
      }
    }).then(response=>response.text()).then(msg=> {alert(msg)})
    .catch(error => {
      // Handle any errors during the request
      console.error(error);
    });
  } // handleProfileView


  return (
    <div className="App">
      <header className="App-header">
        <h1 style={{marginTop:"50px"}}>Test JSON Web Token React-Express</h1>
        <ul className="instructions">
          <li>Login with admin/admin. </li>
          <li>Faded React logo is logged out. Colored React logo is logged in. </li>
          <li>Close webpage and revisit to see if login sticks. </li>
          <li>Check DevTools Applications to see json web token hashed value saved. - Weng</li>
        </ul>

        <div style={{position:"fixed",top:"10px", right:"15px", color:"lightblue", padding:"0 10px"}}>
          <button onClick={()=>{
            handleProfileView();
          }}>Profile (Regardless if logged in)</button>
        </div>

        <div
          className={loggedIn?"clickable":""}
          onClick={()=>{
            if(Auth.loggedIn()) { // Check localStorage for for a valid json web token value
              // eslint-disable-next-line no-restricted-globals
              let wantLogOut = confirm("Want to log out? This will fade the logo colors");
              if(wantLogOut) {
                Auth.logout(); // Clears localStorage of the json web token value
              }
            }
        }}
        >
          <img 
            alt="logo" 
            src={logo} 
            className={`App-logo ${loggedIn?"logged-in":"logged-out"}`} 
            /> 
            </div>

        <form onSubmit={(event) => { event.preventDefault(); handleLogin(); }}>
          <div className="input-group">
            <label htmlFor="field-1">Username</label>
            <input id="field-1" type="text" onChange={(event)=>setFormUsername(event.target.value)} />
          </div>
          
          <div className="input-group">
            <label htmlFor="field-2">Password</label>
            <input id="field-2" type="password" onChange={(event)=>setFormPassword(event.target.value)} />
          </div>

          <input type="submit" value="Login"/>
        </form>
        <br/><br/>

      </header>
    </div>
  );
}

export default App;
```

Using at server level with the logistics of json web token
```
const express = require("express");
const server = express();
const path = require("path");
const {checkUsersTable} = require("./utils/fakeDatabase")
const { signToken, authMiddleware } = require('./utils/auth');

// Boilerplate: Middleware to parse JSON fetch body and URL-encoded form data
// Boilerplate: Middleware to respond with static files after page is loaded
server.use(express.json());
server.use(express.urlencoded({ extended: true }));
server.use(express.static(path.join(__dirname, "..", "client", "build")));

// Routes
server.post("/login",  async (req, res) => {
    let {username, password} = req.body;
    let userPasswordFound = checkUsersTable(username,password);
    if(userPasswordFound) {
        const token = signToken({username:"admin"}); // create json web token that can be deciphered into this object {username:...}
        res.json({userPasswordFound, token})
    } else {
        res.json({userPasswordFound:false})
    }
});

server.get("/profile", authMiddleware, async (req, res) => {
    // If authorized, authMiddleware modifies req by storing a req.user the deciphered contents of the object originally passed into signToken
    if(req?.user?.username) {
        res.send("Viewing Profile... Pretend this is your profile information... and that you are still logged in.");
    } else {
        res.send("403 Forbidden. You are not logged in to access your profile page");
    }
});


async function startServer() {
    let port = process.env.PORT || 3001;

    server.listen(port, () => {
        console.log(`Server listening at ${port}`);
    });
}

startServer();
```

---

For a more visually complete demo, the App.css:
```
.App {
  text-align: center;
}

.App-logo {
  height: 40vmin;
  pointer-events: none;
}

.logged-out {
  filter: grayscale(1);
}

.logged-in {
  filter: grayscale(0);
}

@media (prefers-reduced-motion: no-preference) {
  .App-logo {
    animation: App-logo-spin infinite 20s linear;
  }
}

.App-header {
  background-color: #282c34;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-size: calc(10px + 2vmin);
  color: white;
}

.App-link {
  color: #61dafb;
}

@keyframes App-logo-spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

/* ------------------------------------------ */

code {
  background-color: darkgray;
}

.d-block {
  display: block;
}

.small {
  font-size: 80%;
}

.clickable {
  cursor: pointer;
}

/* ------------------------------------------ */


.instructions {
  list-style: none;
}
.instructions li {
  display: block;
  margin: 10px auto;
}

.input-group {
  display:block;
  margin: 5px auto;
}

.input-group label {
  font-size:50%;
  font-weight:bolder;
  margin-right: 5px;
}
```

---

Client auth utilities
https://github.com/Siphon880gh/weng-teaches-react-express-jwt-json-web-token/blob/main/client/src/utils/auth.js

Server auth utilities
https://github.com/Siphon880gh/weng-teaches-react-express-jwt-json-web-token/blob/main/server/utils/auth.js

Client use:
https://github.com/Siphon880gh/weng-teaches-react-express-jwt-json-web-token/blob/main/client/src/App.js

Server use:
https://github.com/Siphon880gh/weng-teaches-react-express-jwt-json-web-token/blob/main/server/server.js