# Popover Preview Test Document

  

This document demonstrates the popover preview functionality.

  

## Basic Example

  

Here's a link to a webpage with a popover preview: [Example Website](https://example.com) ![title..content](img/1x2.png)

  

This should show a preview when you hover over the link, extracting text between "title" and "content".

  

## Another Example

  

Check out this documentation: [MDN Web Docs](https://developer.mozilla.org) ![Resources...Developers](img/1x2.png)

  

This will extract content between "Resources" and "Developers" from the linked page using three dots.

  

## Custom Preview Feature (NEW)

  

These links use the new custom preview feature with ## delimiter:

  

### Custom Preview Examples

  

- [Technical Term](https://example.com) ![API##Application Programming Interface - a set of protocols and tools for building software applications](1x2.png)

- [Complex Concept](https://example.com) ![Machine Learning##A subset of artificial intelligence that enables computers to learn and make decisions from data without being explicitly programmed for every scenario](1x2.png)

- [Simple Definition](https://example.com) ![CSS##Cascading Style Sheets - used to style and layout web pages](1x2.png)

  

### How Custom Previews Work

  

The custom preview feature allows you to define any preview text directly in the image alt tag using the `##` delimiter:

- Left side of `##`: The text that will appear as the link

- Right side of `##`: The preview text that shows in the popover

- The link goes nowhere (href="#") and just shows the preview

  

## Without Popover

  

This is a regular link without popover: [Regular Link](https://google.com)

  

Since there's no 1x2.png image following it, no popover will be shown.

  

## Multiple Examples (Original Feature)

  

- First link: [GitHub](https://github.com) ![GitHub..code](img/1x2.png)

- Second link: [Stack Overflow](https://stackoverflow.com) ![Questions...Answers](img/1x2.png)

- Third link: [Wikipedia](https://wikipedia.org) ![encyclopedia..knowledge](img/1x2.png)

  

## Mixed Examples

  

You can mix both types in the same document:

  

1. External link preview: [React Docs](https://reactjs.org) ![React...components](1x2.png)

2. Custom preview: [Original Link](https://example.com) ![JSX##JavaScript XML - a syntax extension that allows you to write HTML-like code in JavaScript](1x2.png)

3. Another external: [Vue.js](https://vuejs.org) ![Vue...framework](1x2.png)

4. Another custom: [Another Link](https://example.com) ![REST API##Representational State Transfer - an architectural style for designing web services that use HTTP methods](1x2.png)