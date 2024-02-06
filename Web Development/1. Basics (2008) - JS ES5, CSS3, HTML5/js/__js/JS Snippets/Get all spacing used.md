
https://chat.openai.com/c/d3450497-43e1-4311-bd99-2fc8c2c0f24b

----

Alright, I've made the adjustments to the script. Now, for each spacing value, if it can be converted to a relative unit (like `rem` or `%`), the relative value will be placed in parentheses next to the original value.

Here's the updated script:

```javascript
async function extractStyles() {
    let stylesUsed = [];

    // Get the root font size
    const rootFontSize = parseFloat(getComputedStyle(document.documentElement).fontSize);

    // Extract values from inline and internal stylesheets
    await extractFromStylesheets();

    // Extract values from inline styles
    document.querySelectorAll('[style]').forEach(elem => {
        extractStylesFromElement(elem);
    });

    // Extract computed styles from all elements
    document.querySelectorAll('*').forEach(elem => {
        let computedStyle = getComputedStyle(elem);
        for (let prop of ['padding', 'margin']) {
            for (let dir of ['Top', 'Right', 'Bottom', 'Left']) {
                let fullProp = `${prop}${dir}`;
                let value = computedStyle[fullProp];
                if (value && value !== '0px') {
                    let relativeValue = convertToRelative(value);
                    stylesUsed.push(`${value} (${relativeValue})`);
                }
            }
        }
    });

    async function extractFromStylesheets() {
        for (let sheet of document.styleSheets) {
            if (sheet.href && sheet.href.startsWith('http')) {
                try {
                    let response = await fetch(sheet.href);
                    let cssText = await response.text();
                    let blob = new Blob([cssText], { type: 'text/css' });
                    let objectURL = URL.createObjectURL(blob);
                    let tempLink = document.createElement('link');
                    tempLink.rel = 'stylesheet';
                    tempLink.href = objectURL;
                    document.head.appendChild(tempLink);
                    let tempSheet = Array.from(document.styleSheets).pop();
                    extractStylesFromSheet(tempSheet);
                    document.head.removeChild(tempLink);
                    URL.revokeObjectURL(objectURL);
                } catch (e) {
                    console.warn("Can't fetch the stylesheet of: ", sheet.href, e);
                }
            } else {
                extractStylesFromSheet(sheet);
            }
        }
    }

    function extractStylesFromSheet(sheet) {
        try {
            for (let rule of sheet.cssRules) {
                for (let prop of ['padding', 'margin']) {
                    let shorthandValue = rule.style.getPropertyValue(prop);
                    if (shorthandValue) {
                        shorthandValue.split(' ').forEach(val => {
                            let relativeValue = convertToRelative(val);
                            stylesUsed.push(`${val} (${relativeValue})`);
                        });
                    }
                    for (let dir of ['top', 'right', 'bottom', 'left']) {
                        let fullProp = `${prop}-${dir}`;
                        let value = rule.style.getPropertyValue(fullProp);
                        if (value) {
                            let relativeValue = convertToRelative(value);
                            stylesUsed.push(`${value} (${relativeValue})`);
                        }
                    }
                }
            }
        } catch (e) {
            console.warn("Can't read the css rules of: ", sheet.href, e);
        }
    }

    function extractStylesFromElement(elem) {
        let style = elem.style;
        for (let prop of ['padding', 'margin']) {
            let shorthandValue = style.getPropertyValue(prop);
            if (shorthandValue) {
                shorthandValue.split(' ').forEach(val => {
                    let relativeValue = convertToRelative(val);
                    stylesUsed.push(`${val} (${relativeValue})`);
                });
            }
            for (let dir of ['Top', 'Right', 'Bottom', 'Left']) {
                let fullProp = `${prop}${dir}`;
                let value = style[fullProp];
                if (value) {
                    let relativeValue = convertToRelative(value);
                    stylesUsed.push(`${value} (${relativeValue})`);
                }
            }
        }
    }

    function convertToRelative(value) {
        if (value.endsWith('px')) {
            let numericValue = parseFloat(value);
            if (!isNaN(numericValue)) {
                return `${numericValue / rootFontSize}rem`;
            }
        } else if (value.endsWith('%')) {
            return value; // Percentage values are already relative
        }
        return value; // Return original value if it can't be converted
    }

    return stylesUsed;
}

// Usage:
// extractStyles().then(result => console.log(result));
```

This script will now return an array of strings where each string is a spacing value followed by its relative value in parentheses. For instance, if a padding value of `32px` is found, the script will return a string like `32px (2rem)` (assuming the root font size is the default `16px`). If a value of `50%` is found, it will return `50% (50%)` since percentages are already relative.
