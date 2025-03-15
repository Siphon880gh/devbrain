
You can get the Fetch or cURL code at the graphQL playground.

When you have a working query, click "Copy cURL" at the top right.
You can rewrite the cURL to fetch with ChatGPT if you choose to.

The fetch format for GraphQL is like:
```
const fetchGraphQLData = async () => {
  const response = await fetch('/graphql', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      query: `
        query GetSomeData {
          someData {
            id
            name
          }
        }
      `,
    }),
  });

  if (!response.ok) {
    throw new Error('Network response was not ok');
  }

  return response.json();
};
```