See Weng's repo:
https://github.com/Siphon880gh/weng-teaches-react-aws-s3-file-upload

---

Warning 2024 will have new API. This api is deprecated and will eventually be sunsetted.
https://docs.aws.amazon.com/sdk-for-javascript/v3/developer-guide/migrating-to-v3.html

S3 benefit. You can get signed URLs that expire after 15mins.


AWS has many services. One of them is S3 for file storage. It stands for Simple Storage Service (S3)

Sign up free tier at [https://aws.amazon.com/free/](https://aws.amazon.com/free/)

Console Home -> View all services -> Storage -> S3

Create a new S3 bucket:
![](ufZRgIE.png)
Give your bucket a unique name and leave other settings as default. 

Click into your new bucket and go to the "Permissions" tab. Here you can set up a bucket policy to make the bucket public and allow anyone to upload files.
- If it says "This bucket has bucket owner enforced setting applied for Object Ownership". You click the "Bucket owner enforced" link, then enable ACL. Newer buckets in 2023 has ACL disabled by default.
- You must enable so you can write to bucket with ACL mode "public-read", so your URL is not going to be access denied when being rendered.

Add more permissions to be lenient:
- Block all public access to be: Off
- ACL panel -> Edit -> Enable Read for Everyone/public

Get your credentials for the backend code:
Top right name -> Security credentials
Access keys -> Create access key

Get your bucket name
https://s3.console.aws.amazon.com/s3/buckets

---

Install multer in your backend so you can pass a route middleware to handle file buffers. You'll be passing file buffer into the bucket:
```
npm install multer

```

Install the aws-sdk in your React-Express app
```
npm install aws-sdk
```


EXPLANATION (DONT HAVE TO COPY THIS CODE)
In your Express backend, require aws-sdk and configure it with your AWS credentials:
```
const AWS = require('aws-sdk');

AWS.config.update({
  accessKeyId: 'YOUR_ACCESS_KEY', 
  secretAccessKey: 'YOUR_SECRET_KEY'
});
```

^ You should have them as .env files that are gitignored and not pushed to your repository

EXPLANATION (DONT HAVE TO COPY THIS CODE)
When handling an image upload request, use the S3�`putObject`�method to upload the image to your bucket:
```
const s3 = new AWS.S3();

s3.putObject({
  Bucket: 'YOUR_BUCKET_NAME',
  Key: 'image-name.jpg', 
  Body: imageFileBuffer,
  ACL: 'public-read' 
});
``` 

EXPLANATION (DONT HAVE TO COPY THIS CODE)
After you uploaded to Bucket, you can retrieve either the signed URL (expires 15mins) or a permanent URL. Commented out is the signed URL code. The IIFE for unsigned is to keep the coding style similar.
```
server.post("/uploads", upload.single('file'), async (req, res) => {
    if(req.file === null) {
        return res.status(400).json({error: "No file uploaded from frontend"})
    }
    console.log({req_file: req.file, req_body:req.body, req_body_media: req.body.media, req_files: req.files})

    // Put object into AWS S3
    // Note the await form is: `await s3.putObject({...}).promise();`
    const s3 = new AWS.S3();
    s3.putObject({
      Bucket: 'weng-aws-s3',
      Key: 'image-name.png', 
    //   Body: imageFileBuffer,
      Body: req.file.buffer,
      ACL: 'public-read' 
    })
    .promise()
    .then(data=>{

        // Link would expire after 15mins
        // return s3.getSignedUrl("getObject", {
        //     Bucket: 'weng-aws-s3',
        //     Key: "image-name.png"
        // })

        return (function getUnsignedUrl() {
            let bucketName = "weng-aws-s3";
            let key = "image-name.png";
            const publicUrl = `https://${bucketName}.s3.amazonaws.com/${key}`;
            return publicUrl;
        })();
    }).then(url=>{
        res.send({url})
    })

});
```


---

Frontend code:
```
import { useState, useEffect} from "react";
import logo from './logo.svg';
import './App.css';

function App() {

  const [mediaUrl, setMediaUrl] = useState('')
  const [mediaName, setMediaName] = useState('');

  const handleMedia = (e) => {
    const selectedMedia = e.target.files[0];
    setMediaName(selectedMedia.name);


    const formData = new FormData();
    formData.append('file', selectedMedia);
    handleBackend(formData);
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
        console.log({result});

        setMediaUrl(result.url)
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
        <h1>Test Upload: AWS S3</h1>
        <p>Upload an image. AWS S3 image and link will appear. - Weng</p>

        <img src={mediaUrl?mediaUrl:logo} className={mediaName?"Image-preview":"App-logo"} alt="logo" />
        <form onSubmit={(event) => { event.preventDefault(); }}>
          <input type="file" id="upload-file" onChange={handleMedia} />
          {mediaUrl?(<a href={mediaUrl} target="_blank">{mediaUrl}</a>):""}
          <label class="d-block small" for="upload-file">{mediaName?mediaName:"Choose File"} </label>
        </form>
        <br/><br/>

      </header>
    </div>
  );
}

export default App;

```


Backend code:
```
const express = require("express");
const server = express();
const path = require("path");

// Configure multer to handle file uploads
const multer = require('multer');
const upload = multer({ storage: multer.memoryStorage() });
// const upload = multer({ dest: 'uploads/' }); // Otherwise you do fs.ReadFileSync to pass into s3 bucket body and there's no req.file.buffer

const AWS = require('aws-sdk');
AWS.config.update({
  accessKeyId: 'AKIA44__________UNAB', 
  secretAccessKey: 'NuYAT____/____oXHBF4Zcfa4WekQXiLC'
});

// Boilerplate: Middleware to parse JSON fetch body and URL-encoded form data
// Boilerplate: Middleware to respond with static files after page is loaded
server.use(express.json());
server.use(express.urlencoded({ extended: true }));
server.use(express.static(path.join(__dirname, "..", "client", "build")));

// server.use(fileUpload());

// Routes
server.post("/uploads", upload.single('file'), async (req, res) => {
    if(req.file === null) {
        return res.status(400).json({error: "No file uploaded from frontend"})
    }
    console.log({req_file: req.file})

    // Put object into AWS S3
    // Note the await form is: `await s3.putObject({...}).promise();`
    const s3 = new AWS.S3();
    s3.putObject({
      Bucket: 'weng-aws-s3',
      Key: 'image-name.png', 
    //   Body: imageFileBuffer,
      Body: req.file.buffer,
      ACL: 'public-read' 
    })
    .promise()
    .then(data=>{

        // Link would expire after 15mins
        // return s3.getSignedUrl("getObject", {
        //     Bucket: 'weng-aws-s3',
        //     Key: "image-name.png"
        // })

        return (function getUnsignedUrl() {
            let bucketName = "weng-aws-s3";
            let key = "image-name.png";
            const publicUrl = `https://${bucketName}.s3.amazonaws.com/${key}`;
            return publicUrl;
        })();
    }).then(url=>{
        res.send({url})
    })

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

.d-block {
  display: block;
}

.small {
  font-size: 80%;
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
#upload-file + label:hover, 
#upload-file + a + label:hover {
  box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.4);
}
```