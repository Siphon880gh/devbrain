## Fundamental - Passing data to view
Your `res.render` can receive a data object as a second argument:
```
res.render("location", {
    city: "Los Angeles",
    rest: {
        country: "United States",
        state: "California"
    }
});
```

Then your view can dynamically pull those variables in with {{ }} expressions (at ./views/location.handlebars):
```
Hello you reached location.handlebars.<br/>
We "detected" user's GPS is in <b>{{city}}</b> which is in {{rest.country}}, {{rest.state}}.<br/>
Well, actually this is just an example, but you can probably use some IP address or GPS node module at ./server.js or one of its dependencies.
```

You can also pass request data into the data object at the second argument. Just remember you have to pluck out the values from `req.params` or `req.query` or `req.body` so you can pass them to the data object.