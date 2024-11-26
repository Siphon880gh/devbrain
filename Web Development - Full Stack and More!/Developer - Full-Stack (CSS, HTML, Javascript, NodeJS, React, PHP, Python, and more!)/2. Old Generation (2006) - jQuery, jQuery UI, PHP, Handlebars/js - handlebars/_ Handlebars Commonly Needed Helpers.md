
They could be:
```
Handlebars.registerHelper('times', function (n, block) {  
    let result = '';  
    for (let i = 0; i < n; i++) {  
        result += block.fn(i);  
    }  
    return result;  
});  
  
Handlebars.registerHelper('eq', function(a, b) {  
    return a === b;  
});
```

Example uses:
```
{{#times 5}}  
 <input type="textbox"/>  
{{/times}}
```


```
{{#times count}}  
 <input type="textbox"/>  
{{/times}}
```

```
{{#if difficulty 5}}  
 Hardest!  
{{/if}}
```