
Migrating from v2 to v3 Apollo: https://www.apollographql.com/docs/react/migrating/apollo-client-3-migration/

## Frontend

Apollo Client 3 provides a comprehensive state management library for JavaScript that enables you to manage both local and remote data with GraphQL. Its integration with React is seamless, offering hooks for querying, mutation, and subscription operations.

**Installation**

First, install Apollo Client and GraphQL:

```bash
npm install @apollo/client graphql
```

**Initializing Apollo Client**

Create an instance of `ApolloClient` and pass it your GraphQL server's URI and your cache configuration. In version 3, `ApolloClient` is a one-stop-shop for setting up your client.

```javascript
import { ApolloClient, InMemoryCache, HttpLink } from '@apollo/client';

const client = new ApolloClient({
  link: new HttpLink({
    uri: 'http://localhost:4000/graphql',
  }),
  cache: new InMemoryCache(),
});
```

**ApolloProvider Setup**

Wrap your React app with `ApolloProvider` and pass the `ApolloClient` instance to it. This makes the client available to any component in your application. Any React component that is a descendant of `ApolloProvider` can now execute GraphQL operations using Apollo Client's hooks like `useQuery` or `useMutation`.

```jsx
function App() {
  return (
    <ApolloProvider client={client}>  
		{/* Rest of your app's components */}
    </ApolloProvider>
  );
}
```

**Executing Queries**

Use the `useQuery` hook to execute a query and receive data in your components.

```javascript
import { useQuery, gql } from '@apollo/client';

const GET_VIDEOS = gql`
  query GetVideos {
    videos {
      title
      director
    }
  }
`;

function Videos() {
  const { loading, error, data } = useQuery(GET_VIDEOS);

  if (loading) return <p>Loading...</p>;
  if (error) return <p>Error :(</p>;

  return data.videos.map(({ title, director }) => (
    <div key={title}>
      <p>
        {title}: {director}
      </p>
    </div>
  ));
}
```

**Mutations and Subscriptions**

Apollo Client 3 also simplifies mutations and subscriptions. Use the `useMutation` and `useSubscription` hooks to perform mutations and listen to subscriptions, respectively.

**Advantages of Apollo Client 3**

- **Simplified API**: Apollo Client 3 offers a more streamlined API, making it easier to manage your local and remote data.
- **Improved Caching**: Enhanced caching capabilities allow for more efficient data management and faster UI updates.
- **Modular Imports**: Import only what you need, resulting in a smaller bundle size.

This guide gives you a basic introduction to using Apollo Client 3 with React. The library's comprehensive features and efficient data management make it a powerful tool for building complex, data-driven applications.

### Mutations with Apollo Client 3

Mutations in GraphQL are used to modify server-side data and return a new value. With Apollo Client 3, handling mutations in a React application is streamlined through the `useMutation` hook.

**Implementing a Mutation**

```jsx
import { useMutation, gql } from '@apollo/client';

const ADD_VIDEO = gql`
  mutation AddVideo($title: String!, $director: String!) {
    addVideo(title: $title, director: $director) {
      id
      title
      director
    }
  }
`;

function AddVideo() {
  let inputTitle, inputDirector;
  const [addVideo, { data, loading, error }] = useMutation(ADD_VIDEO);

  if (loading) return 'Submitting...';
  if (error) return `Submission error! ${error.message}`;

  return (
    <div>
      <form
        onSubmit={e => {
          e.preventDefault();
          addVideo({ variables: { title: inputTitle.value, director: inputDirector.value } });
          inputTitle.value = '';
          inputDirector.value = '';
        }}>
        <input
          ref={node => {
            inputTitle = node;
          }}
          placeholder="Title"
        />
        <input
          ref={node => {
            inputDirector = node;
          }}
          placeholder="Director"
        />
        <button type="submit">Add Video</button>
      </form>
      {data && <p>Video added!</p>}
    </div>
  );
}
```

### Subscriptions with Apollo Client 3

Subscriptions allow a client to listen for updates to the data that it cares about. With Apollo Client 3, you can use the `useSubscription` hook to manage GraphQL subscriptions.

**Implementing a Subscription**

```jsx
import { useSubscription, gql } from '@apollo/client';

const VIDEO_ADDED = gql`
  subscription OnVideoAdded {
    videoAdded {
      id
      title
      director
    }
  }
`;

function VideoFeed() {
  const { data, loading, error } = useSubscription(VIDEO_ADDED);

  if (loading) return <p>Waiting for new videos...</p>;
  if (error) return <p>Error: {error.message}</p>;

  return (
    <div>
      <h4>New Video Added:</h4>
      <p>Title: {data.videoAdded.title}</p>
      <p>Director: {data.videoAdded.director}</p>
    </div>
  );
}
```

