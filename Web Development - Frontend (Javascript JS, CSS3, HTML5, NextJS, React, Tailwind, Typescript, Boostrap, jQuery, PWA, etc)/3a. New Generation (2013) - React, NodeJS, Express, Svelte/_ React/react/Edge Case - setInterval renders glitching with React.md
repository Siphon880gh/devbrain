
Using SetInterval to change text info visually or a value but it keeps jumping back to an older value temporarily, then back to the new value temporarily? Use a combination of dangerousHTML with innerHTML. That will tell React not to re-render or reset to an older copy over that portion of the code

Using SetInterval is running too fast causing text info to change visually too fast or a value to change too fast (console.log)? SetInterval could be called and initialized multiple times per re-render, and in fact there are multiple of your SetInterval running simultaneously. Use useRef and check if already initialized before initializing the setInterval. If useRef fails, then use window scope with an initializedAlready flag but this is anitpattern to the React paradigm and doesn't look professional. Or use window.timer destined to be assigned to setInterval to check if already initialized.

```

import React, { useRef, useState, useEffect } from 'react';

function MyComponent() {
    const [secs, setSecs] = useState(0);
    const intervalRef = useRef(null);

    useEffect(() => {
        if (!intervalRef.current) {
            intervalRef.current = setInterval(() => {
                setSecs((prevSecs) => prevSecs + 1);
            }, 1000);
        }

        return () => {
            clearInterval(intervalRef.current);
            intervalRef.current = null;
        };
    }, []);

    return <div>{secs}</div>;
}
```