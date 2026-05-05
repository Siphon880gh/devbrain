
For cross-domain communication, you can use window.postMessage. This method safely enables cross-origin communication. Here's an example of how you would use it inside the webpage that has been iframed:

// Sending a message from the iframe to the parent window window.parent.postMessage('Hello Parent!', '*');

In the parent window, you would set up an event listener to receive the message:
javascript
// Listening for messages in the parent window window.addEventListener('message', (event) => { if (event.origin !== 'http://example.com') { // replace with your domain return; } console.log('The iframe said:', event.data); }, false);

Remember to always validate the origin of the message for security reasons. The wildcard '*' allows any domain to receive the message, so in a production environment, you should specify the exact origin that's allowed.