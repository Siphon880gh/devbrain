## Passing array of primitive data to view
You pass as usual at `res.render`
```
res.render("new-pets", {
    pets: [
        "cat",
        "dog",
        "lizard"
    ]
});
```

The syntax at ./views/new-pets.handlebars is a bit different:
```
<ul>
    {{#each pets}}
    <li>{{this}}</li>
    {{/each}}
</ul>
```

Note that `each` is a built-in helper. Helper helps transform input to output.