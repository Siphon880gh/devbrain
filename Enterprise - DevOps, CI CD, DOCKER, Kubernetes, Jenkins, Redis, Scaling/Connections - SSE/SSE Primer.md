## Code Snippets (Bottom of tutorial):
- Most basic
- Basic with frontend sending info to backend
- With video maker (but without db code)

---

## Concept

SSE is where on the frontend a new EventSource hits a route. So EventSource is acting like a fetch except it’s to perform a frontend to server one way connection. 
Your frontend will only connect and if sends information, sends information to the backend once at the beginning of the connection. The backend can send information whenever needed as long as the connection is maintained.

Frontend starts the connection with new EventSource(route). It listens for messages sent from server by using on-message event handler and captures the message from event.data

That route in python flask would not have method explicitly set in the decorator. If you must pass info from frontend to backend (and you can only do it once at the start of the connection), use url parameters and the python end point will be able to get args from request

Your endpoint has to immediately return a Response type that’s configured for streaming. The Response type is passed a generator function (think of it as a stream event generator). All messages will be sent from inside the generator function. The immediately return Response type allows the frontend to finish starting the connection.

In the generator function, you can send messages using yield STRING. That string consists of data: … \n\n. Usually you have a single word or space separated words in the … that you can parse or to be signaled for at the frontend. You may also decide on a word that if found on the frontend, the frontend will close the connection. All this interpretation is event.data when on-message.

Your frontend will only connect and if sends information, sends information to the backend once at the beginning of the connection. The backend can send information whenever needed as long as the connection is maintained. The connection is maintained until both sides are closed
backend closes by running return in the generator
Frontend closes with eventSource.close(), and it’s usually by checking event.data for a certain string you decided on to signal ending the connection from the frontend

Advanced:
If you are waiting on a video maker or something that hogs the cpu and makes the user waits for when it finishes, you want to inside of generator function: declare a queue, then start an asynchronous thread, followed by a while loop that checks the queue for a new message. 

You had passed a queue into the asynchronous thread call. The thread function can add to the queue. The while loop back at the generator function is looking for new messages on the queue.

This meant declaring queue in the generator code, then passing queue into the Async task, then do while loop in the generator code.

If a new message is found, sends the message with a yield statement inside the while loop. This keeps yield (aka send message to frontend) inside the SSE generator. The message you’re sending inside the async thread function is through a queue. The SSE generator is checking the queue with a while loop. This must be done like this because you’re not allowed to synchronously block the generator function.

---

## Nginx required settings

Make sure if you’re using Nginx to disable its default behavior of buffering responses. Otherwise the frontend .onmessage just wont trigger (you can console log to check it triggers). See (more than example):
```
    location /api {  
        proxy_pass https://127.0.0.1:5001;  
        proxy_read_timeout 600s;   # Adjust as needed  
        proxy_connect_timeout 600s; # Adjust as needed  
        proxy_send_timeout 600s;   # Adjust as needed  
        proxy_set_header Host $host;  
        proxy_set_header X-Real-IP $remote_addr;  
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;  
        proxy_set_header X-Forwarded-Proto $scheme;  
          
        # Allows SSE by disabling Nginx's default behavior of buffering responses,   
        # which can cause issues with SSE as it expects to receive events as they   
        # are sent.  
        proxy_buffering off;  
        proxy_cache off;  
        proxy_set_header Connection '';  
        chunked_transfer_encoding off;  
        proxy_http_version 1.1;  
    }
```

---


## Basic

test.py:

```
from flask import Flask, Response
import time

app = Flask(__name__)

def generate_events():
	for i in range(5):
	yield f"data: Message {i+1}: The server time is: {time.ctime()}\n\n"
	time.sleep(1)
	yield "data: finished\n\n"

@app.route('/testapi/events')
def events():
	return Response(generate_events(), content_type='text/event-stream')

if __name__ == '__main__':
	cert = "/etc/nginx/ssl-certificates/DOMAIN.ai.crt"
	key = "/etc/nginx/ssl-certificates/DOMAIN.ai.key"

	app.run(debug=True, port=5002, ssl_context=(cert, key))
```

