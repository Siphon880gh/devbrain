```
const fs = require('fs')

const path = './file.txt'

try {
  if (fs.existsSync(path)) {
    //file exists
  }
} catch(err) {
  console.error(err)
}
```

Another alternative is `fs.exists( path, callback )` which is the asynchronous version.