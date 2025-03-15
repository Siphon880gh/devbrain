Aka Get Started

By Weng

1. Decide if you want Firebase or Firestore: [[Firebase vs Firestore]]. This tutorial is for firebase.

2. Setup owners in your team by email invitations:
   Settings (Gear icon) -> Users and permission
   
   You can do this now or later.

3. Add your app
   Project Overview (Home icon) -> Get started by adding Firebase to your app -> Select Platform. 
   
   Name your app and follow instructions on adding the Firebase SDK.

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
>  apiKey: "AIzaSyDZw6OtSZIzRztMVm6XvEgGK3czz133I3M",
>  authDomain: "mixoreact.firebaseapp.com",
>  projectId: "mixoreact",
>  storageBucket: "mixoreact.appspot.com",
>  messagingSenderId: "110980428490",
>  appId: "1:110980428490:web:8280bfeec1fdff8dbcba33",
>  measurementId: "G-S44MT5P2Q5"
> };
> 
> // Initialize Firebase
> const app = initializeApp(firebaseConfig);
> const analytics = getAnalytics(app);
> ```


4. Choose Firestore:
   All products (grid icon) -> Cloud Firestore -> Create Database
   When asked on Security Rules, choose "Start in test mode", which will give you these security rules:
   
```
{
  "rules": {
    ".read": "now < 1728630000000",  // 2024-10-11
    ".write": "now < 1728630000000",  // 2024-10-11
  }
}
```

	These timestamps are calculated to be 30 days ahead. After those dates, your data is inaccessible (neither read or write)
	
We will change these rules soon.

---

Decide on security rules and setup security rules (otherwise Google will keep emailing you about your security rules being too laxed)