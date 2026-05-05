
Access SiteGround Speed Optimizer at the Sidebar:
![[Pasted image 20250830205422.png]]

Access WPRocket at the top admin bar:
![[Pasted image 20250830205537.png]]

---

Siteground Speed Optimizer:
- Dynamic caching and Memcached should both be on, but remember you’ll need to activate Memcached in Siteground -> Site Tools before enabling it in SiteGround Optimizer (found under Speed →  Caching → Memcached)
  ![[Pasted image 20250830214303.png]]
- Choose one plugin to perform File Caching. Recommend you choose WPRocket because it has more options regarding the File Caching.

Why WPRocket. Without WPRocket, the lighthouse report could appear with high LCP:
  ![[Pasted image 20250830210356.png]]


We want **WP Rocket** because it’s one of the few optimization plugins that handles **Largest Contentful Paint (LCP) elements** automatically. It detects above-the-fold images and background videos, excludes them from lazy loading, and preloads them with the proper `fetchpriority="high"` attribute.

This means the most important visual elements—the hero image, background video, or main banner—start downloading immediately instead of waiting for layout calculation or JavaScript confirmation. Although the image should be visible right when the webpage loads, the lazy-loading script sometimes still delays it until JavaScript runs and confirms it’s visible. That eliminates the extra delay that usually slows LCP when lazy loading is applied above the fold.

In short, WP Rocket ensures that **critical images and videos load first**, improving Core Web Vitals, reducing LCP times, and delivering a faster “first impression” to visitors.


There can be cases where WPRocket fails to detect a LCP video background, still showing this Lighthouse report
![[Pasted image 20250830210356.png]]

While WP Rocket does a great job with **images and many videos**, there are **edge cases** where it can miss an LCP video background. That’s because WP Rocket relies on detecting the main `<img>` or `<video>` elements in the HTML DOM. 

The workaround is to add a raw html block above your row. It can either be:
```
<video src="https://.....mp4" preload="auto" muted playsinline style="display:none">
```

Or:
```
  <link rel="preload"
        as="video"
        href="https://...mp4"
        type="video/mp4"
        crossorigin>
```


This way the web browser can immediately fetch the video. It will not redundantly load the same file. This should improve the LCP.