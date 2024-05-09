Common problem is the cloned helper that appears at the mouse cursor doesn't have the same width as the original draggable element, which can take the user out of the experience.

At draggable's start:
```
start: function(event, ui) {
    const w = $(event.target).width(); // Use jQuery to get width
    ui.helper.css('width', w); // Use jQuery's css method to set width
},
```

---

Is width() returning 0?

This is likely a flex child. Here are some fixes:
- Ensuring the element has a minimum width set. If you cannot do that, try the other fixes
- Try getBoundingClientRect():
```
start: function(event, ui) {
    const w = event.target.getBoundingClientRect().width; // Get the width using getBoundingClientRect
    ui.helper.css('width', w); // Set the helper width using jQuery's css method
},
```
- Save the width at the draggable as an attribute first

For the draggable elements:
```
setTimeout(()=>{  

	// Make draggable helper clone same width  
	$(".flex-container .flex-child").each((i,el)=>{  

		el.setAttribute("clone-width", el.clientWidth - 50)  
		const w = el.clientWidth  
		  
	})  
}, 200)
```
^ The -50 is a number you have to figure out if there's padding from the flex container or margin from the flex children

For draggable start:
```
// Enable dragging on the flex container
$(".flex-container .flex-child").draggable({
	helper: "clone", // Creates a copy of the element for dragging
	revert: "invalid", // Reverts the drag if not dropped on a droppable target
	start: function(event, ui) {
		const w = event.target.getAttribute("clone-width");
		ui.helper.width(w);
	},
	// ...
});
```