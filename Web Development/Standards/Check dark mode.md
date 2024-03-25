
## If dont want

As of Q1 2024, websites that support dark mode as coded in meta tag or CSS will change to dark mode.

If you are using unfamiliar CSS frameworks, you want to check if dark mode turns on black background white text causing unintended visuals. Tufte CSS has dark mode. To reverse engineer what css you need to reverse the dark mode in a CSS file. Copy to VS Code, Format Document, then look for media queries for dark mode. For example, 

```

@media (prefers-color-scheme:dark) {
    body {
        background-color: unset;
        color: unset;
    }
}

@media (prefers-color-scheme:dark) {

    .hover-tufte-underline:hover,
    .tufte-underline,
    a:link {
        text-shadow: unset;
    }
}

```

Which you place AFTER linking to the CSS framework

---

## If want

Or you may want to implement a dark mode css styling using media query detecting that a device is in dark mode:
```
.theme-a {
  background: #dca;
  color: #731;
}
@media (prefers-color-scheme: dark) {
  .theme-a.adaptive {
    background: #753;
    color: #dcb;
    outline: 5px dashed #000;
  }
}
```
^ This sample code from official: https://developer.mozilla.org/en-US/docs/Web/CSS/@media/prefers-color-scheme

For ease of testing you could have one browser devoted to dark mode. Firefox -> Settings -> Sarch: Dark