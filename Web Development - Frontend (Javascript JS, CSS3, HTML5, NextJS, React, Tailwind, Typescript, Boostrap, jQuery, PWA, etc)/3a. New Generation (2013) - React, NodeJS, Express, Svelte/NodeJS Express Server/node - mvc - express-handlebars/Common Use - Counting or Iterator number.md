## Common Use - Counting or Iterator number

Maybe you need to have an ordered list and you are iterating through an array of objects or primitive data on the template.

### The simple unrefined form counting from 0
```
        {{#each arr}}
            {{@index}}. {{this}}
        {{/arr}}
```

Iteration starts at 0, so adding 1 to it is more human readable. But the above does not start at 1. You cannot simply type + 1 into the index expression. Instead you have to define a helper like `inc` and run it along with `@index`.

### Refined form counting from 1
```
        {{#each arr}}
            {{@increment index}}. {{this}}
        {{/arr}}
```

So the helper you are passing to the template or globally is (Refer to lesson on helpers if confused):
```
        increment: function(num) { return num+1; }
```
