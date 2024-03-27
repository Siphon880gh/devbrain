
Sure, let's adapt your article to focus on integrating JSON Web Tokens (JWT) into a full stack application using an Express server, without GraphQL.

---

This guide demonstrates how to integrate JSON Web Tokens (JWT) into a React application with an Express backend, providing a secure method for handling authentication.

## Frontend

### Modifying `App.jsx`

First, set up a mechanism to attach the JWT to every request. In your `App.jsx`, you can create a middleware function that will add the token to the headers:

```javascript
// At frontend App.jsx

// Function to attach JWT to every request's headers
const attachTokenToHeaders = async (url, config = {}) => {
  const token = localStorage.getItem('id_token');
  const headers = {
    ...config.headers,
    Authorization: token ? `Bearer ${token}` : '',
  };
  return fetch(url, { ...config, headers });
};
```

Examples on how to make fetch requests with JWT will be at the bottom

### Handling Authentication in `auth.js`

In `utils/auth.js`, define methods for token management and user authentication status:

```javascript
// At frontend utils/auth.js
import decode from 'jwt-decode';

class AuthService {
  getProfile() {
    return decode(this.getToken());
  }

  loggedIn() {
    const token = this.getToken();
    return !!token && !this.isTokenExpired(token);
  }

  isTokenExpired(token) {
    try {
      const decoded = decode(token);
      return decoded.exp < Date.now() / 1000;
    } catch (err) {
      return false;
    }
  }

  getToken() {
    return localStorage.getItem('id_token');
  }

  login(idToken) {
    localStorage.setItem('id_token', idToken);
    window.location.assign('/');
  }

  logout() {
    localStorage.removeItem('id_token');
    window.location.assign('/');
  }
}

export default new AuthService();
```

## Backend

### Setting Up Express Server

In your `server.js`, set up the Express server to use JWT for authentication:

```javascript
const express = require('express');
const jwt = require('jsonwebtoken');
const { expressJwt } = require('express-jwt');
const secret = process.env.JWT_SECRET; // Ensure this is secured and not hardcoded

const app = express();

app.use(express.urlencoded({ extended: true }));
app.use(express.json());

// JWT middleware to check the token
app.use(expressJwt({ secret: secret, algorithms: ['HS256'] }).unless({ path: ['/login', '/register'] }));

// Routes
app.post('/login', (req, res) => {
  // Authenticate and generate token
  // Dummy user authentication
  const user = { id: 1, username: 'test' }; // Replace with actual user lookup and authentication
  const token = jwt.sign({ user }, secret, { expiresIn: '2h' });
  res.json({ token });
});

app.get('/protected', (req, res) => {
  // Accessible only with valid token
  res.send('Protected resource');
});

// Error handling for unauthorized access
app.use(function (err, req, res, next) {
  if (err.name === 'UnauthorizedError') {
    res.status(401).send('Invalid token');
  }
});

const PORT = process.env.PORT || 3001;
app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
```

### Authentication Middleware

Create a middleware in `utils/auth.js` on the server-side to verify the token and add the user to the request object:

```javascript
const jwt = require('jsonwebtoken');
const secret = process.env.JWT_SECRET;

module.exports = {
  authMiddleware: (req, res, next) => {
    const token = req.headers.authorization?.split(' ').pop().trim();
    if (!token) return next();

    try {
      const { user } = jwt.verify(token, secret);
      req.user = user;
    } catch (error) {
      console.log('Invalid token');
    }

    next();
  },
};
```

### Security Considerations

- Ensure the use of HTTPS to secure data in transit.
- Store JWTs securely and avoid storing sensitive information in them.
- Implement CSRF protection and validate user input to safeguard against XSS and other web vulnerabilities.
- Regularly update your dependencies to patch security vulnerabilities.

By following this guide, you'll have a secure authentication flow in your full-stack Express and React application, leveraging JWTs for maintaining user sessions.

---

## Examples on how to make fetch requests with JWT

To use the `attachTokenToHeaders` function in your frontend, you'll replace the typical `fetch` calls with this function whenever you need to make authenticated requests to your backend. This function automatically attaches the JWT from localStorage to the headers of your requests, ensuring that your backend can authenticate them.

Suppose you have a React component where you need to fetch some protected data from the backend:

```javascript
import React, { useState, useEffect } from 'react';

const MyProtectedComponent = () => {
  const [data, setData] = useState(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await attachTokenToHeaders('/api/protected/data');
        if (response.ok) {
          const data = await response.json();
          setData(data);
        } else {
          // Handle errors, e.g., token is invalid or expired
          console.error('Failed to fetch data');
        }
      } catch (error) {
        console.error('Error fetching data:', error);
      }
    };

    fetchData();
  }, []);

  return (
    <div>
      {data ? <div>{JSON.stringify(data)}</div> : <p>Loading data...</p>}
    </div>
  );
};

export default MyProtectedComponent;
```

In the example above, `attachTokenToHeaders` is used to make a GET request to `/api/protected/data`, a route that requires authentication. The function ensures that the JWT, if present, is included in the request's `Authorization` header. If the token is valid, the server will respond with the protected data; otherwise, it might return an error, which should be handled appropriately in the frontend.

### Handling POST Requests

You can also use `attachTokenToHeaders` for POST requests or other HTTP methods. Just pass the additional configuration needed for the request. For example:

```javascript
const postData = async (url, data) => {
  try {
    const response = await attachTokenToHeaders(url, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(data),
    });
    return response.json(); // Or handle the response as needed
  } catch (error) {
    console.error('Error posting data:', error);
  }
};
```

This function (`postData`) can be used to send a POST request to the server, including the necessary JWT for authentication in the request headers. The `attachTokenToHeaders` function is versatile and can be adapted for various types of requests (GET, POST, PUT, DELETE, etc.) by adjusting the configuration object accordingly.

