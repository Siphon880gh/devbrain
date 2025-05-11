
Do not mix local git repository with cloud syncing.

So your folder that git is tracking should not be in a Google Drive, One Drive, or Apple Cloud folder on your computer. Reason is because when you do rebase , syncing could corrupt your previous gits. Regular git committing wouldn't have glitches.

If you have a glitched commit from rebasing because the files are on a sync folder, future rebasing will ask you to run --edit-todo or to merge conflicts, but there won't be conflicts for you to resolve.