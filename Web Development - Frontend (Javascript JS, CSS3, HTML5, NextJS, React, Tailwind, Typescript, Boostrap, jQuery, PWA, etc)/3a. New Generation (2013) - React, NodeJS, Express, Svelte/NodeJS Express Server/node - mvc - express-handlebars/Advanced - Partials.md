## Advanced - Partials
Partials are basically smaller templates you can place in other templates. Remember that the biggest most containing template is layouts/main.handlebars. Remember main.handlebars contains another <VIEW>.handlebars. That's simply because of the architecture that Express-Handlebars chose. But in all flavors of Express, there are templates and partials (aka partial templates). In this explanation, the template <VIEW>.handlebars can contain one or more <PARTIAL>.handlebars.

Let's pass data to `res.render`
```
app.get("/f", (req, res) => {

    const codeSnippets = [{
            name: "Print to terminal",
            snippet: "console.log($0);"
        },
        {
            name: "Random number",
            snippet: "const randomNumber = function(min, max) { return Math.floor(Math.random() * (max - min + 1) + min); }"
        }
    ]

    res.render("code-snippets", { codeSnippets });
});
```


The syntax at ./views/code-snippets.handlebars is a bit different:
```
<style>
    table, th, td {
        border: 1px solid black;
    }
</style>

Hello you reached code-snippets.handlebars.<br/>
<p>Here are all the code snippets using partial template at <b>./views/partials/</b>f/code-snippet.handlebar:</p>
<table>
    <thead>
        <th>Name</th
        ><th>Snippet</th>
    </thead>
    <tbody>
        {{#each codeSnippets}}
            {{>f/code-snippet}}
        {{/each}}
    </tbody>
</table>
```

Notice the `>f/code-snippet` is actually referring to the partial template file at `./views/partials/f/code-snippet.handlebars`. A way to remember the angle bracket is that on some terminals, the input starts with ">" and you can cd to change to a specific filepath.

You have a partial template file at ./views/partials/f/code-snippet.handlebars. Remember that data gets passed from the template to the partial.
```
<tr>
    <td>{{name}}</td>
    <td><code>{{snippet}}</code></td>
</tr>
```

### Advanced: An alternative .this syntax for the partial...
if you want to emphasize that you are getting keys from the current object. Use the `this` keyword:
```
<tr>
    <td>{{this.name}}</td>
    <td><code>{{this.snippet}}</code></td>
</tr>
```

### Advanced: Renaming current object to make partial template more conceptual
Because data gets passed from template to partial, you can also reassign a variable name to the current object. This will help the partial template code to make more sense conceptually and aids readability (when it comes to reading the partial template):
1. At the template, add after the partial template:
```
        {{#each codeSnippets}}
            {{>f/code-snippet codeSnippet=.}}
        {{/each}}
```
2. Then at the partial template, notice you can refer to the key of codeSnippet (the new variable name)
```
<tr>
    <td>{{this.name}}</td>
    <td><code>{{this.snippet}}</code></td>
</tr>
```

### Advanced: Pass additional data to the partial template
You can pass additional data. Look at template:
```
        {{#each codeSnippets}}
            {{>f/code-snippet codeSnippet=. a=1 b=2 c=3}}
        {{/each}}
```

So if you refer to `{{a}}`, `{{b}}`, or `{{c}}` in the partial template, it'll produce the values 1, 2, and 3, respectively.