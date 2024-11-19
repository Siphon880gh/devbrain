## Basics

Source control tab.

A red exclamation mark (!) next to a file in the source control view indicates a merge conflict.
![](https://i.imgur.com/D6v81rl.png)

The Merge Conflict Editor is navigated like so:
![](https://i.imgur.com/fAtlwkV.png)

Arrows -
![](https://i.imgur.com/9wn1kP3.png)

If clicked choice “Left combo” will look like:
```
require("dotenv").config();  
const moment = require("moment");
```

If clicked choice “Right combo” will look like:
```
const moment = require("moment");  
require("dotenv").config();
```

Right pointing: That’s the preview after you clicked a choice.

---

## Make sure you looked at all merges in the document comparison

See the orange dot at the scroll bar on either panel! They are all the merge conflicts you need to compare and resolve.

![](https://i.imgur.com/bLwz3ow.png)

![](https://i.imgur.com/qUwfScP.png)


---

## Clicked the wrong choice?

Here we made an oppsie and the merge results look odd. Fortunately, we didn't click "Complete Merge" yet:

![](https://i.imgur.com/Y6KLink.png)

**Solution**: You can undo (CMD+Z on Mac)