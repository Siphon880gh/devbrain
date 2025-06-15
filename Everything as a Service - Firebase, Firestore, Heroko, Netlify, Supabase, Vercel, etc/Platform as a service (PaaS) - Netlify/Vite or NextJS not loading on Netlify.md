Scenario: On netlify, my vite app is blank page and the console shows octet error. Im assuming netlify falls back to the octet builder because it failed to detect it's vite. The package.json has the proper build and start commands though because it's been installed from a create-react-app.

Let's manually add in the settings for a Vite build.

Click "Deploys" sidebar item -> Deploy settings

![[Pasted image 20250615090128.png]]

Click the "Build & deploy" panel sidebar item:
![[Pasted image 20250615090346.png]]

If NextJS:
For build command, have: `npm run build`
For publish directory, have `.next`. Recall that NextJS builds into the .next/ folder.

If Vite:
For build command, have: `npm run build`
For publish directory, have `dist/`. Recall that Vite builds into the dist/ folder.