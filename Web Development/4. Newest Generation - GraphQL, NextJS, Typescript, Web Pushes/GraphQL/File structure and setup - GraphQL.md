

Quick Guide: Apollo v2 React Components

==========================================

Apollo React Components exposes graphQL queries and response data to your React functional components.

  

# Version differences

Version 2 has a more complicated syntax than version 3. Version 3 is easier to code, but some codebases are on version 2, and this tutorial is for version 2. Version 3 is much more streamline; for example, it does not require you to require @apollo/react-hooks because it's included behind the scenes and you require @apollo/client instead

  

# client/package.json:

It's at the React client package.json because this is Apollo components which are tied to React. Notice some packages are not necessary depending on your React needs.

```

{

"name": "client",

"version": "0.1.0",

"private": true,

"proxy": "http://localhost:3001",

"dependencies": {

"@apollo/react-hooks": "^3.1.5",

"@testing-library/jest-dom": "^4.2.4",

"@testing-library/react": "^9.3.2",

"@testing-library/user-event": "^7.1.2",

"apollo-boost": "^0.4.7",

"bootstrap": "^4.4.1",

"graphql": "^15.0.0",

"graphql-tag": "^2.10.3",

"jwt-decode": "^2.2.0",

"react": "^16.13.1",

"react-bootstrap": "^1.0.1",

"react-dom": "^16.13.1",

"react-router-dom": "^5.1.2",

"react-scripts": "3.4.1"

},

"scripts": {

"start": "react-scripts start",

"build": "react-scripts build",

"test": "react-scripts test",

"eject": "react-scripts eject"

},

"eslintConfig": {

"extends": "react-app"

}

}

```

  

# App.js

Wrap all your components in an ApolloProvider component that's provided an initiated ApolloClient

```

import { ApolloProvider } from '@apollo/react-hooks';

import ApolloClient from 'apollo-boost';

const client = new ApolloClient({

uri: '/graphql'

});

  

<ApolloProvider client={client}>

// All your other components

</ApolloProvider>

```

  

# src/utils/queries.js

Where you define the redux equivalent of "actions". Well, it's the same queries from the graphQL playground

  

```

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

  

# <Some_Component>.js:

where you fetch queries or "actions" for data.

  

```

import { useQuery } from '@apollo/react-hooks';

  
  

// import QUERY_FILM_ADAPTATIONS

import { QUERY_FILM_ADAPTATIONS } from '../utils/queries';

  
  

// add the following to your React function component

// use useQuery hook to make query request (this is NOT inside useEffect hook)

// note that useQuery returns an OBJECT with exact key names loading and data, NOT an array, so you cannot rename the variables in the destructoring syntax.

const { loading, data } = useQuery(QUERY_FILM_ADAPTATIONS);

const bookFilms = data?.bookFilms || [];

  

// then when rendering. this is usually at return JSX statement. Fetching takes time so you want a loading cue for the user; and also, React will take care of the data binding so it'll render when the data is available.

  

{loading ? (

<div>Loading...</div>

) : (

<FilmList films={bookFilms} title="List of book to film adaptation(s)..." />

)}

```

  
