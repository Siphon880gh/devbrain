
In GraphQL, you can pass complex objects as inputs to mutations, such as an entire group. You have to define these inputs in your GraphQL schema (typeDefs.js).

Here is an example of how you might define an input type and use it in a mutation:

  
```graphql

// typeDefs.js
input GroupInput {
  id: ID!
  name: String!
  members: [MemberInput!]!
}

input MemberInput {
  id: ID!
  name: String!
}


type Mutation {
  createGroup(input: GroupInput): Group
}

```


In this schema, we've defined a `GroupInput` type that includes an ID, a name, and a list of members. Each member is defined by the `MemberInput` type, which includes an ID and a name.

You can then use this mutation in your frontend code like so:

```jsx
import { useMutation, gql } from '@apollo/client';

const CREATE_GROUP = gql`
  mutation CreateGroup($input: GroupInput!) {
    createGroup(input: $input) {
      id
      name
      members {
        id
        name
      }
    }
  }
`;


function GroupCreator() {

  const [createGroup, { data }] = useMutation(CREATE_GROUP);  

  const newGroup = {
    id: '1',
    name: 'New Group',
    members: [
      { id: '1', name: 'Member 1' },
      { id: '2', name: 'Member 2' },
    ],
  };

  return (

    <button
      onClick={() => {
        createGroup({ variables: { input: newGroup } });
      }}
    >
      Create Group
    </button>
  );
}
```


In this React component, we're calling `createGroup` when a button is clicked. We're passing in a group object as the variable for our mutation. This group object matches the `GroupInput` type we defined in our GraphQL schema.