test.html:
```
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>SSE Example</title>
</head>

<body>
	<h1>Server-Sent Events</h1>
	<div id="events"></div>
	
	<script>
	const eventSource = new EventSource('https://DOMAIN.ai/testapi/events');
	
	eventSource.onmessage = function(event) {
		const newElement = document.createElement("div");
		newElement.innerHTML = "Received event: " + event.data;
		document.getElementById("events").appendChild(newElement);
	
		// Close the connection when "finished" message is received
		if (event.data === "finished") {
			eventSource.close();
			console.log("Connection closed.");
		}
	};
	
	eventSource.onerror = function(event) {
		console.error("EventSource failed:", event);
	};
	</script>
</body>
</html>
```

  

vhost on the server block with 80 and 443:
```

    location /api {  
        proxy_pass https://127.0.0.1:5001;  
        proxy_read_timeout 600s;   # Adjust as needed  
        proxy_connect_timeout 600s; # Adjust as needed  
        proxy_send_timeout 600s;   # Adjust as needed  
        proxy_set_header Host $host;  
        proxy_set_header X-Real-IP $remote_addr;  
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;  
        proxy_set_header X-Forwarded-Proto $scheme;  
          
        # Allows SSE by disabling Nginx's default behavior of buffering responses,   
        # which can cause issues with SSE as it expects to receive events as they   
        # are sent.  
        proxy_buffering off;  
        proxy_cache off;  
        proxy_set_header Connection '';  
        chunked_transfer_encoding off;  
        proxy_http_version 1.1;  
    }

```

  
  

Run command:

```
sudo iptables -A INPUT -p tcp --dport 5002 -j ACCEPT
python test.py
```

  

Visit page directly and you'll see:

Server-Sent Events

```
Received event: Message 1: The server time is: Thu Aug 22 07:08:22 2024
Received event: Message 2: The server time is: Thu Aug 22 07:08:23 2024
Received event: Message 3: The server time is: Thu Aug 22 07:08:24 2024
Received event: Message 4: The server time is: Thu Aug 22 07:08:25 2024
Received event: Message 5: The server time is: Thu Aug 22 07:08:26 2024
Received event: finished
```

---

## Basic with frontend sending info to backend

test.py:
```
from flask import Flask, Response, request # import request in order to parse url query string
import time

app = Flask(__name__)

def generate_events(client_secret):
    for i in range(5):
        if(i==0):
            yield f"data: Message: Client secret communicated from frontend to backend at frontend initiating SSE. Backend sends text stream to the frontend, the client secret: {client_secret}\n\n"
        yield f"data: Message {i+1}: The server time is: {time.ctime()}\n\n"
        time.sleep(1)
    yield "data: finished\n\n"

@app.route('/testapi/events')
def events():
    client_secret = request.args.get('client_secret')
    return Response(generate_events(client_secret), content_type='text/event-stream')

if __name__ == '__main__':
    cert = "/etc/nginx/ssl-certificates/DOMAIN.ai.crt"
    key = "/etc/nginx/ssl-certificates/DOMAIN.ai.key"

    app.run(debug=True, port=5002, ssl_context=(cert, key))
```

test.html:
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSE Example</title>
</head>
<body>
    <h1>Server-Sent Events</h1>
    <div id="events"></div>

    <script>
        const eventSource = new EventSource('https://DOMAIN.ai/testapi/events?client_secret=123');

        eventSource.onmessage = function(event) {
            const newElement = document.createElement("div");
            newElement.innerHTML = "Received event: " + event.data;
            document.getElementById("events").appendChild(newElement);

            // Close the connection when "finished" message is received
            if (event.data === "finished") {
                eventSource.close();
                console.log("Connection closed.");
            }
        };

        eventSource.onerror = function(event) {
            console.error("EventSource failed:", event);
        };
    </script>
