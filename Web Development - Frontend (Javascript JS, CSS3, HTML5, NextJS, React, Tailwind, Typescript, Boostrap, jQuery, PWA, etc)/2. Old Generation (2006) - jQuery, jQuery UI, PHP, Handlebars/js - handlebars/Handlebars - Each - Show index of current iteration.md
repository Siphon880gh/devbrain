In Handlebars, you can display the index of the current iteration within an `{{#each}}` loop using the built-in `@index` variable. This variable provides the zero-based index of the current item in the array. Here's how you can use it:

### Basic Usage with `@index`

Suppose you have the following data:

```json
{
  "items": ["Apple", "Banana", "Cherry"]
}
```

You can display each item along with its index like this:

```handlebars
<ul>
  {{#each items}}
    <li>{{@index}}: {{this}}</li>
  {{/each}}
</ul>
```

**Output:**

```html
<ul>
  <li>0: Apple</li>
  <li>1: Banana</li>
  <li>2: Cherry</li>
</ul>
```

### Starting Index from 1

If you prefer the index to start from 1 instead of 0, you can add `1` to `@index` using a helper. Here's how:

1. **Register a Helper**
    
    First, register a helper in your JavaScript code:
    
    ```javascript
    Handlebars.registerHelper('inc', function(value) {
      return parseInt(value) + 1;
    });
    ```
    
2. **Use the Helper in Your Template**
    
    Then, use the helper within your template:
    
    ```handlebars
    <ul>
      {{#each items}}
        <li>{{inc @index}}: {{this}}</li>
      {{/each}}
    </ul>
    ```
    

**Output:**

```html
<ul>
  <li>1: Apple</li>
  <li>2: Banana</li>
  <li>3: Cherry</li>
</ul>
```

### Accessing Other Metadata

Handlebars provides several metadata variables inside the `{{#each}}` loop:

- `@index`: Zero-based index of the current iteration.
- `@first`: `true` if the current iteration is the first.
- `@last`: `true` if the current iteration is the last.
- `@key`: The key of the current iteration (useful for objects).

**Example Using `@first` and `@last`:**

```handlebars
<ul>
  {{#each items}}
    <li>
      {{#if @first}}First Item: {{/if}}
      {{#if @last}}Last Item: {{/if}}
      {{@index}} - {{this}}
    </li>
  {{/each}}
</ul>
```

**Output:**

```html
<ul>
  <li>First Item: 0 - Apple</li>
  <li>1 - Banana</li>
  <li>Last Item: 2 - Cherry</li>
</ul>
```

### Handling Arrays of Objects

If you're iterating over an array of objects, `@index` still works the same way.

**Data Example:**

```json
{
  "fruits": [
    { "name": "Apple", "color": "Red" },
    { "name": "Banana", "color": "Yellow" },
    { "name": "Cherry", "color": "Red" }
  ]
}
```

**Template Example:**

```handlebars
<table>
  <tr>
    <th>#</th>
    <th>Name</th>
    <th>Color</th>
  </tr>
  {{#each fruits}}
    <tr>
      <td>{{@index}}</td>
      <td>{{name}}</td>
      <td>{{color}}</td>
    </tr>
  {{/each}}
</table>
```

**Output:**

```html
<table>
  <tr>
    <th>#</th>
    <th>Name</th>
    <th>Color</th>
  </tr>
  <tr>
    <td>0</td>
    <td>Apple</td>
    <td>Red</td>
  </tr>
  <tr>
    <td>1</td>
    <td>Banana</td>
    <td>Yellow</td>
  </tr>
  <tr>
    <td>2</td>
    <td>Cherry</td>
    <td>Red</td>
  </tr>
</table>
```

### Summary

- **`@index`**: Use this built-in variable to get the zero-based index of the current iteration.
- **Helpers**: Create helpers if you need to manipulate the index (e.g., start from 1).
- **Metadata Variables**: Utilize other metadata variables like `@first` and `@last` for additional control.

Ensure you're using a version of Handlebars that supports these features (Handlebars 3.0 and above). If you're using an older version that doesn't support `@index`, consider updating Handlebars or implementing custom helpers to achieve similar functionality.