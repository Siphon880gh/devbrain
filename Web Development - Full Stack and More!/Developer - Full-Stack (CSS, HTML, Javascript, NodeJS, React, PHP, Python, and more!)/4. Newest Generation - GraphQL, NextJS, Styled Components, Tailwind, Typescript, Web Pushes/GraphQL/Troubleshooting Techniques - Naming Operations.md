
```
  query GetVideos {
    getVideos {
      title
      director
    }
  }
```

The "GetVideos" is to make diagnosing at the Inspect Network easier because it shows up as operation name. You could have otherwise skipped naming the query and instead:

```
  query {
    getVideos {
      title
      director
    }
  }
```

When you name a GraphQL query, the name (GetVideos in your case) is sent to the server as part of the request payload. This name can then appear in various places, such as server logs, monitoring tools, and the Network tab in browser developer tools, making it easier to identify and troubleshoot specific GraphQL operations.

Without named queries, the requests might just show up as generic POST requests to the /graphql endpoint in the Network tab, making it harder to distinguish between different GraphQL operations based solely on the request details. When you have multiple queries and mutations being sent to the same endpoint, having these operation names becomes even more crucial for understanding the traffic and debugging issues.

Moreover, if you're using a server that supports logging or monitoring of GraphQL queries, these operation names can be used to aggregate data, monitor performance, and track down errors more effectively.
