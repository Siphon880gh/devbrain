Mnemonic  [https://unpkg.com/](https://unpkg.com/) think three letters PKG or no vowels (and a silent c behind k)

Similar to jsdelvr but missing many features from url formulas

However there is directory index viewing

There is no minification from just adding min (which can be a major disadvantage when it comes to performance when you load that css or js file if the author didn’t provide a minified version)
there is no default file by ommiting the ending slash

Slight url changes. It’s not really meant for you to go from url to url to switch between user interface and url file

Direct link in `<script src>` is:
https://unpkg.com/highlight.js@9.12.0/lib/highlight.js

View file in browser with user interface:
- So direct link to file is: no subdomain app and no files/ after the package name
https://app.unpkg.com/highlight.js@9.12.0/files/lib/highlight.js

![[Pasted image 20250405190914.png]]


The intended use is after you browsed on their interface, you can click “View Raw” to get the url for link or script tags. Also there’s bread crumb to let you browse

![[Pasted image 20250405190949.png]]+

---


And you can switch versions at the top right:
![[Pasted image 20250405191008.png]]


Visiting a url without version number will redirect to latest version. As of 4/5/2025:
- Visiting https://app.unpkg.com/tailwindcss redirects to https://app.unpkg.com/tailwindcss@4.1.3

---


Some are poorly maintained mirrors or wrong repo entirely
- With poorly maintained mirrors, there's usually older versions on there (their team forgot to update the mirror) or only the main versions instead of being exhaustive (their team's SOP is to update the mirror only on major versions). Some variation of the name may include adding the suffix "js" or "css" or being hyphenated, etc, whatever convention they use.

This one is poorly maintained only having major versions:
https://app.unpkg.com/tailwind

This one is the official exhaustive with all the versions:
https://app.unpkg.com/tailwindcss

---

Some are only the npm versions and missing the global script versions (see if has umd or es scripts at least). Some whose es scripts work on npm but not in web browser with `<script type="module">.