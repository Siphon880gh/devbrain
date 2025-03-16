Still is:
```
const client = new ApolloClient({
  uri: '/graphql',
  cache: new InMemoryCache()
});
```

```
export default {
  server: {
    port: 3000, // optional, since 3000 is the default
    proxy: {
      '/graphql': 'http://localhost:3001'
    }
  }
}
```

```
app.listen(3001, () => {
  console.log('GraphQL server is running on http://localhost:3001/graphql');
});
```