Text: Troubleshooting full stack cra or vite cors error with local api endpoints

Problem Statement: I have a full stack app that when I ran `npm run dev` from the root, and when I visit localhost:3000/, the webpage loads fine with static assets, but when the webpage makes API requests to my express server that's in the same project folder, I get CORS errors.


## Requirements
Let's say your file structure is setup as:
```
./
./client
./server
```

And your packages, you have 3 packages, with the root package coordinating which page's scripts to run or whether to run the root package's scripts:
```
./package.json
./client/package.json
./server/package.json
```


## Solution:
Your developer HRM client could be on protocol 3000 when you ran `npm run dev` while your server.js with the API endpoints could be on protocol 3001, for example

You need to set up a proxy at ./client to ensure that API requests made from the frontend (running on one port, say 3000) are correctly forwarded to the backend server (running on a different port, say 3001).

When you set up a proxy, you are telling the development server (the one serving the frontend) to intercept certain requests and forward them to another destination (the backend server). This is particularly useful in development environments to avoid issues with CORS (Cross-Origin Resource Sharing) policies that browsers enforce.

For Vite, you would configure a proxy in the `vite.config.js` file using the `proxy` option within the `server` field. Here's a basic example:

```javascript
// vite.config.js
export default {
  server: {
    proxy: {
      '/api': {
        target: 'http://localhost:3001',
        secure: false,
        changeOrigin: true
      }
    }
  },
};
```

This configuration tells Vite that any requests on the frontend to `/api/...` should be forwarded to `http://localhost:3001/api/...`.

For Create React App, you would add a `proxy` field in the `package.json` file:

```json
// package.json
{
  "proxy": "http://localhost:3001",
}
```

In CRA, this configuration will forward any unknown requests (requests that don't match a static file) to `http://localhost:3001`. This is particularly useful for API calls.

With this setup, when you make a request from the frontend like `fetch('/api/data')`, the development server intercepts this request and forwards it to `http://localhost:3001/api/data`. The browser is unaware of this redirection; it simply sends the request to the frontend server (at port 3000) and receives a response as if the data came from the same origin. This setup simplifies development and avoids CORS issues, making it appear as if both the frontend and backend are served from the same origin.