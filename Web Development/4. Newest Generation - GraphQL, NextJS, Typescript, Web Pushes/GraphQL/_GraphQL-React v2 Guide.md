
## Frontend

Apollo React Components enable the integration of GraphQL queries and response data with your React functional components.

**Version Differences**

This guide focuses on Apollo Client version 2, which has a different syntax compared to version 3. While version 3 streamlines many processes, including the inclusion of hooks within `@apollo/client`, this tutorial will cater to those still using version 2.

**client/package.json:**

Below is an example of a `package.json` file for a React client using Apollo v2. Note that the specific dependencies might vary based on your project's requirements.

```json
{
  "name": "client",
  "version": "0.1.0",
  "private": true,
  "proxy": "http://localhost:3001",
  "dependencies": {
    "@apollo/react-hooks": "^2.x.x",
    "apollo-boost": "^0.4.7",
    "react": "^16.13.1",
    "react-dom": "^16.13.1",
    "react-scripts": "3.4.1",
    // Other dependencies...
  },
  // Other configurations...
}
```

**App.js:**

Encapsulate your components within an `ApolloProvider` to provide them with access to the Apollo Client.

```jsx
import React from 'react';
import { ApolloProvider } from '@apollo/react-hooks';
import ApolloClient from 'apollo-boost';

const client = new ApolloClient({
  uri: '/graphql'
});

function App() {
  return (
    <ApolloProvider client={client}>
      {/* All your other components */}
    </ApolloProvider>
  );
}

export default App;
```

**src/utils/queries.js:**

Define your GraphQL queries here, similar to actions in Redux.

```javascript
import gql from 'graphql-tag';

export const QUERY_FILM_ADAPTATIONS = gql`
query {
  bookFilms {
    book
    film
  }
}
`;
```

**__Some_Component__.js:**

Example component demonstrating how to fetch and use data with Apollo.

```
import React from 'react';
import { useQuery } from '@apollo/react-hooks';
import { QUERY_FILM_ADAPTATIONS } from '../utils/queries';
import FilmList from './FilmList';

function SomeComponent() {
  const { loading, data } = useQuery(QUERY_FILM_ADAPTATIONS);
  const bookFilms = data?.bookFilms || [];

  return (
    <>
      {loading ? (
        <div>Loading...</div>
      ) : (
        <FilmList films={bookFilms} title="List of book to film adaptation(s)..." />
      )}
    </>
  );
}

export default SomeComponent;
```

## Backend

Below is a guide to setting up the server and configuring the `typeDefs` and `resolvers` in a typical Apollo Server setup.

**server/server.js:**

This is your entry point for the Apollo server. You'll need to set up ApolloServer and provide it with type definitions (`typeDefs`) and resolvers.

```javascript
const { ApolloServer } = require('apollo-server');
const typeDefs = require('./schema/typeDefs');
const resolvers = require('./schema/resolvers');

const server = new ApolloServer({
  typeDefs,
  resolvers,
});

server.listen().then(({ url }) => {
  console.log(`🚀 Server ready at ${url}`);
});
```

However, if you have a beefier server.js, say for example includes Mongo and an authMiddleware (json web token/jwt to validate each request is authorized):
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

**/server/schema/typeDefs.js:**

Here, you define the structure of your GraphQL API using SDL (Schema Definition Language). This includes defining your queries, mutations, and the data types of your API.

```javascript
const { gql } = require('apollo-server');

const typeDefs = gql`
  type Video {
    title: String
    duration: Int
    director: String
  }

  type Query {
    videos: [Video]
  }
`;

module.exports = typeDefs;
```

In this example, a `BookFilm` type is defined along with a query that returns an array of `BookFilm` objects.

**/server/schema/resolvers.js:**

Resolvers are functions that resolve the data for the fields in your schema. They are organized in the same structure as your types and fields in the `typeDefs`.

```javascript
const resolvers = {
  Query: {
    videos: () => {
      // In a real application, this data would likely come from a database
      return [
        { title: "Interstellar", duration: 169, director: "Christopher Nolan" },
        { title: "Inception", duration: 148, director: "Christopher Nolan" },
        // Add more video entries as needed
      ];
    },
  },
};

module.exports = resolvers;
```

In this example, the `videos` resolver returns a hardcoded array of books and their film adaptations. In a real-world application, you would likely fetch this data from a database or another API. For instance, you could axios fetch an external API endpoint, or you could use Sequelize models' methods, or you could use Mongo native driver's methods. You can swap in MySQL native driver (like mysql2) or Sequelize.

**Running the Server:**

Once you have these files set up, you can start your Apollo server by running `node server/server.js` in your terminal. If everything is set up correctly, you should see a message indicating that the server is running and the URL it's listening on.

With this setup, your backend should be able to respond to queries made from the frontend you configured earlier. The next steps would typically involve further refining your schema, adding more queries and mutations, and connecting your resolvers to actual data sources.