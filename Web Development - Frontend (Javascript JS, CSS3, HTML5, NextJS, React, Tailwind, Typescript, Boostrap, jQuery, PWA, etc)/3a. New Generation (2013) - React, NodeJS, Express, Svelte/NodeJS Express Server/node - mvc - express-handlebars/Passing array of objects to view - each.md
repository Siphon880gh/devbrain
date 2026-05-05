
## Passing array of objects to view
You pass as usual at `res.render`
```
    const arrObjPets = [{
            name: "a",
            type: "cat"
        },
        {
            name: "b",
            type: "dog"
        },
        {
            name: "c",
            type: "lizard"
        }
    ];
    res.render("old-pets", { pets: arrObjPets });
```

The syntax at ./views/old-pets.handlebars cuts to the chase by referencing the keys directly:
```
<ul>
    {{#each arrObjPets}}
    <li>{{name}} is a {{type}}</li>
    {{/each}}
</ul>
```

An alternative syntax if you do not like referencing the keys directly is to be explicit that the key is from the current `each` object with the `this` keyword
```
<ul>
    {{#each pets}}
    <li>{{this.name}} IS a {{this.type}}</li>
    {{/each}}
</ul>
```

Yet another alternative syntax if you have a lot of lines and fear you may lose track of what `this` means when it comes to readability, you can reassign the object to a variable then reference the key by the object's new variable name:
```
<ul>
    {{#each pets as |pet|}}
    <li>{{pet.name}} IS A {{pet.type}}</li>
    {{/each}}
</ul>
```

Note that `each` is a built-in helper. Helper helps transform input to output.
