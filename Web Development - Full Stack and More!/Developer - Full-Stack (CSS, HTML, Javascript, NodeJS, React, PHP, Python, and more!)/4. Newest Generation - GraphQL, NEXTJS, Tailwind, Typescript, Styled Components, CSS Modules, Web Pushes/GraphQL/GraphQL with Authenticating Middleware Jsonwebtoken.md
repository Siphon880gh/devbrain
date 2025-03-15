This guide refers to GraphQL v3 with React.

## Frontend

You'll add some modifications. At frontend App.jsx:
```
// Construct request middleware that will attach the JWT token to every request as an `authorization` header
const authLink = setContext((_, { headers }) => {
  // get the authentication token from local storage if it exists
  const token = localStorage.getItem('id_token');
  // return the headers to the context so httpLink can read them
  return {
    headers: {
      ...headers,
      authorization: token ? `Bearer ${token}` : '',
    },
  };
});
```

At frontend utils/auth.js, you have your usual methods to check token saved from localStorage so user doesn't need to login again the next time they visit, check if the token expires (if you make it expirable) and valid (in case someone tries to hack with a fake token), saves the token to localStorage when user signs in successfully (this token from a login endpoint), and let user logout to clear the token

```
// use this to decode a token and get the user's information out of it
import decode from 'jwt-decode';

// create a new class to instantiate for a user
class AuthService {
  // get user data
  getProfile() {
    return decode(this.getToken());
  }

  // check if user's logged in
  loggedIn() {
    // Checks if there is a saved token and it's still valid
    const token = this.getToken();
    return !!token && !this.isTokenExpired(token); // handwaiving here
  }

  // check if token is expired
  isTokenExpired(token) {
    try {
      const decoded = decode(token);
      if (decoded.exp < Date.now() / 1000) {
        return true;
      } else return false;
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
    // this will reload the page and reset the state of the application
    window.location.assign('/');
  }
}

export default new AuthService();

```

## Backend

Set the server.js graphQL to use the middleware
```
  app.use('/graphql', expressMiddleware(server, {
    context: authMiddleware
  }));
```

The entire server.js could be:
```
const express = require('express');
const path = require('path');
// Import the ApolloServer class
const { ApolloServer } = require('@apollo/server');
const { expressMiddleware } = require('@apollo/server/express4');
const { authMiddleware } = require('./utils/auth');

// Import the two parts of a GraphQL schema
const { typeDefs, resolvers } = require('./schemas');
const db = require('./config/connection');

const PORT = process.env.PORT || 3001;
const server = new ApolloServer({
  typeDefs,
  resolvers,
});

const app = express();

// Create a new instance of an Apollo server with the GraphQL schema
const startApolloServer = async () => {
  await server.start();
  
  app.use(express.urlencoded({ extended: false }));
  app.use(express.json());
  
  app.use('/graphql', expressMiddleware(server, {
    context: authMiddleware
  }));

  if (process.env.NODE_ENV === 'production') {
    app.use(express.static(path.join(__dirname, '../client/dist')));

    app.get('*', (req, res) => {
      res.sendFile(path.join(__dirname, '../client/dist/index.html'));
    });
  }

  db.once('open', () => {
    app.listen(PORT, () => {
      console.log(`API server running on port ${PORT}!`);
      console.log(`Use GraphQL at http://localhost:${PORT}/graphql`);
    });
  });
};

// Call the async function to start the server
startApolloServer();
```

Your backend utils/auth.js will have a method that verifies the token that's being passed to each request and piping the request over to the next request if successful or throwing an authentication error if unsuccessful. There should also be a method that will create the token on successful login or sign up (aka signing the token) and piping that web token over to the next request. The token could include data about the user that's encoded, could include expiration, and will have a secret salt to make the token unique so that no website's tokens have a universal way to be hacked.

```
const jwt = require('jsonwebtoken');
const { GraphQLError } = require('graphql');
const secret = 'WengCanTutorOrConsultYou.GoToWengIndustryDOTCom';
const expiration = '2h';

module.exports = {
  AuthenticationError: new GraphQLError('Could not authenticate user.', {
    extensions: {
      code: 'UNAUTHENTICATED',
    },
  }),
  authMiddleware: function ({ req }) {
    // allows token to be sent via req.body, req.query, or headers
    let token = req.body.token || req.query.token || req.headers.authorization;

    // ["Bearer", "<tokenvalue>"]
    if (req.headers.authorization) {
      token = token.split(' ').pop().trim();
    }

    if (!token) {
      return req;
    }

    try {
      const { data } = jwt.verify(token, secret, { maxAge: expiration });
      req.user = data;
    } catch {
      console.log('Invalid token');
    }

    return req;
  },
  signToken: function ({ username, email, _id }) {
    const payload = { username, email, _id };

    return jwt.sign({ data: payload }, secret, { expiresIn: expiration });
  },
};
```

Please keep in mind that for simplicity's sake I hard coded the secret salt. In security practices, you want that salt to be pulled from an .env file using the dotenv node package!

---

## Security Practices

Certainly! When integrating JSON Web Tokens (JWT) into your application, it's crucial to adhere to best practices for security. Here are some key security practices to consider:

1. **Secure Transmission:** Always use HTTPS to transmit tokens between the client and server. This ensures that the token is encrypted during transmission, protecting it from being intercepted by unauthorized parties.

2. **Token Storage:** On the client side, be cautious about where you store the JWT. Storing tokens in local storage is convenient but can be susceptible to cross-site scripting (XSS) attacks. Consider using secure, httpOnly cookies as an alternative, which are not accessible via JavaScript. For simplicity's sake, this guide saved the token to localStorage.

3. **Token Expiration:** Use short-lived tokens to reduce the risk of token theft. If a token is stolen, it will only be valid for a short period. Implement refresh tokens to manage longer sessions securely.

4. **Secret Key Security:** The secret key used to sign the JWT should be stored securely and not hard-coded into your application. Use environment variables and server-side configuration to manage your secret keys. Libraries like `dotenv` can help manage environment variables in a Node.js environment.

5. **Handle Token Verification Errors:** Ensure that your application gracefully handles errors that occur during token verification, such as token expiration or tampering. Provide clear error messages and prompt the user to re-authenticate if necessary.

6. **Avoid Storing Sensitive Information:** Do not store sensitive or personally identifiable information (PII) in the JWT payload. The payload is encoded but not encrypted, which means it can be decoded easily.

7. **Cross-Site Request Forgery (CSRF) Protection:** Even if you're using JWTs, you should still protect against CSRF attacks. Ensure that you verify that the request originated from your application and not from a malicious site.

8. **Regularly Update Dependencies:** Keep all your libraries and dependencies up to date to protect against known vulnerabilities. Use tools like `npm audit` to identify and resolve security issues in your Node.js applications.

9. **Token Revocation:** Implement a mechanism to revoke tokens if a user logs out or changes their credentials. This can be challenging with stateless JWTs, but it's crucial for maintaining a secure application.

10. **Proper Error Handling:** Avoid leaking sensitive information in error messages. Provide generic error messages to avoid giving clues to attackers.

By following these security practices, you can enhance the security of your application, protecting both your users' data and your system from potential threats.