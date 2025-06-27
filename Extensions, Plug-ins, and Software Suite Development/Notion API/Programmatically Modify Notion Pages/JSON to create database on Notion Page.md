
## 🎯 Overview - How It Works

1. **Ask ChatGPT** to design a Notion database or page for your specific needs.

2. **Request the JSON** template in Notion API JSON format. Feel free to show ChatGPT a truncated example JSON from a later section here.

3. **Upload via API**. Place the json file inside somewhere that the code will have access to and make sure .env file points to the json file, your integration ID, and your page ID. We will go over the code in this tutorial.

---

## 👱‍♂️ Get your Notion credentials:

- **Integration Token**: Create a new integration at [https://www.notion.so/my-integrations](https://www.notion.so/my-integrations)

	1. Add an integration
	   ![[Pasted image 20250627013037.png]]
	2. You will name your integration. Do not use the word "Notion" in the name - that's blocked. Select the Notion Workspace that your code will access. Choose Internal or Public purpose. Add your logo.
	   ![[Pasted image 20250627013300.png]]
	3. After your integration is finished creating, go back into editing it. You need to scope the pages at the "Access" tab:
	   ![[Pasted image 20250627011848.png]]
	4. Note that Notion as of June 2025 is glitchy. It may look like the adding page access is unchanged. Just refresh the web browser:
	   ![[Pasted image 20250627012030.png]]

	5. Finally, copy the integration token at the "Configuration" tab:
	   
	![[Pasted image 20250627012218.png]]

	   

- **Parent Page ID**: Copy the page ID from your Notion page URL (the 32-character string after the last `/`). For example, if the page URL in the web app is `https://www.notion.so/Test-21fdd9f91fa080f1abd9e9dd2ebedd19`, then the page ID is `21fdd9f91fa080f1abd9e9dd2ebedd19`.
	![[Pasted image 20250627012721.png]]

---

## Create the code

package.json:
- Make sure to have ran `npm run install`
```
{
  "name": "notion",
  "version": "1.0.0",
  "main": "create_notion_database.js",
  "scripts": {
    "test": "echo \"Error: no test specified\" && exit 1",
    "deploy": "node create_notion_database.js"
  },
  "author": "",
  "license": "ISC",
  "description": "",
  "dependencies": {
    "dotenv": "^16.0.0",
    "node-fetch": "^2.7.0"
  }
}
```

Your .env file could be:
```
NOTION_TOKEN="your-secret-integration-token"
PARENT_PAGE_ID="your-page-id"
WORKSPACE_JSON="templates/your-filename-from-chatgpt-asking-for-notion-template-json.json"
```

Create a folder templates/ that stores your database in JSON format that ChatGPT outputted. Here's a working json file

templates/notion_task_prioritization_template.json:
```
{
  "parent": {
    "type": "page_id",
    "page_id": "YOUR_PAGE_ID"
  },
  "properties": {
    "Task": {
      "title": {}
    },
    "Category": {
      "select": {
        "options": []
      }
    },
    "Tags": {
      "multi_select": {
        "options": []
      }
    },
    "Impact": {
      "number": {
        "format": "number"
      }
    },
    "Hours Complexity": {
      "number": {
        "format": "number"
      }
    },
    "Effort Complexity": {
      "number": {
        "format": "number"
      }
    },
    "Accountable To": {
      "people": {}
    },
    "Time Sensitive": {
      "checkbox": {}
    },
    "Deadline": {
      "date": {}
    },
    "Job to Vision": {
      "checkbox": {}
    },
    "Job to Mission": {
      "checkbox": {}
    },
    "Opportunity Cost: Dopamine": {
      "checkbox": {}
    },
    "Opportunity Cost: Focus Window": {
      "checkbox": {}
    },
    "Plan Effectiveness": {
      "formula": {
        "expression": "prop(\"Impact\") / prop(\"Hours Complexity\")"
      }
    },
    "Performer Effectiveness": {
      "formula": {
        "expression": "prop(\"Impact\") / prop(\"Effort Complexity\")"
      }
    },
    "Urgent & Important": {
      "formula": {
        "expression": "prop(\"Time Sensitive\") and (prop(\"Job to Vision\") or prop(\"Job to Mission\"))"
      }
    }
  },
  "created_time": "2025-06-27T07:20:36.647556Z",
  "object": "database"
}
```

Note DO NOT worry about this section - the code will replace it anyways:
- It's like this because the Notion API will take the JSON that has the database and fields but it reads the page ID in that JSON to know where to create the database in your Notion workspace
```
  "parent": {
    "type": "page_id",
    "page_id": "YOUR_PAGE_ID"
  },
```


create_notion_database.js:
```
const dotenv = require('dotenv');
dotenv.config();

const fs = require('fs');
const fetch = require('node-fetch');

// Replace with your actual integration token and parent page ID
const NOTION_TOKEN = process.env.NOTION_TOKEN || "your-secret-integration-token";
const PARENT_PAGE_ID = process.env.PARENT_PAGE_ID || "your-page-id";
const WORKSPACE_JSON = process.env.WORKSPACE_JSON || "workspace.json";

// Read the JSON template
let rawData = fs.readFileSync(WORKSPACE_JSON);
let payload = JSON.parse(rawData);

// Set the parent page ID dynamically
payload.parent = {
  "type": "page_id",
  "page_id": PARENT_PAGE_ID
}

fetch('https://api.notion.com/v1/databases', {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${NOTION_TOKEN}`,
    'Content-Type': 'application/json',
    'Notion-Version': '2022-06-28'
  },
  body: JSON.stringify(payload)
})
.then(response => response.json())
.then(data => {
  if (data.object === 'database') {
    console.log('✅ Database created successfully!');
    console.log(JSON.stringify(data, null, 2));
  } else {
    console.error('❌ Failed to create database:', data);
  }
})
.catch(error => {
  console.error('❌ Request failed:', error);
});
```

After you adjusted .env file to set the database you're creating and which page the database gets created into, you can run the script to connect to your Notion via your integration app:
```
npm run deploy
```

---

## Repo?

If you would like to have the code work already done, refer to Weng's repository at:
https://github.com/Siphon880gh/notion-api-create-database-on-page