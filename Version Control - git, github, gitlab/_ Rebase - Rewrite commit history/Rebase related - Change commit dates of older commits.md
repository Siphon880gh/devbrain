**Use Case**: You want your commits to have different commit dates. You can change the commit dates/times strategically in an excel spreadsheet and convert it into git commands.

**Background**: Commits are broken into Author Date and Commit Date. You need to change both to present a more activity rich contribution graph at your Github Profile and making sure it can't be double checked against your repos' commits pages.

**Warning:** Not to be done with partner shared repo. It's for your own repo.

Breakdown of where each date shows on your Github:
Author Date: Profile Contributions Graph and `git log`
Commit Date: Repos commit page

**Confirm command (will refer back to this)**
```
echo "ShortHash, LongHash, AuthorDate, CommitDate, Author, CommitMessage";
git log --pretty=tformat:"%h, %H, %ad, %cd, %an, %s" --date=iso | cut -c 1-170;
```

^ Explanation: The `cut` will make sure long commit messages doesn't run over the screen

**Plan:**
Which dates you will override from empty to filled
https://github.com/siphon880gh/

---

### Automation

**Automate the workflow if multiple commit dates are being planned to change** - Create csv for Google Sheet

1. **Get long hashes and dates of all your commits in a consumable format for automation**

	You may want to clear the terminal (Run `clear`)
	
	Then run the confirm command. It should be in CSV format already. And copy and paste it into a csv file on the outer folder (so it wont affect current git tracking)
	- This would be running the confirm command, then copying terminal output to ../a.csv:
	  `touch ../a.csv; vim ../a.csv;`
	- Then paste into vim screen
	  
	- Or do the above steps all in one command:
```
echo "ShortHash, LongHash, AuthorDate, CommitDate, Author, CommitMessage";
git log --pretty=tformat:"%h, %H, %ad, %cd, %an, %s" --date=iso | cut -c 1-170 > ../a.sh;
```
	
If `vim ../a.csv` opens an older a.csv, you can clear all by writing the commands
`:%d`

2. **Convert into Google Sheet for you to tweak the automation**

	Go to Google Sheet:
	https://docs.google.com/spreadsheets/u/0/
	
	At Google Sheet, File -> Import -> Upload -> Browse.
	
	Now you have a Google Sheet like:

