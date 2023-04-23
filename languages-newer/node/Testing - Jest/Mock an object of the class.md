# Mock an object of the class

Create __mocks__/Potion.js and add the following code. The __mocks__ folder must be in the same folder as where the original Potion.js is. So a file structure like this:
-----------------------------
| lib/                      |
|    Potion.js              |
|    __mocks__/             |
|              Potion.js    |
-----------------------------

The __mocks__/Potion.js would look like:
```
module.exports = function() {
  this.name = 'health';
  this.value = 20;
};
```

At your Potion.test.js file, initialize mock after requiring the class
const Potion = requier("../lib/Potion");
jest.mock('../lib/Potion');