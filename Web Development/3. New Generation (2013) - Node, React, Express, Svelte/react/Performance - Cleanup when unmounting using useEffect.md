This form of useEffect [] runs on mount and unmount. You can implement cleanup logic in the return statement of the callback


```
import React, { useEffect } from 'react';

function MyComponent() {
  useEffect(() => {
    // Subscription or event listener logic...
    const subscription = someCostlyOperation();

    // Return a cleanup function to be executed when the component unmounts
    return () => {
      // Clean up the subscription or event listener
      subscription.unsubscribe();
    };
  }, []); // Empty dependency array to run only once on mount

  // Rest of component logic...
  return <div>My Component</div>;
}
```

Return a function in useEffect to have React run it when the DOM is unmounted. This could clean up memory spills in a single page application (otherwise, app risks getting laggier over time).

---

So: useEffect takes an optional return function that cleans up code. For example, emptying the fields on a webpage showing report details. Equivalent to componentWillUnmount