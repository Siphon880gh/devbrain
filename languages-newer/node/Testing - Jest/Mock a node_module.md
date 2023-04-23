# Mock a node_module

Normally you place __mocks__/*.js file in the same location as where the node js file you are testing. You can't do that for node_modules.

Let's say you already wrote fs read functions, you can mock it with:

```
const fs = require('fs');
jest.mock('fs');
fs.readFileSync.mockReturnValue('fake content');
```