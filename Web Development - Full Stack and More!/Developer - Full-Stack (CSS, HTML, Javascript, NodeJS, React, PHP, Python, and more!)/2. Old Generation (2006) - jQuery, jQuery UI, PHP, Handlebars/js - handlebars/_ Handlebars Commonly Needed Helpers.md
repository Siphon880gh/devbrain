
They could be:
```Handlebars.registerHelper('times', function (n, block) {
    let result = '';
    for (let i = 0; i < n; i++) {
        result += block.fn(i);
    }
    return result;
});

Handlebars.registerHelper('eq', function(a, b) {
    return a === b;
});

Handlebars.registerHelper('inc', function(value) {
    return parseInt(value) + 1;

    /* 
        So that counting can start at 1
        {{#each items}}
          <li>{{inc @index}}: {{this}}</li>
        {{/each}}
    */
});
```

---


Example uses:
- Show checkboxes 5 times:
```
{{#times 5}}  
 <input type="textbox"/>  
{{/times}}
```

- Show checkboxes x times (based on variable count):
```
{{#times count}}  
 <input type="textbox"/>  
{{/times}}
```

- If difficult key exists and is 1 (for true) in object, tell user that's the hardest setting:
```
{{#if difficult}} 
  {{#if (eq difficult 1)}}
  <span class="text-red-500">Hardest Level!</span>
  {{/if}}
{{/if}}
```


- Show index of the current iteration of `{{#each}}`, starting from 0 or from 1:
  Refer to [[Handlebars - Each - Show index of current iteration]]