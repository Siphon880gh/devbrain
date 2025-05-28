When working with Google APIs like Gmail, Drive, or Sheets, your app needs to be authenticated. Google provides **two distinct types of JSON credential files** as part of the app authentication, each suited for a different use case:

- **OAuth2 Client JSON File** – for **user-based** access (e.g. logging in with Gmail)
- **Service Account JSON File** – for **server-to-server** access (e.g. reading a Sheet in the background)

And the type of Google service also limits you to a specific type of JSON credential files:
- **OAuth2 Client JSON File** - For personal Gmail accounts. Example: Sending email as a logged-in user (`you@gmail.com`)
- **Service Account JSON File** – In Google Workspace, a service account JSON file allows your app to act on behalf of any user in the domain using domain-wide delegation. This means your app can impersonate individual users to access their emails or files. Only service accounts are supported in Google Workspace because OAuth2 is based on individual user consent, which doesn’t fit Google Workspace’s model—Workspace accounts belong to organizations, not individuals.

Understanding the difference is critical to avoid misusing them.

---

This is the Google Cloud Dashboard's Credentials area where you can create the either JSON file types:
![[Pasted image 20250527043236.png]]

---

### 🔐 OAuth2 Client JSON (User Login Flow)

To send emails through Gmail or access a user’s data, you must authenticate **on behalf of a user** using **OAuth2**.

#### 📝 Step 1: Identify Your App with OAuth2 Credentials

1. Go to **Google Cloud Console > APIs & Services > Credentials**
    
2. Create an **OAuth Client ID**
    
    - Application type: **Desktop App** or **Web App**
        
3. Download the `.json` file — it contains:
    
    - `client_id`
    - `client_secret`
    - `redirect_uris`

This file is used to **start the OAuth2 login flow** — it proves your app’s identity to Google.

#### 🌐 Step 2: User Logs In and Grants Access

Once the OAuth client is initialized, your backend generates an authorization URL. The flow looks like this:

- The user visits the link and sees Google’s **consent screen**
    
- After granting permission, Google redirects to your callback with a `?code=AUTHORIZATION_CODE`
    
- You use a Google SDK to exchange the code for:
    
    - `access_token` (short-lived, for API access)
    - `refresh_token` (optional, for silent re-auth)
    - `expiry_date` (when the access token expires)
        

> ✅ These tokens are **returned dynamically at runtime** — they’re not in the original JSON file.

---

### 🛑 Service Account JSON (No User Login)

Service accounts are for **server-to-server** operations where **no user login or consent is required**.

- Created under **Google Cloud > Credentials > Service Accounts**
    
- You download a different `.json` file — it contains:
    
    - `client_email`
    - `private_key`
    - `project_id`, etc.
        

These are used for use cases like:

- Automating Google Sheets, Drive, or Cloud Storage
- Running background jobs
- Admin-level access within a **Google Workspace** domain
    

> ⚠️ You **cannot** use service account JSON with a regular `@gmail.com` address.  
> It only works in **Google Workspace** domains, and even then, only if **domain-wide delegation** is configured.

---

### ✅ Credential Types Compared

|Type|Purpose|Works with Gmail?|File Format|
|---|---|---|---|
|**OAuth2 Client JSON**|User login + consent (OAuth2 flow)|✅ Yes (standard Gmail)|`.json`|
|**OAuth2 Tokens**|Returned _after_ login + consent|✅ Yes|In-memory or stored|
|**Service Account JSON**|Server-to-server, no user involved|🚫 No (unless Workspace + delegation)|`.json`|
