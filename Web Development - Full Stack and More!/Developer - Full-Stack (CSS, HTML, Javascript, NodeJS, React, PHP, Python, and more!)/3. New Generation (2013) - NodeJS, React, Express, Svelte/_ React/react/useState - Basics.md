
Requirement:

```
import React, { useState } from 'react';
```


Expose initial value which is live and setter method
The initial value is assigned from useState. That variable will be live, meaning it'll cause re-renders in the JSX like a Hot Module Replacement (HMR), also known as Hot Reloading, on a live production webpage.
The setter method is what you'll be using to reassign the value at anytime, so it can hook into React's ecosystem to cause a HMR re-render

```

const [name, setName] = useState("");

```

This syntax is from eS6 destructuring of an array. useState actually returns an array of the initial/live variable and the setter/rerender method

```
const stateArr = useState("")
const name = stateArr[0]
const setName = stateArr[1]
```
  

Here's a practical example of how an user interaction changes the value:

```

<input
  type="text"
  onChange={(event) => setName(event.target.value)}
  value={name}
/>

```

  