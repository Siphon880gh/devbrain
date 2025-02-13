You've recently ingested data into a new AstraDB collection at a Load flow.

![[Pasted image 20250212182032.png]]

However the AstraDB shows that the collection still has 0 records at the Retrieval flow: (refer to collection `new2`):
![[Pasted image 20250211033731.png]]


**Solution:**

Click refresh on the database name:
![[Pasted image 20250211033750.png]]

Then check if the collection shows the updated number of records now:
![[Pasted image 20250211033817.png]]

It passes if `new2` no longer shows 0 records. We can now retrieve without errors about page_content (which is a vague error meaning the collection is empty, though it's because of syncing issues).

---

If still doesn't work, try (in this order):

- Literally refreshing the webpage on your web browser
- Deleting the AstraDB component and re-adding the AstraDB
- May be a caching issue on your web browser. 
	- CMD+SHIFT+I, then CMD+SHIFT+R or click and holding refresh browser button -> Empty Cache and Hard Reload
	- Then click refresh icon on the database in AstraDB component
	- Then retype the collection name
- It may be a caching issue on Datastax's server.
	- Rename the collection at Datastax AstraDB dashboard. 
	- Then use the new collection name. 