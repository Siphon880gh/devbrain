https://chat.openai.com/c/3afd0219-8ac1-4bed-827f-8ce37fcb92b6

----

To append a dropdown with the font family names displayed in their respective font styles, you can create a `select` element and append `option` elements to it for each font family. You can then set the `font-family` style of each `option` to the corresponding font family. Here’s how you can modify the code to achieve this:

```javascript
async function getAllFontFamilies() {
  let fontFamilies = new Set();

  async function parseStyleSheet(sheet) {
    for (const rule of sheet.cssRules) {
      if (rule instanceof CSSStyleRule && rule.style.fontFamily) {
        fontFamilies.add(rule.style.fontFamily);
      } 
      // Handling @font-face rule here.
      else if (rule instanceof CSSFontFaceRule && rule.style.fontFamily) {
        fontFamilies.add(rule.style.fontFamily);
      } 
      // Handling @import rule here.
      else if (rule instanceof CSSImportRule && rule.styleSheet) {
        await parseStyleSheet(rule.styleSheet);
      }
    }
  }

  // Extract from inline styles and internal style blocks
  document.querySelectorAll('[style]').forEach(el => {
    const fontFamily = el.style.fontFamily;
    if (fontFamily) fontFamilies.add(fontFamily);
  });

  // document.styleSheets includes both internal style blocks and external stylesheets.
  Array.from(document.styleSheets).forEach(sheet => {
    try {
      parseStyleSheet(sheet);
    } catch (e) {
      console.error('Error parsing stylesheet', e);
    }
  });

  // Extract from external stylesheets
  for (const link of document.querySelectorAll('link[rel="stylesheet"]')) {
    try {
      const response = await fetch(link.href);
      const text = await response.text();
      const blob = new Blob([text], { type: 'text/css' });
      const blobURL = URL.createObjectURL(blob);
      const sheet = await new Promise((resolve, reject) => {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = blobURL;
        link.onload = () => resolve(link.sheet);
        link.onerror = reject;
        document.head.appendChild(link);
      });
      await parseStyleSheet(sheet);
      URL.revokeObjectURL(blobURL);
      document.head.removeChild(link);
    } catch (e) {
      console.error('Error fetching or parsing external stylesheet', e);
    }
  }

  // Create and append a dropdown with the font families
  const select = document.createElement('select');
  Array.from(fontFamilies).forEach(fontFamily => {
    const option = document.createElement('option');
    option.textContent = fontFamily;
    option.style.fontFamily = fontFamily;
    select.appendChild(option);
  });
  document.body.appendChild(select);

  return Array.from(fontFamilies);
}

getAllFontFamilies().then(fontFamilies => console.log(fontFamilies));
```

This modification will create a dropdown at the end of the body of the document, with each option styled with its corresponding font family.