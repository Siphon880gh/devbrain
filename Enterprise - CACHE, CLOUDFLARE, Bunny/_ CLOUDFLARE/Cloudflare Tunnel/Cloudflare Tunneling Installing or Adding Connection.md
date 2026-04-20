Cloudflare Tunnel is designed to expose an app running locally on your server without opening extra public inbound ports. That is useful because Cloudflare does not proxy arbitrary custom ports such as 5000 or 5001 the way many people expect.

Instead of sending traffic directly to those ports, the `cloudflared` daemon creates outbound-only connections from your server to Cloudflare. Your app is then reached through Cloudflare, usually on a subdomain, without exposing the actual port to the public internet.

This is helpful when you have multiple apps running on ports like 5000, 5001, and so on, but do not want to disable Cloudflare and do not want to set up a traditional reverse proxy at the vhost level.

In that case, Cloudflare Tunnel is often a good fit. It has a free tier, but setup can be a little confusing the first time.

---

There are a few requirements which are not well documented and are not obvious until you run into problems.

The requirements:
- Use subdomain (Path will be more problematic than they need to be)
- Do NOT add a DNS record for the subdomain
- Do NOT wildcard your SSL certificate to that subdomain
- Cloudflare will handle the automatic DNS and SSL of your subdomain. If you try to do it for them, there will be problems like SSL handshake errors  
    
- Your app must run locally if it exposes network connection (eg. Flask `app.run(debug=True)` )
	```
	if __name__ == "__main__":
	    app.run(debug=True)
	    # app.run(host="0.0.0.0", port=5000, debug=True)
	```

- Test like with:
	- Adjust your MySQL username and password
	```
	from flask import Flask, jsonify
	from flask_mysqldb import MySQL
	
	app = Flask(__name__)
	
	app.config["MYSQL_HOST"] = "127.0.0.1"
	app.config["MYSQL_USER"] = "root"
	app.config["MYSQL_PASSWORD"] = "PASSWORD"
	app.config["MYSQL_DB"] = "mysql"
	app.config["MYSQL_PORT"] = 3306
	app.config["MYSQL_CURSORCLASS"] = "DictCursor"
	
	mysql = MySQL(app)
	
	@app.route("/")
	def users():
	    cur = None
	    try:
	        cur = mysql.connection.cursor()
	        cur.execute("SELECT * FROM user")
	        rows = cur.fetchall()
	
	        for row in rows:
	            for key, value in row.items():
	                if isinstance(value, bytes):
	                    row[key] = value.decode("utf-8", errors="replace")
	
	        return jsonify(rows)
	    except Exception as e:
	        return jsonify({"error": str(e)}), 500
	    finally:
	        if cur:
	            cur.close()
	
	if __name__ == "__main__":
		# app.run(debug=True)
	    app.run(host="0.0.0.0", port=5000, debug=False)
	```

---

Here's how to setup a tunnel on Cloudflare's dashboard:

1. At Cloudflare, find to open Tunnels here (after your domain selected):
   ![[Pasted image 20260415061953.png]]

2. Give your tunnel a new name:
   ![[Pasted image 20260415062020.png]]

3. Add a route under Routes
   ![[Pasted image 20260415062043.png]]

4. For our case of Python/Flask/NodeJS/Express app at a custom port, we choose:
   ![[Pasted image 20260415062110.png]]

5. Here we have a hypothetical coder notes app in Flask (port 5000):
   ![[Pasted image 20260415062151.png]]

^ Note worthy, service URL is to the http localhost at the app's port. We chose subdomain rather than path (can be more problematic than it needs to be).

After it's finalized, it'll show that a CNAME is automatically created for you too:
![[Pasted image 20260420064330.png]]

For example if you have an express server.js running on the server side like:
```
const express = require('express');
const app = express();
const PORT = 3000;

// Root route
app.get('/', (req, res) => {
  res.send('Express works');
});

// Start server
app.listen(PORT, () => {
  console.log(`Server running on http://localhost:${PORT}`);
});
```

As a quick test, I run it in foreground at a ssh
![[Pasted image 20260420064652.png]]

When I created the tunnel, I used address `http://localhost:3000`

Then going to `https://codernotes.wengindustries.com` would have shown:
![[Pasted image 20260420064057.png]]

---

Hold up!

First time? It may complain it can’t connect
![[Pasted image 20260415062248.png]]

**To find out which architecture refer to [[Fundamental - Stats - What architecture I'm on]]**

**And make sure to install via all the commands, not just the first command. Either run the second command (recommended) or third command (more performant long run on the server when yo ushut down a temporary test rather than having a permanent or multiples)**

Continued failure to set this up could show:
![[Pasted image 20260415062324.png]]
Or shows:
![[Pasted image 20260415062354.png]]

---

Double check it works from the server's SSH terminal

Run:
```
cloudflared tunnel list
```

It should show something like:
```
ID                                   NAME CREATED              CONNECTIONS      
xxx-xx-xx-xx-xxxx Test 2026-04-14T21:45:46Z 2xxxxxx, 2xxxxxx 
```

If instead it shows:
```

2026-04-20T09:28:18Z ERR Cannot determine default origin certificate path. No file cert.pem in [~/.cloudflared ~/.cloudflare-warp ~/cloudflare-warp /etc/cloudflared /usr/local/etc/cloudflared]. You need to specify the origin certificate path by specifying the origincert option in the configuration file, or set TUNNEL_ORIGIN_CERT environment variable originCertPath=
Error locating origin cert: client didn't specify origincert path
```

Then run:
```
cloudflared tunnel login
```

It will try to open a web browser page which will probably fail since we're doing SSH. In that case it gives you a URL at the SSH terminal to copy and paste to your own web browser. 

Click the domain that applies to the tunnel:
![[Pasted image 20260420061354.png]]

->
![[Pasted image 20260420063127.png]]

->
![[Pasted image 20260420063142.png]]

Then you can double check again by running:
```
cloudflared tunnel list
```