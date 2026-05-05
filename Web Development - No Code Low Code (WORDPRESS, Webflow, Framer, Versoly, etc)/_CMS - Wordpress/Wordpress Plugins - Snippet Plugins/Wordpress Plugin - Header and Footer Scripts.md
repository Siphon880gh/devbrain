
[https://wordpress.org/plugins/header-and-footer-scripts/](https://wordpress.org/plugins/header-and-footer-scripts/)

When editing your page, you can insert into the head block:
![[Pasted image 20250831012950.png]]

Note this metabox may appear below your page builder. You may want to arrange it to the top.

---

Most often you need javascript code to run in the head block. You can type into the metabox:
```
<script type="text/javascript">
YOUR JS CODE HERE
</script>
```

But for document ready you have to use DOMContentLoaded:
```
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function () {
    // Your JS code here
    console.log("DOM fully loaded and parsed");
});
</script>
```
^ There is still a slight lag if it's very long javascript.

For CSS, you could also use the same metabox:
```
<style type="text/css">
YOUR CSS CODE HERE
</style>
```

Additional schemas, because they're basically javascript, can also be part of the metabox:
```
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "WebPage",
    "name": "Generic Webpage Example",
    "description": "An example webpage that...",
    "url": "https://www.example.com/"
  }
  </script>
```