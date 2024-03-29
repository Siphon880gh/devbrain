After scraping html, you can use jQuery-style selectors to easily extract information from the HTML you've fetched. You can choose to re-save the HTML files or save to your database, whatever your mechanism is.

You will need both jsdom and jquery in node to parse scrapped information. Notice this is the node implementation of jquery, not the traditional js library.

Example:
```
const { JSDOM } = require('jsdom');  
const jquery = require('jquery');  
  
const { window } = new JSDOM('<!doctype html><html><body></body></html>');  
const $ = jquery(window);  
  
// Now you can use jQuery syntax to manipulate the virtual DOM  
$('body').append('<div class="testing">Hello World</div>');  
console.log($('div.testing').text());  // Output: Hello World
```