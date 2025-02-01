## Problem Statement

As the co-founder and engineer of a small SaaS web startup specializing in video creation for users, I maintain a MongoDB database with two collections:

- **Users**: Each user has a unique `_id` and other identifying information.
- **Content**: Contains details of generated videos, referencing users by a `userId` field, which acts as a "foreign key" to the `users` collection.

Investors/strategists want access to view customer data and their videos, but the data is split between two tables. With metabase, the two tables can be joined, the columns rearranged and certain columns removed, and there can be sorting. Then the investors/strategists can look at one table. Also they won't be able to accidentally modify your data.

In this example, we are working with MongoDB connected data to Metabase.

Click join icon and join the two tables:

![](Nm9bhtB.png)

Click Play icon on the right to see the resultant inner join.

If satisfied, then click the “>_” at the top right
![](JVoN6B2.png)

If result table is empty and you KNOW that the inner join is correct, you may have an older metabase problem. Refer to next section

---

## Older Metabase?

If you had to use the Metabase AMD64 Image that containerized for Apple M1/M2 etc from https://github.com/StephaneTurquay/metabase-arm64-docker last changed on Jan 27, that version of Metabase does not automatically convert BJSON Object ID from `users._id` to match the string at `content.userID`.

However on Metabase newer versions (Like the image `metabase/metabase:latest` as far as I know in Oct 2024), it does automatically cast Object ID to string so inner join can work in many practical examples.

In the case you need to cast BJSON Object ID manually:

Convert the question into a native query by clicking this button (Otherwise the query is read-only so that the Config UI does not conflict):
![](rRSGtCq.png)

By converting it into a native query (aggregate leverage), we can also leverage AI like ChatGPT:
```
\<
Im using metabase https://www.metabase.com/. Generating a report, the join is not working. I suspect when I join content.userId (foreign key) on users._id, it's because userId is a string whereas _id is ObjectID. Whats the native aggregate query?

\<
Heres my query. I need help converting users._id to string so can be matched

\<  
Awesome! Is it possible to rename id to users._id And to hide userId Is it possible to expand content_is into its own columns?
```

**Additional Tweaks if needed**
- Let's say we have nested object in your Mongo document and you want to flatten that out because we're doing a table with columns, you can use ChatGPT:
```
Help me do the work of creating a query on Metabase https://www.metabase.com/. Here's a sample content_is. Notice there's a nested object in there caseDetails.a and caseDetails.b - which we should flatten along with c, d, e:
{caseDetails:{a:1,b:2}, c:3, d:4, e:5}

And here is my actual data:
```
	  
- -> You might additionally have to rename those columns generated from the flattened nested object because the name might hint at its structure and you remember this table is for non developers.
- You may want sorting. At a subsequent prompt:
```
Let's sort by name_first
```

- -> The generated query will have a sort phase before the limit phase:
```
// ...
  {  
	"$sort": {  
	  "Users - UserId__name_first": 1  
	}  
  },  
  {  
	"$limit": 1048575  
  }  
]
```

Now you can edit the once read-only query since you've converted it into a query input.