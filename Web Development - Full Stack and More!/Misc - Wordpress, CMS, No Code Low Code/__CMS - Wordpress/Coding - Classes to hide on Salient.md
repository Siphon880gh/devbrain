The WPBakery Page Builder (Formerly Visual Composer because of legal reasons) classes that Salient uses for hiding starts with "vc_" and you can have device responsive hding classes:

## Visual Composer/WPBakery Responsive Hiding Classes

- `.vc_hidden-xs` - Hides elements on extra small screens (mobile devices, typically under 768px)
- `.vc_hidden-sm` - Hides elements on small screens (tablets, typically 768px to 991px)
- `.vc_hidden-md` - Hides elements on medium screens (small desktops, typically 992px to 1199px)
	- This is from js_composer.min.css (Part of Visual Composer / WPBakery):
		```
		@media (min-width: 1000px) and (max-width: 1299px) {
		    .vc_hidden-md {
		        display: none !important;
		    }
		}	  
		```
- `.vc_hidden-lg` - Hides elements on large screens (large desktops, typically 1200px and above)
	- This is from js_composer.min.css (Part of Visual Composer / WPBakery):
		```
		@media (min-width: 1300px) {
		  .vc_hidden-lg {
		    display: none !important;
		  }
		}
		```

## Warning - ChatGPT

ChatGPT may recommend other types of classes but they're wrong. For example, ChatGPT may recommend:

```
- `.vc_hidden` - Completely hides an element across all devices
- `.vc_hidden-desktop` - Alternative class for hiding content on desktop devices
```

While vc_hidden class may be defined in js_composer's css, it's usually on certain types of rows and only on the row and not element. So don't rely on that


---

## Hiding entire row

For hiding an entire row you can simply, go to Row settings then near the bottom of the settings is "Disable row":
![[Pasted image 20250429232706.png]]

In the backend editor, you can see a visual cue (faded gray row outline):
![[Pasted image 20250429232817.png]]

Unfortunately, elements and columns don't have such a setting to hide.
