**How:**

Use a combination of onMouseEnter and onMouseLeave with state that conditionally renders a styling class.

---

**Nuances**

Why many nuances? React is not the way how javascript was originally programmed to work, so it's "hackish" and there are workarounds you must consider.

- React has no onHover even though it would not error out if you insist on using it
- To access the DOM you may want to use Ref
- If you have children in the element you want to animate on hovering over, that child could trigger onmouseout, so you want to use onmouseleave instead which includes parent and children in figuring out if your mouse left the area

<<
onmouseout is triggering when I move the mouse over a child element

\>>
Here are a few ways to avoid onmouseout triggering when moving the mouse over a child element:

- Use onmouseleave instead of onmouseout. onmouseleave only triggers when the mouse leaves the element and its children, while onmouseout triggers when moving to any element outside.

- Check the relatedTarget property of the event in the onmouseout handler. If relatedTarget is a child element, don't trigger the handler logic.

```js
element.onmouseout = function(event) {
  if (event.relatedTarget && element.contains(event.relatedTarget)) {
    return; 
  }
  
  // rest of onmouseout logic
}
```

- Stop event propagation in child element mouseover handlers using event.stopPropagation(). This prevents the onmouseout from triggering in the parent.

```js 
childElement.onmouseover = function(event) {
  event.stopPropagation();
}
```

- Use event delegation instead of binding handlers directly to each element. Check the source element in the delegated handler to determine if mouseout should trigger.

```js
parentElement.addEventListener('mouseout', function(event) {
  if (event.target !== parentElement) {
    return;
  }

  // onmouseout logic for parentElement only 
});
```

So in summary, onmouseleave, relatedTarget, stopPropagation, and delegation are good techniques to prevent onmouseout misfiring on child elements.


<<
In react how to trigger onmouseover. What is ref?

\>>
Here are a few ways to trigger onmouseover events in React:

1. Use the onMouseOver prop on the element:

```jsx
<div onMouseOver={handleMouseOver}>
  Hover over me
</div>

function handleMouseOver() {
  // do something
}
```

2. Attach an event listener in a useEffect hook:

```jsx
useEffect(() => {
  const element = document.getElementById('myDiv');
  element.addEventListener('mouseover', handleMouseOver);

  return () => {
    element.removeEventListener('mouseover', handleMouseOver);
  }
}, []);

function handleMouseOver() {
  // do something
}
```

3. Use the ref and onMouseOver callback:

```jsx
const myRef = useRef(null);

function handleMouseOver() {
  // do something
}

return (
  <div ref={myRef}>
    Hover over me
  </div>
);

myRef.current.onmouseover = handleMouseOver;
```

So in summary, the main options are the onMouseOver prop, effect with addEventListener, and ref with onmouseover callback. Each approach has tradeoffs and can be useful in different situations.

<<
Whats the ref for?

\>>
The ref in React is used to get direct access to a DOM element or React component instance. There are a few main reasons you may want to use a ref:

- Call imperative methods on a child component - If you need to invoke methods on a child component, you can get access to the component instance via ref.

- Access DOM nodes directly - Refs provide a way to bypass the React abstraction and get the actual DOM node. This is useful for things like managing focus, text selection, or working with 3rd party DOM libraries.

- Trigger side effects on mount/unmount - You can run certain side effects when a component mounts/unmounts using the ref and componentDidMount/componentWillUnmount lifecycle methods.

- Integration with other libraries - Some external libraries may require access to the DOM node, so refs provide a way to integrate React with these libraries.

- Animations - Refs can be useful for animations where you need to directly manipulate a DOM node.

Some common examples of using refs:

- Accessing video/audio DOM nodes to control playback
- Getting the DOM node for focus management 
- Triggering imperative animations like GSAP
- Integrating with D3 by passing the node to D3 methods

So in summary, refs provide an escape hatch from the React data flow for cases where you need direct access to a DOM element or component instance in order to integrate with non-React code. But avoid overusing refs, as it can lead to poorly structured code.


<<
how to trigger it though? like element.trigger("mouseover")

\>>
React doesn't have a built-in method to programmatically trigger events like jQuery's .trigger() method. But you can simulate events using the standard DOM APIs:

To trigger a mouseover event on a DOM element referenced by a ref:

```
return (
  <div ref={myRef}>
    Hover over me
  </div>
);
```

```jsx
const myRef = useRef(null);

// Trigger mouseover 
myRef.current.dispatchEvent(new MouseEvent('mouseover', {
  bubbles: true
}));
```

A couple notes on manually dispatching events in React:

- Create an event object using the MouseEvent, FocusEvent etc constructors. This allows you to specify properties like bubbles, cancelable etc.

- For React event handlers to run, the event needs to bubble. So set {bubbles: true} in the event options.

- Avoid calling dispatchEvent during render, as this can lead to infinite loops. Do it in event handlers or useEffect instead. 

- Manually dispatched events won't have all the properties of native events like target, timestamp etc. 

- Be aware synthetic React events and native events have some differences in behavior.

So while possible, manually dispatching events takes more work than jQuery's .trigger() and lacks some convenience. But it can be useful for testing or cases where you need direct control over event creation.