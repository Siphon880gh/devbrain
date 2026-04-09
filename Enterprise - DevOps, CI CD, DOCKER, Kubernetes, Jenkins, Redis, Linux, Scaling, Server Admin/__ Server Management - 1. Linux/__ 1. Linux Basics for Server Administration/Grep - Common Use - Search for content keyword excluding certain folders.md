Eg. Perform a grep to see if the private key is exposed. For example, here our keyword is SECRET - note we are excluding node_modules etc:
```
grep -nriI ./ --exclude={.git,\*.sql,package-lock.json,webpack.config.js,composer.lock,\*.chunk.css,\*.chunk.js,\*.css.map,\*.js.map} --exclude-dir={.git,.git/index,bower_components,node_modules,.sass-cache,vendor\*,\*backup\*,\*cached\*} -e "SECRET"
```