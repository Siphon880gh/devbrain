## event.currentTarget

When you use `event.target.getAttribute('data-url')`,  on a button that has an icon and label, and its data attribute that you’re passing to a function at the onclick handler is on the button, it might fail because those child elements do not have the data attribute

### Solution: Use `event.currentTarget`

The `event.currentTarget` property refers to the element to which the event listener is attached, regardless of which child element is clicked. You can update your `onclick` handler to use `event.currentTarget` instead of `event.target`:

```
<div  
  class="download-thumbnail mt-6 mb-6 text-gray-600 clickable hoverable cursor-pointer"  
  data-url="my-video.mp4"  
  onclick="event.stopPropagation(); downloadFromLink(event.currentTarget.getAttribute('data-url'))"  
>  
  <i class="fa fa-download text-center"></i>  
  <span> Preview Thumbnail</span>  
  <!-- <input id="sharePreview" class="form-control" rows="3" readonly style="width:355px; display:none;"></input> -->  
</div>
```

### Explanation

- `event.target`: Refers to the actual element that triggered the event (e.g., `<i>` or `<span>`).
- `event.currentTarget`: Refers to the element on which the event listener is attached (e.g., the `<div>`).

By using `event.currentTarget`, you ensure that the correct element (`<div>`) is always targeted for retrieving attributes like `data-url`.

  
---

## event.target

So when is it actually useful? Maybe you have multiple clickable elements and you want to check their .closest is a panel element versus the other clickable elements in the other panel element. That's very edge case.