
Tailwind classes in React must be spelled out

This fails:
```
"use client";
import { useState } from "react";

export default function Button() {
    const [color, setColor] = useState("purple");
    return (
        <button
            className={`bg-${color}-500 text-white font-semibold py-2 px-4 rounded`}
        >
            Submit
        </button>
    );
}
```


You can't just conditionally with `className={bg-${color}-500}` because Tailwind React is optimized to scan for the classnames and only generate the css file with those class names that apply, so your source code must have the full tailwind css class even if it's not in className.

Deep dive: [https://www.youtube.com/watch?v=guh9qzxkb1o](https://www.youtube.com/watch?v=guh9qzxkb1o)