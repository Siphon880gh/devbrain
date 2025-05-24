
**Goal:**  
Export your local MongoDB database (from Compass) to MongoDB Atlas, so your app (e.g., hosted on Heroku) can connect to a cloud database.

---

### 1. Export from Local MongoDB (Compass)

1 of 2:
![[Pasted image 20250523063655.png]]  

2 of 2:
![[Pasted image 20250523063748.png]]

---

### 2. Browse Collections in MongoDB Atlas

Click **"Browse Collections"**:
![[Pasted image 20250523063811.png]]

Click **"Add My Own Data"**:  
![[Pasted image 20250523063823.png]]

Fill in your **Database Name** and **Collection Name**:  
![[Pasted image 20250523063834.png]]

---

### 3. Upload Using `mongoimport`

If MongoDB is installed locally, use the CLI tool `mongoimport`:

```bash
mongoimport <options> <connection-string> --db <DB_NAME> --collection <COLLECTION_NAME> compass_exported.ndjson
```

---

## ✅ Requirements for Successful Upload

### 📌 Requirement 1: Valid Connection String

- Must include a **username and password**.

Get your connection string from MongoDB Atlas:  
![[Pasted image 20250523063955.png]]

> 💡 Unsure if your connection string is valid? Ask ChatGPT to check it—just mask your password.

Create a DB user:  
![[Pasted image 20250523064011.png]]

If your password is too short or invalid, the UI may fail silently:  
![[Pasted image 20250523064025.png]]

---

### 📌 Requirement 2: Network Access Enabled

Ensure your IP is whitelisted or access is open to all.

![[Pasted image 20250523064234.png]]

To allow access from anywhere, enter `0.0.0.0/0` or click this option:  
![[Pasted image 20250523064254.png]]

---

### 📌 Requirement 3: Data Must Be in Newline-Delimited JSON (NDJSON)

If you see an error like:

```
Failed: cannot decode array into a primitive.D
```

…it means your file is a JSON **array**, but `mongoimport` expects **NDJSON** (newline-delimited JSON documents).

#### ❌ Compass Export (Incorrect Format):

```json
[
  { "_id": "abc123", "name": "John", "age": 24 },
  { "_id": "def456", "name": "Jane", "age": 22 }
]
```

#### ✅ Required Format (NDJSON):

```
{ "_id": "abc123", "name": "John", "age": 24 }
{ "_id": "def456", "name": "Jane", "age": 22 }
```

Compass does **not** support NDJSON export:  
![[Pasted image 20250523064427.png]]

#### 🔁 Convert with `jq`:

Use this command:

```bash
jq -c '.[]' compass_exported.json > compass_exported.ndjson
```

> 💡 Install `jq`:
> 
> - macOS: `brew install jq`
> - Ubuntu/Debian: `sudo apt install jq`
> - RedHat/CentOS: `sudo yum install jq`
> - Windows: `choco install jq`
>     

`jq` is like `sed` for JSON—great for transforming structured data from arrays into line-by-line objects.

---

## 🎉 Once All 3 Requirements Are Met

You’re ready to import:

```bash
mongoimport "mongodb+srv://<USERNAME>:<PASSWORD>@cluster0.mongodb.net" \
  --db my_database --collection my_collection \
  --file compass_exported.ndjson
```

This will upload your local data to MongoDB Atlas and make it available to your cloud-deployed app.