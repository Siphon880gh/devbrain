
In terms of Mongoose:
- typeDefs has GraphQL types, not any outside mongoose models, so you dont import mongoose models!
- Resolvers usually do import mongoose models, so you can return data.  Resolves can also return hard coded json data
- Remember resolvers implement the actual data that query and mutations return, whereas typeDefs enforces what query and mutation inputs and outputs are allowed