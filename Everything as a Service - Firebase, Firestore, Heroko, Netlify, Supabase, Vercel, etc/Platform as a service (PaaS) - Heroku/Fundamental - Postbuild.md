Your package.json could have:
```
	"build": "vite build",
	"heroku-postbuild": "node scripts/generateSitemap.js",
```