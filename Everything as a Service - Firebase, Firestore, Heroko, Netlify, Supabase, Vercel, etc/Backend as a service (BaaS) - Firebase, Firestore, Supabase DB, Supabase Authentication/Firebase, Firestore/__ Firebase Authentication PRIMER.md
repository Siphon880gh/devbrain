Aka: Get Started
## Guide

### Fundamentals:
- Frontend users are from All Products -> Authentication. Can be modified with code.
- App authentication is from API key or service account of a Console project owner user (Settings -> Users and permissions)

### Have Users
Required steps:

You have added project users at: Settings (Gear icon) -> Users and permissions
- **More info**: This allows them to access your Console. You can also use one of these App Project users to create a service account to authenticate the app in the backend (this is different from authenticating the frontend user that signs into your app, if you choose to have user accounts for your app). But for authenticating the app, you could alternately (and less steps) to just use the firebaseConfig object that the "Get Started" wizard generated for you that precludes an app API key.
- https://console.firebase.google.com/u/3/project/****/settings/iam

You might need frontend user sign-in ability: 
- All products (grid icon) -> Authentication -> Get Started -> Add an appropriate sign-in provider
	- eg. Email/password (if your frontend will sign up / login that way)
	- https://console.firebase.google.com/u/3/project/****/authentication/users
- **Why might need:** If your app doesnt require user login for your customers, you have two options:
	- You can authenticate the **app itself** without authenticating users and still be able to modify documents in **Firebase Firestore** or other Firebase services. There is just no uid (user id) that comes from frontend users that you can compare to documents that stored the uid.
	- You can choose to still authenticate a user and you'll add this single master user account at All Products -> Authentication -> Users. Then authenticate the master user on the backend instead of the frontend because your tech savvy customers don't need to see it. This is having one foot in the door in case you will scale up the app to have users in the future

You have added frontend user: 
- All products (grid icon) -> Authentication -> Users -> Add user
- OR: Your code has added an user and their role (owner, editor, viewer, or assign firebase roles of "firebase",analytics/develop/quality/grow)

Firebase Roles:
- "Firebase": All products
- Analytics: Analytics only
- Develop: Analytics + Database + Auth + Storage...
- Quality: Analytics + Crashlytics, Performance...
- Grow: Analytics + Messaging, Remote Config...
- MORE INFO https://firebase.google.com/docs/projects/iam/roles-predefined

### Authorization Process (Email/password method)
1. User signs in on the frontend or creates an user on the frontend. This gives you the strings of email and password. 
	- You may additionally have logic to encrypt/decrypt password so you don't store to Firebase the plain password. 
2. You send these two strings to the backend and a way to track if you want login user or create user.
3. On the backend, you have "firebase/auth" which comes from the "firebase" npm package. It prepares the code by authenticating your app either through the firebaseConfig object that the "Get Started wizard generated that precludes your app api key or it can authenticate your app through a service account generated from a project owner at the Console (Settings -> Users and permissions, NOT the product Firebase Authentication):
```
// Your web app's Firebase configuration  
// For Firebase JS SDK v7.20.0 and later, measurementId is optional  
const firebaseConfig = {  
  apiKey: "******",  
  authDomain: "****.firebaseapp.com",  
  projectId: "___",  
  storageBucket: "___.appspot.com",  
  messagingSenderId: "___",  
  appId: "1:******:web:*****",  
  measurementId: "G-******"  
};  

const app = initializeApp(firebaseConfig);  
const auth = getAuth(app); // Initialize Firebase Auth  
const db = getFirestore(app); // Initialize Firestore
```

The auth is important for managing the frontend users. Both creating and logging in frontend users require the auth. The db is important for modifying collection data (Firebase classic Realtime Database or Cloud Firestore). Note that the above generated code from Console is an overkill (has storage, messaging, and analytics, in addition to database) - we will trim down later at [[__ Firestore PRIMER]].
4. Then the app can authenticate your frontend user for logging in or creating. Your two strings email and password AND the auth object from authenticating the app are passed into:
	- createUserWithEmailAndPassword
	- signInWithEmailAndPassword
5. You may modify documents and collections depending on the security rules you've set for the corresponding Firebase or Firestore database. You import the methods and objects from the appropriate Firebase or Firestore package. Because you have authenticated the app AND have authenticated the user, when you authenticated the user, the auth object has been updated to reflect the authenticated user as well. Then subsequent collection or document modifications and reading becomes possible, up to and limited by your Security Rules.
6. The full code for app authentication and frontend user sign in are at [[__ Firestore PRIMER]]

### Decide if separating the processes

Authenticating the app and authenticating the user can happen in two separate processes if you want to have a microservice only for database related work and another microservice for only authenticating the user. To keep that more simplified, you can have authenticating users done on the frontend (Yes the "firebase" package that includes "firebase/auth" can be on React import side). However to mitigate hackers, you have to get an ID Token from the authenticating user then pass the ID token to the backend where the app is authenticated. All operations on the backend would verify the ID token before performing operations (reads and writes). 

Because of vulnerabilities, then Firebase enforces the ID token to expire every hour, with a refresh token to refresh the ID token for continued access to operations. This happens in the background and you can get the most current ID token at anytime with `await user.getIdToken()`

**Reworded**: You can separate into multiple microservices in the form of either: a.) two backend microservices, or b.) having frontend authenticate user and backend authenticate the app (which requires ID Token verification)

FYI, technically both the frontend user authentication AND the app authentication (either through app api key or project owner service account) can be on the frontend but that's strongly advised against, because abusers will tax your free quota or on the paid Blaze plan, overcharge you.

### Decide if using ID token and/or uid

When the frontend user is authenticated with log in or with creating user, the user object returned from either method includes the uid and gives you a way to get the ID Token:
```
const userCredential = await signInWithEmailAndPassword(auth, email, password); // or createUserWithEmailAndPassword
const user = userCredential.user;

const uid = user.uid;
const idToken = await user.getIdToken(); // Ask Firebase to sign and give you a token
```

#### When to use ID Token:
You do if you separated the processes. Refer to previous section.

#### When to use uid:
If you have stricter Security rules ([[Firebase, Firestore Security Rules]]), you may be allowing document access (reading or writing) only when the uid of the authenticated user matches the uid of a document. If you allow all access for any authenticated user, then you don't need the uid.

For your convenience, listed are such security rules

Firebase:
```
{
  "rules": {
    "users": {
      "$uid": {
        ".read": "$uid === auth.uid",
        ".write": "$uid === auth.uid"
      }
    }
  }
}
```

Firestore:
```
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    match /users/{userId} {
      allow read, write: if request.auth != null && request.auth.uid == userId;
    }
  }
}
```

## Optional: What is firebase-admin

In most cases you do NOT need firebase-admin. That is used to manage project owners and even more. This is why it's called admin, a hint to the Admin Console (Dashboard). You would need to npm install:
```
npm install firebase firebase-admin
```