
typeDefs types refer to its own types, not any outside mongoose models, so you dont import mongoose models!


However resolvers usually do import mongoose models, so you can return data. Remember resolvers implement the typeDefs and typeDefs are like the schema of the query types