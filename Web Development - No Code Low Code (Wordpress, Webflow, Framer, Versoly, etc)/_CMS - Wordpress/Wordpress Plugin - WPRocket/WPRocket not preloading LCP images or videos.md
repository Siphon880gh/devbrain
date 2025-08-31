**WP Rocket** is one of the few optimization plugins that handles **Largest Contentful Paint (LCP) elements** automatically. It detects above-the-fold images and background videos, excludes them from lazy loading, and preloads them with the proper `fetchpriority="high"` attribute.

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