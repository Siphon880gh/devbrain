
You apply these rules on the direct children of a flex container (an element with display:flex)

DEFAULT: If you don't apply grow/shrink/basis rules, the default is:
```
flex: 0 1 auto
```


1. **flex-grow: 0** - This means that the flex item will not grow to fill the available space in the container. Its size will be determined based on its width/height or content.
    
2. **flex-shrink: 1** - This indicates that the flex item can shrink if necessary, so if the total size of the flex items is larger than the container, this item can shrink.
    
3. **flex-basis: auto** - This sets the initial size of the element to be based on its size property (like width or height) or its content if the size property isn't set.
    

When you explicitly set an element to `flex: 1` or `flex: 1 1 0%`, you're overriding these default values, instructing the item to both grow and shrink as needed to adapt to the available space, starting with a base size of 0% of the container's size. This is a common pattern when you want the flex items to equally divide the container's space, regardless of their content size.

----


Commonly divided children? Apply these to the direct children:
```
flex: 1 1 0%;
```

An alternate syntax is the shorthand:
```
flex: 1;
```

^ which is shorthand for flex: 1 1 0%;