You can create custom named events and trigger them. For example, in jQuery, you could do $("#someDiv").on("click", clickHandler). And you can programmatically trigger a click event on that div as if an user had clicked it: $("#someDiv").trigger("click"), then clickHandler function will run.

This is excellant to apply in a Publisher-Subscriber pattern. Subscribers are event handlers that gets called after an asynchronous task such as user choosing an option on the menu. Choosing the option here would be publishing. Then the subscriber would be informed and runs the event handler function. The publishing gives information to the subscriber, and a good way to do this is to trigger a custom event that the subscriber was listening to. In addition to triggering the custom event, the publisher code can also send extra context information such as values to the subscriber.

Node JS has an Events node module that's built in. As part of the events node mudule, it has an EventEmitter object that has these methods to assign custom events and to trigger custom events. In the case of EventEmitter, triggering is called emitting. You are not attaching events or triggering events on DOM, so instead it happens in the whole app.

In some cases, it's recommended to make the EventEmitter a globally saved object `globa.eventEmitter = eventEmitter` but you would run this after setting up all the custom events and their event handler functions.

Theory: https://www.tutorialspoint.com/nodejs/nodejs_event_emitter.htm
More theory: https://www.eventhelix.com/RealtimeMantra/Patterns/publish_subscribe_patterns.htm
Refer to the subscribers folder in the field hierarchy diagram:  https://softwareontheroad.com/ideal-nodejs-project-structure/#architecture

Basically:
```
    const events = require('events');
    const eventEmitter = new events.EventEmitter();

    const constantEvents = {
        raiseFlag: "raise color"
    }
    const raiseFlagEventHandler = (color) => {
        console.log(`${color} flag`);
    }

    /** Delegate riase flag event handler */
    eventEmitter.on(constantEvents.raiseFlag, raiseFlagEventHandler);

    /** Test with Jest framework: 
     * Emit raise flag event and pass a context of flag color red 
     */
    const consoleSpy = jest.spyOn(console, "log");
    eventEmitter.emit(constantEvents.raiseFlag, "red");
    expect(consoleSpy).toHaveBeenCalledWith("red flag");
```

Reference:
- .on: delegates event handler
- .once: delegates event handler but will only run once. Conventional examples: ready, onload.
- .emit: triggers the custom event