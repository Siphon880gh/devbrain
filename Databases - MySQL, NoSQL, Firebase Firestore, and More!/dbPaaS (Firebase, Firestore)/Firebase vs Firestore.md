
Firebase and Firestore: They're both real time databases 

---

Differences:
Firebase Realtime Database (Eventual Consistency): After a write, data changes are eventually propagated to all clients, but there's no guarantee that every client will immediately have the most up-to-date version. In most cases, the delay is minimal. Also when it comes to remotely updating the database, it leads to quicker updates. The developer experience at the Console is horrible because the Firebase Realtime Database doesn't follow the typical two-column view that you might be familiar with in SQL databases. Instead, it’s structured as a **NoSQL** JSON tree:
![](https://i.imgur.com/Bxuu5a2.png)


Firestore (Strong Consistency): Gives the most recent data after a successful write operation, even across different clients. But more overhead. When it comes to remotely updating the database, you get slightly slower updates. The developer experience at the Console is great because it has the two column view:

![](https://i.imgur.com/Z0BewEm.png)

Differences in transport protocols:
- Firebase's classic Realtime Database uses websocket as its transport protocol, whereas Cloud Firestore uses grpc as its transport protocol. Firebase-admin is needed for the backend authentication of the app. Firebase package includes "firebase/auth" for the frontend authentication of the frontend sign in user (although you can move this to the backend).
- Firestore requires you to install grpc: `npm install @grpc/grpc-js`

More info:
https://firebase.google.com/docs/firestore/rtdb-vs-firestore

---

Confusing branding of products:
1. **Firebase** initially started as a standalone **backend-as-a-service (BaaS)** with its core offering being the **Firebase Realtime Database**
2. Google acquired Firebase in **2014**, and it remained primarily known for the **Realtime Database** until Google expanded Firebase into a broader platform with additional services (authentication, hosting, analytics, etc.). That point on of 2024, Firebase is a broader platform.
3. Google introduced **Cloud Firestore** in **2017** as a new, more advanced NoSQL document database. To differentiate between the two database services, Google renamed the original  database to **Realtime Database** when **Firestore** was released. **Firebase** remains the broader platform of products
4. Even more confusingly, technically both Real Time Database and Cloud Firestore are BOTH real time databases, except "Real Time Database" is the original real time database.
5. Therefore veterans when they say Firebase, they might be referring to the original Realtime Database which is still available as a choice.
 

At the Products Page on 9/2024:

Firebase:
![](https://i.imgur.com/AqHaYEM.png)


Firestore
![](https://i.imgur.com/kBmLBBt.png)


But remember they are both realtime databases. As you can see from the Cloud Firestore's description: "Realtime updates, powerful..."

---

Confusing branding:

The Console is also called Firebase Console and the logo is Firebase
![](https://i.imgur.com/Jus4DAR.png)
