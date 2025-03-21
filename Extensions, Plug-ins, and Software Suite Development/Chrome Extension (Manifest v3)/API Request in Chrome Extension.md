This `connect-src 'self' https://pokeapi.co;` at manifest.json, would allow for this fetch to run without being blocked:
```
fetch("https://pokeapi.co/api/v2/pokemon/pikachu")  
  .then(response => response.json())  
  .then(data => console.log(data))  
  .catch(error => console.error('Error:', error))
```

If you own pokeapi.co, you would have to enable CORS at the server/website.