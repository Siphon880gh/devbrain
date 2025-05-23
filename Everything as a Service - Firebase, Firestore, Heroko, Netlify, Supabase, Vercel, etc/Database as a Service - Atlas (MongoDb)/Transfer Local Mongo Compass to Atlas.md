**Export Local mongodb (from compass) to online mongodb atlas? Because ready to move the code to a platform like Heroku that relies on online database platforms**

Export from Mongo DB
![[Pasted image 20250523063655.png]]

![[Pasted image 20250523063748.png]]

Browse Collections
![[Pasted image 20250523063811.png]]

Click "Add My Own Data"
![[Pasted image 20250523063823.png]]

Fill database name and collection name:
![[Pasted image 20250523063834.png]]

With mongo database installed locally, you have access to the cli `mongoimport` cli
```
mongoimport <options> <connection-string> <file> --db <DB_NAME> --collection <COLLECTION_NAME> compass_exported.ndjson
```
  

To upload correctly, there are three requirements:
- You have a database username and password is in the connection string
- You have enabled network accesss to anywhere or whitelabeled your IP address
- The file you're importing is ndjson (newline delimited json)

**REQUIREMENT 1:**
^Get the connection-string:
![[Pasted image 20250523063955.png]]

^ There are many platform-specific formats for connection strings. If you're unsure whether your connection string is compatible with your platform, ask ChatGPT to review it—just be sure to omit the password or replace it with a placeholder. 

Create database account:
![[Pasted image 20250523064011.png]]

Your password too short etc. Just nothing happens. Bad UX. The console would be
![[Pasted image 20250523064025.png]]

**REQUIREMENT 2:**

![[Pasted image 20250523064234.png]]

For anywhere, enter `0.0.0.0` or click the button "Allow access from anywhere":
![[Pasted image 20250523064254.png]]


**REQUIREMENT 3:**

Re-export as newline-delimited JSON?

Seeing error:
```
Failed: cannot decode array into a primitive.D
```

..means that `mongoimport` is trying to interpret your **entire JSON file as a single document**, when it's actually an **array of documents**.

Exporting from Mongo Compass would export in an array of objects. It does not support exporting as newline-delimited:
```
{ _id: abcdefgh, name: "John", age: 24}  
{ _id: abcdefgh, name: "Jane", age: 22}
```

Usually Mongo compass exports in the expected format of array and objects:
```
[  
 { _id: abcdefgh, name: "John", age: 24},  
 { _id: abcdefgh, name: "Jane", age: 22}  
]
```

Mongo Compass not supporting:
![[Pasted image 20250523064427.png]]

Run this to convert:
```
jq -c '.[]' compass_exported.json > compass_exported.ndjson
```

^ jq is a lightweight and powerful command-line JSON processor. (MacOS Homebrew: `brew install jq`, Ubuntu/Debian: `sudo apt install jq`, Redhat/CentoS: `sudo yum install jq`, Windows: `choco install jq`)

jq is like `sed` for JSON data - you can use it to slice and filter and map and transform structured data with the same ease that `sed`, `awk`, `grep` and friends let you play with text.