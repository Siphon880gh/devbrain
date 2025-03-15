
You can easily have useQuery repoll every 500 milliseconds (aka refetching)

You can configure your query to poll at a specific interval, effectively "rerunning" the query on a regular basis.

```jsx
const { loading, error, data } = useQuery(MY_QUERY, {
  pollInterval: 500,  // Poll every 500 milliseconds
});
```