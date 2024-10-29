
When sharing to Twitter a link, that link's webpage meta tags can determine which preview layout to use

For example:
```
<meta name="twitter:card" content="summary"></meta>
```

Your choices include:
```
summary – Shows a small image along with the title and description.
summary_large_image – Shows a larger, more visually prominent image with the title and description.
app – Specifically for apps, allowing links to install or open the app.
player – For embedded video/audio content, allowing users to play media directly on Twitter.
```

Only one card type per-page is supported. If more than one `twitter:card` value exists in the page, the “last” one in sequence will take priority.

Configure card attribution using the following properties (these are OPTIONAL):

| `twitter:site`    | @username for the website used in the card footer. |
| ----------------- | -------------------------------------------------- |
| `twitter:creator` | @username for the content creator / author.        |

More information here:
https://developer.x.com/en/docs/x-for-websites/cards/guides/getting-started
