
In the world of modern application development, interacting with external APIs is often a necessity, not just an option. Firebase Cloud Functions stand out as a powerful tool, allowing developers to automate responses to events within their Firebase environment. This article delves into a specific use case: triggering an external API call when a user is added or updated in the Firestore 'users' collection, demonstrating the versatility of Cloud Functions in real-world scenarios.

## Firebase Cloud Functions: An Overview

Firebase Cloud Functions offer a serverless framework where you can run backend code in response to Firebase events or HTTPS requests. They automatically scale with your application's needs, ensuring optimal resource utilization and performance.

## Automating External API Calls Based on User Activity

A common requirement is to interact with external services whenever there's a change in user data. For instance, you might want to enrich user profiles, validate information, or trigger external workflows when a new user is added or an existing user is updated in your Firestore 'users' collection.

### Code Example: Triggering API Calls on User Changes

Let's explore how to set up a Cloud Function that listens for changes in the 'users' collection and triggers an API call:

```javascript
const functions = require('firebase-functions');
const admin = require('firebase-admin');
const axios = require('axios');

admin.initializeApp();

exports.onUserUpdate = functions.firestore
    .document('users/{userId}')
    .onWrite(async (change, context) => {
        // Determine if it's a new user or an update
        const userData = change.after.exists ? change.after.data() : null;

        // Exit if no user data
        if (!userData) return null;

        // Example API call using user data
        try {
            const response = await axios.post('https://api.example.com/user', {
                userId: context.params.userId,
                userName: userData.name,
                userEmail: userData.email,
                // Add other user properties as needed
            });

            console.log('API response:', response.data);

            // Optionally, update user document with API response
            await admin.firestore().collection('users').doc(context.params.userId).update({
                apiResponse: response.data,
            });

            return response.data;
        } catch (error) {
            console.error('API call failed:', error);
            return null;
        }
    });
```

This function listens for any write operations (create, update, delete) on documents within the 'users' collection. When a user document is created or updated, the function triggers an API call, sending relevant user data to the external service. The response from the API can then be logged, used for further processing, or stored back in the user's document.

## Access Token

Often case unless that external API service is free, you're required to have an access token. You can have a firestore collection config that saves the accessToken. You can have it updated too if necessary (refresh tokens, etc)

```
exports.useAccessToken = functions.https.onCall(async (data, context) => {
  const doc = await admin.firestore().collection('config').doc('accessToken').get();
  const accessToken = doc.data().token;

  const response = await axios.get('https://api.example.com/data', {
    headers: { Authorization: `Bearer ${accessToken}` }
  });

  const processedData = processData(response.data);
  await admin.firestore().collection('externalData').add(processedData);

  return { status: 'Data processed and stored' };
});

function processData(data) {
  // Data processing logic goes here
  return data;
}

```

## Conclusion

Integrating Firebase Cloud Functions with Firestore offers an elegant solution to automatically interact with external APIs in response to data changes. This approach not only enhances the dynamism of your application but also opens up a myriad of possibilities for data enrichment, validation, and integration with other services. Whether you're managing user profiles, connecting to third-party services, or orchestrating complex workflows, Firebase Cloud Functions provide a robust, scalable, and efficient way to enhance your application's capabilities and responsiveness.