![](https://i.imgur.com/BfiGGWj.png)


Make sure column G to I are cleared. Sometimes a commit message gets partially parsed into column G. We will not be batch renaming commits (for that, just use `GIT_EDITOR="code --wait" git rebase -i HEAD~20`) to open multiple commits in VS Code for easy editing.

3. **Add your preferred dates**
    
- Add a column to the right.  This is column G. You can name it "PreferredDate" if you want a header row for this column.
- Copy date values there, choosing either "Author" or "Commit" to copy from.
	- Paste special -> Values only.
- Plan on the dates and times you want.
	- You may want to plan this on paper: Plan which empty dates at the Contribution Chart on your Github profile to fill in (back-commit). 
		- Don't always fill in one commit a day. Vary them between 1-3+.
		- Don' fill every single white slot because that looks fake or staged. 
		- Look like you're working in sprints of half a week or 3/4 a week so it's more realistic with someone's energy levels. You may want to plan on paper.
	- Mind the time (besides just the date)
		- You want to look like you work on your repos after work and before a regular sleeping time, so after 1800 pm but before 0000 (midnight).
		- Commit names that suggest you probably worked right before or after another commit should be considered before advancing the date.
	- If modifying the first commits too, you want to have a sprint of early commit days because of natural excitement for the new repo
	- Because formatting won't affect the script, you may plan with formatting
		- Bold changed dates after a second check on their date and times.
	- You can use the Author column to plan dates too writing key pivot dates. You can choose to empty this row and type on the commits you have planning notes for.
- When you're ready, edit the date and time you want at column G "PreferredDate" (if you named the header)
- Leave alone the dates you're not changing **OR remove their row to speed up the script**.

4. **Build the automation script**
    
Continue adding columns. Make sure to duplicate down the columns. Column H,I,J,K,L are:

H
```
git filter-branch -f --commit-filter '

if [ "$GIT_COMMIT" = "
```

I
```
" ]; then

GIT_AUTHOR_DATE="
```

J
```
"

GIT_COMMITTER_DATE="
```


K

```
"

git commit-tree "$@"

else

git commit-tree "$@"

fi' -- --all;
```

L

```
=Concatenate(H2,B2,I2,G2,J2,G2,K2)
```

_Confirm that first cell of L looks like:_
```
git filter-branch -f --commit-filter '

if [ "$GIT_COMMIT" = "5a66dfc8836e248f82f14266c81fb494f4450260" ]; then

GIT_AUTHOR_DATE="2023-05-20 18:20:00 -0700"

GIT_COMMITTER_DATE="2023-05-20 18:20:00 -0700"

git commit-tree "$@"

else

git commit-tree "$@"

fi' -- --all;
```

Make sure the columns are filled, copied downwards

5. **Condense down to one script**
    

Concatenate the entire L column into one cell. You can place directly underneath the L column's content cells (You can CMD+Down to go to most bottom content cell):

```
=Concatenate(L2:L??)
```

The L?? is the last row being concatenated (Remember you are concatenating the column L downwards, skipping the column header hence the range starts at L2).

_Confirm the spreadsheet looks like this_
_(I added headers for readability: Preferred Date, Concatenated, Concatenated Column)_

![](https://i.imgur.com/DhVouqV.png)


6. Clean the copy and paste script

Copy the cell into VS Code to make sure the copy and paste is quoted right, maybe into a `../a.sh` like you had done for `../a.csv`.

- 1. Remove double quotation marks surrounding entire text contents if applicable
- 2. Fix repeated double quotation marks globally
    `"" => "` 

_For example, the uncleaned:_
```
"git filter-branch -f --commit-filter '

if [ ""$GIT_COMMIT"" = ""e6e8e1dfe55ae0db3a74de3363fd6386ff20b21d"" ]; then

GIT_AUTHOR_DATE=""2023-05-01 18:20:00 -0700""

GIT_COMMITTER_DATE=""2023-05-01 18:20:00 -0700""

git commit-tree ""$@""

else

git commit-tree ""$@""

fi' -- --all;git filter-branch -f --commit-filter '

if [ ""$GIT_COMMIT"" = ""150fbbe2b5b2ce4547e34235f6f3ef7a2fd1a30d"" ]; then

..."
```

_=> Becomes_
```
git filter-branch -f --commit-filter '

if [ "$GIT_COMMIT" = "e6e8e1dfe55ae0db3a74de3363fd6386ff20b21d" ]; then

GIT_AUTHOR_DATE="2023-05-01 18:20:00 -0700"

GIT_COMMITTER_DATE="2023-05-01 18:20:00 -0700"

git commit-tree "$@"

else

git commit-tree "$@"

fi' -- --all;git filter-branch -f --commit-filter '

if [ "$GIT_COMMIT" = "150fbbe2b5b2ce4547e34235f6f3ef7a2fd1a30d" ]; then

...
```

Tip: If vim, press gg to go to top. Press G, then $, to jump to the very end, so you can remove the surrounding double quotes. Now to replace "" into " with `:%s/""/\"/g`

7. Run the script
    
Copy over the cleaned script into a .sh file. Make sure you create the script outside the git repo so it wont complain you have changes you haven't staged.
- You can do: `touch ../a.sh; vim ../a.sh`
- Then CMD+V into vim editor, and quit by pressing Escape, :wq

^ If previously had an a.sh file, you may see an old script. You can run `:%d` to select all lines and delete them in vim.

Then you run the script with `sh ../a.sh`  **while inside the git folder.** Make sure you run inside the git folder. Otherwise it complains: `You need to run this command from the toplevel of the working tree.`

8. **Wait if being successful:**
- While it's performing the process, check that it's being successful. If not successful, CTRL+C or CMD+C out of it and follow the steps above closer. If first commits are successful, it's likely all the commits will be successful, then wait it out. The following are examples of bad and good


You dont want an error like this:
```
WARNING: Ref 'refs/heads/main' is unchanged

WARNING: Ref 'refs/remotes/origin/main' is unchanged
```

- You will see Warnings about git-filter-branch having a glut of gotchas generating mangled history. It may seem stuck on that warning. Just ignore. It's actually working on the rewrites.


What you want is like:
```
Ref 'refs/heads/main' was rewritten

Ref 'refs/remotes/origin/main' was rewritten
```


---


### Expected Wait Times

About 14 seconds for each date rewrite on a 103 commits branch.


---

### After Automation Finishes

Finalize online repo
    
- Push forcefully to your repo: `git push origin main --force`
- Check commits page and contribution graph at profile page that the dates are modified.
- Check contribution graph


**Have to go back rewrite another date?** 
- Keep in mind the hash ID's will change again. If you need to edit date(s) again, you have to repeat the entire process from step 1 which lists the hash IDs into the csv file for building the automation script.

---
---
### Appendix

**Edge Cases**
    
When you modified an old author date, that date on contribution graph will be updated if:

- If it was previously 0 commits, it'll update to 1
- If it had other commits, it won't update the count unless you updated the most recent commit during that day (so may require you to rebase another repo).
    
---

**HOW IT WORKS: Updating Contribution Graph**

Yes, changing the dates [author dates] of old commits can affect the contribution graph on GitHub. The contribution graph on GitHub is based on the commit timestamps, and modifying the dates of old commits can alter the appearance of your contribution history.

When you change the dates of old commits and force-push the modified commits to a repository on GitHub, the contribution graph will reflect the updated dates. This can result in changes to the number and distribution of commits across different days, weeks, or months.

...

If you modify the date of a commit to make it the only commit on a particular day, and you push that modified commit to a repository on GitHub, then the contribution graph will reflect that change. The day will be updated from a 0 count to a 1 count for that day on the contribution graph.

GitHub's contribution graph considers the presence of at least one commit on a day to determine the count of contributions for that day. So, if you modify the date of an old commit and it becomes the only commit on a specific day, it will be counted as a contribution for that day, and the contribution graph will reflect the updated count.

...

But... if you change the dates of old commits, the overall count of your contributions on a given day may not change significantly unless you modify the most recent commit made on that day.

---

**HOW IT WORKS: Sets author and committer date**

```
git filter-branch -f --commit-filter '

if [ "$GIT_COMMIT" = "905ff634cc4766ab0a146af930abd7e0ab20d131" ]; then

GIT_AUTHOR_DATE="May 28 18:20 2023 -0700"

GIT_COMMITTER_DATE="May 28 18:20 2023 -0700"

git commit-tree "$@"

else

git commit-tree "$@"

fi' -- --all;
```

Replace the long hash of the commit and the two dates. Do not use short hash.

Ambiguous warnings: Warnings are actually fatal errors.They stop the date rewriting from working. Git needs to work on their error reporting more.

If `WARNING: Ref 'refs/heads/main is unchanged` , likely your hash is wrong or you are using the short hash which is wrong. You need the long SHA-1 Hash([https://stackoverflow.com/questions/454734/how-can-one-change-the-timestamp-of-an-old-commit-in-git](https://stackoverflow.com/questions/454734/how-can-one-change-the-timestamp-of-an-old-commit-in-git))

If `Warning: previous backup already exists in refs/original/.... Force overwriting the backup with -f`  will ignore your new commit dates rewriting too. But that's prevented by adding a -f already

---

**FUTURE PROOF**: The above works (either How it works and Automation workflow) so far in 2023 Q2. But in case it no longer sets the author date (but able to set the commit date)

```
git rebase -i --root

:

%s/pick/edit/g

:wq
```
  

```
GIT_COMMITTER_DATE="May 21 18:20 2023 -0700" GIT_AUTHOR_DATE="May 21 18:20 2023 -0700"

git commit --amend --no-edit --reset-author --date="May 21 18:20 2023 -0700"; git rebase --continue;
```

^ The 'no-edit' will suppress it asking for you to rename the message. The 'reset-author' will more guarantee you can reset the date

^ On newer version of git, it won't let you rewrite a committer date of an old commit like this. It'll just be ignored. But run this command as usual because it'll affect the author date

Make sure to remove the two dates so your subsequent commits won't be locked into that date:

```
unset GIT_COMMITTER_DATE; unset GIT_AUTHOR_DATE;
```