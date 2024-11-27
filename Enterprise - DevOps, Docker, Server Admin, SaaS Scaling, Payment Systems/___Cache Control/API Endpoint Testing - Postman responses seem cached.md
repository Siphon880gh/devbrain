
If testing API endpoints on Postman and the response seems cache, check:
- Does your PHP headers of Nginx/Apache vhost enabled cache? Refer to [[Cache busting as the developer and sys admin]] on PHP and Server Side sections.
- Did you restart the nodejs express or python flask server? It could be running on an old copy which is the default behavior unless it's in watch mode (reloads the server process whenever it detects code changes in your files)
- Postman might be caching the responses and sending the cache to you on subsequent api requests. The default behavior is no caching, but in case it's been changed in the future, you go to settings to take care of caching responses:
  ![](https://i.imgur.com/B69fLf9.png)
