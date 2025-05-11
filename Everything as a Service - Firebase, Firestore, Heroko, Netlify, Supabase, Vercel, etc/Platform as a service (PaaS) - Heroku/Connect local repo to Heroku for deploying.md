
The command is:
```
git remote add heroku https://git.heroku.com/your-app-name.git
```

An alternate command is:
```
heroku git:remote -a your-app-name
```

Then you can push/deploy with:
```
git push heroku main
```

---

But you have to have authenticated your shell session with `heroku login` (it'll ask you to press any key other than q, and then it can open the login webpage in your web browser). 
- If it doesn't open the web browser, just copy and paste the url that the terminal provided into a web browser.

---

And if `heroku login` command doesn't work because the command doesn't exist, you'd have to install heroku

**On macOS:**
```
brew tap heroku/brew && brew install heroku
```

**On Ubuntu/Debian:**
```
curl https://cli-assets.heroku.com/install.sh | sh
```

**On Windows:**  
Download the installer from: https://devcenter.heroku.com/articles/heroku-clis/heroku-cli