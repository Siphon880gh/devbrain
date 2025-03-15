
ERR_BUFFER_OUT_OF_BOUNDS when you run setDoc to add document to a Firestore collection

Which version of Node are you running? I had the same issue with the latest version 22.7.0 and downgraded to the one I used before, 22.5.0. That worked.
https://github.com/nodejs/node/issues/54518

Perhaps use nvm to switch version
nvm install 22.5.0
nvm use 22.5.0
If downloading takes long, you can downgrade to an available version on nvm, first listing the available options: nvm list 
You could use other versions that are named like: nvm use lts/iron  which is version 20.17.0

It will be fixed in node version 22.8.0
https://github.com/nodejs/node/issues/54518#issuecomment-2307687124
