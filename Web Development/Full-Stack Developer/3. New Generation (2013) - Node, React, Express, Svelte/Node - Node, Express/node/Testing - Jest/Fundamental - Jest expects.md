# Fundamental - Jest expects
Typical section of code:
```
test('gets random number between 1 and 10', () => {
  expect(randomNumber()).toBeGreaterThanOrEqual(1);
  expect(randomNumber()).toBeLessThanOrEqual(10);
});
```

Some examples:
```
toBe(primitive value)
toEqual(expect.any(Class)); // Class can be Number, String, or your own classes.
expect(player.getHealth()).toEqual(expect.stringContaining(player.health.toString()));
expect(player.getStats()).toHaveProperty('potions');
```

Testing what's passed in console.log:
```
it('calls console.log with "hello"', () => {
  const consoleSpy = jest.spyOn(console, 'log');

  console.log('hello');

  expect(consoleSpy).toHaveBeenCalledWith('hello');
});
```

Documentation: Jest expect methods
https://jestjs.io/docs/en/expect