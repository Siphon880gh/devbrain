Aka Get Started
By Weng

## Team Alignment

1. Decide if you want Firebase or Firestore: [[Firebase vs Firestore]]. This tutorial is for FIRESTORE, the more user friendly and more real-time database.

2. Setup owners in your team by email invitations:
   Settings (Gear icon) -> Users and permission
   
   You can do this now or later.

3. Know if you will follow free plan or paid plan
	- Spark: Free with limits
	- Blaze: Pay as you go. You will have to enable Billing by adding billing details.
	
   You could choose free for now

---

## Console

1. Add your app project (This is your app entity that Google recognizes)
   Project Overview (Home icon) -> Get started by adding Firestore to your app -> Select Platform. 
   
   Name your app and follow instructions on adding the Firestore SDK.

> [!note] If for example npm, but you should follow their latest instructions
> Install with: `npm install firebase`
> 
> Script:
> ````
> // Import the functions you need from the SDKs you need
> import { initializeApp } from "firebase/app";
> import { getAnalytics } from "firebase/analytics";
> // TODO: Add SDKs for Firebase products that you want to use
> // https://firebase.google.com/docs/web/setup#available-libraries
> 
> // Your web app's Firebase configuration
> // For Firebase JS SDK v7.20.0 and later, measurementId is optional
> const firebaseConfig = {
>  apiKey: "******",
>  authDomain: "****.firebaseapp.com",
>  projectId: "___",
>  storageBucket: "___.appspot.com",
>  messagingSenderId: "___",
>  appId: "1:******:web:*****",
>  measurementId: "G-******"
> };
> 
> // Initialize Firebase
> const app = initializeApp(firebaseConfig);
> const analytics = getAnalytics(app);
> ```

2. Unfortunately their instructions are not complete. Install all the npm dependencies you will need with:
```
npm install firebase @firebase/firestore @grpc/grpc-js
```
Explanation: Firebase's classic Realtime Database uses websocket as its transport protocol, whereas Cloud Firestore uses grpc as its transport protocol.  Firebase package includes "firebase/auth" for the  authentication of the app AND the authentication of the frontend user (either login or creating user). 

4. Create Firestore:
   All products (grid icon) -> Cloud Firestore -> Create Database
   When asked on Security Rules, choose "Start in test mode", which will give you these security rules:

Firestore security rules:
```
rules_version = '2';

service cloud.firestore {
  match /databases/{database}/documents {
    match /{document=**} {
      allow read, write: if
          request.time < timestamp.date(2024, 10, 11);
    }
  }
}
```

These timestamps are calculated to be 30 days ahead. After those dates, your data is inaccessible (neither read or write)
	
We will change these rules later.

5. Learn collections
A database has collections. A collection has documents. As an analogy to MySQL, collection is table, and a document is a row

Decide if you want to create a collection
- Optional: You could click "Start collection" on the left, and create a "users" collection or desired collection. 
- Why optional: If a collection doesn't exist when code adds a document to that collections path, it'll automatically create the collection. So this is all personal preference (you might want to see the collections at the Console dashboard because it helps you)
  
![](Z0BewEm.png)


6. Refer to [[__ Firebase Authentication PRIMER]] that includes creating required users at the Console (dashboard), authenticating the app, and authenticating frontend users. If your app doesnt require user login for your customers, you have two options:
	- You can authenticate the **app itself** without authenticating users and still be able to modify documents in **Firebase Firestore** or other Firebase services. There is just no uid (user id) that comes from frontend users that you can compare to documents that stored the uid.
	- You can choose to still authenticate a user and you'll add this single master user account at All Products -> Authentication -> Users. Then authenticate the master user on the backend instead of the frontend because your tech savvy customers don't need to see it. This is having one foot in the door in case you will scale up the app to have users in the future
	
	7 . For now we can test that the app authentication and frontend user sign in works by placing them all in a backend call. Later you can decide if you will keep all in backend or separate into multiple microservices in the form of either: a.) two backend microservices, or b.) having frontend authenticate user and backend authenticate the app (which requires ID Token verification)
```
// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
import { getAuth } from "firebase/auth";
import { createUserWithEmailAndPassword } from "firebase/auth";
import { signInWithEmailAndPassword } from "firebase/auth"
import { getFirestore, doc, setDoc } from "firebase/firestore";

