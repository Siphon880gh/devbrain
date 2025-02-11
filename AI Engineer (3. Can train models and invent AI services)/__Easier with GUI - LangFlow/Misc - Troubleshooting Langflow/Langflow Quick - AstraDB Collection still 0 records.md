You've recently ingested data into a new AstraDB collection, however the AstraDB shows that the collection still has 0 records at the retrieval flow: (refer to collection `new2`):
![[Pasted image 20250211033731.png]]


**Solution:**

Click refresh on the database name:
![[Pasted image 20250211033750.png]]

Then check if the collection shows the updated number of records now:
![[Pasted image 20250211033817.png]]

Sweet! `new2` no longer shows 0 records. We can now retrieve without errors about page_content (which is a vague error meaning the collection is empty, though it's because of syncing issues).

If still doesn't work, try literally refreshing the project by hitting Refresh icon on your web browser.