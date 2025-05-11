For features like pushing/deploying repo to Heroku, you have to authenticate your shell session with `heroku login` 

It'll ask you to press any key other than q, and then it can open the login webpage in your web browser. If it doesn't open the web browser, just copy and paste the url that the terminal provided into a web browser.

---

And if `heroku login` command doesn't work because the command doesn't exist, you'd have to install heroku

**On macOS:**

`brew tap heroku/brew && brew install heroku`

**On Ubuntu/Debian:**

`curl https://cli-assets.heroku.com/install.sh | sh`

**On Windows:**  
Download the installer from: https://devcenter.heroku.com/articles/heroku-cli