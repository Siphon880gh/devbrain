
**Keep in mind there are two syntaxes for two services**

Firebase rules:
```
{
  "rules": {
    ".read": "now < 1728630000000",  // 2024-10-11
    ".write": "now < 1728630000000",  // 2024-10-11
  }
}
```


FireSTORE rules:
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


The syntax is a bit different. This is because the two examples are for different Firebase services: **Firestore** and **Realtime Database** (aka the original Firebase). Each service has its own format and way of defining security rules, although they serve the same purpose of controlling access to your data.

Firestore rules include a `rules_version = '2';` line at the top, which specifies the version of the Firestore security rules. Firestore rules are written using a language similar to a combination of SQL and JavaScript.

Real Time Database rules are written in JSON format and may have paths.

---


Lock Mode when creating a firebase/firestore at the Console and chosen Lock Mode

Firebase:
```
{
  "rules": {
    ".read": false,
    ".write": false
  }
}
```

FireSTORE:
```
rules_version = '2';

service cloud.firestore {
  match /databases/{database}/documents {
    match /{document=**} {
      allow read, write: if false;
    }
  }
}
```

Neither reading nor writing to the database is possible. The intention is that your app is you will adjust the security rules very soon after you finish the process of initializing a firebase in the Console


---


Test Mode when creating a firebase/firestore at the Console and chosen Test Mode

Firebase:
```
{
  "rules": {
    ".read": "now < 1728630000000",  // 2024-10-11
    ".write": "now < 1728630000000",  // 2024-10-11
  }
}
```

FireSTORE:
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

These timestamps are calculated to be 30 days ahead. After those dates, your data is inaccessible (neither read or write). The intention is that your app is not public yet and that within 30 days you'll be done working on the database structure and logic, so you will adjust the security rules for public use

---

Read for everyone regardless if logged in, but not writable for anyone

Firebase:
```
{
  "rules": {
    ".read": true,
    ".write": false
  }
}
```

FireSTORE:
```
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    match /{document=**} {
      allow read: if true;
      allow write: if false;
    }
  }
}
```


---

2nd highest security - Allow only authenticated users to read and write data (Settings (Gear icon) -> Users and permission):

Firebase:
```
{
  "rules": {
    ".read": "auth != null",
    ".write": "auth != null"
  }
}
```

FireSTORE:
```
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    match /{document=**} {
      allow read, write: if request.auth != null;
    }
  }
}
```

---

1st highest security - Allow only authenticated users to read and write data that they own

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

FireSTORE:
```
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    match /users/{uid} {
      allow read, write: if request.auth != null && request.auth.uid == uid;
    }
  }
}
```

When creating new documents for an user (like an "uploadedPics" collections, or an "users" collections for storing users' profile data), you have to make sure it saves the uid. The uid is from the authenticated user which you can get from code but you can also see it in All Products -> Authentication -> Users tab. The reason why you have to save the uid for each document that the user owns is because your security rules would be only allowing read/write if the uid in that document matches. Note in this example, it's seeing if the uid matches in /users/ documents.