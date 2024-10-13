# Basic
1. Have a npm script:
```
"test": "jest"
```

2. Have a test folder:
```
__test__
```
3. All test files inside this folder must be named as __.test.js
```
__test__/ClassName.test.js
```

Keep naming conventions for __.test.js because Jest can report test coverage

4. A test file can be like this:
```
const PortDetector = require("../lib/Port");

describe("Test port detector", () => {
    test("Test port is 3001 when running tests on localhost", () => {
        const portDetector = new PortDetector();

        // Port Detector returns an object
        expect(portDetector).toEqual(expect.any(Object));

        // Port is 3001
        expect(portDetector.port).toBe(3001);
    });
});
```

5. To run tests, at the root folder in terminal:
```
npm test
```

Note: test is one of the npm scripts that don't need "run" in `npm run scriptName`. Another is start.