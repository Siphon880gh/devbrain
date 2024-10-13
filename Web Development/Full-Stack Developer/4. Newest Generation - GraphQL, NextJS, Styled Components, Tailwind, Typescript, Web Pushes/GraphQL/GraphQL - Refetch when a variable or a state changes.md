Expose the refetch method from useQuery. This refetch method when called will rerun useQuery and updates its associated state and re-render if applicable. Next, you'll have useEffect watch for the other state's change, then useEffect will run whenever that other state changes. Inside useEffect you'd call the refetch method.

```
  let { loading, data: user, refetch } = useQuery(userParam ? GET_USER : GET_ME, {
    variables: { username: userParam },
  });

  useEffect(() => {
    refetch();
    console.log("Following triggered")
  }, [amIAFollower])
```
