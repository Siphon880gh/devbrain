Bootstrap leveraged this simple CSS rule to make sure images don't overflow and they exposed it in a styling class img-fluid. 

Unfortunately by default, images just render their dimensions instead of regarding the container's size, causing an overflow

Use bootstrap's .img-fluid or add the style max-width:100%; and height:auto; for your images.

1. **Selector: `.img-fluid`**  
    This targets all HTML elements with the class of `img-fluid`. In many frameworks, this is used for images that should be responsive to the size of their container.
    
2. **Property: `max-width: 100%;`**  
    This sets the maximum width of the element to 100% of its container. This means the element can't grow larger than its container width. This is useful for images because it ensures that they don't overflow and stretch out of their parent container.
    
3. **Property: `height: auto;`**  
    This sets the height of the element to be automatically determined by the ratio of the width. When you change the width of an image but you want to maintain its aspect ratio (so it doesn’t get stretched or squished), you set the height to `auto`. This allows the browser to adjust the height proportionally as the width changes.
    

In practice, if you had an image like this:

htmlCopy code

`<img src="example.jpg" class="img-fluid" alt="A responsive image">`

The image would scale and resize proportionally within its container without overflowing or getting distorted, thanks to the `.img-fluid` CSS rule.

This is a common technique in responsive web design, especially when dealing with images that should adapt to different screen sizes and container widths.