<<
Im a web developer. I need to show an animation that instructs the user to rotate their phone into landscape if I detect they're on portrait. How to figure out with javascript. And what are free resources for this animation?

\>>
Here are a few suggestions for detecting device orientation and showing a landscape orientation prompt in JavaScript:

To detect orientation, you can use the window.orientation property. This will give you a value indicating if the device is in portrait or landscape mode.

```js
const isPortrait = () => {
  return window.orientation === 0 || window.orientation === 180; 
}
```

To show a prompt to rotate to landscape, you can create a modal overlay with text and graphics instructing the user to rotate their device. You can use CSS transforms and animations to make the prompt graphical.

Some free resources for animated graphics:

- LottieFiles - https://lottiefiles.com/ - Library of free animated SVGs and JSON files 
- Animista - https://animista.net/ - CSS animations generator
- SVGator - https://www.svgator.com - Create and animate SVGs

You'd show the prompt modal when isPortrait() returns true, and hide it when the orientation changes to landscape.

Here's a simple example:

```js
const prompt = document.getElementById('rotate-prompt');

if (isPortrait()) {
  prompt.classList.add('visible');
}

window.addEventListener('orientationchange', () => {
  if (!isPortrait()) {
    prompt.classList.remove('visible'); 
  }
});
```

Hope this helps give you some ideas for how to approach the device orientation prompt! Let me know if you have any other questions.


---


Yes, there are quite a few more free resources for finding animations and animated graphics online. Here are some additional options to check out:

- Motion Design Resources - https://motiondesign.io/ - Curated animations and templates 
- UILottie - https://uimotion.com/lottie - Library of free Lottie animations
- Craftwork Design - https://craftwork.design/downloads/category/freebies/ - Free animated illustrations
- Kubix - https://kubix.design/templates - Animated templates and UI components 

Some keywords to search for more resources:

- Free animated illustrations
- Free animated icons 
- Free Lottie files
- Free SVG animations
- Free After Effects templates
- Free animated GIFs

Places to search:

- Behance - Filter for free animated UI kits and examples
- Pinterest - Search for "free animated illustrations" etc.
- Google Open Gallery - Collection of public domain media
 
When searching, look for reusable animated elements that can be customized and integrated into your web project. Things like animated icons, characters, shapes, and background textures will give you lots of options.

I'd also recommend browsing sites like CodePen and GitHub for open source animated demos you can learn from. There are lots of great animation examples and code snippets to build on.

Let me know if any other specific types of animations you're looking for!


---

<<
No I meant what keywords to search for an animation that instructs the user to rotate their phone into landscape if I detect they're on portrait

\>>
Ah I see - for an animation specifically instructing the user to rotate their device, here are some targeted search terms and ideas:

- "Rotate device animation"
- "Rotate phone animation" 
- "Rotate to landscape animation"
- "Device orientation change animation"

Look for animations that demonstrate rotating a phone or indicate switching from portrait to landscape orientation. Some ideas:

- An animated phone that rotates from vertical to horizontal
- Arrows or shapes that transition from portrait to landscape
- A hand/finger making a turning motion
- Text with "Rotate" or "Turn phone" instructions
- Icons like rotate arrows or orientation change indicators

Things to include:

- Visual indicator of phone/screen rotating
- Clear directional symbols or arrows
- Simple, readable text instructions if needed
- Animation on a solid background for easy integration

Places to look:

- LottieFiles and other animation libraries
- GIF search on Google, Giphy
- Behance and Dribbble for UI/UX examples
- CodePen for orientation change demos

Focus on finding a simple, clean animated graphic you can use with minimal effort. Custom illustrations are great but reusable animations will be easiest to implement.

Let me know if you have any other questions!