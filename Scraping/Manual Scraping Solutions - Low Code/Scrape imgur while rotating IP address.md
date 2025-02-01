
## Category

Some Code: You do configure a `config.js` with the desired filenames to scrape and run a `script.js`

Manual: You use a VPN software to change IP addresses each time `script.js` finishes (which would have downloaded 200 images)

Adaptable: 
- Automatic VPN: You can host this on an online server and make the IP rotation automatic (You can subscribe to proxy api services)
- Besides Imgur: You can rewrite script.js to scrape another image hosting service as long as you have the proper filenames at imageListString in config.js and that their URL follows a predictable pattern. Speaking of which, you have to adjust the URL at script.js. You may have to adjust timeBetweenDownload for each failure (rotate the IP address and hopefully you won't burn off all your IP's until you find a reasonable milliseconds duration that doesn't kick you off and can squeeze in as much performance as possible). Then you adjust the random timeAppendMinRange and timeAppendMaxRange that prevents other scraping detection.

---

## Code Snippets

config.js has the filenames that imgur has in the URL or that the Obsidian imgur plugin creates when you pasted images:
```
const imageListString = `
L9SlEGI.png
DwFZ8Zs.png
ECxijBe.png
LnPemOU.png
Y6vZR1k.png
`;

module.exports = { imageListString };
```

script.js:
```
const axios = require('axios');
const fs = require('fs');
const path = require('path');
const {imageListString} = require('./config.js');

const timeBetweenDownload = 2250;
const timeAppendMinRange = 0;
const timeAppendMaxRange = 250;

let i = 0;
const total = imageListString.trim().split('\n').length;

// Function to download an image
async function downloadImage(imageName) {
  const url = `https://i.imgur.com/${imageName}`;
  const filePath = path.resolve(__dirname, 'downloaded', imageName);

  try {
    const response = await axios({
      url,
      method: 'GET',
      responseType: 'stream'
    });

    response.data.pipe(fs.createWriteStream(filePath));
    i++;
    console.log(`Downloaded ${i}/${total}: ${imageName}`);
    return true; // Indicate success
  } catch (error) {
    console.error(`Error downloading ${imageName}:`, error.message);
    return false; // Indicate failure
  }
}

// Function to count files in a directory
function countFilesInDirectory(directory) {
  return fs.readdirSync(directory).length;
}

// Main function to process the images
async function processImages(imageList) {
  const downloadedDir = path.resolve(__dirname, 'downloaded');
  
  // Count files before downloading
  const initialFileCount = countFilesInDirectory(downloadedDir);
  console.log(`Initial file count: ${initialFileCount}`);

  let successfulDownloads = 0;

  for (const imageName of imageList) {
    const success = await downloadImage(imageName);
    if (success) {
      successfulDownloads++;
    }
    const finalTimeBetweenDownload = timeBetweenDownload + Math.floor(Math.random() * timeAppendMaxRange) + timeAppendMinRange;
    await new Promise(resolve => setTimeout(resolve, finalTimeBetweenDownload)); // Wait for 3 seconds
  }

  // Count files after downloading
  const finalFileCount = countFilesInDirectory(downloadedDir);
  console.log(`Final file count: ${finalFileCount}`);
  console.log(`Files successfully downloaded: ${successfulDownloads}`);
}

// Convert the multiline string to an array of image names
const imageList = imageListString.trim().split('\n');

// Ensure the 'downloaded' directory exists
if (!fs.existsSync(path.resolve(__dirname, 'downloaded'))) {
  fs.mkdirSync(path.resolve(__dirname, 'downloaded'));
}

// Start processing the images
processImages(imageList);
```

This means initiating a npm package with axios as a dependency:
```
npm init
npm install axios
```

## Preliminary Setup
If applies (migrating your code to another computer so you already have package.json), run `npm install` against the package.json to make sure `axios` is installed.

## Batch Process

1. Refer to your list of files to download (from previous scripts).

Note: If you had exported imgur in the past, you may have a diff list between exported imgur filenames and obsidian matched imgur filenames, therefore having a list of files you do not have locally on the computer and need to download now so that your Obsidian documents can load images locally rather than from imgur. 

Your list may look like:
```
asaX9823.png
bsaX2821.png
```

2. Copy no more than 200 lines of imgur jpg/png filenames into `config.js` (Notice it's not a .json file)
3. Join a new IP address on your VPN app. Visit https://www.whatsmyip.org/ to check a.) you can load a webpage, and b.) your ip address changed.
4. Run script.js. It will download every 2250-2500 seconds which will download 24 pics a minute.
5. While it autodownloads, check downloaded/ folder sorted by last modified and see if they are successfully downloading.

What worked without imgur servers throttling the batch downloader:
- Download 200 pics waiting after each pic 2250ms-2500ms
- Then rotate the IP address with your VPN server.
- 2000ms will hit at capacity message when visiting their homepage (when in fact they throttled your IP).

VPN app:
For example, with VPN Unlimited, switch to another state (California, Utah, etc) after each 200 pics download (or when the script finishes)
Then add your next batch to `imageListString` at config.json.

How it works: The downloading script works on the basis of curl
```
curl -o downloaded/6tbAP5p.png "https://i.imgur.com/6tbAP5p.png"
```