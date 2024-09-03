
- The curious might ask: Does onLongPress work for when an user touches on a touch screen for a long time or click and hold left button for a long time? How would it distinguish between left click hold or right click hold?

- **Touchscreen:** When a user touches and holds down on a component for a specified duration (usually around 500ms or longer), the `onLongPress` event is triggered.
- **Mouse Interaction (if applicable):** On platforms like React Native for Web, where mouse events are also supported, `onLongPress` can be triggered by clicking and holding the left mouse button.

- Btw right click mouse is: `onContextMenu={this.handleClick}` . To detect right click hold, you combine onContextMenu and onLongPress and use a flag like contextMenuTriggered, which gets reset on long press and normal press