
You're right, it would be better to indicate that the `videos` array contains `Video` objects. You can do that like this:

```js
/**
 * Props for the component.
 * 
 * @typedef {Object} Props
 * @property {Array<Video>} videos - The array of Video objects
 *
 * @typedef {Object} Video
 * @property {string} id - The video ID 
 * @property {string} title - The video title
 * @property {string} thumbnail - The thumbnail URL
 * @property {string} url - The video URL
*/
```

The key part is:

```js 
@property {Array<Video>} videos - The array of Video objects
```

Using `Array<Video>` signifies that `videos` is an array containing objects of type `Video`.

This is better than just `Array<Object>` because it tells the consumer that the array specifically contains `Video` objects, rather than any generic object.

So in summary:

- Define `Video` type with `@typedef` 
- Use `Array<Video>` in the Props `@property` for `videos`

This clearly documents the shape of the props.