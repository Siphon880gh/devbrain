
**Goal:** 
We’ll enhance an app to support multiple users, and the AI should infer what data needs to be saved per user so people can log back in and pick up where they left off. 

**High level steps:**
We build this in phases: first, implement `localStorage` persistence so the app reliably saves and restores data across sessions. Next, extend that same local-only approach to support multiple users (still using `localStorage`) so it behaves like real account switching during in-person demo testing, but structure the stored data like a real database—one “table” per entity type (users, workflows, settings, etc.) instead of scattered keys. After that, create the REST API endpoints, then migrate the frontend off `localStorage` by swapping repository calls into API requests against the remote API server. To maximize the chances of success, generate spec docs up front, build a test harness/tests before implementation, and use solid design patterns (like a repository layer) so the UI stays decoupled from whichever storage backend is active in each phase.

---

Run these **prompts in sequence**:

- Analyze **who this app is for** and **how people will use it from start to finish**. Identify the key user types and map out the main user journeys they’ll follow when using the app. Then create a `specs-user-flows.md` file that clearly documents these user flows in an easy-to-understand format.
    
- Based on your understanding of the codebase and the user flows (see `specs-user-flows.md`), create a specs file that defines what data should be persisted. For example, in a todo list app, the tasks should be saved. Assume this is a single-user app, so user accounts do not need to be implemented. Document all persistence decisions in `specs-data-persistence.md`.
- Implement local storage that stores data so that they’re persistent (refer to `specs-data-persistance.md` ) to make it easy for the user using the app when they return to the app across multiple sessions.
- Implement **local storage** so my app data persists across multiple sessions (see **`specs-data-persistance.md`**on how to do it)  to make it easier for me when I come back to the app later. This is for local use only—no multi-user support needed. Keep clean separation of concerns: the **UI should not touch local storage directly**. Instead, implement a **repository pattern** that the UI talks to, and the repository is what reads/writes to local storage. Finally, create **`AGENTS-data-persistence.md`** explaining how the local storage + repository setup works.

Test the app. See if it crashes. If crashes, look into DevTools console errors. And report to Cursor with prompt:

For example:
```
Please fix app. I get error userState is not defined when opening library
```  

Also confirm that date is storing at DevTools → Applications → Local Storage

---

Next, add multiple local users keeping it local storage with this prompt:
```
Refer to AGENTS.md and any applicable AGENTS-*.md for high level understanding of the codebase if needed.  
  
"""  
Right now the app stores everything in local storage, which only works for a single user (me).  
  
I’m now doing in-person testing with real people, so users need to be able to create accounts, log in, and log out. That means local storage needs to be updated to support multiple users and keep each person’s workflows/settings separate.
  
Please:  
- Add Signup / Login / Logout in the top-right.  
- Refactor local storage to store data per user. Continue using the Repository pattern so that the UI never talks to the localstorage directly and instead talks to the Repository.  
- Keep everything local for now (no backend), but make it work like a real multi-user experience for testing.  
- We dont want local storage to be bloated with too many keys because it becomes difficult to debug. We can take inspiration from MySQL or MongoDB:  
 - Organize localStorage as a simple client-side database:  
   - One key represents a users table (accounts, credentials, user IDs).  
   - Separate keys represent other entity tables (e.g., workflows, settings), where each record is associated with a userId.  
  
Make only the exact changes requested, and don’t modify any lines that aren’t strictly necessary to complete the task. Don’t review or explore other existing features for optimizations or correctness—doing so is unnecessary and wastes tokens.  
"""  
  
Only after the implementation is complete, you should update AGENTS.md and/or the relevant AGENTS-*.md files to reflect the new state of the codebase.
```

---

  

Prompt to create test
- Replace `[PLACE_TEST_HARNESS_VERSION_HERE]` based on your tech stack. 
	- If html works:
	```
	The test harness should be a browser-based UI only, implemented as an index.html file located at test/ and accessible by visiting that path directly.
	```
	- If it’s a Vite/React app with an entry point like index.tsx:
	```
	Create a test harness that loads when the app is in test mode; otherwise, load the normal application. Add a testMode boolean flag to the config file to control this behavior.
	```

- After replacing that partial in the prompt, run the prompt:
```
Refer to AGENTS.md and any applicable AGENTS*.md for high level understanding of the codebase if needed.  
Let's implement:  
  
"""  
Add only:  
- Create a test harness UI (no CLI or automated tests) to validate data storage behavior for signup, login, and logout, as well as per-user data persistence defined in AGENTS-data-persistence when multiple users are involved.  
- [PLACE_TEST_HARNESS_VERSION_HERE]  
  
Make only the exact changes requested, and don’t modify any lines that aren’t strictly necessary to complete the task. Don’t review or explore other existing features for optimizations or correctness—doing so is unnecessary and wastes tokens.  
"""  
  
Only after the implementation is complete, you should update AGENTS.md and/or the relevant AGENTS-*.md files to reflect the new state of the codebase.
```

---

Then test out the app works at the app level. Then test the harness (either test/ or configure to be in test mode, depending on your tech stack).

While testing user creation and logging in, you should view DevTools Applications simultaneously. You should see localstorage changes in regards to multiple users.