</body>
</html>
```

vhost on the server block with 80 and 443:
```
location /api {  
        proxy_pass https://127.0.0.1:5001;  
        proxy_read_timeout 600s;   # Adjust as needed  
        proxy_connect_timeout 600s; # Adjust as needed  
        proxy_send_timeout 600s;   # Adjust as needed  
        proxy_set_header Host $host;  
        proxy_set_header X-Real-IP $remote_addr;  
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;  
        proxy_set_header X-Forwarded-Proto $scheme;  
          
        # Allows SSE by disabling Nginx's default behavior of buffering responses,   
        # which can cause issues with SSE as it expects to receive events as they   
        # are sent.  
        proxy_buffering off;  
        proxy_cache off;  
        proxy_set_header Connection '';  
        chunked_transfer_encoding off;  
        proxy_http_version 1.1;  
    }
```

Run command:
```
sudo iptables -A INPUT -p tcp --dport 5002 -j ACCEPT
python test.py
```

Visit page directly and you'll see:
Server-Sent Events
```
Received event: Message 1: The server time is: Thu Aug 22 07:08:22 2024
Received event: Message 2: The server time is: Thu Aug 22 07:08:23 2024
Received event: Message 3: The server time is: Thu Aug 22 07:08:24 2024
Received event: Message 4: The server time is: Thu Aug 22 07:08:25 2024
Received event: Message 5: The server time is: Thu Aug 22 07:08:26 2024
Received event: finished
```


---

## With video maker (but without db code)

test.py (partially):
```
# Functions defined: createVideoFromDb(caseId)

@app.route("/create/video") # SSE
def createVideo():
    caseId = request.args.get('caseId')

    def background_task(queue):
        vidCreatedInfo = None
        try:
            vidCreatedInfo = createVideoFromDb(caseId) # performVLAI
        except Exception as e:
            queue.put(f"data: error {e}\n\n")
            queue.put("data: finished_video\n\n")

        queue.put(f"data: var previewThumbnail {vidCreatedInfo['previewThumbnail']}\n\n")
        queue.put(f"data: var finalVideo {vidCreatedInfo['muxedVideo']}\n\n")
        queue.put("data: finished_video\n\n")

        return # Close SSE on the backend side

    def create_video_background():
        yield "data: processing_video\n\n"

        q = queue.Queue()
        threading.Thread(target=background_task, args=(q,)).start()

        # Wait for a message from the background task
        while True:
            msg = q.get()
            if msg is None:
                break
            print(msg)
            yield msg

    return Response(create_video_background(), mimetype='text/event-stream')
```

test.html (partial):
```
<script>
// Functions defined: getCaseId(), showVideoOnWebsite()

        var videoModel = {
          previewThumbnail: "",
          finalVideo: ""
        }

        var errored = false
        var finalVideo = ""
        var previewThumbnail = ""

        var params = new URLSearchParams({
          caseId: getCaseId()
        })

        window.eventSource = new EventSource(`https://DOMAIN.ai/media/video?${params.toString()}`);
        eventSource.onmessage = function(event) {
          
          if(event.data.indexOf('error')===0) {
            alert(event.data);
            document.querySelector("#display-error").innerHTML = event.data;
            errored = true;
            eventSource.close();
          }

          if(event.data.indexOf("var")===0) {
            var [,key,value] = event.data.split(" ");
            switch(key) {
              case "previewThumbnail":
                videoModel.previewThumbnail = value;
                break;
              case "finalVideo":
                videoModel.finalVideo = value;
                break;
            } // switch
          } // if var

          console.log(event.data);

          if (event.data.indexOf('finished_video')===1) {
              // Extract and use the video URL
                eventSource.close();
                
                if(!errored) {
                  showVideoOnWebsite(videoModel)
                } // !errored
          } // finished_video
      } // on message
</script>
```

