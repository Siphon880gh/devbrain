There is a node module called "linus" that can give you the specific linux distribution.

Install linux with:
```
npm install -g linux
```

Then run these commands line by line to get the linux distro:
```
node << END
var distro = require('linus');

distro.name(function(err, name) {
if (name)
    console.log('Current distro: ' + name);
else
    console.log(err.message || 'Failed.');
})

distro.version(function(err, version) {
if (version)
    console.log('Version is: ' + version);
else
    console.log(err.message || 'Failed.');
})
END
```

Actually, after typing `node << END`, you can copy and paste the rest of the lines.

Troubleshooting: Does it say node module not found? That's a problem with it not looking up the global node_modules where we installed linus. A quick fix is to create a new folder, cd into folder, run `npm init -y` to start a new npm project, then run `npm install --save-dev linux` to install it locally. Then run these commands inside the folder. You can delete the folder afterwards with `cd ../; rm -R <folder>`.

Repository Link: https://github.com/tomas/linus