
We have a GraphQL mutation to add a new item to the database (for backend, refer to GraphQL-React Guides), and we want to update the UI based on the mutation's response.

First, let's define our GraphQL mutation. Suppose we have a mutation to add a book with a title and an author:

```graphql
mutation AddVideo($title: String!, $duration: Int!) {
  addVideo(title: $title, duration: $duration) {
    id
    title
    duration
  }
}
```

Now, let's create a React component that uses this mutation:

```jsx
import React, { useState } from 'react';
import { gql, useMutation } from '@apollo/client';

const ADD_VIDEO_MUTATION = gql`
  mutation AddVideo($title: String!, $duration: Int!) {
    addVideo(title: $title, duration: $duration) {
      id
      title
      duration
    }
  }
`;

const AddVideo = () => {
  const [title, setTitle] = useState('');
  const [duration, setDuration] = useState('');
  const [addVideo, { data, loading, error }] = useMutation(ADD_VIDEO_MUTATION);

  const handleAddVideo = async () => {
    try {
      await addVideo({

```

In this component:

1. We define `ADD_BOOK_MUTATION` using the `gql` tag.
2. We use the `useMutation` hook to prepare the mutation function `addBook` and to access the mutation's state (`data`, `loading`, `error`).
3. In the UI, there are inputs to accept the title and author and a button to trigger the mutation.
4. When the button is clicked, `handleAddBook` is executed, calling the mutation with the provided title and author.
5. The UI reflects the mutation's state: it shows a loading message while the mutation is in progress, displays any errors, and shows the added book's details upon success.

This example demonstrates the basic pattern for integrating `useMutation` with a React component, allowing you to perform mutations and respond to their outcomes in the UI.