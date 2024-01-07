


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