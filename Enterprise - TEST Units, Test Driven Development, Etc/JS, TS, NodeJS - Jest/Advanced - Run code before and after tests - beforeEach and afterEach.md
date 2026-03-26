# Advanced - Run code before and after tests - beforeEach and afterEach
If you have some work you need to do repeatedly for many tests, you can use beforeEach and afterEach. When they are inside a describe block, the before and after blocks only apply to the tests within that describe block.

```
beforeEach(() => {
  initializeCityDatabase();
});

afterEach(() => {
  clearCityDatabase();
});
```