
**Where are we:**
You're editing a page because you went from the left sidebar Pages -> Editing a specific page

Let's explore WPBakery Page Builder. 

You can switch between Backend and Classic Mode by clicking the toggle mode button (first button):

https://wpbakery.com/features/wordpress-editor/

![](https://i.imgur.com/Ym8CNID.png)

![](https://i.imgur.com/wPL8JB9.png)


When in backend mode, the toggle button's text is "Classic Mode" because the button label is what you go into when clicked. And vice versa.

"Frontend editor" is the enhanced WPBakery's Frontend Editor.

## Classic Mode

Classic Mode allows you to fine tune the layout and design with the shortcodes of WPBakery (AKA Visul Composer formerly, dt legal reasons) and HTML which is the backbone of Salient theme's site builder

Classic Mode is actually a re-skinned version of the Code Editor of Gutenberg which is the default site builder for all Wordpress installations.

To find your place among the short codes you may have to rely on the RTF elements of styled texts and images, or do a text search for specific keywords from your live website.

Notice on the top right of the content editing is Visual and Text. Think of Visual as "Visual RTF" mode that shows you shortcuts, your styled text, and your images and renders some of the text formatting and images.


![](https://i.imgur.com/HYlCxhm.png)

But notice the Classic Mode is not only re-skinned but enhanced with new design elements. The Nectar shortcodes button is a library of shortcodes that add designed elements. Refer to [[Salient WPBakery Site Builder - Nectar Shortcodes]]

----

## Visual RTF vs Text

### Both Visual RTF mode and Text are the same code. 
It's a combination of shortcodes (Wordpress plugin code) and HTML. You can have sections of shortcodes and HTML, or you can have them mixed together like this:
![](https://i.imgur.com/BhpWZTc.png)

```
<div style="margin-top:10px; text-align:center;">[nectar_animated_title heading_tag="h3" style="color-strip-reveal" color="Accent-Color" text="Pricing" custom_css="text-align:center;"]</div>
```

Style and script blocks are allowed in Classic Mode. Make sure to add them in Text Mode instead of Visual RTF mode. Refer to "Text mode is ALL Text" implications for rationale.

### Visual RTF mode renders text formats and images:
![](https://i.imgur.com/dzBy3ST.png)


### Text mode is ALL TEXT. 
No rendered formatting is involved which has implications:
- Readability: When editing in text mode, you can add blank lines and spacing as is necessary to aid your understanding of the shortcodes. Whitespaces are ignored like it is in HTML.
- Typing HTML: Type html into Text mode, NOT Visual RTF mode. In Visual RTF mode if you type HTML, it's assumed you're writing a HTML coding tutorial and the tags are rendered as text to the visitor - add HTML in Text mode.
- In a similar way, style and script blocks are allowed in Classic Mode, but make sure to add them in Text Mode instead of Visual RTF mode. If you had added them in Visual RTF mode, Wordpress assumes you're writing a coding tutorial and will render them as text to your visitor; In text mode, you would see `&lt;script&gt;` for the opening script tag.


----

## Learn with AI

You can ask ChatGPT to explain the shortcodes.

Example:
```
[vc_row_inner column_margin="100px" column_direction="default" column_direction_tablet="default" column_direction_phone="default" bottom_padding="50" text_align="left" row_position="default" row_position_tablet="inherit" row_position_phone="inherit" overflow="visible" pointer_events="all"]
```

ChatGPT:
The text you've provided does indeed look like a shortcode, specifically one that seems to be associated with a page builder plugin rather than WordPress core. The structure [shortcode] is characteristic of WordPress shortcodes, but the details inside the brackets can vary widely depending on the plugin or theme that adds them.
In your example, [vc_row_inner ...] is likely a shortcode from a visual composer or page builder plugin. These plugins often add their own set of shortcodes to help users design and structure their web pages with various layouts and elements. The attributes within the shortcode, like column_margin, text_align, overflow, etc., are parameters that control the appearance and behavior of the content or layout element that the shortcode represents.
Such shortcodes are particularly useful for creating complex page layouts and designs without requiring users to have in-depth knowledge of HTML, CSS, or PHP. They're a popular feature in many WordPress themes and plugins, especially those focused on customizability and visual editing.