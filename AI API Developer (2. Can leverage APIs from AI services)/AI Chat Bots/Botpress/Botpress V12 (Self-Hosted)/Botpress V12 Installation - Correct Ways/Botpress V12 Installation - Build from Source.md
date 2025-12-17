Get from:  
[https://github.com/botpress/v12](https://github.com/botpress/v12)  

Instead of their main botpress repo then commit reset/checkout back to v12 because that will fail.
V12 repo is constantly updated to remain compatible.

Mostly version bumps as they update package versions to make sure all are still compatible (although at one angle, as long as same versions, it should be all compatible with yarn install, that's not the case because some dependencies may retire old repo links). See their commit page as of 5/16/2025. V12 is still being maintained to keep compatible:
![[Pasted image 20250517062817.png]]

Follow instructions at
https://v12.botpress.com/going-to-production/deploy/

1. `git clone git@github.com:botpress/v12.git && cd botpress`
2. `yarn cache clean` (proceed to the next step if this command fails)
3. `yarn`
4. `yarn build`
5. `yarn start`

You should be able to get it up and running very quickly.