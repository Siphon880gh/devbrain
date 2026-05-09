
Use npm package sharp-cli to create an icon set of black squares.

You'll make a folder, go into it to initiate a npm project, then install sharp-cli, then run nodejs code at the terminal to generate the multiple icon files:

```
mkdir generate_icons  
cd generate_icons  
npm install -y  
npm install sharp-cli  
node -e "const fs = require('fs'); const sharp = require('sharp'); [16,32,48,128].forEach(size => sharp({ create: { width: size, height: size, channels: 4, background: 'black' } }).png().toFile(\`icon\${size}x\${size}.png\`));"  
  
cp icon16x16.png icon.png
```

It’ll create icon files:
```
.  
├── icon128x128.png  
├── icon16x16.png  
├── icon32x32.png  
├── icon48x48.png  
├── node_modules  
├── package-lock.json  
└── package.json
```

An icon file may look like:
![[Pasted image 20250320123806.png]]