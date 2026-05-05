
## LazyQuery

The `useLazyQuery` hook from Apollo Client is a React hook that allows you to execute a GraphQL query lazily. This means the query is not automatically executed when the component mounts. Instead, **you get a function** that, when called, triggers the execution of the query. This feature is particularly useful when you need to run a query based on a user action, like clicking a button, submitting a form, or any other event-driven interaction.

Here's a basic outline of how `useLazyQuery` works:

1. **Importing useLazyQuery**: First, you import `useLazyQuery` from `@apollo/client`.

2. **Using the Hook**: When you use `useLazyQuery`, you pass your GraphQL query to it. The hook returns an array with a function to trigger the query and an object containing the query's state (`loading`, `data`, `error`, etc.).

3. **Triggering the Query**: You can trigger the query by calling the function returned by `useLazyQuery`. This is typically done in response to a user action, like clicking a button, or an useEffect that calls it when a dependency variable changes. Next two sections will cover both scenarios.

4. **Accessing the Result**: After the query is executed, you can access the result (data, loading state, error) through the object returned by the hook.

---

### LazyQuery: Clicking a button


Here's a simple example in code:

```javascript
import React from 'react';
import { useLazyQuery, gql } from '@apollo/client';

const GET_DATA_QUERY = gql`
  query GetData($id: ID!) {
    data(id: $id) {
      id
      value
    }
  }
`;

function MyComponent() {
  const [getData, { loading, data, error }] = useLazyQuery(GET_DATA_QUERY);

  if (loading) return <p>Loading...</p>;
  if (error) return <p>Error :(</p>;

  return (
    <div>
      <button onClick={() => getData({ variables: { id: '123' } })}>
        Load Data
      </button>
      {data && <p>Data: {data.value}</p>}
    </div>
  );
}
```

In this example, the data is fetched when the user clicks the button, not when the component is initially rendered. This approach is beneficial for optimizing component renders and fetching data on demand, based on user interaction.

---

### LazyQuery: When a dependency variable changes


You can use React's `useEffect` hook to manually control when the query is run.

```jsx
const [executeQuery, { loading, error, data }] = useLazyQuery(MY_QUERY);

React.useEffect(() => {
  executeQuery();
}, [someDependency]);
```
Here, `useLazyQuery` is like `useQuery`, but it doesn't automatically run when your component mounts. Instead, you can run it manually by calling the function it returns (`executeQuery` in this case). In this example, the query will be rerun whenever `someDependency` changes.


## Refetch

**Refetch**: The `useQuery` hook returns a `refetch` function that you can call to execute the query again. This will use the same variables as the original query, but you can also pass in new variables if you'd like.

```jsx
const { loading, error, data, refetch } = useQuery(MY_QUERY);

// Somewhere else in your component...
refetch();
```