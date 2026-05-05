Sortable - Dropping causes a slide up from bottom of container effect

The down and up vertical animation is distracting

---

Im using jquery ui. When I drag then release, it does this slide up animation from the bottom of the parent div. I dont want that slide up animation because the div where I can drag and drop is very tall.

Just turn revert to false:

    $("#sortable").sortable({  
        revert: false,  
        // ...  

  

  

Revert is the animiation that happens when you dont drop to a valid area. Even though if it’s a valid area and the rearrangement is successful, the animation might still run.