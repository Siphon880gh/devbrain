Let’s say you want to download jquery and bootstrap external scripts and stylesheets to use them in your script src and link href tags.

Yarn can download modules, isomorphics (can be either modules or not), or external scripts/stylesheets. It's difficult to distinguish which is which because you have to read their Readme's which might mention isomorphic/module/etc, or it might not.

Another problem is Yarn tends to only keep the minor versions of the most recent major versions. The older major versions will only have a few minor versions available. You'll see this with Font-Awesome (Actually both npm and yarn have this problem).

But if you still want to proceed:
But if you still want to proceed:
```
yarn add jquery bootstrap
```

And you can install with version specificity:
```
yarn add bootstrap@5.3.2
```

 You may want to recursively ls the files under the hood and only show file paths that end with min.js and min.css:
```
find node_modules -type f \( -name "*.min.js" -o -name "*.min.css" \)
```
^ Tip: For future adding more libraries, you may want to add this command as a npm script called "browser", so you don't have to memorize the command or refer back to this guide.

If you’re not used to the various min.js, and min.css (because bootstrap can provide pieces of min.css or the entire min.css), feed it to AI to ask it to explain or to pick the main ones - overtime you will learn
```
Wengs-MBP-New temp % npm ls --parseable | xargs -I {} find {} -type f \( -name "*.min.js" -o -name "*.min.css" \)  
/Users/wengffung/dev/web/temp/node_modules/@popperjs/core/dist/umd/popper-base.min.js  
/Users/wengffung/dev/web/temp/node_modules/@popperjs/core/dist/umd/enums.min.js  
/Users/wengffung/dev/web/temp/node_modules/@popperjs/core/dist/umd/popper-lite.min.js  
/Users/wengffung/dev/web/temp/node_modules/@popperjs/core/dist/umd/popper.min.js  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap-grid.rtl.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap-grid.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap.rtl.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap-reboot.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap-utilities.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap-utilities.rtl.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap-reboot.rtl.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/js/bootstrap.esm.min.js  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/js/bootstrap.min.js  
/Users/wengffung/dev/web/temp/node_modules/jquery/dist/jquery.slim.min.js  
/Users/wengffung/dev/web/temp/node_modules/jquery/dist/jquery.min.js  
/Users/wengffung/dev/web/temp/node_modules/font-awesome/css/font-awesome.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap-grid.rtl.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap-grid.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap.rtl.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap-reboot.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap-utilities.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap-utilities.rtl.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/css/bootstrap-reboot.rtl.min.css  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/js/bootstrap.esm.min.js  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js  
/Users/wengffung/dev/web/temp/node_modules/bootstrap/dist/js/bootstrap.min.js  
/Users/wengffung/dev/web/temp/node_modules/font-awesome/css/font-awesome.min.css  
/Users/wengffung/dev/web/temp/node_modules/jquery/dist/jquery.slim.min.js  
/Users/wengffung/dev/web/temp/node_modules/jquery/dist/jquery.min.js
```