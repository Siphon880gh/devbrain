In JavaScript, you can add or remove the `disabled` attribute from an element (like a button or input) using the following methods:

### To Add the `disabled` Attribute:
You can use the `setAttribute()` method to add the `disabled` attribute to an element, which will disable it.

```javascript
// Assuming you have an element with id 'myElement'
var element = document.getElementById('myElement');
element.setAttribute('disabled', '');
```

### To Remove the `disabled` Attribute:
You can use the `removeAttribute()` method to remove the `disabled` attribute from an element, which will enable it.

```javascript
// Assuming you have an element with id 'myElement'
var element = document.getElementById('myElement');
element.removeAttribute('disabled');
```

### Alternative Method Using Property:
JavaScript also allows you to directly manipulate the `disabled` property of the element.

#### To Disable:
```javascript
// Assuming you have an element with id 'myElement'
var element = document.getElementById('myElement');
element.disabled = true;
```

#### To Enable:
```javascript
// Assuming you have an element with id 'myElement'
var element = document.getElementById('myElement');
element.disabled = false;
```

### Notes:
- Ensure your element has an `id` attribute or use other selectors like `getElementsByClassName` or `querySelector` if needed.
- Changing the `disabled` attribute or property will immediately affect the element's state in the UI (User Interface).
- The `disabled` attribute can be used on form elements like inputs, buttons, select, etc.

Choose the method that best suits your needs and coding style!