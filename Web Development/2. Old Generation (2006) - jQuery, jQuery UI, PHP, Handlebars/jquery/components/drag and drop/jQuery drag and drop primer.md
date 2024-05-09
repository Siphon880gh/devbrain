`$__.draggable` and `$__.droppable`, where the underline is, that’s the selector indicating what’s draggable and what’s droppable, respectively, using jQuery DOM selector

CDNs:
```
  <!-- Include jQuery Library -->
  <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Include jQuery UI Library -->
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

  <!-- Include jQuery UI Touch Punch for mobile touch events -->
  <script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
```


In the example of a left panel that’s a flexbox with children and a right panel that’s a flexbox with children and you want to drag a child from left into a child from right, and that causes the right child to change content:

```
            // Enable dragging on the left panel items  
            $(".flex-container-left .child").draggable({  
                helper: "clone", // Creates a copy of the element for dragging  
                revert: "invalid", // Reverts the drag if not dropped on a droppable target  
                start: function(event, ui) {  
                    // This line pauses the execution if the developer tools are open  
                    debugger;  
                },  
            });  
  
            // Enable dropping on the right panel items  
            $(".flex-container-right .child").droppable({  
                accept: ".flex-container-left .child", // Only accept items from the left panel  
                drop: function(event, ui) {  
                    $(this).text(ui.draggable.text()); // Copy the text of the dragged item  
                    ui.draggable.remove(); // Hide the original item  
                    $(this).removeClass('hover-effect'); // Remove the hover class  
                },  
                over: function(event, ui) {  
                    $(this).addClass('hovered'); // Add a class for styling when an item is hovered over  
                },  
                out: function(event, ui) {  
                    $(this).removeClass('hovered'); // Remove the class when the item is no longer hovered over  
                }  
            });
```

CSS for letting you know you're hovering over an item on the right:
```
.thumbnail-container.hover * {  
    opacity: 0.5;  
}  
.thumbnail-container.hover {  
    background-color: #666; /* Darker color for hover */  
}
```

Init and Methods:
draggable’s start runs when you’re actively dragging. Open inspect, and drag left panel child to see the chrome pause
droppable's accept only accept items whose selectors match the value
droppable's drop runs when an item drops onto another item

Elements in Draggable's start:
- event.target gives you javascript DOM to the original element you’re dragging.
	- To convert to jQuery DOM, you run $(event.target)
- ui.helper gives you  the jQuery DOM to the cloned helper that appears on your mouse cursor

Elements in Droppable's drop:
- ui.draggable gives you javascript DOM  to the original element you’re dragging
- this or $(this) gives you the jquery DOM to the dropped area

---

More event objects and methods:


**Timestamp**
event.timeStamp: The time at which the event occurred.

**Mouse Position**
event.pageX and event.pageY: Provide the mouse position in terms of the page's coordinates.
event.clientX and event.clientY: Give the mouse position relative to the viewport.

**Event Methods**
event.preventDefault(): Prevents the default action the browser makes on that event. For example, this can be used to prevent a link from being followed or to prevent text from being selectable during a drag.
event.stopPropagation(): Stops the bubbling of an event to parent elements, preventing any parent handlers from being notified of the event.

**Modifier Keys**
event.altKey, event.ctrlKey, event.metaKey, and event.shiftKey: Indicate whether the respective modifier keys were pressed when the event was triggered.