Example test harnesses
![[Pasted image 20260119053128.png]]

![[Pasted image 20260119053136.png]]

---

Once the multiple users work locally, ask Cursor AI to update the data persistence specs with this prompt:
```
Lets update specs-data-persistence.md in regards to now having multiple users at local storage
```

---

**Then have a migrate to Mongo database plan**  

- Think ahead of where you will host the API endpoints - what tech stack is it. And what database will we use for remote persistence storage (unless you’re using JSON because it’s a small app that only you and a few handful use).
- If you dont want a single-file API implementation because you plan to add more features over time and you want the code to remain easy to navigate, remove the line `Prefer a single-file implementation. Keep as much code as possible in one file—for example, define all routes in the same file rather than splitting them into separate folders or importing multiple route files.` 
- Replace database and API server filetype as needed in the prompt. Here we have them as MongoDB and plain PHP
- Yes, **TypeScript works with PHP** when used as part of a typical web development stack. The two languages have different roles: TypeScript is used for the client-side frontend, and PHP is used for the server-side backend.
```
Refer to AGENTS.md and any applicable AGENTS-*.md for high level understanding of the codebase if needed.

Let's implement:

"""
Analyze how the app currently uses local storage to store users and any other data it needs to run. Use these as reference inputs: **AGENTS.md**, any relevant **AGENTS-*.md** files, the user flows in **specs-user-flows.md**, and the persistence plan in **specs-data-persistence.md**.

Then write migration documentation for how this data would look if it lived in **MongoDB** behind a **RESTful API** instead of local storage. The API should be implemented in **plain PHP (no framework)**. Prefer a single-file implementation. Keep as much code as possible in one file—for example, define all routes in the same file rather than splitting them into separate folders or importing multiple route files—or for example, schemas remain in the server file rather at importing files.

The doc should include:

* Data model + type definitions (collections, fields, relationships)
* API endpoints (route, method)
* Request payloads (required vs optional keys)
* Response shapes (including error responses)

Save the output as `specs-api-migration.md`. 

Make only the exact changes requested, and don’t modify any lines that aren’t strictly necessary to complete the task. Don’t review or explore other existing features for optimizations or correctness—doing so is unnecessary and wastes tokens.
"""

Only after the implementation is complete, you should update AGENTS.md and/or the relevant AGENTS-*.md files to reflect the new state of the codebase.
```

---

Implement the API with this prompt

- Adjust auth details and database name accordingly. If MySQL, adjust accordingly
- It’s important to mention the tech stack you want the API in again. One time I let it just follow the API specs that uses PHP endpoints, but it generated express js. If you want another tech stack (eg. express JS) - make sure sure adjust away plain PHP below

```
Refer to `api-migration-specifications.md` and implement the backend server file into a folder `AGENTS/`. Remember we are implementing in **plain PHP**. Make sure the server file has good error logging. Add a test endpoint to the server file that tests status of the api running and status of being able to authentiate database.  
  
This server file will act as the “source of truth” for future frontend work that connects to the remote REST API. I’ll copy this same server file to the real server later, but we also keep it in this repo as context for ongoing frontend changes.  
  
Use the following database and server configuration:  
  
* `PORT`: `process.env.PORT || 3001`  
* `MONGODB_URI`: `process.env.MONGODB_URI || "mongodb://localhost/aiorchestrate"`  
  
MongoDB credentials (via environment variables):  
  
* `MONGODB_USERNAME="admin"`  
* `MONGODB_PASSWORD="password"`  
  
Add a `.env` file for local development, and also include a `.env.sample` that documents the required variables.  
  
In addition, create a database seed script in the same language as the server file that populates the database with test users so we can quickly fill the database for testing.
```

Note if you’re using PHP, make sure the api.php has this:
```
// Composer autoload (mongodb/mongodb library provides MongoDB\Client)
$autoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($autoload)) {
    require $autoload;
}
```

Otherwise you get some error like "Class \"MongoDB\\Client\" not found”
![[Pasted image 20260120223850.png]]

The php mongodb expects some sort of composer plugin at your php file… so you have to composer init and composer require mongodb/mongodb:^2.1. You have to make sure the CLI php and the web php matches otherwise composer doesn't quite run even though you're in the app's folder. 

Php version for web you can adjust at cloudpanel or equivalent. CLI php you can set with `sudo update-alternatives --set php /usr/bin/php8.1`  which will make sure your composer command is compatible with your php.
Eg. CloudPanel (website hosting cpanel)
![[Pasted image 20260120224047.png]]

Upload to your server. Then run the test endpoint. AI could have rendered it as `/health` , or `/status` , or `/test` 

If fails to run test endpoint, try to resolve it in cursor by copying the error, even if it’s a vague error like Internal server error. Errors could be for example “MongoDB PHP extension not installed” which you install with `pecl install mongodb` (making sure your cli’s php is the same php as the web’s!). For cli, that’d be setting with `sudo update-alternatives -set php /usr/bin/php8.1` , and for web, you could go through your panel like cloudpanel to select the php version.

