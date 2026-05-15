
Create custom folding unfolding sections. They can be collapsed/expanded in the code and they can be navigated to or jumped to from the Region Viewer sidebar.

Install VS Code Extension:
`#region folding for VS Code v1.0.22` by `maptz`
https://marketplace.visualstudio.com/items?itemName=maptz.regionfolder

---

**HTML:**
```
<!-- #region main -->
	<main>
		<h1>Title</h1>
		<p>Some paragraph</p>
	</main>
<!-- #endregion -->
```

But notice you can collapse and expand next to line number
![](VZb3ADd.png)


**CSS:**
```
/* #region test */
.blurred {
    filter: blur(5px);
}
/* #endregion */
```

**JS:**
```
// #region config
var CONFIG = {
    source: "live",
    initialUploadMode: "classically-first-upload"
}
// #endregion
```

Bottom left has Region Viewer (is NOT Outline), so you can navigate regions at a glance and jump to regions:
![](oxKPvnu.png)
