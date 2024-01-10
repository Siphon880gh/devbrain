To check if the checkbox is actually ticked or not:

  ```javascript
  let isCheckboxChecked = document.getElementById('myCheckbox').checked;
  console.log(isCheckboxChecked); // This will output true if the checkbox is checked, false otherwise.
  ```

---

Nuances:
In JavaScript, the `.value` of a checkbox input doesn't indicate whether it's checked or not; instead, it represents the value attribute of the input element, which is "on" by default if you haven't specified another value. 

- **To get the value (which will be "on" by default):**
  ```javascript
  let checkboxValue = document.getElementById('myCheckbox').value;
  console.log(checkboxValue); // This will output "on" if you haven't set a value attribute.
  ```

---

In practice, you'll often want to use `.checked` to see if a checkbox is ticked. The `.value` is more useful when you have multiple checkboxes with different values and you need to know which specific option was selected. That would be in place of referring to the name attribute.