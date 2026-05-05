
As a quick and dirty fix, you can indicate the specific port:

```
const client = new ApolloClient({
  cache,
  uri: "http://localhost:4000/graphql",
});
```

But don't forget to make the port dynamic again when you deploy online