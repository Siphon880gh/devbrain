
**How to use:**
Open persistent Table of Contents

---


## WPBakery / Visual Composer / Salient
Classic Mode allows you to fine tune the layout and design with the shortcodes of WPBakery (AKA Visual Composer) which is the backbone of Salient theme's site builder

## Elementor

You can switch between Visual or **Text Mode**. Text Mode is the raw html / css / shortcodes of that page


----

## Add CSS Globally on Website

Appearance -> Customize -> Additional CSS
![[Pasted image 20250429181759.png]]
## 
Add CSS Per Page

### - Salient
Sidebar item "Salient" -> General Settings -> CSS/Script Related
![](2pA53x4.png)


### - WPBakery / Visual Composer 
Click gear icon at the top-right of the content editing
![](ODHB7Bi.png)


Will look like this:

- ### Elementor
Pages -> All Pages -> Find Your Page: Edit -> Wordpress Editor -> Text mode
You can add style block

## Add JS Per Page
Try [[Code Snippets Plugin]]

At Elementor you can go into Text mode and add script block.

## Add JS Globally on Website

Try [[Code Snippets Plugin

At Salient, you can: Salient → General Settings → CSS/Script Related

---

Still problems?

Once you find a way to add JS globally, you can add CSS or JS to globally or per page. 
- If it's to per page, you can check window.location.href to see if you're at a particular page
- You can add css using JS by creating a style block, setting its inner HTML, then appending the style block to body.