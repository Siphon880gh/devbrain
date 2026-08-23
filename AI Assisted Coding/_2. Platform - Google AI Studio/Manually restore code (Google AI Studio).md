**Requirement**:
You've been disciplined with syncing to Github or downloading manually, so you have the .zip file to the last state of the code you want to restore to. 

**Explanation:**
As of **January 2026**, Google AI Studio doesn’t have a reliable “restore” workflow. Sometimes a chat turn shows a **Restore point**, but many turns don’t—so you can’t count on it. If you’ve been disciplined about syncing to GitHub or downloading backups manually, you’re in luck.

To restore from a backup, you provide that **.zip** file that comes from Github or downloading manually (See requirement above). Press **“+” button** in **Code view** and select the zip file. AI Studio will unzip it for you, and it typically lands inside a **nested folder** (a folder-within-a-folder). Don’t drag-and-drop the zip into Code view because it won't unzip and there's no unzip option (as of Jan 2026). Use the **“+” upload** button instead.

Once the zipped contents are in that nested folder, you’ll basically “reset” the project by removing the current files in Code view, then moving the restored files from the nested folder back into the **root**. Two files—`metadata.json` and `index.tsx`—can’t be deleted, so just **overwrite their contents** and save (instead of trying to delete and move them). When everything is back in the root and updated, **delete the nested folder** so your project structure is clean again.

---

Delete all:
![[Pasted image 20260119053355.png]]

Until...
![[Pasted image 20260119053421.png]]
^ Because index.tsx and metadata.json can’t be removed. However you can edit and save them later, if it has been changed compared to restoration

NOT:
![[Pasted image 20260119053442.png]]

because:
![[Pasted image 20260119053453.png]]


  
But YES:
![[Pasted image 20260119053515.png]]

  
Now you have it’s restored because the zip automatically unzips.

Make sure to test Preview:
![[Pasted image 20260119053707.png]]

