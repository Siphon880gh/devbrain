
Regardless of framework, language, technology, here are ways to test if you can connect to a remote server. For our example, we used React Native, but the code will be the same:

## **TEST 1 - PHP**  
  
Step 1.

Test with a PHP website first because there are many web hosts that offer PHP for free, and you dont have to setup anything to make it work (no need to setup ports, open ports, do reverse proxying, or run a server). If you don’t have PHP, then skip this step.
```
<?php  
// Set the header to ensure we're dealing with JSON  
header('Content-Type: application/json');  
  
// Get the raw POST data (assumed to be in JSON format)  
$inputJSON = file_get_contents('php://input');  
  
// Decode the JSON input to an array (optional, if you want to work with PHP arrays)  
$input = json_decode($inputJSON, true);  
  
// Write the JSON data into a log.txt file  
file_put_contents('log.txt', $inputJSON . PHP_EOL, FILE_APPEND);  
  
// Optionally return a success message  
echo json_encode(['status' => 'success', 'message' => 'Data received and logged']);  
?>
```

Step 2.

Test with an api tester like Insomnia or Postman.Reason why instead of app is that you’re testing only the route and in case your code gets in the way.

Postman to test the php code is correct:
POST, Body → raw

```
{  
    "a":"1",  
    "b":"2"  
}
```

Then visit the txt file directly to see it’s been saved. eg. https://domain.tld/log.txt

Then test appending by sending the POST body request multiple times, then visiting the txt file to see the same entries have been appended to the text file. THis would prove no file permission issues on your server to handle api calls.

Step 3.
Now test in the app. Implement fetch request at your app. 

If React or React Native, trigger an on useEffect onload (by using []):
```
  useEffect(() => {  
    // Data you want to send  
    const data = {  
      key1: 'value1',  
      key2: 'value2',  
    };  
  
    // Send POST request  
    fetch('http://yourserver.com/intercept_api.php', {  
      method: 'POST',  
      headers: {  
        'Content-Type': 'application/json',  
      },  
      body: JSON.stringify(data),  
    })  
    .then(response => response.json())  
    .then(responseData => {  
      console.log('Response:', responseData);  
    })  
    .catch(error => {  
      console.error('Error:', error);  
    });  
  
  }, []);
```

---

## TEST 2 - YOUR DESIRED BACKEND API

Now implement in the desired language either a python flask or a nodejs express server. If PHP is your go-to, then you’re good.  

Whichever port you choose, make sure to perform a reverse proxy OR to open the port up to the public internet if you have ufw or iptables enabled. When doing reverse proxy, you are specifying a specific url the internet connects to then the host server will redirect the traffic and data to the specific port locally, and when responding back, the traffic flows in reverse back to the client. Hence with reverse proxying, you are not required to open specific port to the if you have ufw or iptables enabled.

For checking if ufw or iptables are enabled, and if they’re enabled, then how to open a port, if you choose not to go with reverse proxy, refer to the tutorials [..]

For reverse proxy, refer to the tutorial ...

Now for nodejs or python. We’re going to use nodejs for this tutorial
- Setup a GET / endpoint that you will visit on a web browser to test that the API is reachable on a whole
- Setup a POST /test endpoint for posting data to: POST /test.

NodeJS Example:
```
const express = require('express');  
const bodyParser = require('body-parser');  
const fs = require('fs');  
const app = express();  
  
// Middleware to parse JSON bodies  
app.use(bodyParser.json());  
  
// Get the PORT from environment variables, default to 3000 if not set  
const PORT = process.env.PORT || 3000;  
  
app.get('/', (req, res) => {  
  res.status(200).json({ status: 'success', message: 'Reached API /.' });  
});  
  
// POST /test endpoint  
app.post('/test', (req, res) => {  
  const jsonData = JSON.stringify(req.body);  
  
  // Append the received JSON data to a log.txt file  
  fs.appendFile('log.txt', jsonData + '\n', (err) => {  
    if (err) {  
      console.error('Failed to write to file:', err);  
      return res.status(500).json({ status: 'error', message: 'Failed to log data' });  
    }  
  
    console.log('Data received and logged:', jsonData);  
    res.status(200).json({ status: 'success', message: 'Data received and logged' });  
  });  
});  
  
// Start the server  
app.listen(PORT, () => {  
  console.log(`Server is running on port ${PORT}`);  
});  
  
~
```

Remember that if you reverse proxy like to https://domain.tld/app1-api/test

Then your endpoints in express or flask routes need to hit “app1-api/test”. You can choose to strip away app1-app before matching the routes. Place before the rest of the routes. You may want to do this because that subpath (in this case, app1-api) was because you’re forced to have to have that subpath for reverse proxying and you may want to keep that detail unknown to the API to keep with separation of concerns.

```
// Middleware to strip "/app1-api" from the URL path  
app.use((req, res, next) => {  
  if (req.path.startsWith('/app1-api')) {  
    req.url = req.url.replace('/app1-api', ''); // Strip "/app1-api" from the URL path  
  }  
  next(); // Continue to the next middleware or route handler  
});
```

Also with reverse proxy you may want to enable cors in nginx (cross origin) in the reverse proxy location block

Now visit in web browser https://domain.tld/app1-api and you should get some message in the web browser about a 'Reached API /.’

Then to test a similar route to PHP to see if the api can receive parameters and can append data to a file on the server. You are NOT going to be able to test by visiting directly in the web browser (those are for GET requests because it’s just retrieving information like you would retrieve text files or web pages). So use Insomnia or Postman. In Postman for POST method, for example, you make sure that you go to Body->Raw, then enter the json (make sure key names have double quotation marks)

After Insomnia or Postman success, you have proven the correct URL AND that the desired API technology works.

You can be sure of the full url you used from there. Then you work on using this url for fetching or making data requests in your app.