
## Install WP Colorbox

WPBakery's native lightbox is only for videos

If you want a lightbox for misc content including iframe, search for plugin:
WP Colorbox by Noor Alam

Downside is you have to use shortcodes, so you need to go into WPBakery Classic Mode (then either Visual or Text Mode is fine) (Reminder: Visual is RTF mode)

When you click the plugin's Details, it gives you the shortcode for the most common types of lightboxes (not including iframe snippet). Their documentation gives all the possible shortcodes (includes iframe snippet):
https://noorsplugin.com/wordpress-colorbox-plugin/

---

### Iframe/External Page in Lightbox
```
[wp_colorbox_media url="http://wikipedia.com" type="iframe" hyperlink="click here to open external page"]
```

### Inline HTML in Lightbox
```
[wp_colorbox_media url="#inline_content" type="inline" hyperlink="click here to open inline HTML"]
```

---

## Buttons

The shortcode generates a link "click here to open external page" in this example:

![](https://i.imgur.com/BgylDk7.png)


Let's say I had a normal button from WPBakery or other themes and I want to stick with it. The problem is you can't place the shortcode inside your normal button.

What you need to do is to have the normal button programmatically click the text link "click here to open external page". And you use CSS to hide the text link.

![](https://i.imgur.com/iGeq2Id.png)

That link is a javascript link that runs javascript when clicked:
```
javascript:document.querySelector('.wp-colorbox-iframe').click()
```

Or if you go into the Classic Backend editor, you edit that button's shortcode (code varies by theme, how you style the buttons, etc) - notice the url:
```
[nectar_btn size="large" button_style="regular" button_color_2="Accent-Color" solid_text_color_override="#ffffff" icon_family="none" text="QUICK SIGN UP" url="javascript:document.querySelector('.wp-colorbox-iframe').click()"]
```

Regardless, now you hide the text link with a Page CSS:
```
.wp-colorbox-iframe {
    display:none !important;
}
```

Hint: You add page CSS at Backend Editor, gear icon at top right of content