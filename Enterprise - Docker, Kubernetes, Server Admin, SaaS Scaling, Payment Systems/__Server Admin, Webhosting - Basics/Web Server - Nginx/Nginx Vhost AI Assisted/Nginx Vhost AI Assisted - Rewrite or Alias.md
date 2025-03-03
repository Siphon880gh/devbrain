Quick review of rewrite and alias if needed: [[Nginx Vhost Fundamental - Redirect vs Rewrite vs Alias]]

AI Prompt to get rewrite or alias:
```
/home/wengindustries/htdocs/wengindustries.com/app/workout-player/ has a create-react-app where I run `npm run build` creates a folder at /home/wengindustries/htdocs/wengindustries.com/app/workout-player/build/ and that build folder has index.html

Visiting wengindustries.c/ serves document root at /home/wengindustries/htdocs/wengindustries.com/ which opens index.html at document root

I want users to see the build/ folder’s index.html when they visit [https://wengindustries.com/app-workout-player](https://wengindustries.com/app-workout-player) or [https://wengindustries.com/app-workout-player](https://wengindustries.com/app-workout-player)/ so the trailing slash is optional

Help me write the location block for vhost. I am guessing we will have regular expression to make the trailing slash optional. Please pass any arguments or url query into the build url. Let’s rewrite internally or use alias rather than redirect because I want to hide the build/ url.
```