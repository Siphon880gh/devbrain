jQuery into Vanilla JS - Essential
Why essential: May not necessarily be foundational to JS but you'll encounter jQuery in the wild and need to optimize by removing jQuery and changing the logic back into vanilla Javascript.

Converting querySelectorAll NodeList object into array of elements

```
const allCp = Array.from(document.querySelectorAll(".control-panel"));
```

Also works and perhaps more used:
```
$(selector).toArray()
```

Perhaps equally known:
```
$(selector).get()
```
