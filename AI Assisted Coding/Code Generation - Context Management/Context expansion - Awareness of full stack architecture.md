To ensure Cursor AI understands your full stack architecture—especially when you need it to implement both a frontend feature and the internal API endpoint that supports it—start with the following prompt.

For the following prompt example, the folder structure is:
```
.
├── full-stack
    ├── server.js
    └── app
        ├── index.js
        ├── index.css
        └── index.html
```
And Cursor AI is opened to full-stack/

Prompt:
- Replace your relative paths as appropriately
```
The backend code is in the root folder: full-stack/.  
  
The frontend code is in the app/ subfolder and communicates with the backend via API calls.  
  
Make sure you understand this structure.
```

Then **resume asking AI** for help in the same chat thread.