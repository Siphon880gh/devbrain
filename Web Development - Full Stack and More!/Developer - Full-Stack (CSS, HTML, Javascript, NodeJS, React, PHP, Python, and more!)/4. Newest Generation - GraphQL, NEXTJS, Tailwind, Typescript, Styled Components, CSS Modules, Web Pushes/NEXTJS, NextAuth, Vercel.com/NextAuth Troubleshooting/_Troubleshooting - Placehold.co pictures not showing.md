
Local machine dev hot reloading server has broken images for placehold.co:
![[Pasted image 20250705181451.png]]
When you deploy online, it's not a problem
![[Pasted image 20250705181518.png]]

---


Back at local - if you inspected:
![[Pasted image 20250705181502.png]]

You might think the cause is srcset especially if you're new to srcset. That is NOT the problem.

If you read the terminal where you started the dev server you'll see:
```
 ⨯ The requested resource "[https://placehold.co/1200x600/blue/white?text=Video+Preview](https://placehold.co/1200x600/blue/white?text=Video+Preview)" has type "image/svg+xml; charset=utf-8" but dangerouslyAllowSVG is disabled

```


There is a **SVG error** blocking placehold.co from loading because:
- The image URL (`https://placehold.co/...`) **returns an SVG**, even if the extension is missing.
- Next.js `<Image />` **blocks SVGs** by default for security reasons
- The strict check only happens in Development. Production favors speed and silent failure over dev-time verbosity. Therefore, it loads in production fine.

---


You have two options:

### METHOD 1 - Configure to allow SVG (Dangerous)

next.config.js:
```
const nextConfig = {
  images: {
    remotePatterns: [
      {
        protocol: 'https',
        hostname: 'placehold.co'
      },
    ],
    dangerouslyAllowSVG: true,
    contentSecurityPolicy: "default-src 'self'; script-src 'none'; sandbox;",
  },
```


> [!note] ⚠️ Why dangerouslyAllowSVG and contentSecurityPolicy
> SVG files can **embed JavaScript** (`<script>` tags inside the SVG), which could be **executed in your app's context**, potentially leading to:
> - **Cross-site scripting (XSS)**
> - **Data leakage**
> - **Session hijacking**
> 
> So when you tell Next.js:
> "Yes, I know it's dangerous, allow SVGs anyway"  
> You need to also add **a restrictive Content Security Policy (CSP)** to **mitigate that risk.**
> 
> The csp is as follows: Allow only loading resources (images, fonts, etc) from your own domain when it comes to additional resources inside the SVG tag (default-src being self) and completely blocks any javascript execution inside the SVG or HTML (script-src being none). In addition, apply a secure sandbox to all iframes/images/SVGs (`sandbox`), essentially making embedded content inert unless explicitly allowed. This combination **neuters any embedded JavaScript inside SVGs**, even if they're served from trusted domains.
> 



### METHOD 2 - Placehold.co has a png version

Use the url:
```
https://placehold.co/1200x600.png
```

Unfortunately as of July 2025, png generation does not support colors. Neither parameters color, bgcolor, textcolor, works.
![[Pasted image 20250705185305.png]]

Japan's does support it though:
```
https://placehold.jp/3d4070/ffffff/150x150.png
```

https://placehold.jp/en.html