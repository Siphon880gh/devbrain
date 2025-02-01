Badges are "linktree" and status pieces often found on Github repo pages, that can also work well on webages. It can be done in markdown code or HTML. Since markdown allows HTML, here we will do HTML badges so you port to either platform. The markdown equivalent is just using a combination of link and image markdown syntax.

---

<a href="https://github.com/Siphon880gh/social-media-api" rel="nofollow" target="_blank"><img class="my-badge" src="https://img.shields.io/badge/-white?style=flat&amp;logo=github&amp;labelColor=darkgray&amp;logoColor=white" alt="Youtube" data-canonical-src="https://img.shields.io/badge/Github-white?style=flat&amp;logo=youtube&amp;labelColor=lightgray&amp;labelColor=white"></a>

```
<a href="https://github.com/Siphon880gh/social-media-api" rel="nofollow" target="_blank">
<img class="my-badge" src="https://img.shields.io/badge/-white?style=flat&amp;logo=github&amp;labelColor=darkgray&amp;logoColor=white" alt="Youtube" data-canonical-src="https://img.shields.io/badge/-white?style=flat&amp;logo=github&amp;labelColor=darkgray&amp;logoColor=white"></a>
```

![](80Am5bU.png)

Rules:
Left side icon content is from logo=github
Left side foreground color is from logoColor=white
Left side background color is from labelColor=darkgray
Right side text and background is from `https://img.shields.io/badge/`\_\_`?style`
Style can be: [`flat`, `flat-square`, `plastic`, `for-the-badge`, `social`]

---


Right side text and background must have some value. At minimum it can be:
```
https://img.shields.io/badge/-white?
```

![](nGb0TIp.png)

