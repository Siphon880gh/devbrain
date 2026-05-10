
Let's say you want to present a different version of the website to a specific bot:

```
location / {
    if ($http_user_agent != "SOME BOT NAME") {
        return 403;
    }

    proxy_pass http://127.0.0.1:3000;
}
```
^ Syntax: Header names become lowercase and hyphens become underscore lines, and we prefix with $http
^ In this example, we have an ecosystem.config.js keeping a NextJS app always on at port 3000