
Yes - some `npm install` packages can be loaded directly in the web browser. Some packages are exclusively only for web browser js files or exclusively for node js modules, and some packages can do both. 

For example, markdown-it-checkbox can do both:
https://www.npmjs.com/package/markdown-it-checkbox

Markdown-it-checkbox adds onto the classic markdown-it parser, allowing you to convert markdown into rendered html,  but also rendering checkboxes `[ ]` too, which the original markdown-it parser doesn't. 

You can use this markdown-it plugin by having require (a choice):
```
var md = require('markdown-it')()
            .use(require('markdown-it-checkbox'),{
              divWrap: true,
              divClass: 'cb',
              idPrefix: 'cbx_'
            });
 
md.render('[ ] unchecked') // =>
```


Or by having had done `script src` (another choice):
```
<script src="./node_modules/markdown-it-checkbox/dist/markdown-it-checkbox.min.js"></script>

var md = require('markdown-it')()
            .use(window.markdownitCheckbox),{
              divWrap: true,
              divClass: 'cb',
              idPrefix: 'cbx_'
            });
 
md.render('[ ] unchecked') // =>
```

Notice it's included as a `script src` relatively to node_modules/. Web browser js only supported if their documentation says it's supported. 

At markdown-it-checkbox, their docs explains browser js is supported:
>> "Differences in browser. If you load script directly into the page, without package system, module will add itself globally as window.markdownitCheckbox."


In the past, browser js files were distributed by cdn and bower but nowadays in 2023 it became in practice to distribute via npm although it would blurry the boundary between node modules and web browser javascript.