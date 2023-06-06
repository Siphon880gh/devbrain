Many node modules available for file upload on the express server.

Here's express-fileupload that makes managing the filedata simple at the express backend. Simply, it moves the filedata into client/build/uploads folder. Make sure your client/package.json creates an /uploads folder in the build folder when you run `npm run build`

https://www.npmjs.com/package/express-fileupload


You created a client folder with `create-react-app client`

client/package.json:
```
...
"proxy": "http://localhost:3001",
"scripts": {

	"start": "react-scripts start",

	"build": "react-scripts build && cd build && mkdir uploads",
...
```

Component:
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
	setMedia(selectedMedia)
	setMediaName(selectedMedia.name)
	handleBackend(selectedMedia);
	setTimeout(()=>{
		setPurgeCache(Date.now());
	}, 1000)
} // handleMedia

  
const handleBackend = async (mediaFile) => {
	const formData = new FormData();
	formData.append('media', mediaFile);

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

		<h1>Test Upload: Express-fileupload</h1>

		<p>Upload an <code>a.png</code>, <code>b.png</code>, <code>c.png</code>, <code>d.png</code> to test. - Weng</p>

		<div className="gallery">
			<img className="image" src={`uploads/a.png?v=${purgeCache}`}></img>
			<img className="image" src={`uploads/b.png?v=${purgeCache}`}></img>
			<img className="image" src={`uploads/c.png?v=${purgeCache}`}></img>
			<img className="image" src={`uploads/d.png?v=${purgeCache}`}></img>
		</div>


		<img src={mediaName?`uploads/${mediaName}?v=${purgeCache}`:logo} className={mediaName?"":"App-logo"} alt="logo" />
		<form onSubmit={(event) => { event.preventDefault(); handleBackend() }}>
			<input type="file" id="upload-file" onChange={handleMedia} />
			<label class="d-block small" for="upload-file">{mediaName?mediaName:"Choose File"} </label>
		</form>
	</header>
</div>
);
}

export default App;
```


server/server.js
```
const express = require("express");
const server = express();
const path = require("path");
const fileUpload = require("express-fileupload")
  
// Boilerplate: Middleware to parse JSON fetch body and URL-encoded form data
// Boilerplate: Middleware to respond with static files after page is loaded
server.use(express.json());
server.use(express.urlencoded({ extended: true }));
server.use(express.static(path.join(__dirname, "..", "client", "build")));

server.use(fileUpload());

// Routes
server.post("/uploads", async (req, res) => {
	if(req.files === null) {
		return res.status(400).json({error: "No file uploaded from frontend"})
	}
	const file = req.files.media;


	// express-fileupload has a file.mv that moves files
	// https://www.npmjs.com/package/
	file.mv(path.join(__dirname, "..", "client", "build", "uploads", file.name), err=>{

		if(err) {
			console.error(err);
			res.status(500).send(err)
		}

		res.json({fileName: file.name, filePath: `/uploads/${file.name}`});
	}); // file.mv
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