import dotenv from "dotenv/config"
// console.log(process.env)
const {API_KEY, AUTH_DOMAIN, PROJECT_ID, APP_ID, MASTER_EMAIL, MASTER_PASSWORD} = process.env

// Your web app's Firebase configuration
// For Firebase JS SDK v7.20.0 and later, measurementId is optional
const firebaseConfig = {
  apiKey:API_KEY,
  authDomain:AUTH_DOMAIN,
  projectId:PROJECT_ID,
  appId:APP_ID
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const auth = getAuth(app); // Initialize Firebase Auth
const db = getFirestore(app); // Initialize Firestore

// Function to create a user and add their data to Firestore
const createUserAndSaveToFirestore = async (auth, db, email, password) => {
  try {
    // Create a new user with the provided email and password
    const userCredential = await createUserWithEmailAndPassword(auth, email, password);
    const user = userCredential.user;

    console.log("User created with UID:", user.uid);

    // Add the user document to Firestore using the user's UID
    await setDoc(doc(db, "users", user.uid), {
      email: user.email,
      createdAt: new Date().toISOString()
    });

    console.log("User document created in Firestore");
  } catch (error) {
    console.error("Error creating user or saving to Firestore:", error);
  }
};

// Function to log in with email and password
const loginWithEmailAndPassword = async (auth, email, password) => {
  try {
    const userCredential = await signInWithEmailAndPassword(auth, email, password);
    const user = userCredential.user;

    console.log("User logged in successfully with Firebase Authentication uid:", user.uid);
  
  } catch (error) {
    console.error("Error with logging in or with callback:", error);
  }
};

// Note to toggle the comments on and off for either Logging in or Creating the user:

// Login with email and password
const email = MASTER_EMAIL;
const password = MASTER_PASSWORD;
loginWithEmailAndPassword(auth, email, password);

// Create the user and save to Firestore
// const email = MASTER_EMAIL;
// const password = MASTER_PASSWORD;
// createUserAndSaveToFirestore(auth, db, email, password);
```

Note to toggle the comments on and off for either Logging in or Creating the user

8. Next step is evaluate your app's requirements and adjust the code. 
	- This sample code uses ES6 (package.json: "type":"module"). If refactoring this sample code into a full project that is NOT using ES6, for your convenience:
	```
	// Require the functions you need from the SDKs you need
	const { initializeApp } = require("firebase/app");
	const { getAuth, createUserWithEmailAndPassword, signInWithEmailAndPassword } = require("firebase/auth");
	const { getFirestore, doc, setDoc } = require("firebase/firestore");
	const dotenv = require("dotenv");
	
	// Load environment variables
	dotenv.config();
	
	// Destructure environment variables
	const { API_KEY, AUTH_DOMAIN, PROJECT_ID, APP_ID, MASTER_EMAIL, MASTER_PASSWORD } = process.env;
	```

	- You may consider breaking the code apart into backend and frontend, or keep them both backend. This was discussed in [[__ Firebase Authentication PRIMER]] under section "Decide if separating the processes"
	- Add database modification methods. You import methods from the firebase package or firestore package depending on which database you are using. Their documentations are at:
		- Reference for Firebase classic Realtime Database: https://firebase.google.com/docs/database/admin/save-data
		- Reference Cloud Firestore: https://firebase.google.com/docs/firestore/manage-data/add-data
		- The above references are for saving/adding data. In the same menu will be for retrieval and deleting data.
	- You may consider in express routes to refactor the code into middleware.

10. Finish setting up the security rules once you're done with Firestore at [[Firebase, Firestore Security Rules]]] using either 2nd most secured rules or 1st most secured rules.