---

## Advanced topics

### Caching Strategies

Apollo Client's InMemoryCache offers sophisticated caching capabilities, allowing for efficient data storage and retrieval. Understanding and utilizing cache policies and cache normalization can significantly improve the performance of your application.

- **Cache Normalization:** Apollo Client uses IDs to normalize the data in the cache, enabling the efficient update and retrieval of data entries.
- **Cache Policies:** Configuring cache policies allows you to specify how the client interacts with the cache for specific operations, optimizing data consistency and freshness.

### Error Handling

Error handling in Apollo Client can be achieved at various levels, including network errors, GraphQL errors, and cache errors. Implementing comprehensive error handling ensures a resilient and user-friendly application.

```jsx
const { loading, error, data } = useQuery(GET_VIDEOS);

if (error) {
  console.error(error);
  return <p>Error loading videos.</p>;
}
```

### Testing Strategies

Testing Apollo Client-based applications involves mocking client responses, testing component behavior in response to data changes, and ensuring that mutations and subscriptions are correctly handled.

- **Mocking:** Use tools like `MockedProvider` to mock queries, mutations, and subscriptions in your tests.
- **Component Testing:** Ensure that your components behave as expected with different data states (loading, error, success).

By delving deeper into these aspects of Apollo Client 3, you can leverage its full potential to build efficient, scalable, and maintainable React applications.

---

## Backend

To complement the frontend setup with Apollo Client, let's establish a simple backend using Apollo Server. We'll create a basic GraphQL server that will serve video data. This backend will include `server.js`, `typeDefs.js`, and `resolvers.js` within the `/server/schema` folder.

### Setting up the Server (`server/server.js`)

First, we'll set up the main server file. This file initializes Apollo Server and defines the schema and resolvers.

```javascript
// server/server.js
const { ApolloServer } = require('apollo-server');
const typeDefs = require('./schema/typeDefs');
const resolvers = require('./schema/resolvers');

const server = new ApolloServer({ typeDefs, resolvers });

server.listen().then(({ url }) => {
  console.log(`Server ready at ${url}`);
});
```

### Defining Type Definitions (`/server/schema/typeDefs.js`)

Type definitions (`typeDefs`) in GraphQL are used to define the shape of your data and the operations you can perform. Here's a basic setup for our video data:

```javascript
// server/schema/typeDefs.js
const { gql } = require('apollo-server');

const typeDefs = gql`
  type Video {
    id: ID!
    title: String!
    director: String!
  }

  type Query {
    videos: [Video]
  }

  type Mutation {
    addVideo(title: String!, director: String!): Video
  }

  type Subscription {
    videoAdded: Video
  }
`;

module.exports = typeDefs;
```

### Implementing Resolvers (`/server/schema/resolvers.js`)

Resolvers are functions that resolve the data for the fields in your schema. Let's define resolvers for our queries, mutations, and subscriptions.

```javascript
// server/schema/resolvers.js
const videos = []; // This will act as a simple in-memory database

const resolvers = {
  Query: {
    videos: () => videos,
  },
  Mutation: {
    addVideo: (_, { title, director }) => {
      const newVideo = { id: videos.length + 1, title, director };
      videos.push(newVideo);
      return newVideo;
    },
  },
  Subscription: {
    videoAdded: {
      subscribe: (_, __, { pubsub }) => pubsub.asyncIterator('VIDEO_ADDED'),
    },
  },
};

module.exports = resolvers;
```

### Additional Setup for Subscriptions

To support subscriptions, you'll need to enhance your server setup with `PubSub`:

```javascript
// Modify server/server.js to include PubSub
const { ApolloServer, PubSub } = require('apollo-server');
const typeDefs = require('./schema/typeDefs');
const resolvers = require('./schema/resolvers');

const pubsub = new PubSub();

const server = new ApolloServer({ typeDefs, resolvers, context: { pubsub } });

server.listen().then(({ url }) => {
  console.log(`Server ready at ${url}`);
});
```

Also, update the mutation resolver to publish an event when a new video is added:

```javascript
// Modify the addVideo mutation in server/schema/resolvers.js
Mutation: {
  addVideo: (_, { title, director }, { pubsub }) => {
    const newVideo = { id: videos.length + 1, title, director };
    videos.push(newVideo);
    pubsub.publish('VIDEO_ADDED', { videoAdded: newVideo });
    return newVideo;
  },
},
```

With this setup, you have a basic backend that supports queries, mutations, and subscriptions. This backend can interact with your frontend Apollo Client application, allowing you to perform operations like fetching video data, adding new videos, and subscribing to updates.