

Purpose: When an user completes a form on your website, you want the details to be emailed to you. However, you can’t receive emails without a FROM, so the backend will email on the behalf of another gmail account (can be a dummy gmail you don’t use) to your email. 

Requirements:
The email you are emailing on behalf of must be an existing standard Gmail account. Refer to my other tutorial if you are using a Google Workspace (formerly G Suite) email account. The TO email does not have this restriction and doesn’t have to be a gmail account.

What is Google workspace? Google Workspace (formerly G Suite) allows organizations to use their own domain names for email addresses. So, instead of the standard "@gmail.com" suffix, Google Workspace users can have email addresses that match their organization's domain, like "employee@yourcompany.com".

Google Cloud Platform:
Make sure you have a Project, with Gmail API enabled, and you create a OAuth 2.0 Client ID. A popup with client id and client secret will appear upon creating a new OAuth2 ID; make sure to download the json file which will contain the client id and client secret. 

Security:
Your code will refer to the client id and client secret json file. Recommend saving the path of the json file as an env file and that the code is in the backend.

Package.json:
```
  "dependencies": {  
    "express": "^4.19.2",  
    "google-auth-library": "^9.9.0",  
    "googleapis": "^136.0.0",  
    "nodemailer": "^6.9.13"  
  }
```

This is the nodejs script. Please adjust the CLIENT-DETAILS.json x1, [standard@gmail.com](mailto:standard@gmail.com "mailto:standard@gmail.com") x2, and [you@yourcompany.com](mailto:you@yourcompany.com "mailto:you@yourcompany.com") x1:
```
const nodemailer = require('nodemailer');  
const express = require('express');  
const {google} = require('googleapis');  
  
const app = express();  
const port = 3001; // Ensure this matches the port in your redirect URI  
  
const key = require("./CLIENT-DETAILS.json").installed;  
  
const oauth2Client = new google.auth.OAuth2(  
    key.client_id,   
    key.client_secret,   
    `http://localhost:${port}/oauth2callback` // This should match your redirect URI set in GCP  
);  
  
  
// Generate a url that asks permissions for Gmail scopes  
const scopes = [  
    'https://mail.google.com'  
];  
  
// Obsoleted:  
// const scopes = [  
//     'https://www.googleapis.com/auth/gmail.send'  
// ];  
    
const url = oauth2Client.generateAuthUrl({  
    access_type: 'offline',  
    scope: scopes  
});  
  
console.log('Visit the following url to authorize:', url);  
  
  
// Function to send email using Nodemailer with tokens  
async function sendEmail(tokens) {  
    console.log("keys", key)  
    console.log("tokens", tokens)  
    // Check if the current access token is expired  
    const now = new Date();  
    const isTokenExpired = tokens.expiry_date ? now.getTime() > tokens.expiry_date : false;  
  
    if (isTokenExpired) {  
        console.log("Access token has expired, refreshing...");  
        const newTokens = await oauth2Client.refreshAccessToken(); // Refresh the access token  
        tokens.access_token = newTokens.credentials.access_token;  
        tokens.expiry_date = newTokens.credentials.expiry_date;  
    }  
  
    let transporter = nodemailer.createTransport({  
        service: 'gmail',  
        auth: {  
            type: 'OAuth2',  
            user: 'standard@gmail.com',  
            clientId: key.client_id,  
            clientSecret: key.client_secret,  
            refreshToken: tokens.refresh_token,  
            accessToken: tokens.access_token  
        }  
    });  
  
    let mailOptions = {  
        from: 'standard@gmail.com',  
        to: 'you@yourcompany.com',  
        subject: 'Hello from Node.js App!',  
        text: 'This is a test email sent from our Node.js app using OAuth2 and Nodemailer.',  
        html: '<b>This is a test email sent from our Node.js app using OAuth2 and Nodemailer.</b>'  
    };  
  
    // try {  
    //     let info = await transporter.sendMail(mailOptions);  
    //     console.log('Email sent:', info.response);  
    // } catch (error) {  
    //     console.log('Error sending email:', error);  
    // }  
  
  
    transporter.sendMail(mailOptions, (error, info) => {  
        if (error) {  
            console.error('Detailed Error Information:', error);  
            return;  
        }  
        console.log('Email sent:', info.response);  
    });  
      
      
}  
  
  
app.get('/oauth2callback', async (req, res) => {  
    const {code} = req.query;  
    try {  
        const {tokens} = await oauth2Client.getToken(code);  
        oauth2Client.setCredentials(tokens);  
        // Store these tokens securely if you need to use them later  
        res.send('Authentication successful! You can close this window.');  
        console.log('Tokens:', tokens);  
        // Attempt to send an email after successful authentication  
        await sendEmail(tokens);  
    } catch (error) {  
        console.error('Error getting tokens:', error);  
        res.send('Authentication failed.');  
    }  
});  
  
app.listen(port, () => {  
    console.log(`Listening on http://localhost:${port}`);  
});
```


When you run this server, make sure to have access to the terminal which will output the OAuth2 screen URL. Visit the URL and sign in using the standard Gmail email that is used to email on your behalf in your code. Then after successful OAuth2 login, Google redirects to http://localhost:3001/oauth2callback which will say “Authentication successful...” and then you get to check your terminal to see if there are any errors. If no errors, the email is sent.

You can manage the OAuth2 at
https://myaccount.google.com/security-checkup/
Which will show your Google Project App name
