

Purpose: When an user completes a form on your website, you want the details to be emailed to you. However, you can’t receive emails without a FROM, so the backend will email on the behalf of employee@yourcompany.com to your email. 

Requirements:
The email you are emailing on behalf of must be an email from Google workspace (formerly G Suite) for the purposes of this tutorial. A standard Gmail account must use a different authentication method. Refer to my other tutorial if you are using a standard Gmail email account. The TO email does not have this restriction.

What is Google workspace? Google Workspace (formerly G Suite) allows organizations to use their own domain names for email addresses. So, instead of the standard "@gmail.com" suffix, Google Workspace users can have email addresses that match their organization's domain, like "employee@yourcompany.com".

Google Cloud Platform:
Make sure you have a Project, with Gmail API enabled, and you create a service account. That service account doesn’t need to be set with specific scopes. But for the service account, you must enable domain-wide delegation so that the service account can perform actions on behalf of any user within the Google Workspace domain without individual user credentials. When enabling, it will ask you to login with an account that has administrative privileges on the Google Workspace domain. Download the service account file.

Security:
Your code will refer to the service account file. Recommend saving the path of the service account file as an env file and that the code is in the backend.

Package.json:
```
  "dependencies": {  
    "express": "^4.19.2",  
    "google-auth-library": "^9.9.0",  
    "googleapis": "^136.0.0",  
    "nodemailer": "^6.9.13"  
  }
```

This is the nodejs script. Please adjust the SERVICE-ACCOUNT.json x1, employee@yourcompany.com x3, and you@yourcompany.com x1:
```
const nodemailer = require('nodemailer');  
const {google} = require('googleapis');  
  
const key = require('./SERVICE-ACCOUNT.json');  
  
// Generate a url that asks permissions for Gmail scopes  
const scopes = [  
    'https://mail.google.com'  
];  
  
// Obsoleted:  
// const scopes = [  
//     'https://www.googleapis.com/auth/gmail.send'  
// ];  
  
  
const jwtClient = new google.auth.JWT(  
    key.client_email,  
    null,  
    key.private_key,  
    scopes,  
    "employee@yourcompany.com"  
);  
  
jwtClient.authorize((err, tokens) => {  
    if (err) {  
        console.log('Authorization error', err);  
        return;  
    }  
    console.log("Successfully connected!");  
    // console.log("Token Information", tokens);  
  
  
    let transporter = nodemailer.createTransport({  
        service: 'gmail',  
        auth: {  
            type: 'OAuth2',  
            user: 'employee@yourcompany.com',  
            clientId: null,  
            clientSecret: null,  
            refreshToken: null,  
            accessToken: tokens.access_token,  
            expires: tokens.expiry_date  
        }  
    });  
  
    console.log(key.client_email);  
    let mailOptions = {  
        from: "Employee <employee@yourcompany.com>", // sender address  
        to: 'you@yourcompany.com', // list of receivers  
        subject: 'Hello', // Subject line  
        text: 'Hello world?', // plain text body  
        html: '<b>Hello world?</b>' // html body  
    };  
    // You are setting both plain text (text) and HTML (html) bodies for the email. This is common practice, but ensure that the content is exactly what you want to send.  
  
  
    // send mail with defined transport object  
    transporter.sendMail(mailOptions, (error, info) => {  
        if (error) {  
        return console.log('Error while sending mail: ' + error);  
        }  
        console.log('Message sent: %s', info.messageId);  
    });  
});
```