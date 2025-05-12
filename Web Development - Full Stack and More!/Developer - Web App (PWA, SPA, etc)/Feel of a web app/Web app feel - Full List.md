
### 🔄 **Mobile Platform-Specific Adjustments**

- Note some are PWA specific at the second and beyond tables.
- If you want to detect if it's android or iphone and be able to add the corresponding style, refer to [[Detect android or iphone then adjust the styles]]

|Feature / UI Behavior|Android|iOS|Platform-Specific Adjustments|
|---|---|---|---|
|**Select Dropdowns**|Styled natively and often skinnable|Locked into iOS’s native picker UI|Use custom UI libraries or inputs for consistent dropdown styling across platforms|
|**Date/Time Inputs**|`<input type="date">` shows calendar picker|Shows iOS-style rolling selector|Consider using a JS date picker (e.g., flatpickr) for consistent UX|
|**Font Rendering**|Uses Roboto by default|Uses San Francisco or Helvetica Neue|Load platform-neutral fonts or apply platform-specific font stacks for visual consistency|
|**Back Navigation Gestures**|Physical back button or 3-button nav|Swipe-from-left is default and aggressive|Add margin to left edges of modals or prevent gesture conflicts using touch event handlers|
|**Scroll Bounce**|No bounce unless explicitly coded|Default scroll bounce (rubber band effect)|Add `overscroll-behavior: none` to prevent visual jank during modals or nested scroll areas|
|**File Upload Button**|Android shows file picker with camera/gallery|iOS shows native picker with limited folder access|Adjust `<input type="file">` expectations, e.g., use `accept="image/*"` for camera access on both|
|**Audio/Video Autoplay**|Allowed if muted or triggered by gesture|Restricted (autoplay often blocked)|Check `canplaythrough` event and prompt user to start playback manually on iOS|
|**Custom Scrollbars**|Supports custom CSS scrollbars|iOS ignores most scrollbar styling|Keep designs that rely on scrollbars minimal, or hide them altogether for consistency|
|**Vibration Feedback (`navigator.vibrate`)**|Fully supported|Mostly ignored or restricted|Don’t rely on vibration for critical UX — make it optional or Android-only|
|**Web Share API**|Supported (can invoke native share sheet)|Supported on Safari (with quirks)|Use `navigator.share()` but always check for support first and provide fallback|
|**Viewport Units (`vh`/`vw`)**|Generally stable|`100vh` on iOS includes browser chrome, causing layout jumps|Use dynamic viewport units (via JS or `env(safe-area-inset-*)`) to avoid cutoffs or hidden buttons|
|**Safe Area Insets (Notch/Island)**|No safe-area inset issues|Needs padding for iPhone X+ notch, island|Use `padding: env(safe-area-inset-top)` etc. to protect content on notched devices|

More:

|Feature|Android|iOS|Adjustments You Can Make|
|---|---|---|---|
|Install Prompt|Supported via `beforeinstallprompt`|No native prompt|Show custom install instructions for iOS|
|Push Notifications|Supported|Not supported|Disable or hide push settings on iOS|
|Splash Screen|Follows `manifest.json`|Requires Apple-specific meta tags|Add `<meta name="apple-mobile-web-app-capable" content="yes">` for iOS|
|Status Bar Style|Controlled via manifest|Controlled via meta tag|Use `<meta name="apple-mobile-web-app-status-bar-style">`|
|Scrolling behavior|Smooth|May bounce or overscroll|Apply scroll locking or styling per platform|

And more:

|Feature / UX Detail|Android|iOS|Platform-Specific Adjustments|
|---|---|---|---|
|**Install Experience**|Native “Add to Home Screen” prompt via `beforeinstallprompt`|No prompt; user must manually use "Share → Add to Home Screen"|Detect iOS and show a custom banner or modal with installation instructions|
|**Splash Screen Control**|Uses `manifest.json` values|Requires Apple-specific meta tags and `apple-touch-icon`|Add `<meta name="apple-mobile-web-app-capable" content="yes">` and related tags|
|**Status Bar Color**|Controlled via `theme_color` in manifest|Controlled via `<meta name="apple-mobile-web-app-status-bar-style">`|Set `theme_color` in manifest for Android, and `status-bar-style` to `default` or `black-translucent` on iOS|
|**Home Screen Icon**|Uses manifest icons|Requires `apple-touch-icon` in `<head>`|Provide multiple `apple-touch-icon` sizes for retina screens|
|**Navigation Bar Color**|Controlled via `theme_color`|Not supported|Optionally use subtle background or full-screen mode to hide nav bar on iOS|
|**Scrolling Behavior**|Standard scroll; supports fixed elements well|May experience rubber-banding and fixed-position bugs|Add `body { overscroll-behavior: contain; }` or `touch-action` tweaks for smoother UX|
|**Gesture Controls (e.g., Swipe to Go Back)**|Usually requires explicit code or OS support|Enabled by default on iOS Safari (can interfere with UI)|Avoid left-edge swipe gestures on iOS for full-screen overlays|
|**Keyboard Handling**|Stable with `position: fixed` and `vh` units|iOS can shrink viewport and cause layout issues|Use JavaScript to detect viewport resizing and reposition inputs/modals accordingly|
|**Push Notifications**|Fully supported|Not supported on Safari (as of 2025, still limited support even with newer iOS)|Hide or disable push notification UI elements on iOS or prompt fallback behavior|
|**Web App Capabilities (`navigator.standalone`)**|Use manifest to check standalone mode|Use `navigator.standalone` (Safari only)|Check for `window.matchMedia('(display-mode: standalone)')` or `navigator.standalone` to conditionally render UI|
|**Back Button Behavior**|Physical back button exists|No hardware back button|On Android, intercept the back button event to avoid exiting app unintentionally|

There are more:
- Refer to [[Web app feel - Keyboard differences and implications]]
- Refer to notes referring to specific styles in the same folder. Those specific styles are usually not mentioned in the above tables.