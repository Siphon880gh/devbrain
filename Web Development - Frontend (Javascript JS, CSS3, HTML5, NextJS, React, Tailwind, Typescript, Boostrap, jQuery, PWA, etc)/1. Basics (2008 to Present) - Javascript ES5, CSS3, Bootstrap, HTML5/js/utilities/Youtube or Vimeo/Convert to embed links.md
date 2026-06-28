Dev - JS - Convert Youtube/Vimeo links to embed links (allowing iframe not same origin)

How to use:
Pass the URL to convertToEmbedUrl. It will return the iframe code that has the embed link which doesn't have the same-origin restriction.

```
function convertToEmbedUrl(html){
        var pattern1 = /(?:http?s?:\/\/)?(?:www\.)?(?:vimeo\.com)\/?(.+)/g;
        var pattern2 = /(?:http?s?:\/\/)?(?:www\.)?(?:youtube\.com|youtu\.be)\/(?:watch\?v=)?(.+)/g;

        if(pattern1.test(html)){
            console.log("html", html);

           var replacement = '<iframe width="420" height="345" src="//player.vimeo.com/video/$1" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';

           var html = html.replace(pattern1, replacement);
        }


        if(pattern2.test(html)){
              console.log("html", html);

           var replacement = '<iframe width="420" height="345" src="http://www.youtube.com/embed/$1" frameborder="0" allowfullscreen></iframe>';

            var html = html.replace(pattern2, replacement);
        } 


        return html;
    } // convertToEmbedUrl
```
