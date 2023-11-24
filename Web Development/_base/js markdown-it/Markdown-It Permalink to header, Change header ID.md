
```
    <script src="https://cdn.jsdelivr.net/npm/markdown-it@12.0.4/dist/markdown-it.min.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/markdown-it-emoji/1.4.0/markdown-it-emoji.min.js"></script>  
    <script src="https://unpkg.com/markdown-it-anchor@8.6.5/dist/markdownItAnchor.umd.js"></script>
```


```
                var md = window.markdownit({
                    html: true,
                    linkify: true
                }).use(window.markdownItAnchor, {
                    level: [1, 2, 3, 4, 5, 6], // Apply to all heading levels
                    slugify: function(s) {
                        return s.toLowerCase().replace(/\s+/g, '-').replace(/[^a-z0-9\-]/g, '');
                    },
                    permalink: true,
                    permalinkSymbol: '🔗' // Set to true if you want a permalink symbol
                    // Other options as needed
                });

                var summaryHTML = md.render(summary);



                summaryHTML = summaryHTML.replaceAll(/\xA0/g, " ");
                console.log(summaryHTML)
                summaryInnerEl.innerHTML = summaryHTML;
                // summaryInnerEl.innerHTML = `<iframe src="https://www.w3schools.com" title="W3Schools Free Online Web Tutorials!!"></iframe>`;
                summaryInnerEl.querySelectorAll("a").forEach(a=>{
                    if(a.href.length && a.href[0] !== "#")
                        a.target = "_blank"
                })


```