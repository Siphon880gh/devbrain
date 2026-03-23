
For the React Router: [[Mixed Web Server - Reverse Proxied and Have React Router]]
- That's in ADDITION to **this** tutorial for the React app itself

For the JS manipulations of location url (that can be on top of React): [[_REFERENCE - Frontend sourcing, hrefing, and js locationing after migrating to a server with base url]]


---


React apps that by default uses the `/` root path for loading static assets and React Router using / root path for linking. CRA that makes React work with webpack - it also assumes / root path

As a consequence, you have 404 loading static js, css, asset from the root level instead of properly at your base app url level (like `/app/app1`)

![](RK59PVl.png)


By loading at root level, your reverse proxy location won’t be hit at “/api/book-search”, then the build/  folder (which has build/static , etc) of assets can’t load. So the solution is:

CRA React folder’s package.json:
```
    "homepage": "https://wengindustries.com/app/book-search/",
```

For PWA launching URL which CRA includes, adjust `client/public/manifest.json`:
```
"start_url": "/app/book-search/",
```

And then run `npm run build`

---

React Router? Refer to [[Mixed Web Server - Reverse Proxied and Have React Router]]