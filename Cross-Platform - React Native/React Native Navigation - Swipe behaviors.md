
### **Stack Navigator**:

- Automatically when you navigate to different route-screen pairs defined in the stack navigator, your app keeps a history of them. When the user gestures with a swipe, the phone shows an animation getting rid of the current screen to unwind (aka pop off) to the previous screen. The user may keep repeating this swipe gesture until they return to the first route-screen they ever navigated to that's in the current stack navigator.

### **Tab Navigator**:

   - A tab navigator displays a set of tabs at the bottom (or top) of the screen, allowing users to switch between different screens freely. The phone shows an animation of switching screen in the direction where the tab is at.

### **Drawer Navigator**:

   - A drawer navigator provides a hidden navigation menu that slides out from the side, allowing users to navigate between screens freely.


###  **Gesture-based Navigation (Android Back/Forward Swipe)**:

   - On iOS, the stack navigator supports the swipe-to-go-back gesture by default. However, there is no built-in forward swipe gesture to navigate forward through the stack. You would need to manually implement such functionality using a combination of state management and navigation actions.