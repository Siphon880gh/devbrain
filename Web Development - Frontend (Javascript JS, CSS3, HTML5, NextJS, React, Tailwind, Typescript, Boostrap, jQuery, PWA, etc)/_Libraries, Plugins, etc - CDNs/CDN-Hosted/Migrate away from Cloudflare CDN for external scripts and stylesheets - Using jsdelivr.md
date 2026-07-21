## Situation

As of February 2025, I noticed that resources like jquery.js and font-awesome.css from Cloudflare’s CDN could take up to 30 seconds to load on certain internet connections. However, when testing other pages with no cache, I didn’t experience any issues. Cloudflare status webpage showed it was all good to go. At the time, I was exploring internet cafes, and this led me to suspect that Cloudflare's CDN might be particularly sensitive to router configurations.

Bad IPv6 router settings could slow down js and css files delivered from Cloudflare CDN. I decided to migrate away from Cloudflare’s CDN so that users with misconfigured internet could still load my pages smoothly. 

The pages on bad connections are either white screens for a long time or it loads but the font-awesome icons don't load:
![[Pasted image 20250205013424.png]]

I had numerous apps that relied on cdnjs.cloudflare.com. Here is a collection of scripts to help in this task.

## Instructions

Let's say you grep for cdnjs.cloudflare.com ignoring .git and node_modules, command looking like (Note the path in this command is ./ at grep -nriI .  - adjust as appropriately.
```
grep -nriI . --exclude={.git,\*.sql,package-lock.json,webpack.config.js,composer.lock,\*.chunk.css,\*.chunk.js,\*.css.map,\*.js.map} --exclude-dir={.git,.git/index,bower_components,node_modules,.sass-cache,vendor\*,\*backup\*,\*cached\*} -e "cdnjs.cloudflare.com"
```

![[Pasted image 20250202204901.png]]

That’s long. Let’s first focus on converting handlebar cloudflare url to jsdeliver url recursively. At a later section I will reveal steps to batch this effort.

----

If to remove one external source, take a look at this recursive substitution command:
```
find . -type f \( -name "*.php" -o -name "*.html" \) -exec perl -pi -e 's|STRING_1|STRING_2|gi' {} +
```

