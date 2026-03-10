QA Item: Cacheless, cookieless, extensionless — confirm the intended design in a clean browser session: Incognito mode, no extensions, and if on Wordpress, logged out of WordPress.

---

A site can look correct in your normal browser session but still break for real visitors because your environment is not clean. 

Browser cache may keep old CSS, JavaScript, or images, so you may be seeing stale design assets instead of the latest version. 

Browser extensions can inject their own CSS, fonts, scripts, overlays, or dark-mode changes, which can alter rendering and hide the site’s true appearance. 

Cookies and logged-in sessions can also change what loads. In WordPress, being logged in as an admin may add the admin bar, load extra scripts or styles, and slightly shift layout, spacing, or CSS behavior. 

That is why design QA should include a clean test environment: Incognito mode, no extensions, and logged out of Wordpress (if site is Wordpress).

