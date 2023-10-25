```
var arr = [];

document.querySelectorAll(".recent-discussion-message").forEach(el=>{

    var parsed = el.textContent;

    parsed = parsed.replaceAll("\n", "");

    parsed = parsed.replaceAll(/[\s]{2,}/g, " ");

    parsed = parsed.trim()

    arr.push(parsed)

})

for(var i = 0; i<arr.length; i++) {

    console.log(arr[i]);

}
```