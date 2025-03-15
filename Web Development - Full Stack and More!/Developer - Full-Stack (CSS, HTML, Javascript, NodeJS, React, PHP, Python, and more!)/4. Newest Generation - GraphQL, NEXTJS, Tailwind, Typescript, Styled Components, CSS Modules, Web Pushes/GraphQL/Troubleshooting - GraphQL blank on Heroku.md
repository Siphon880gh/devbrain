Problem Statement: GraphQL works on localhost but once it's on heroku it fails with 404 when reaching /graphql whenever React components make a request. It's usually a fixed port it's requesting that results in 404.

Remember GraphQL from the /server folder is apollo-server
And GraphQL wrapping with React components to make them fetch with queries and mutations to the backend at /client is apollo-client


1. Is it working on your localhost but not on Heroku because you hard coded the port number?
   
   a. Check server.js
   b. Check your frontend:
   
```
// const client = new ApolloClient({
//   uri: "http://localhots:9090/graphql"
//   cache: new InMemoryCache(),
// });

const client = new ApolloClient({
  uri: "/graphql"
  cache: new InMemoryCache(),
});
```

2. Does Heroku give you the port number? Have this at server.js before the server process gets locked in running continuously:

```
if(process.env.PORT)
	fs.writeFile("log.txt", process.env.PORT, "utf8", ()=>{});
```

   
   Then go into server with `heroku run bash`, then run a node instance in that isolated folder instance with `npm start`, then check out the file with `tail log.txt`. It should give back some number. Alternately, you could run the isolated instance and have it console log the port number once the server starts.
   
3. Try app.listen({port:PORT}) for your apollo-server (server/server.js) if applicable. Worse case, set it to app.listen(PORT) and downgrade your apollo-server to perhaps ^2.12.0 (server/server.js)
   
   Background: Express and Heroku will end up being on the same port with app.listen(PORT)
   Another problem is on the newer version of GraphQL, it's app.listen({port:PORT})
   Both GraphQL and express shares the same app.listen... and that's actually OKAY if you're using apollo-server-express which allows that hybridization.
   
4. And is it not generating the PORT number for your express/graphql hybrid so it can run in parallel with the main PORT of your website because it's not in the right environment? 
   Add NODE_ENV = production && as part of the start script at package.json
   
   Alternately you could add "NODE_ENV" variable and value at Heroku's online dashboard.
   
   You can test it went through by going into Heroku's server by running `heroku run bash` then open up the node shell by running `node`
   
   While in node's shell, run `process.env.NODE_ENV` which is equivalent to a console.log on process.env.NODE_ENV. If it's undefined then you should work on defining the NODE_ENV to production
   

