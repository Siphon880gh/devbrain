Add sign off author name and author email to commit messages when commiting message

git log:
![[Pasted image 20250205001139.png]]

git log --oneline:
![[Pasted image 20250205001208.png]]

At `.git/hooks/commit-msg`:
```
SOB=$(git var GIT_AUTHOR_IDENT | sed -n 's/^\(.*>\).*$/Signed-off-by: \1/p')  
grep -qs "^$SOB" "$1" || echo "$SOB" >> "$1"  

test "" = "$(grep '^Signed-off-by: ' "$1" |  
	 sort | uniq -c | sed -e '/^[ 	]*1[ 	]/d')" || {  
	echo >&2 Duplicate Signed-off-by lines.  
	exit 1  
}
```

Explanation:
`git var GIT_AUTHOR_IDENT` retrieves the author's identity in the format:
```
Siphon880gh <weng.f.fung@gmail.com> 1738743300 -0800
```
, and `sed -n 's/^\(.*>\).*$/Signed-off-by: \1/p'` extracts everything up to the > symbol (i.e., the name and email) and prefixes it with "Signed-off-by: " 

How the `test "" = "$(grep...` block which prevents duplicate Signed-off lines from passing:
- Commit message (`$1`):
```
Fix a bug in the login system  
  
Signed-off-by: Alice <alice@example.com>  
Signed-off-by: Alice <alice@example.com>  

```
- `grep` extracts:
    Signed-off-by: Alice <alice@example.com>  
    Signed-off-by: Alice <alice@example.com>  
- `sort | uniq -c`:
    2 Signed-off-by: Alice <alice@example.com>  
- `sed` does not delete this line because `2` is not `1`, leaving:
    2 Signed-off-by: Alice <alice@example.com>  
- `test "" = "2 Signed-off-by: Alice <alice@example.com>"` fails.
- Error message prints:
    Duplicate Signed-off-by lines.  
- `exit 1` aborts the commit.

Had there been no Signed-off duplicates:
- `sort | uniq -c`:    
    `1 Signed-off-by: Alice <alice@example.com>`
- `sed` removes the `1`, leaving an empty output.
- `test "" = ""` passes → No error → Commit proceeds