


For different environments you can have your local machine store DEVELOP in the env variable and the remote machine store PRODUCTION. You can have this easily done if you have them in package.json scripts, and you make sure to run the script at your respective machines (Npm start doesn't need to only start node apps. You can start Python scripts and/or run commands)

You can have two different build scripts based on DEVELOP or PRODUCTION.

---

You can have supervisor that monitors itself needing to restart and it can run the appropriate .sh file based on DEVELOP or PRODUCTION to run commands (make sure its paths are absolute paths and remember your bash_profile PATH doesn’t carry over to the .sh context)

---

Or you can keep things simple

Local:
npm run dev
npm run build-dev

Remote:
npm run build
npm run start


---

An example use is different javascript and express PORT based on :

```
  "scripts": {
    "start": "python server.py",
    "dev": "python server.py",
    "build-prod": "cp run/template-prod.py run/env.py; echo 'var finalHost = \"https://wengindustry.com:5002\"' > assets/common.js;",
    "build-dev": "cp run/template-dev.py run/env.py; echo 'var finalHost = \"http://127.0.0.1:5001\"; var guestPassword = \"guest123\";' > assets/common.js;",
    "seed": "python seed.py",
    "test": "python tests/docker.py"
  },
```

---

If you find paths change for your dependencies between your local machine and remote server, you can create sh file then you run on the online server, and another sh file that you run on your local development environment whenever you're migrated files. That sh file can change the preceding file path as an environment variable or various other ways you can do it.

If your primary way of migrating files are git pushes and git pulls, you can setup to automatically run the sh file right after a pull