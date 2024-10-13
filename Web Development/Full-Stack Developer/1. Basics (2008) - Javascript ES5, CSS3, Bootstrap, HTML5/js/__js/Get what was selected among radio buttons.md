Assign values for each possible radio option, but make sure they're the same name if they're choices within the same context:
```html
<form>
  <div>
    <input type="radio" id="flexRadioDefault1" name="flexRadioDefault" value="Option1">
    <label for="flexRadioDefault1">Option 1</label>
  </div>
  <div>
    <input type="radio" id="flexRadioDefault2" name="flexRadioDefault" value="Option2">
    <label for="flexRadioDefault2">Option 2</label>
  </div>
  <div>
    <input type="radio" id="flexRadioDefault3" name="flexRadioDefault" value="Option3">
    <label for="flexRadioDefault3">Option 3</label>
  </div>
  <!-- More radio buttons can be added here with the same name 'flexRadioDefault' -->
</form>

```


In JS, you get the value with:
```
document.querySelector("[name='flexRadioDefault']:checked").value
```