
So for example, if you have fetch in useEffect, fetch would run twice, spiking up server bandwidth costs.

>Turn off React StrictMode by removing the `<React.StrictMode>` or `<StrictMode>` wrapping at index.js

Why? A significant change that broke things was introduced in React 18: while Strict Mode is active, all components mount and unmount before being remounted again