You must install graphql and @apollo/client on the client side, and graphql and @apollo/server on the server side

## Their roles
The graphql package you install in your project is the core GraphQL implementation that defines the GraphQL language and execution behavior. It provides the necessary functionality to parse GraphQL queries, execute them, and return results according to the GraphQL specifications.
Apollo Client is a comprehensive state management library that provides practical and powerful tools to interact with GraphQL. 
Apollo Server, another part of the Apollo ecosystem, allows you to build a self-documenting API in Node.js using GraphQL. However, it also enforces what are valid queries/mutations, inputs, and responses from the frontend. It enforces using schemas defined at backend’s typeDefs.js

You can think of graphql as mysql in that it has a query language and apollo server as the sequelizer in that it lets your backend interact with it, however except graphql has no database system; instead graphql is a hybrid of query language and express api endpoints, except it’s the same endpoint /graphql and the routes are really functions that queries and mutations are named after. Those functions in resolvers.js can return whatever data you want, either from a database or stored raw json data

## Version Conflicts

While you must install graphql and @apollo/client on the client side, and graphql and @apollo/server on the server side - you have to make sure their versions are compatible. You can look at the package.json of existing full stack graphql repos for which versions to install with npm. Or you may have the versions written on paper. But if you don’t have this resource, your other option is to install the latest of every package by not specifying the version when running npm install

However, if you need to have a specific version of @apollo/client or a specific version of @apollo/server, you should look up the version number on their npm repo page, then get the rough date. Go to the other @apollo npm page and find an equivalent version based on the date. If there are multiple candidates based on the date, do not go for version 0.0.0 or beta’s or alphas.

Then you need to know the graphql version. Click Runkit at @apollo/client for the graphql version to install on your client side - click the package.json at Runkit.  Click Runkit at @apollo/server for the graphql version to install on your server side - click the package.json at Runkit. 

https://www.npmjs.com/package/@apollo/client
https://www.npmjs.com/package/@apollo/server/

You’d have found those links at npmjs.com searching for “@apollo/client” or “@apollo/server”