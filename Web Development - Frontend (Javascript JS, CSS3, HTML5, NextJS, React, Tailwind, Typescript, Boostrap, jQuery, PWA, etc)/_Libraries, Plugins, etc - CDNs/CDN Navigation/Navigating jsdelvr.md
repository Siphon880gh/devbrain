Mnemonic https://www.jsdelivr.com/ think no duplicated characters. So no second e, so jsdelvr

## Basics

A cdn that you can easily find the cdn you want using their directory listing interface
[https://cdn.jsdelivr.net/npm/font-awesome](https://cdn.jsdelivr.net/npm/font-awesome@latest/)/
![[Pasted image 20250405184055.png]]

You can select a version near the top right:
![[Pasted image 20250405184114.png]]


Let's say you're looking for a css file
1. You've clicked through folder css
   ![[Pasted image 20250405184222.png]]

2. Clicking font-awesome.min.css will give you the file url that can be linked to:
   https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css
   ![[Pasted image 20250405184231.png]]

There's also a breadcrumb for you to navigate back any path

---

## Nuances - Css file referring to other files

Revisiting the font-awesome.min.css above:

```
/*!
 *  Font Awesome 4.7.0 by @davegandy - http://fontawesome.io - @fontawesome
 *  License - http://fontawesome.io/license (Font: SIL OFL 1.1, CSS: MIT License)
 */@font-face{font-family:'FontAwesome';src:url('../fonts/fontawesome-webfont.eot?v=4.7.0');src:url('../fonts/fontawesome-webfont.eot?#iefix&v=4.7.0') 
```

You see font files being referenced. This snippet is truncated... there are more font files.
- If linking directly to cdn is fine, because those relative files exist on the cdn server.
- If downloading to your code base, you have to download the font files and preserve the folder relationship (go up one path and add folder "fonts").

---

## Nuances - Library / Framework name may not be correct one for the url

### Wrong repo entirely

Tailwind is NOT `https://cdn.jsdelivr.net/npm/tailwind/`. It’ll open some code, but it wont be the correct ones! It even has the wrong versions numbers. It's something else that takes the tailwind name. It's not a CSS Utilities Framework, but a base module for streaming and evented CQS applications (multithreaded software).
- FYI Command-Query Separation is CQS.
- A principle in programming that states a method should either perform an action (a command) or return data (a query), but not both. Reworded: Promotes clarity and simplicity in code by separating actions from data retrieval, making it easier to understand and maintain.


Correct is: https://cdn.jsdelivr.net/npm/tailwindcss/

### Poorly maintained mirrors

Some are unmaintained mirrors so there's usually older versions on there (their team forgot to update the mirror) or only the main versions instead of being exhaustive (their team's SOP is to update the mirror only on major versions). Some variation of the name may include adding the suffix "js" or "css" or being hyphenated, etc, whatever convention they use.


---

## Advanced - End in forward slash or not

The ending slash matters
[https://cdn.jsdelivr.net/npm/bootstrap/](https://cdn.jsdelivr.net/npm/bootstrap/)
![[Pasted image 20250405184737.png]]

Without ending slash:
![[Pasted image 20250405184747.png]]

So without ending slash would open a default file. In Bootstrap's case, the default file is the minified css file of the latest bootstrap. The intention is to make it easy for developers to type the cdn url into the link tag from memory.


Sometimes there is no default file, then it just redirects to the latest version:
- https://cdn.jsdelivr.net/npm/tailwindcss redirects to https://cdn.jsdelivr.net/npm/tailwindcss@latest, which is an alias for https://cdn.jsdelivr.net/npm/tailwindcss@4.1.2 (As of 4/4/2025
- This contrasts with bootstrap where https://cdn.jsdelivr.net/npm/bootstrap is an alias for the latest version’s minified css file


---

## Advanced - Automatic Minification

There’s automatic minification based on the url. See this only has default.css. There is no default.min.css:
![[Pasted image 20250405184955.png]]

But you can load a minified default.css into the link tag like so:
[https://cdn.jsdelivr.net/npm/highlightjs@9.16.2/styles/default.min.css](https://cdn.jsdelivr.net/npm/highlightjs@9.16.2/styles/default.min.css)


---

## For More - Official Docs

When you visit jsdelivr.com, that’s what that panel is about, much of what we discussed, plus more:
![[Pasted image 20250405185112.png]]

There’s a full docs button at the bottom right for even more nuances (full docs on jsdelivr npm describes omitting the final slash to get the default file).