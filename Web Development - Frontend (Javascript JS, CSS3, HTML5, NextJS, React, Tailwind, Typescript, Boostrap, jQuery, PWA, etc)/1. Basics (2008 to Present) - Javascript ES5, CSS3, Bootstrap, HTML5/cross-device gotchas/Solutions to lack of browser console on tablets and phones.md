## Debugging Websites on Real Phones and Tablets

Websites are easy to debug on a computer because you can open the browser console and inspect what is happening.

You can resize your browser window to simulate a phone or tablet screen. This helps, but it is not always 100% accurate. Real devices may still reveal issues caused by screen DPI, touch behavior, browser differences, and layout changes your media queries did not fully account for, such as wrapping, spacing, overflow, or content flowing differently on smaller screens.

A website may look fine on your computer, but still have problems on a real phone or tablet. Some JavaScript may behave differently on Android vs. iPhone.

When you open the website on the actual device, you might be able to guess the problem just by looking at the screen. But sometimes you need console logs to understand what is really happening.

There are two useful ways to do this.

### Option 1: Use Safari DevTools for iPhone or iPad

If you are testing on an iPhone or iPad, you can connect the device to your computer with a cable and use Safari DevTools on your desktop.

This lets you inspect the mobile browser from your computer.

The downside is that this mainly helps with Safari testing. It does not fully cover what might happen in Chrome, Firefox, or Android browsers.

### Option 2: Add an On-Page Debug Widget

Another option is to create a small debug widget inside your website.

You can control it with a config file, such as:

```json
{
  "debugWidget": true
}
```

When debugging is turned on, a small button can appear in the corner of the page. Clicking the button expands a widget that shows logs directly on the page.

This is useful when testing on real phones and tablets because you can see logs without needing the browser console.

You can also decorate `console.log`, `console.error`, `console.warn`, and whichever console methods you use. This means each console call can do two things:

1. Send the message to your on-page debug widget.
    
2. Still send the message to the normal browser console.
    

Example:

```js
function attachConsoleToWidget(widgetEl) {
  const originalConsole = {
    log: console.log.bind(console),
    warn: console.warn.bind(console),
    error: console.error.bind(console),
    info: console.info.bind(console),
  };

  function writeToWidget(type, args) {
    const row = document.createElement("div");
    row.className = `console-row console-${type}`;

    row.textContent = args
      .map(arg => {
        if (typeof arg === "object") {
          try {
            return JSON.stringify(arg, null, 2);
          } catch {
            return String(arg);
          }
        }
        return String(arg);
      })
      .join(" ");

    widgetEl.appendChild(row);
  }

  console.log = (...args) => {
    writeToWidget("log", args);
    originalConsole.log(...args);
  };

  console.warn = (...args) => {
    writeToWidget("warn", args);
    originalConsole.warn(...args);
  };

  console.error = (...args) => {
    writeToWidget("error", args);
    originalConsole.error(...args);
  };

  console.info = (...args) => {
    writeToWidget("info", args);
    originalConsole.info(...args);
  };
}
```

The important idea is that you save the original console methods first:

```js
const originalConsole = {
  log: console.log.bind(console),
  warn: console.warn.bind(console),
  error: console.error.bind(console),
  info: console.info.bind(console),
};
```

Then your custom version can write to the widget and still call the original browser console.

This gives you a lightweight mobile debugging tool that works directly inside the page.