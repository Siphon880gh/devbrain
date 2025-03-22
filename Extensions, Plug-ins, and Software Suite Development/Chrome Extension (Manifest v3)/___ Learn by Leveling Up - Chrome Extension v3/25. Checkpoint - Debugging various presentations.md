
When debugging / refreshing the chrome extension:

- When debugging background scripts, content scripts, popup scripts, and devtools all have different Developer Tools instances. So, always make sure to open the Developer Tools for the correct context when debugging different parts of your extension. For example, you’d right click → inspect → console on the popup modal for popup.js errors, not content.js errors.
- You have to refresh the page when changing content.js for things to reflect
- You may want to clear Errors if an Errors button appear for the extension at the Extensions page before dropping a newer copy of the folder. It preserves previous errors from console. Then you’ll know if there are fresh errors when you re-run the chrome extension.
  ![[Pasted image 20250320164049.png]]
- Suggested workflow: Leave one Chrome tab opened to extensions. Have Finder/explorer showing the folder of your code. You could run `open .`  or `explorer .`  from VS Code’s integrated terminal, then go up a directory if required (CMD+Up on Mac). You’ll drag and drop between the chrome window and the window of the folder.