
Basics

You use scrollIntoView as usual but with one simple change:
```

    document.querySelector(".interval")?.scrollIntoView({ behavior: 'smooth'}
```


---

Advanced

The `scrollIntoView` method in JavaScript is used to scroll the browser to the element that the method is invoked on. It accepts an object as an argument, where you can set `block` and `inline` properties to define the alignment of the element, and `behavior` to define the transition animation.

Here is an example of using `scrollIntoView` with smooth behavior:

```javascript
element.scrollIntoView({ behavior: 'smooth', block: 'end', inline: 'nearest' });
```

In this case, `behavior: 'smooth'` will create a smooth scrolling effect. However, the duration of the smooth scroll is not defined by the standard and can vary between browsers; there is no native way to control the speed (i.e., the duration) directly via the `scrollIntoView` options.

If you need more control over the animation speed, duration, or easing, you might want to use a custom function with `window.requestAnimationFrame()`, or a library that provides more advanced animation options, such as jQuery's `animate` method, or other animation libraries like GreenSock (GSAP) or anime.js.

Here's a very basic example of how you might implement a custom smooth scroll with a set duration using `window.requestAnimationFrame`:

```javascript
function smoothScrollTo(element, duration) {
    var startingY = window.pageYOffset;
    var elementY = window.pageYOffset + element.getBoundingClientRect().top;
    var targetY = document.body.scrollHeight - elementY < window.innerHeight ? document.body.scrollHeight - window.innerHeight : elementY;
    var diff = targetY - startingY;
    var start;

    // Bootstrap our animation - it will get called right before next frame shall be rendered.
    window.requestAnimationFrame(function step(timestamp) {
        if (!start) start = timestamp;
        // Elapsed milliseconds since start of scrolling.
        var time = timestamp - start;
        // Get percent of completion in range [0, 1].
        var percent = Math.min(time / duration, 1);

        window.scrollTo(0, startingY + diff * percent);

        // Proceed with animation as long as we wanted it to.
        if (time < duration) {
            window.requestAnimationFrame(step);
        }
    })
}

// Usage:
var element = document.getElementById('my-element');
smoothScrollTo(element, 500); // for half a second duration
```

This is still a simple example and might not cover all cases (like different easing behaviors), but it illustrates the concept. For complex animations, it's better to use a dedicated library.