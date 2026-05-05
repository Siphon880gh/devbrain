
When importing your SVG similar as a regular image file (for example, you don't need to manipulate its internal elements), you can import it and use it in an `img` element's `src` attribute.

```javascript
import React from 'react';
// Importing SVG as an image
import yourSvg from './your-svg-file.svg';

const YourComponent = () => {
  return (
    <div>
      <h1>Here is your SVG:</h1>
      <img src={yourSvg} alt="Your SVG" />
    </div>
  );
};

export default YourComponent;
```