
## Passing array of objects to view
You pass as usual at `res.render`. Notice the first level is an array of objects. Then the objects themselves have deeper levels of key-value pairs. There may be situations where you have to render those deeper levels of key-value pairs. We also have deeper and deeper levels of data here to show there is no limit on how far we can nest data and yet still render the data. 

Firstly, at the router:

```
app.get("/h", (req, res) => {

    res.render("nested", {
        arr: [{
                a: 1,
                inner: {
                    a: 11,
                    innerInner: {
                        a: 111
                    }
                }
            },
            {
                a: 2,
                inner: {
                    a: 22,
                    innerInner: {
                        a: 222
                    }
                }
            }
        ]
    });
});
```

The syntax at ./views/nested.handlebars:
```
Should repeat like X, XX, XXX: for i=1..2
<ul>
    {{#each arr }}
        <li>{{a}}... 
            {{#with inner}} 
                {{a}}...
                
                {{#with innerInner}} 
                    {{a}}...
                    
                {{/with}}
            {{/with}}
            </li>
    {{/each}}
</ul>
```

Notice the `with` helper accepts an argument of the key that kicks off to a deeper level of data.

If you do not like the above syntax when it comes to readability, there's an alternative syntax that is explicitly using the `this` keyword:
```
Should repeat like X, XX, XXX: for i=1..2
<ul>
    {{#each arr }}
        <li>{{this.a}}... 
            {{#with this.inner}} 
                {{this.a}}...
                
                {{#with this.innerInner}} 
                    {{this.a}}...
                    
                {{/with}}
            {{/with}}
            </li>
    {{/each}}
</ul>
```