**Note:** This is a writeup of why you don't listen to ChatGPT for Botpress V12 installation (Actually, you can't rely on it for any Botpress suggestions without paid Deep Research feature on)

To build from source then install, get from:  
[https://github.com/botpress/v12](https://github.com/botpress/v12)  

Instead of their main botpress repo then commit reset/checkout back to v12 because that will fail.

---

## Explanation why incorrect

While it's tempting to have ChatGPT guide you through installation, as of 5/2025, ChatGPT often suggests you to clone https://github.com/botpress/botpress directly, then reset to the tag `v12.26.7`. 

After installing, you run `yarn start`. The terminal shows that a messaging module is missing. But it appears the port has been successfull started and listening at. You visit localhost at the port anyways, but you see this on the web browser:
```
Error occured while trying to proxy: localhost:4000/
```

> [!note] FYI - What is messaging module
> Multi-channel messaging ability to deploy across multiple communication platforms such as web chat, fb, tele, slack, twilio, Teams, etc

Going back to the messaging module is missing error on the terminal: You ask ChatGPT about it. It tells you that `v12.26.6` has removed messaging module and instead have it as a separate repo, then it suggests you to reset to `v12.26.5` instead because it has the messaging module in the codebase.

You go on `v12.26.5` and then encounter the same error about a missing messaging module when you run `yarn start`. ChatGPT when asked, now corrects itself and apologizes, and then claims that the last the messaging module was still found was in `v12.26.4`. This keeps happening and then you realize ChatGPT is just hallucinating.

You realize it doesn't matter that the messaging module is missing, because you can find the botpress organization on github and get their messaging repo https://github.com/botpress/messaging. You cd into packages/ and then you clone that messaging into the folder messaging so you have a new folder `packages/messaging`. You know to do this because the missing module error gave you the path that was ENOENT (Error No Entity):
```
yarn start
...
Error: spawn _________/botpress/packages/bp/dist/bin/messaging ENOENT
```

Now comes another problem. Your botpress module's current state is out of sync with messaging's current state because you had resetted to an older commit for botpress but messaging repo is at the newest commit.

Since messaging module is figured out, you will go for the latest V12 Botpress before they moved to sole Cloud platform (their repo would have you run `bp login` that opens the web browser where you manage your chat bots on their Cloud platform).

You reset botpress repo to `v12.30.9` and you reset the messaging repo to `v1.2.10`. You arrived at these versions because for botpress, by navigating and comparing their dates to make sure they're released at reasonably similar points in time:
- [https://newreleases.io/project/github/botpress/botpress/release/v12.30.9](https://newreleases.io/project/github/botpress/botpress/release/v12.30.9)  
- [https://github.com/botpress/messaging/releases/tag/v1.2.10](https://github.com/botpress/messaging/releases/tag/v1.2.10)

You now go into the messsaging repo to run `yarn` (to install), then `yarn build` (to build). Fail or not, next you go to the root then run `yarn`, then `yarn build` 
- You find it necessary to add gulp before running yarn (and at first you added gulp, the latest version, but then it failed, so Chat eventually told you that Botpress V12 expects the older Gulp v4, so:
  ```
  yarn add gulp@^4.0.2 -W
	```
- You then find it complaining about node-svm. When asked Chat, it said that the node-svm is no longer available on Yarn registry because it has been removed for security concerns. Chat does say the ndu is optional in botpress, used for NLU training and intent/entity detection or debugging NLU related workflows, so it recommends to remove ndu so that node-svm won't run and error:
```
rm -rf modules/ndu
```

After those errors are resolved, you still find them failing because of various permutations of:
- error bp_main@12.25.0: The engine "node" is incompatible with this module. Expected version "^12". Got "16.0.0" 
- parcel@2.15.1: The engine "node" is incompatible with this module. Expected version ">= 16.0.0". Got "12.22.12"

You can use nvm to switch to using v12.22.12 at the botpress root, but when you install and it changes into other folders (because the npm scripts have `yarn workspaces` command which allows recursively going into folder to install more packages with yarn), that's when node conflicts happen. You research into whether nvm or volta can switch node version. You find that with volta, you can update the npm scripts to switch versions before the `yarn workspace` command. That's going to take a lot of trial and error because there are several package.json and you have to map out which folder the `yarn workspace` command references and when it references. 

You figured it's a matter of package.json dependencies updating to latest minor and patch versions because much of the versions are prefixed with `^` which is best practice and the default of what happens when the original author installed packages and npm adds the packages to package.json... however developers of these dependencies did not practice NOT breaking their package with minor and patch updates. Recall that the version number is conventionally: `[major].[minor].[patch]` and breaking changes are what advances the number at `[major]`. 

So the solution is to make all dependencies install at their exact versions or the troublesome package to install at the exact version or lower version. 

Note that the package complaining could actually be the name of your repo:
- error bp_main@12.25.0: The engine "node" is incompatible with this module. Expected version "^12". Got "16.0.0" 
There is no bp_main package in npm registry as of 5/2025. That's the name assigned to the root package.json, and the expected node version here is really from package.json's engines.node field. You either correct that package.json's node version or add a .nvmrc to yield to that node version (make sure to `nvm use`). This is in addition to replacing all the package.json's prefix `^`.

Consideration: You may think that's an overkill to exact all the dependencies because you know what the problematic dependency is because it complained about the node expect and got mismatch. (Eg. `parcel@2.15.1: The engine "node" is incompatible with this module. Expected version ">= 16.0.0". Got "12.22.12"`). You can indeed remove that package and re-add it at a lower version OR remove the prefix "^". There is still the chance that you'll bump into another package downstream that complains about node version! So may as well lock down all the versions exactly - let's continue.

You perform a wide sed to replace all `"^` in package.json's to `"`, however the sed command that ChatGPT gave you was wrong because it's platform specific and you forgot to mention you're on a Mac. Instead, you opted to go to VS Code to do a replacement.
![[Pasted image 20250517031153.png]]

You click Replace All after you've mapped out search and replacing to `"\^` and `"` and the files to include to be `**/package.json`
![[Pasted image 20250517031224.png]]

You clear all at both messaging/ and root/:
```
rm -rf node_modules
yarn clean cache
```

Then you reinstall and re-build with `yarn` and `yarn build`, at messaging/, then at root/

Now you have another problem. It just hangs at warnings:
```
warning workspace-aggregator-d607b464-b697-46b8-8629-8052949d2851 > @botpress/module-builder > @babel/preset-env > @babel/plugin-proposal-nullish-coalescing-operator@7.18.6: This proposal has been merged to the ECMAScript standard and thus this plugin is no longer maintained. Please use @babel/plugin-transform-nullish-coalescing-operator instead.  
warning workspace-aggregator-d607b464-b697-46b8-8629-8052949d2851 > @botpress/module-builder > @babel/preset-env > @babel/plugin-proposal-unicode-property-regex@7.18.6: This proposal has been merged to the ECMAScript standard and thus this plugin is no longer maintained. Please use @babel/plugin-transform-unicode-property-regex instead.  
warning workspace-aggregator-d607b464-b697-46b8-8629-8052949d2851 > @botpress/messaging > pkg > prebuild-install > npmlog@4.1.2: This package is no longer supported.  
warning workspace-aggregator-d607b464-b697-46b8-8629-8052949d2851 > @botpress/messaging > eslint > @humanwhocodes/config-array > @humanwhocodes/object-schema@1.2.1: Use @eslint/object-schema instead  
warning workspace-aggregator-d607b464-b697-46b8-8629-8052949d2851 > @botpress/messaging > @types/conventional-changelog > @types/conventional-changelog-core > @types/conventional-recommended-bump@10.0.3: This is a stub types definition. conventional-recommended-bump provides its own type definitions, so you do not need this installed.  
warning workspace-aggregator-d607b464-b697-46b8-8629-8052949d2851 > @botpress/messaging > @parcel/transformer-babel > @parcel/babel-ast-utils > @parcel/babylon-walk > lodash.clone@4.5.0: This package is deprecated. Use structuredClone instead.
```

Possibilities why it's hanging when no error is being shown is some sort of network timeout or some tool that's running outside of the npm/yarn is in a while loop. Another possibility is that a node module's url has been retired! More technically:
- You’re likely hitting native packages that hang or fail silently during build (e.g., `node-gyp`).
- Even the registry resolution may pause indefinitely due to incompatibilities or lack of polyfills in Node 12.

Even trying to rule out the problems don't help:
```
YARN_IGNORE_ENGINES=1 arch -x86_64 yarn install --ignore-optional --network-timeout 60000 --ignore-scripts  --ignore-engines --verbose
```

This shows that you can't just revert to an old commit and install modules. Fortunately, Botpress as of 5/2025 has been maintaining V12, not in the sense of adding features, but in the sense that whenever dependencies have changed so far that their automated build test fails, there's a reconcile, commit, and bumping up of the version. This occurs at their official V12 repo:
https://github.com/botpress/v12. Follow our guide [[Botpress V12 Installation - Build from Source]] which will involve the official V12 repo.


---

## Appendix

Here's a short retelling of the commands and actions that have been taken:

**Build from Source**
```
git clone https://github.com/botpress/botpress.git  
cd botpress  
git checkout v12.30.9 
```


Go into packages to clone in messaging that's a separate repo
```
cd packages  
git clone https://github.com/botpress/messaging.git messaging  
cd messaging  
git checkout v1.2.10  
```


Then replaced all `"\^`  with `"` in all package.json's (but not inside node_modules)

cd back into the root of botpress, then switch to node 12.22.12 (`nvm use 12.22.12` ). It's to avoid this future error `error bp_main@12.26.7: The engine "node" is incompatible with this module.`:

```
nvm use 12.22.12
```
- if nvm cli instructs you to, then install 12.22.12 too

Install older version gulp (which is used for yarn building botpress):
```
yarn add gulp@^4.0.2 -W  
```

Install modules:
```
yarn  
```
^  If you're on Mac ARM (arch arm64), your screen will look crazy with a lot of lines that starts with `c++` . There will be many and it'll take a while. Node.js doesn't ship a precompiled binary for your platform and it's building from source.  

Remove ndu because it'll complain about node-svm when building botpress. The node-svm is no longer available on Yarn registry because it has been removed for security concerns. The ndu is optional in botpress, used for NLU training and intent/entity detection or debugging NLU related workflows
```
rm -rf modules/ndu  
```

Build botpress using yarn (which will referring to package.json then use gulp) - this will be a long process:
```
yarn build
```

Start:
```
yarn start
```