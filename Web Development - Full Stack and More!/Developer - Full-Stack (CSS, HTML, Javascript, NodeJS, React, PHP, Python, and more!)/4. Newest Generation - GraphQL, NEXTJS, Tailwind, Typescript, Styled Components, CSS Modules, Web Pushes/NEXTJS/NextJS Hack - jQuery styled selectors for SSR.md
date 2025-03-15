
Let's say you need to fetch an external HTML page, then on the backend it needs to manipulate the HTML content on the server before presenting them to the Next.js page. Let’s say you want to have an easier time manipulating the external HTML page by using jQuery styled selectors.

You will need to install both jsdom and jquery (not the traditional js library

In this example, we'll fetch a simple HTML, manipulate it by changing the text of an element, and then send the manipulated content to the front end.

First, you'd have a Next.js API route that uses `jsdom` to manipulate an HTML string:

```javascript
// pages/api/manipulateHtml.js
import { JSDOM } from 'jsdom';

export default function handler(req, res) {
  const htmlContent = `
    <!DOCTYPE html>
    <html>
    <body>
      <h1 id="myheader">Original Header</h1>
    </body>
    </html>
  `;

  const dom = new JSDOM(htmlContent);
  const $ = require('jquery')(dom.window);

  // Use jQuery to change the text of the header
  $('#myheader').text('Changed Header');

  // Send the manipulated HTML as a response
  res.status(200).send(dom.serialize());
}
```

Then, in your Next.js page, you could fetch this manipulated HTML and display it:

```javascript
// pages/index.js
import { useState, useEffect } from 'react';

export default function Home() {
  const [htmlContent, setHtmlContent] = useState('');

  useEffect(() => {
    fetch('/api/manipulateHtml')
      .then(response => response.text())
      .then(data => {
        setHtmlContent(data);
      });
  }, []);

  return (
    <div>
      <div dangerouslySetInnerHTML={{ __html: htmlContent }} />
    </div>
  );
}
```

In this setup, when the Next.js page loads, it calls the API route, which manipulates an HTML string using jQuery within a `jsdom` environment and returns the manipulated HTML. The page then injects this HTML into the DOM.

It's important to note that this example is quite artificial and is just meant to illustrate the mechanics. In real-world applications, you'd likely have more complex and meaningful interactions with the HTML content. Additionally, direct manipulation of HTML like this is rare in Next.js applications due to React's powerful server-side and client-side rendering capabilities.
