See Weng's repo:
https://github.com/Siphon880gh/weng-teaches-react-multer-file-upload

---

Warning Heroku: Files or folders can be added via your Node.js script in Heroku. However, any additions will be removed when the dyno restarts or resets. The dyno restarts when there are scheduled restarts, new deployments, scaling operations, application crashes, or configuration changes. These restarts ensure the health and correct operation of the application but lead to the loss of any additions due to Heroku's ephemeral filesystem. Instead you should use another tool service Firebase Storage or AWS.

Many node modules available for file upload on the express server.

Here's multer that makes managing the file data simple at the express backend. Simply, you setup the destination where you want the file buffer to save as a file and you set it into client/build/uploads folder. Make sure your client/package.json creates an /uploads folder in the build folder when you run `npm run build`

https://www.npmjs.com/package/multer

You created a client folder with `create-react-app client`

Frontend client/package.json makes sure will create the uploads folder in build/:
```
...
"proxy": "http://localhost:3001",
"scripts": {
	"start": "react-scripts start",
	"build": "react-scripts build && cd build && mkdir uploads",
...
```

Frontend Component:
```
import { useState, useEffect} from "react";
import logo from './logo.svg';
import './App.css';

function App() {

  const [media, setMedia] = useState('')
  const [mediaName, setMediaName] = useState('');
  const [purgeCache, setPurgeCache] = useState('');

  const handleMedia = (e) => {
    const selectedMedia = e.target.files[0];
    setMediaName(selectedMedia.name);

    const formData = new FormData();
    formData.append('file', selectedMedia);
    handleBackend(formData);
    setTimeout(()=>{
      setPurgeCache(Date.now());
    }, 1000)
  } // handleMedia

  const handleBackend = async (formData) => {
    console.log({formData})

    try {
      const response = await fetch("/uploads", {
        method: "POST",
        body: formData
      });

      if (response.ok) {
        console.log("Upload successful");
        var result = await response.json();
        console.log("Server response: ", result); // Log the entire result object
        let fileUrl = 'http://localhost:3001' + result.filePath;
        console.log("File URL: ", fileUrl);
      } else {
        console.error("Upload unsuccessful");
      }

    } catch (error) {
      console.error(error);
    }
  } // handleBackend


  return (
    <div className="App">
      <header className="App-header">
        <h1>Test Upload: Multer</h1>
        <p>Upload an <code>a.png</code>, <code>b.png</code>, <code>c.png</code>, <code>d.png</code> to test. - Weng</p>
        <div className="gallery">
          <img className="image" src={`uploads/a.png?v=${purgeCache}`}></img>
          <img className="image" src={`uploads/b.png?v=${purgeCache}`}></img>
          <img className="image" src={`uploads/c.png?v=${purgeCache}`}></img>
          <img className="image" src={`uploads/d.png?v=${purgeCache}`}></img>
        </div>

        <img src={mediaName?`uploads/${mediaName}?v=${purgeCache}`:logo} className={mediaName?"Image-preview":"App-logo"} alt="logo" />
        <form onSubmit={(event) => { event.preventDefault(); }}>
          <input type="file" id="upload-file" onChange={handleMedia} />
          <label class="d-block small" for="upload-file">{mediaName?mediaName:"Choose File"} </label>
        </form>
        <br/><br/>

      </header>
    </div>
  );
}

export default App;
```


Backend server/server.js receives the e.target.files[0] that was sent over at the request body at "file", and saves that file to client/build/uploads so that the frontend website can render the static file just uploaded:
```
const express = require("express");
const server = express();
const path = require("path");

// Configure multer to handle file uploads
const multer = require('multer');
// const upload = multer({ storage: multer.memoryStorage() }); // saves to memory, great for passing off a req.file.buffer to another upload service like AWS S3
// const upload = multer({ dest: path.join(__dirname, '../build/uploads/') }); // saves to file storage but doesnt allow for custom filenames. quick and dirty syntax.
const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        cb(null, path.join(__dirname, '../client/build/uploads'));
    },
    filename: (req, file, cb) => {
        // cb(null, file.fieldname + '-' + Date.now() + path.extname(file.originalname)); // Custom filename of input field name and timestamp
        cb(null, file.originalname); // originalname has filename with extension
    }
});
const upload = multer({ storage: storage });

// Boilerplate: Middleware to parse JSON fetch body and URL-encoded form data
// Boilerplate: Middleware to respond with static files after page is loaded
server.use(express.json());
server.use(express.urlencoded({ extended: true }));
server.use(express.static(path.join(__dirname, "..", "client", "build")));

// Routes
server.post("/uploads", upload.single('file'), async (req, res) => {
    if(req.file === null) {
        return res.status(400).json({error: "No file uploaded from frontend"})
    } else {
        res.json({fileName: req.file.originalname, filePath: `/uploads/${req.file.originalname}`});
    }
});

server.get("/", async (req, res) => {
    res.sendFile(path.join(__dirname, "..", "client", "build", "index.html"))
});

async function startServer() {
    let port = process.env.PORT || 3001;

    server.listen(port, () => {
        console.log(`Server listening at ${port}`);
    });
}

startServer();
```

Remember to coordinate the /client and /server
```
{
  "name": "upload-app",
  "version": "1.0.0",
  "description": "",
  "main": "server/server.js",
  "scripts": {
    "start": "node server/server.js",
    "develop": "concurrently \"cd server && npm run watch\" \"cd client && npm start\"",
    "install": "cd server && npm i && cd ../client && npm i",
    "build": "cd client && npm run build"
  },
  "keywords": [],
  "author": "",
  "license": "ISC",
  "devDependencies": {
    "concurrently": "^5.1.0"
  }
}
```


---

For a more visually complete demo, the App.css:
```
.App {
  text-align: center;
}

.App-logo, .Image-preview {
  height: 40vmin;
  pointer-events: none;
}

@media (prefers-reduced-motion: no-preference) {
  .App-logo {
    animation: App-logo-spin infinite 20s linear;
  }
}

.App-header {
  background-color: #282c34;
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  font-size: calc(10px + 2vmin);
  color: white;
}

.App-link {
  color: #61dafb;
}

@keyframes App-logo-spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}

/* ------------------------------------------ */

code {
  background-color: darkgray;
}

.d-block {
  display: block;
}

.small {
  font-size: 80%;
}

/* ------------------------------------------ */

.gallery {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 10px;
  background-color: rgba(255,255,255,0.1);
  margin: 20px auto;
  border-radius: 10px;
  height: 100px;
}
.gallery .image {
  border: 1px solid black;
  transform: scale(.25);
  -webkit-transform: scale(.25);
  height: fit-content;
}


/* ------------------------------------------ */

#upload-file {
  width: 0.1px;
  height: 0.1px;
  opacity: 0;
  overflow: hidden;
  position: absolute;
  z-index: -1;
}
#upload-file + label {
  cursor: pointer; /* hand cursor */
  background-color: gray;
  border: 1px solid black;
  padding: 10px;
  color: black;
  transition: all 200ms ease-in-out;
  width: 95px;
  margin-top:10px;
}
#upload-file + label:hover {
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.4);
}
```