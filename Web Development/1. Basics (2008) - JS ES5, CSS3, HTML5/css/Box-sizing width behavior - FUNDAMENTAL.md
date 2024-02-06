Why fundamental? If you're spearheaded to create the layout from scratch you may have padding and width issues causing you to be able to scroll left and right on a mobile if you don't know what's going on

---

The box-sizing property in CSS has 3 possible values:

- content-box (default) - The width and height only apply to the content box. Any padding, border or margin will be added on top of the width and height.

- border-box - The width and height apply to the border box (content + padding + border). Any padding or border will be included inside the set width and height. 

- inherit - Inherits the box-sizing value from its parent element.

So in summary:

- content-box: width/height applies only to content
- border-box: width/height includes content, padding and border 
- inherit: use parent element's box-sizing value

The border-box value is very useful for creating responsive layouts, as you can set a width of 100% and have padding and borders included without increasing the total size.

content-box is the default in browsers for backwards compatibility reasons. But many developers explicitly set border-box on elements to make width/height easier to manage.

inherit allows propagating the desired box model down from parent elements to inheriting children.

So border-box and inherit give the most flexibility in managing box layouts.

---

In addition to pixel, percentage, and auto values, the width property in CSS also supports:

- fit-content - Width is the intrinsic width of the content. Basically the natural width of the element based on its content.

- min-content - Width is the smallest size that doesn't cause overflow of the content.

- max-content - Width is the largest size that doesn't cause overflow of the content. Larger than min-content.

- fill - Stretches to fill the available space. Similar to 100% but more flexible.

- fill-available - Fills only the space not already taken up by other elements. A smarter stretch than just fill.

So in summary:

- fit-content: Natural width of content 
- min-content: Smallest non-overflowing width
- max-content: Largest non-overflowing width  
- fill: Stretch to fill available space
- fill-available: Fill space not occupied by other elements

These are newer values that allow width to be determined in different ways besides just fixed pixels. They provide more flexibility in responsive layouts.

fit-content is useful for intrinsic UI widths. min/max-content adapt to content. fill and fill-available smartly expand widths.

So they give more options than just fixed pixels or percentages when controlling responsive widths.


----

The main difference between fill and fill-available for the CSS width property is:

- fill: Expands to fill the entire parent container, regardless of siblings.

- fill-available: Expands to fill the available space in the parent, after accounting for the space taken up by sibling elements.

Some key points:

- fill will set the width to 100% of the parent width, overriding any widths of sibling elements. 

- fill-available will respect the widths of siblings and fit in the remaining gap, essentially equal columns or flexible widths.

- fill-available requires the parent to NOT be display: flex or grid. Those layouts have their own space distribution.

- fill is similar to width: 100%, fill-available is more intelligent.

So in summary:

- fill: Fill entire parent container 
- fill-available: Fill available space around siblings

Use fill for a full width element like a hero banner. Use fill-available for equal width columns or sidebars next to main content.

fill forces full width, fill-available plays nice with existing layout.