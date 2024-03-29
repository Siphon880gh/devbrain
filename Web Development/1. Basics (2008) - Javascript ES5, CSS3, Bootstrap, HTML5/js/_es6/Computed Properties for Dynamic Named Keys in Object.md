
There is a slight difference in computed properties between ES5 and ES6

### ES5 Computed Properties

In ECMAScript 5 (ES5), if you wanted to create an object with properties that are computed or set dynamically, you would typically need to define the object first and then use bracket notation to assign values based on dynamic expressions or variables. Your example illustrates this:

```javascript
var emp = {
    id: 101, 
    name: 'Peter'
};
var department = 'dep name';
emp[department] = 'Production';
```

In this ES5 example, the `department` property is added dynamically to the `emp` object using bracket notation. The key 'dep name' is not known until runtime, and its corresponding value 'Production' is assigned to the `emp` object after its declaration.

### ES6 Computed Property Names

ECMAScript 6 (ES6) introduced a more concise and expressive way to define objects with dynamic property names right at the time of object creation. This is achieved using computed property names within the object literal syntax. You can include an expression in square brackets `[]`, which will be computed as the property name. Here’s the correct ES6 code based on your example:

```javascript
var department = 'dep name';
var emp = {
    id: 101,
    name: 'Peter',
    [department]: 'Sales'
};
```

In this ES6 example, the `department` variable's value ('dep name') is computed as the property name, and 'Sales' is assigned as its value, all within the object literal. It's more succinct and integrates the dynamic assignment within the object's definition.

### Further Example with ES6

Your last snippet seems to aim at creating an object using a computed property for a more complex structure. However, it has syntax issues. Here's the corrected version:

```javascript
var empId = 'id' + emp.id; // Assuming emp.id is dynamic
var empInfo = {
    [empId]: emp
};
```

This creates an `empInfo` object where the property name is dynamically generated (e.g., 'id101') and its value is the `emp` object.

### Conclusion

The introduction of computed property names in ES6 provides a more intuitive and concise way to handle dynamic property names in JavaScript objects. It allows for the definition of object properties using expressions evaluated at runtime, encapsulated within the object literal, enhancing readability and reducing the likelihood of errors.
