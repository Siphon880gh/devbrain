
With IIFE, you can now have async await inside useEffect

```
useEffect(() => {
  (async () => {
    const response = await fetch("url");
    const data = await response.json();

    setPosts(data);
  })();
}, []);

```


First discovered:
https://javascript.plainenglish.io/iifes-can-change-the-way-you-write-the-useeffect-hook-in-react-a5cb5d69d14a