The client can request the server. It can request in many different ways. Some ways include fetch, jQuery ajax, and XMLHttpRequest. Requesting the server using fetch is called Fetching.

The server can be the PHP server, a server.js node that's running at specific port, a python server, among many.

#Fetching with JSON request:
```
fetch('http://localhost:3001/api/characters/', {
  method: 'POST',
  headers: {
    "Accept": 'application/json',
    'Content-Type': 'application/json'
  },
body: JSON.stringify({
    name: "X",
    age: 200
})
})
  .then(response => {
    if (response.ok) {
      return response.json();
    }
    alert('Error: ' + response.statusText);
  })
  .then(postResponse => {
    console.log(postResponse);
  });

  app.post("/api/characters", (req, res) => {
    const newCharacter = req.body;
    res.send(req.body);
    return;
  });
```


# Fetching with URL query
```
fetch('http://localhost:3001/api/characters/?name=Y&age=100', {
  method: 'POST',
})
  .then(response => {
    if (response.ok) {
      return response.json();
    }
    alert('Error: ' + response.statusText);
  })
  .then(postResponse => {
    console.log(postResponse);
  });

  app.post("/api/characters", (req, res) => {
    const newCharacter = req.body;
    res.send(req.body);
    return;
  });

  app.post("/api/characters", (req, res) => {
    const newCharacter = req.query;
    const keys = Object.keys(newCharacter);
    if (Object.keys(newCharacter).length && Object.keys(newCharacter).includes("name")) {
        characters.push(newCharacter);
        res.json(characters);
    } else {
        res.status(400).send("Not expected queries for new character");
    }
})
```