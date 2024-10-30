## Problem Statement

As the co-founder and engineer of a small SaaS web startup specializing in video creation for users, I maintain a MongoDB database with two collections:

- **Users**: Each user has a unique `_id` and other identifying information.
- **Content**: Contains details of generated videos, referencing users by a `userId` field, which acts as a "foreign key" to the `users` collection.

Investors/strategists want access to view customer data and their videos, but the data is split between two tables. With metabase, the two tables can be joined, the columns rearranged and certain columns removed, and there can be sorting. Then the investors/strategists can look at one table. Also they won't be able to accidentally modify your data.

In this example, we are working with MongoDB connected data to Metabase.

Click join icon and join the two tables:

![](https://i.imgur.com/Nm9bhtB.png)

Then click the “>_” at the top right
![](https://i.imgur.com/JVoN6B2.png)

It can give you the native query that's read only because this is generated from the config ui. Go ahead and convert it into all native query only:
![](https://i.imgur.com/rRSGtCq.png)

Reason why is because the Metabase UI doesn't provide an easy way to  convert `_id` from a BSON Object ID into string to check equality with foreign key. By converting it into a native query (aggregate leverage), we can also leverage AI like ChatGPT:
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