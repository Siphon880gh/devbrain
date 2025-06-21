## 📋 Prerequisites

- **Google Cloud project** with the Sheets API enabled
- A **Service Account** created in that project, with the **Sheets API** scope granted
- The Service Account’s **email** and **private key** (from the JSON you download)

---

## 🔧 Environment Variables

Create a `.env` in your project root with at least these entries:

```dotenv
# Service account credentials
GOOGLE_SERVICE_ACCOUNT_EMAIL=your-service-account@your-project.iam.gserviceaccount.com
GOOGLE_PRIVATE_KEY="-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkq…\n…\n-----END PRIVATE KEY-----\n"

# Sheet details
GOOGLE_SHEET_ID=abc123-8910hij              # from https://docs.google.com/spreadsheets/d/GOOGLE_SHEET_ID/edit
GOOGLE_SHEET_NAME=Sheet1                    # the tab name (or "Sheet1!A1:C100" for ranges)
```

> **Tip:** When copying your private key into `.env`, wrap it in quotes and replace literal newlines with `\n`.

---

## 🛠 Installing Dependencies

```bash
npm init -y
npm install googleapis dotenv
```

---

## 📝 Sample Code

```javascript
// src/readSheet.js
import { google } from 'googleapis';
import dotenv from 'dotenv';

dotenv.config();

async function readSheet() {
  // 1. Configure JWT client
  const jwtClient = new google.auth.JWT({
    email: process.env.GOOGLE_SERVICE_ACCOUNT_EMAIL,
    key: process.env.GOOGLE_PRIVATE_KEY?.replace(/\\n/g, '\n'),
    scopes: ['https://www.googleapis.com/auth/spreadsheets.readonly'],
  });

  // 2. Authorize
  await jwtClient.authorize();

  // 3. Create Sheets API client
  const sheets = google.sheets({ version: 'v4', auth: jwtClient });

  // 4. Fetch values
  const res = await sheets.spreadsheets.values.get({
    spreadsheetId: process.env.GOOGLE_SHEET_ID,
    range: process.env.GOOGLE_SHEET_NAME,
  });

  const rows = res.data.values;
  if (!rows || rows.length === 0) {
    console.log('No data found.');
    return;
  }

  // 5. Output as JSON
  console.log(JSON.stringify(rows, null, 2));
}

readSheet().catch(console.error);
```

---

## 🚀 How It Works

1. **JWT Client**  
    We spin up a `google.auth.JWT` with your service‐account email & private key—no file needed.
    
2. **Scopes**  
    Use `spreadsheets.readonly` for reading; swap to `spreadsheets` if you’ll write later.
    
3. **Range**  
    You can put just the tab name (`Sheet1`) to read every populated row, or a full A1 notation (`Sheet1!A2:D`) for specific ranges.
    
4. **Output**  
    We `console.log` the 2D array you get back; feel free to map it into objects if your first row is headers.
    

---

## ✅ Quick Test

```bash
node src/readSheet.js
```

You should see your sheet’s rows printed as JSON.

---

## 🔄 Next Steps

- **Writing back**: switch to `sheets.spreadsheets.values.update` or `append`.
- **Batch reads**: use `batchGet` with multiple ranges.
- **Error handling**: wrap calls in try/catch and inspect `err.code`/`err.errors`.
- **Deployment**: make sure your production env injects the same `.env` vars securely.

That’s it—you now have a clean, env-driven Node.js setup for reading Google Sheets!