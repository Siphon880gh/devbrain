
Default style is not geared towards readability even though you think it should. Here are css classes that style the base tags H1, H2, etc

H1 h2 not 1995. No classes needed. Style based on html tags
https://chat.openai.com/c/8782a328-bb38-4058-9959-f53bf002d555

- Typebase.css: This is a minimal and extensible base typography stylesheet that styles basic HTML elements without classes, focusing on proper typography and readability.
- Tufte CSS: Inspired by the work of Edward Tufte, this CSS provides tools to style web articles using the ideas of Tufte, focusing on readability and the effective presentation of information, though it's more specific to text-heavy content.

For Tufte, you may want to remove the body paddings if you’re combining with Bootstrap container etc and you may want to remove the dark mode. Tufte has some outdated style changes and undesirable normalization, so I bring back with this style block following after Tufte:

```
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tufte-css/1.8.0/tufte.min.css" rel="stylesheet">  
    <style>
      body {
        width: unset;
        margin-left: unset;
        margin-right: unset;
        padding-left: unset;
        max-width: unset;
      }
      a {
        text-shadow: none !important;
      }

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
    @media (max-width: 760px) {
        body {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    }
    /* Remove the underline on links that have fa icon or image. Tufte uses 1px background as underline */
    a:has(> img), a:has(> .fa), a:has(> .fas) { 
        text-decoration: none;
        background: 0 !important;
    }
    /* Bring back listing style */
    ul, ul > li, ol, ol > li, li {
        padding-left: revert !important;
        list-style: unset !important;
    }
    /* Turn off device preferring dark mode from having separate styles */
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
    </style>
```

Example Tufte
![](https://i.imgur.com/KajLILs.png)

- **Typographic**: Typographic is an SCSS responsive typography framework with vertical rhythm. It has sensible defaults and is designed to be overridden. It's an excellent tool for ensuring consistency in your typography across different devices and screen sizes.
- **Text.css**: Text.css is a minimal CSS framework that provides basic styling for typography without the need for classes. It's designed to make the text on web pages more readable and visually appealing.
- **Gutenberg**: A web typography reset/normalize style sheet which is specifically designed for web content. Gutenberg aims to provide a solid foundation for typography, has built-in styles for semantic HTML tags, and ensures consistency across browsers.
- **Basscss**: While not solely focused on typography, Basscss provides low-level utility classes for design. It includes base element styles and utilities for typography, ensuring that the text is readable and that the overall design is clean and responsive.
- **Chota**: Chota is a super lightweight CSS framework (only 3kb minified and gzipped) that doesn't require any classes for the basic styling of elements. It includes a simple grid and some typography styles to make content readable and clean.
- **Marx**: Marx is a classless CSS reset that styles raw HTML elements without the need for classes or JavaScript. It's designed to be a lightweight and simple starting point for building web pages and includes basic styles for typography, buttons, forms, and tables.
- **Pico.css:** A minimalist and lightweight starter kit that prioritizes semantic syntax, making every HTML element responsive and elegant by default. [https://picocss.com/](https://picocss.com/)
    

When selecting a framework or library, consider your specific needs regarding typography and overall design. Some frameworks may offer more extensive styling options or customization features than others, so it's essential to choose one that aligns with your design goals and preferences.