Connect to your database on compass. Run the seed script and see if the database gets filled. If fails, you may have to install php-mongodb at a system level, but you have to install it for your particular php version (there may be several php versions!)

---

NOT USING PLAIN PHP for API server?

If it were Express JS and you use the pm2 ecosystem (multiple nodejs apps running on VPS) with Makefile (easier to manage at cli):

/ create a simple api express server that [ Also → OBS standalone || Also → this OBS ]

- Just says hi as a response
```
// Routes  
app.get('/', (req, res) => {  
  res.send('hi');  
});
```


- test it works localhost
- eco vhost base url with reverse proxies
	- find the next available express port, searching 3001, 3002, 3003… 
	- Duplicate code block like 
	    /app/note-taking[/]* 
	    → /app/new-app[/]* 
	- proxy_pass it to the next port number, eg 3007
- ecosystem.config.js
	- Searching up the final port that was defined, eg 3006. Then duplicate to a new port 3007, and adjust the app name and file path, eg. 
	    name: 'note-taking:3006', → name: ‘new-app:3007’
	- The cwd at ecosystem.config.js is where you will copy the server.js, .env and package.json files, and run npm install
- ssh
	- go into the app folder and then run `npm install` . do not start express here
	- go to where your ecosystem.config.js and run `make restart` or whatever command is applicable in the Makefile that manages ecosystem.config.js
	- Restart `sudo service nginx reload` 
- web browser test
	- See that your ‘hi’ returned
- Once passed, you can generate the full express server.js etc and copy it over to the online folder (or use git clone or git pull etc). Dont forget npm install in case the more full server uses other dependencies (like for json web token) and make sure .env file is good.

Prepare the api further more

Going into ssh, you have express.js running. lets run the seed and you’ll see any node compatibility issue or other issue
Eg. If it complains of `??==` , you prompt cursor:  
It is complaining of `??==` . Please rewrite the code so that I dont have to update the Node JS version

---

Back to generating front end code, let’s run through two passes to create the frontend connection to the remote api

- At `{..if typescript-react-vite}` , you can replace with `Let’s make the config flag load the test-api/ harness rather than the test/ harness` . Otherwise remove it.
- Adjust the base url below including the walkthrough of how the base url is resolved into an api call

```
Refer to AGENTS.md and any applicable AGENTS-*.md for high level understanding of the codebase if needed.  
Let's implement:  
"""  
Let's create another version of the current test harness ui at `test-api/`. It will perform the same multiple user test as the test harness ui at `test/` except it connects to the remote api endpoint instead of using localstorage. Recall that the repository pattern is where the ui makes contact. The ui contact will never make direct contact to the local storage or the api. The remote api server handles the data storage in a database.  
  
{..if typescript-react-vite}  
  
You can see an exact copy of the remote api server endpoint implementations inside the folder `AGENTS/`. From the implementations, you can figure out the request payloads and response formats.   
  
You should also know that the base API URL is: https://wengindustries.com/backend/dailytimepoints/.  
  
So if a designed endpoint is api/foobar/, then the full api url evaluated would be: https://wengindustries.com/api/dailytimepoints/api.php?action=/api/foobar/  
  
Then you should be able to figure out the exact api calls including their methods, their urls, and their payloads, and how to handle the response.  
Make only the exact changes requested, and don’t modify any lines that aren’t strictly necessary to complete the task. Don’t review or explore other existing features for optimizations or correctness—doing so is unnecessary and wastes tokens.  
"""  
  
Only after the implementation is complete, you should update AGENTS.md and/or the relevant AGENTS-*.md files to reflect the new state of the codebase.
```

---

Then test out the app works at the app level. Then test the remote version harness (either test-api/ or configure to be in test mode, depending on your tech stack).

While testing user creation and logging in, you should view the Mongo database simultaneously, perhaps using an app like Compass - or whichever database you use (MySQL, etc). You should see changes in regards to multiple users. For example, after signing up User A:
![[Pasted image 20260119054355.png]]

![[Pasted image 20260119054403.png]]

---

We are testing if the remote harness test-api/ has errors

Look into console log for errors
- If using Cursor, then you’re testing in DevTools console
- If Google AI Studio for frontend generation, you open the studio’s console
![[Pasted image 20260119054427.png]]

Tell the AI the errors that shows up in console

For example, a “No token provided”. You could prompt:
```
Have the error "No token provided". Why even need a token when not logged in?
```

Once no more errors, you’re good to do the next step

---
  
Next step - Frontend connects to API calls

Since the API calls have passed at the test harness, let’s actually implement it for the app.

Use this prompt:
```
Based on how the frontend already connects to the remote API in test-api/, update the app to replace local storage–based persistence with API calls. This should be done by updating the Repository layer, so the UI continues to work the same way and never talks to the API directly.
```

Now try out the app. See if it affects the Mongo database in compass (or whichever database you use)

---

Update AGENTS/server.js whenever needed.

Some recommended next steps:
- enhance auth system to remember password, use json web token, to remember password
- enhance auth system to be able to reset password (may initially without emailing system)
- fingerprint device saved to database x1 month use OR free trial use
- credit system (eg. 30 credits a month, resets when, doesn't reset if late bill)