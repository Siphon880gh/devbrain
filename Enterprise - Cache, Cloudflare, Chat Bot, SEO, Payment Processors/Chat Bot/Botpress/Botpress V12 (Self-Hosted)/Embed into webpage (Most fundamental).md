
Lets test this locally first.

Lets say you manage the chat flow / bot at port 3000
![[Pasted image 20250517023729.png]]

The inject script will come from this same port:
```
<script src="http://localhost:3000/assets/modules/channel-web/inject.js"></script>
```

The sdk to inject into a div is initiated with this:
```
    <script>
        window.botpressWebChat.init({
        host: 'http://localhost:3000',     // URL where Botpress is running
        botId: 'test',                       // Your bot's ID (name or ID from Botpress)
        hideWidget: false                       // (Optional) false = show chat icon widget
        // You can add more configuration options here (see below)
        }, '#chat-anchor');
    </script>
```

Notice there's a `#chat-anchor`. That adds the button that opens chat:
![[Pasted image 20250517023928.png]]


If you hadn't included a target, it would just attach to document.body:
```
    <script>
        window.botpressWebChat.init({
        host: 'http://localhost:3000',     // URL where Botpress is running
        botId: 'test',                       // Your bot's ID (name or ID from Botpress)
        hideWidget: false                       // (Optional) false = show chat icon widget
        // You can add more configuration options here (see below)
        });
    </script>
```

However, it won't matter. The button CSS actually position it fixed to the bottom right.

Make sure this script is ran AFTER body is done loading most elements, therefore you should place this script near end of body tag.

The next fundamental is the botID. You can find this at
- Firstly, by pressing Config button on your bot, to reach its Config page:
  ![[Pasted image 20250517024251.png]]
- Then at Config page, you'll see the bot id:
  ![[Pasted image 20250517024306.png]]


----

The boilerplate is:
```
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <head>
        <!-- 1. Include the Botpress webchat script from your Botpress server -->
        <script src="http://localhost:3000/assets/modules/channel-web/inject.js"></script>
    </head>
</head>
<body>

  <div id="chat-anchor"></div>
    
    <!-- 2. Initialize the chat widget with host and bot ID -->
    <script>
        window.botpressWebChat.init({
        host: 'http://localhost:3000',     // URL where Botpress is running
        botId: 'test',                       // Your bot's ID (name or ID from Botpress)
        hideWidget: false                       // (Optional) false = show chat icon widget
        // You can add more configuration options here (see below)
        });
    </script>
</body>
</html>
```

Just open the page in a http server on local server (like MAMP)

---

Once satisfied, you may want to move to trying this on a production server. Note you should run this behind a reverse proxy with https, so that web browsers will allow your chatbot through.