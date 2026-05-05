localStorage lets you persist data across multiple visists to the domain address. The key returns null if undefined. If is defined, it always returns a string. A common use is to store JSON string with JSON.stringify and to retrieve the key's JSON into useable data with JSON.parse

- You can clear localStorage with:
```
localStorage.clear();
```


- You can get items with:
```
localStorage.getItem("key");
```

- You can check if the item is defined with
```
let isFound = localStorage.getItem("key")!==null;
```

- Finally, you set item with
```
localStorage.setItem("key", 1);
```

- And you always get a string back:
let retrievedDataIsString = gettype localStorage.getItem("key") === "string"

## When does localStorage clear?
- In Chrome, localStorage is cleared when these conditions are met: (a) clear browsing data, (b) "cookies and other site data" is selected, (c) timeframe is "from beginning of time". In Chrome, it is also now possible to delete localStorage for one specific site.
- In Firefox, localStorage is cleared when these three conditions are met: (a) user clears recent history, (b) cookies are selected to be cleared, (c) time range is "Everything"
