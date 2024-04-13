In GraphQL, the single endpoint (often /graphql) can be thought of as exposing various "functions" or operations, which are defined in the schema as queries and mutations (and subscriptions, for real-time operations). Each query or mutation can be considered as a specific function or method that you can call to interact with the data.

Queries: In GraphQL, queries are used to fetch data. They are akin to functions that you call to retrieve data. Each query in the schema is like a predefined function that specifies what arguments it accepts and what data it returns.

Mutations: Mutations are used to modify data (create, update, delete). Like queries, each mutation can be thought of as a function that you call to perform some action on the data, with specified inputs and expected outputs.

Subscriptions: You can think of subscriptions as functions that you call to subscribe to data updates.

When you send a query or mutation to the /graphql endpoint, you're essentially calling one of these "functions," providing necessary arguments, and specifying what data you want in return. The GraphQL server interprets your query, executes the corresponding "function" (resolving the query or mutation against your data sources), and returns the data in the structure you requested.

This approach provides a highly flexible and efficient interface for interacting with data, allowing clients to specify exactly what they need in a single "function call" to the /graphql endpoint.