By default, if the method and route runs correctly, it will return http status code 200. If you want to send more specific status codes so that the developer on the client side can debug their request, you can do so. Google for http status code for the specific numbers and their meanings.

The most common ones you should at least know is:
- 200 success
- 404 not found
- 400 general error message that the request is wrong


Example:
```
res.status(404).send("Album not found. Try another search with: /api/albums/:album_name");
```

Another example:
```
res.status(400).send("Malformed request. You may email us your request code for suggesetions.");
```