So it’s actually:
```
find . -type f \( -name "*.php" -o -name "*.html" \) -exec perl -pi -e 's|https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.1.2/handlebars.min.js|"https://cdn.jsdelivr.net/npm/handlebars@4.1.2/dist/handlebars.min.js|gi' {} +
```
You got the jsdeliver source by some researching (looking up the library and the version) at [https://www.jsdelivr.com/](https://www.jsdelivr.com/)
![[Pasted image 20250202204951.png]]

![[Pasted image 20250202205006.png]]

Then typically you want to grep  for handlebars.min.js to confirm they’re no longer Cloudflare (Note the path in this command is ./ at `grep -nriI .`  - adjust as appropriately.
```
grep -nriI . --exclude={.git,\*.sql,package-lock.json,webpack.config.js,composer.lock,\*.chunk.css,\*.chunk.js,\*.css.map,\*.js.map} --exclude-dir={.git,.git/index,bower_components,node_modules,.sass-cache,vendor\*,\*backup\*,\*cached\*} -e "cdnjs.cloudflare.com"
```

---


If you have a lot of files, perform a grep and redirecting the output to a text file (outside where your webpages are).

The command becomes:
```
grep -nriI . --exclude={.git,\*.sql,package-lock.json,webpack.config.js,composer.lock,\*.chunk.css,\*.chunk.js,\*.css.map,\*.js.map} --exclude-dir={.git,.git/index,bower_components,node_modules,.sass-cache,vendor\*,\*backup\*,\*cached\*} -e "cdnjs.cloudflare.com" > ../a.txt
```

And the file contents may look like:
![[Pasted image 20250202205032.png]]  

Take care of link href’s:
`.*href="(.+?)".*`  → `$1` 

Take care of script src’s:
`.*src="(.+?)".*`  → `$1` 

Then check it’s work:
![[Pasted image 20250202205052.png]]

There may be sections that didn’t normalize. It could just be referring to cloudflare for different reasons (like in a tutorial) describing a cloudflare source. Or it could be part of javascript or part of php or is quoted differently using single quotes instead. You should manually change them to urls:
![[Pasted image 20250202205104.png]]

Search for single quotes. After it’s been normalized

We remove duplicates. You can either create a nodejs script that will place them into a set then spit them back out as line separated values again.Or if using Google Sheet, you create a filterable table and sort the column head A-Z, then you manually delete alikes (leaving only one):
![[Pasted image 20250202205122.png]]

You can take advantage of Search to do highlighting:
![[Pasted image 20250202205132.png]]

Such that one is left:
![[Pasted image 20250202205141.png]]

There may be variations of a similar file that’s minified (`*.min.css` /  `*.min.js`) or those that have relative protocol (// instead of https://)

---

After the substitution is done, do a final grep to make sure you didn’t mess anything. It’s possible if manually pruning the duplicates, you may have overpruned uniques that look too similiar:

For example, one number off but they look the same width:
```
https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.2/handlebars.min.js
https://cdnjs.cloudflare.com/ajax/libs/handlebars.js/4.0.5/handlebars.min.js
```

FYI: The final command to substitute text recursively at the folder you’re in would be:
```
find . -type f \( -name "*.php" -o -name "*.html" \) -exec perl -pi -e '
s|//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css|https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.css|gi;
s|//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js|https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js|gi;
s|//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css|https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.12.1/css/all.min.css|gi;
s|//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js|https://cdn.jsdelivr.net/npm/moment@2.18.1/min/moment.min.js|gi;
' {} +
```

FYI: But to make the google spreadsheet to create the substitution pairs, we probably will copy that column of substitution pairs into a reqs.txt, so the final final command would become (while you're inside the folder of html/php files and the reqs.txt is on the outside to prevent self-substituting):
```
 find . -type f \( -name "*.php" -o -name "*.html" \) -exec perl -pi -e "$(cat ../req.txt)" {} +
```

Therefore the third column **FORMULA**, let's say at C2:
```
=CONCATENATE("s|", SUBSTITUTE(A2, "@", "\@"), "|", SUBSTITUTE(B2, "@", "\@"), "|gi;")
```
^ We chose perl’s `perl -pi -e`  over sed because sed although popular, is inconsistent with syntax across operating systems.
^ ` =CONCATENATE("s|", SUBSTITUTE(A2, "@", "\@"), "|", SUBSTITUTE(B2, "@", "\@"), "|gi;") ` simplifies into ` =CONCATENATE("s|", A2, "|", B2, "|gi;") ` but because jsdelivr sometimes has "@" for versioning which messes up perl substitution and tells it to cut ahead on text, that we have to escape the "@" character.

Now prepare the spreadsheet by filling in the second column (The Non-Cloudflare link):
![[Pasted image 20250206230112.png]]

The “Command to run in terminal” is generated from the prior cells to create the perl recursive substitute text command

Now comes the next tedious part which is to fill in their jsdelivery equivalent so we can substitute and migrate away from cloudflare  

---

Once the table is finished:

![[Pasted image 20250206230318.png]]

Once the table is finished... you want to double check the accuracy. It's quite possible to copy the js url to a css row, or vice versa.

search css
![[Pasted image 20250206230528.png]]

All highlighted are css, therefore if you have one highlighted cell, its entire row should be highlighted. Otherwise, you need to check why there was a mismatch

The reason why we don't check with js is because the convention for some of these CDN asset services is that all css files must end with .css in URL, but js files do not need to end with js at the URL. Proof:
Eg. https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.0 serves a js file, which is NOT obvious from the url because the URL does not end with ".js"
Eg. https://cdn.jsdelivr.net/npm/d3@7.8.5/dist/d3.min.js serves a js file, which is obvious from the url because the URL ends with ".js"

---

Then, you’ll want to copy all of the partial command column (excluding header) and paste into a `req.txt` file (however you want to name it):
![[Pasted image 20250206233114.png]]

Make sure that text file is **outside** the folder that has all the recursive html and php files you will be substituting. 

Cd into **inside** the folder that has all the recursive html and php files, then run this command:
```
find . -type f \( -name "*.php" -o -name "*.html" \) -exec perl -pi -e "$(cat ../req.txt)" {} +
```

It may appear to "hang" for a short time. But that's better than having any errors.

OPTIONAL: Once it's done, perform a final grep to see that the Cloudflare sources have been changed in all your apps/pages:
```
grep -nriI . --exclude={.git,\*.sql,package-lock.json,webpack.config.js,composer.lock,\*.chunk.css,\*.chunk.js,\*.css.map,\*.js.map} --exclude-dir={.git,.git/index,bower_components,node_modules,.sass-cache,vendor\*,\*backup\*,\*cached\*} -e "cdnjs.cloudflare.com"
```

OPTIONAL: If you find there are still some cdnjs.cloudflare.com because they're in other file types, you can decide rather to expand beyond .php and .html by adjusting the command.
```
find . -type f \( -name "*.php" -o -name "*.html" -o -name "*.handlebars" -o -name "*.txt" \) -exec perl -pi -e "$(cat ../req.txt)" {} +
```

For some gotchas... you might get some bad results:
```
    <script src="https:https://cdn.jsdelivr.net/npm/jquery-ui-touch-punch@0.2.3/jquery.ui.touch-punch.min.js"></script>  
    <link rel="stylesheet" href="//https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.13.1/css/all.min.css">
```

So run this one over:
```
find . -type f \( -name "*.php" -o -name "*.html" -o -name "*.handlebars" -o -name "*.txt" \) -exec perl -pi -e '
s|//https://|https://|gi;
s|https:https://|https://|gi;
' {} +
```

**Congratulations!** This should. cover it all.

---
## Appendix (Optional)

Note: Instead of writing find/pearl and grep commands from global npm scripts:
[https://github.com/Siphon880gh/global-npm-scripts](https://github.com/Siphon880gh/global-npm-scripts)  

You can use my global npm scripts which already included them, so you can run for grepping:
```
npm run gr --prefix ~/npm/ -- `pwd` cdnjs.cloudflare.com
```

Which is a lot easier syntax. It changes the package.json directory temporarily to home directory where your ~/npm/package.json is, then it passes through arguments of your current folder and the search term.