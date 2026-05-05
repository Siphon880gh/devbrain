## Helpers

Built-in helpers include each and if and they deal with transforming inputs into outputs. You can create your own helpers globally or per template basis.


### Globally
Define the helpers in the .create method when initializing express handlebars:
```
var hbs = exphbs.create({
    // Specify helpers which are only registered on this instance.
    helpers: {
        foo: function () { return 'FOO!'; },
        bar: function () { return 'BAR!'; },
        increment: function(num) { return num+1; }
    }
});
```

### Per template
```
app.engine('handlebars', hbs.engine);
app.set('view engine', 'handlebars');

app.get('/', function (req, res, next) {
    res.render('home', {
        someKey: "Some Value",

        // Override `foo` helper only for this rendering.
        helpers: {
            foo: function () { return 'foo.'; },
            bar: function () { return 'bar.'; },
            increment: function(num) { return num+1; }
        }
    });
});
```

Notice that the helpers property is part of the data argument where we pass data to the template. So you can think of the object as a settings+data object. This also means you should not pass any data called helpers to template; it'd set helper functions instead.

How you define the helpers depends on the type of helpers: Expression helpers or Block helpers. Read documentation on the most common Handlebar flavor because Express-Handlebars will follow similar convention.
- Expression helpers: https://handlebarsjs.com/guide/block-helpers.html#basic-blocks
- Block helpers: https://handlebarsjs.com/guide/block-helpers.html#basic-blocks