## Fundamental - Conditonal template - if
You can choose what to render base on Boolean values

You pass as usual at `res.render`
```
app.get("/e", (req, res) => {
    const randomNumber = function(min, max) {
        return Math.floor(Math.random() * (max - min + 1) + min);
    };

    // Flip a coin
    const isTail = randomNumber(0, 1) === 1;

    res.render("flip-coin", { isTail });
});
```

The syntax at ./views/flip-coin.handlebars is a bit different:
```
Hello you reached flip-coin.handlebars.<br/>
Let's flip a coin:
{{#if isTail}}
    Is tails!
{{else}}
    Is heads!
{{/if}}

{{#if isTail}}
<p>
    You bet on tails, so you won!
</p>
{{/if}}
```

Notice that there are two forms of the if syntax. There are the if-else and the if versions.

Note that `if` is a built-in helper. Helper helps transform input to output.