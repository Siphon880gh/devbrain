TLDR:  
`git-blame` shows what revision and author last modified each line of a file. It's like checking the history of the development of a file.

---

`git blame` is a Git command that shows **who last changed each line of a file**, along with the commit hash, author name, date, and line number.

It is useful when you are reviewing a file and want to understand where a specific line came from.

The information displays on the terminal. However if you install the plugin [vim-fugitive](https://github.com/tpope/vim-fugitive), then you can view the information while navigating inside vim, the in-console text editor.

![[Pasted image 20260430141653.png]]

---
## Basic Example

```bash
git blame .htaccess
```

Example output:

```bash
^e1fb2d7 (John Doe    2015-07-03 06:30:25 -0300  4) allow from all
^72fgsdl (Arthur King 2015-07-03 06:34:12 -0300  5)
^e1fb2d7 (John Doe    2015-07-03 06:30:25 -0300  6) <IfModule mod_rewrite.c>
^72fgsdl (Arthur King 2015-07-03 06:34:12 -0300  7)     RewriteEngine On
```

## How to Read the Output

Each line tells you:

```bash
commit_hash (author_name date time timezone line_number) file_content
```

For example:

```bash
^e1fb2d7 (John Doe 2015-07-03 06:30:25 -0300  4) allow from all
```

This means:

- `^e1fb2d7` is the commit related to that line.
    
- `John Doe` is the person Git says last changed that line.
    
- `2015-07-03 06:30:25 -0300` is when that commit happened.
    
- `4` is the line number.
    
- `allow from all` is the actual content of the file on that line.
    

## What `git blame` Is Really Showing

`git blame` does **not** show the full history of every edit to a line.

It shows the **most recent commit that changed each line**, based on the version of the file you are looking at.

In simpler terms:

> `git blame` answers: “Who last touched this line?”

It does **not** fully answer:

> “What is the complete history of this line?”

## Important Limitation

A line may have been edited many times in the past.

However, `git blame` only shows the commit that Git considers responsible for the current version of that line.

For example, if a line was created by John, edited by Arthur, and later changed again by Maria, `git blame` will usually show Maria, because Maria made the latest change to that line.

## Why This Matters

This is important when you are investigating a problem.

You should avoid assuming that the person shown by `git blame` is the person who originally wrote the line or caused the issue.

They may have only:

- reformatted the line
    
- moved the line
    
- fixed a small typo
    
- changed nearby code
    
- touched the file during a larger cleanup
    

So treat `git blame` as a starting point, not final proof.

## Check a Specific Line Range

You can limit `git blame` to a specific line or group of lines:

```bash
git blame -L 4,7 .htaccess
```

This shows blame information only for lines 4 through 7.

That is useful when the file is large and you only care about one section.

## View the Commit Behind a Line

Once you find a commit hash, inspect it with:

```bash
git show e1fb2d7
```

This shows the commit message and the exact changes made in that commit.

If the blame output shows a caret like this:

```bash
^e1fb2d7
```

you can usually still run:

```bash
git show e1fb2d7
```

The `^` often means Git traced that line back to the beginning of the available history.

## Better Investigation Flow

A good workflow is:

```bash
git blame .htaccess
```

Then copy the commit hash for the line you care about:

```bash
git show COMMIT_HASH
```

Then, if needed, check the history of the file:

```bash
git log -- .htaccess
```

You can also see patches for that file’s history:

```bash
git log -p -- .htaccess
```

## Quick Summary

`git blame` shows **the last commit that changed each line in a file**.

It is helpful for finding context, but it is not the full chronological edit history of a line.

Use it together with:

```bash
git show COMMIT_HASH
git log -- filename
git log -p -- filename
```

That gives you a clearer picture of what changed, when it changed, and why.

----

## Just for fun - Blame someone else

This can change the authorship of commits, and hence what appears in git blame, allowing you to blame other team members instead for certain lines.

Don't actually use this in a serious project or professional setting

https://github.com/jayphelps/git-blame-someone-else

Usage:
```
git blame-someone-else <author> <commit>
```