Quick review:
.gitignore:
**/compress/test-area

If already exists:
1. Add to .gitignore

2. Add all files to stage for now
git add .

3. Remove desired files/folders from stage
git rm -r --cached <folder>
git rm --cached <file>

If removing folders recursively:
git rm -r --cached **/<folder>

4. Commit
Git commit -m "...