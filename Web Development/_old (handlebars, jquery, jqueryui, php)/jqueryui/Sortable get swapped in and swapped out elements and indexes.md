
Get swapped in and swapped out elements and indexes of a drag and drop in a .sortable container

```
$("#drag-and-drop-items").sortable({  
    items: ".thumbnail-container",  
    tolerance: "pointer",  
    revert: true,  
    placeholder: "thumbnail-placeholder",  
    forcePlaceholderSize: true,  
    cursor: "move",  
    opacity: 0.7,  
    start: function(event, ui) {  
        // Save the old position of the item being moved (swapped in)  
        ui.item.data('oldIndex', ui.item.index());  
    },  
    update: function(event, ui) {  
        // The new position of the item being moved (swapped in)  
        var newIndex = ui.item.index();  
  
        // The old position of the item being moved (swapped in)  
        var oldIndex = ui.item.data('oldIndex');  
  
        // The item being moved (swapped in)  
        var movedItem = ui.item;  
  
        // Find the swapped out item. This requires iterating over the list  
        // and finding which item now occupies the oldIndex position.  
        var swappedOutItem = $(this).children().eq(oldIndex);  
  
        // Now you have both elements and can perform your desired actions.  
        console.log("Moved item from index " + oldIndex + " to " + newIndex);  
        console.log("Swapped in item: ", movedItem);  
        console.log("Swapped out item: ", swappedOutItem);  
  
        // Optionally: handle the update event, for example, to save the new order  
        debugger;  
    }  
});
```