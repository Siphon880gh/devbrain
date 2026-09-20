An emerging, nonstandard term for an app primarily created, configured, or controlled through an AI coding harness such as Cursor. Most interactions with the app’s data layer—such as generating, enriching, editing, or deleting information—happen through prompts or direct file manipulation in the harness. The app primarily provides a more readable, structured, and visually useful way to explore the data when artifacts inside the harness’s chat interface are insufficient. It may still support direct user interactions, but these often save requests for the AI to process later through the coding harness (for example, PUTTING into a json file for the coding harness to read).

One common workflow is to copy a subset of data from the app and paste it into the harness’s chat interface with instructions for the AI. Another approach is for buttons in the app to record requested actions in a file such as `requests.json`. The user can then prompt the coding harness:

> Look in `requests.json` for any pending AI requests and complete them.

In this model, the app serves mainly as the presentation and interaction layer, while the AI harness performs the more complex work behind the scenes.