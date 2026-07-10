A Git commit records more than the files that changed. It also stores identity information, including:

- The **author name and email**
    
- The **committer name and email**
    
- The author date
    
- The committer date
    
- The commit message
    
- The parent commit or commits
    
- A snapshot of the repository
    

Because this information is part of the commit itself, changing an author name or email address creates a new commit with a new commit hash. When an older commit changes, every descendant commit must also be recreated because each commit points to its parent’s hash.

That is why correcting Git authorship can range from a simple one-command amendment to a repository-wide history rewrite.

## Author Versus Committer

Git stores two identities in each commit:

- The **author** is the person credited with originally writing the change.
    
- The **committer** is the person who created or applied that particular Git commit.
    

For example, one developer may create a patch while a project maintainer applies it. The developer remains the author, while the maintainer becomes the committer.

You can inspect both identities with:

```bash
git log --format=fuller
```

For a compact custom view:

```bash
git log --format='%h%n  Author:    %an <%ae>%n  Committer: %cn <%ce>%n  Subject:   %s%n'
```

The placeholders include:

```text
%an  Author name
%ae  Author email
%cn  Committer name
%ce  Committer email
%h   Abbreviated commit hash
%s   Commit subject
```

## Configure the Correct Identity for Future Commits

Before rewriting old commits, make sure new commits will use the correct identity.

Set the identity for the current repository:

```bash
git config user.name "Weng Example"
git config user.email "weng@example.com"
```

This writes the settings into the repository’s local `.git/config` file.

To use the identity as the default across repositories:

```bash
git config --global user.name "Weng Example"
git config --global user.email "weng@example.com"
```

Check the effective values:

```bash
git config user.name
git config user.email
```

To see where the values came from:

```bash
git config --show-origin --get-regexp '^user\.(name|email)$'
```

A repository-local setting normally overrides the global setting.

Changing `user.name` and `user.email` affects future commits. It does not retroactively modify existing history.

# Correcting the Latest Commit

The latest commit is the easiest commit to correct.

## Set an Explicit Author

To change the author of the latest commit while keeping its files and message unchanged:

```bash
git commit --amend \
  --author="Weng Example <weng@example.com>" \
  --no-edit
```

The options mean:

- `--amend` replaces the current commit.
    
- `--author` explicitly sets the author identity.
    
- `--no-edit` keeps the existing commit message.
    

Git’s `--author` option expects the conventional format:

```text
Name <email@example.com>
```

It overrides the commit author, but the committer will normally be the person running the amendment.

Verify the result:

```bash
git show --format=fuller --no-patch HEAD
```

## What `--reset-author` Actually Resets

When you amend a commit, Git normally preserves the original author. This is useful when the committer is applying someone else’s work.

Sometimes, however, you want the amended commit to belong to the person currently making the amendment. That is what `--reset-author` does:

```bash
git commit --amend --reset-author --no-edit
```

**`--reset-author` resets the commit’s author to the current committer identity and renews the author timestamp.**

The identity usually comes from your current Git configuration:

```bash
git config user.name
git config user.email
```

Git documents `--reset-author` as declaring that authorship of the resulting commit belongs to the committer. It applies when amending, reusing another commit’s message, or committing after certain conflicting cherry-picks.

Use:

```bash
git commit --amend \
  --author="Specific Person <specific@example.com>" \
  --no-edit
```

when you need to assign a particular author.

Use:

```bash
git commit --amend --reset-author --no-edit
```

when the person currently committing should become the author.

`--reset-author` is not a repository-wide history command. It only affects the commit currently being created or amended.

# Correcting an Older Commit

To modify a commit farther back in the current branch, use an interactive rebase.

Suppose the incorrect commit is somewhere among the last five commits:

```bash
git rebase -i HEAD~5
```

Git opens an instruction list similar to:

```text
pick a8d4102 Add login form
pick 74ac932 Connect login API
pick 18e71dd Add validation
pick b13bc8f Improve error handling
pick e749214 Update documentation
```

Change `pick` to `edit` for the commit whose author needs correction:

```text
pick a8d4102 Add login form
edit 74ac932 Connect login API
pick 18e71dd Add validation
pick b13bc8f Improve error handling
pick e749214 Update documentation
```

Save and close the editor. Git will stop after applying that commit.

Assign a specific author:

```bash
git commit --amend \
  --author="Weng Example <weng@example.com>" \
  --no-edit
```

Or make the current committer the author:

```bash
git commit --amend --reset-author --no-edit
```

Then continue:

```bash
git rebase --continue
```

Repeat the amendment process if you marked more than one commit as `edit`.

Interactive rebase recreates the selected commits and their descendants, so their hashes change. Git’s documentation warns against casually rebasing commits that other developers already use.

## Starting From a Specific Commit

To edit a known commit, start the rebase from its parent:

```bash
git rebase -i <commit-hash>^
```

For example:

```bash
git rebase -i 74ac932^
```

To include the repository’s first commit:

```bash
git rebase -i --root
```

## Recovering From a Rebase Problem

Cancel an in-progress rebase:

```bash
git rebase --abort
```

After a completed rewrite, the reflog can often help locate the previous branch state:

```bash
git reflog
```

A precautionary backup branch is also useful:

```bash
git branch backup-before-author-rewrite
```

# Changing Many Commits

Interactive rebase works well for a few commits. It becomes cumbersome when dozens, hundreds, or thousands of commits contain an incorrect name or email.

For a broad rewrite, use `git filter-repo`.

`git filter-repo` is designed to rewrite repository history using programmable filters. Its documentation emphasizes that this is a destructive operation: it creates replacement objects and removes the original history from the rewritten repository. It therefore includes a safety check that normally refuses to run unless the repository appears to be a fresh clone.

## Use a Mailmap for Identity Corrections

A mailmap describes how old identities should map to canonical identities.

Create a file outside or inside the disposable clone, such as:

```text
authors.mailmap
```

To replace every occurrence of an old email, regardless of the recorded name:

```text
Weng Example <weng@example.com> <old-address@example.com>
```

To match both a particular old name and old email:

```text
Weng Example <weng@example.com> Weng Oldname <old-address@example.com>
```

The general format is:

```text
Correct Name <correct-email> Old Name <old-email>
```

Git’s mailmap syntax also supports changing only an email address:

```text
<correct-email> <old-email>
```

Mailmap matching is case-insensitive.

Run the rewrite:

```bash
git filter-repo --mailmap authors.mailmap
```

This permanently rewrites matching author, committer, and tagger names and email addresses. The filter-repo documentation specifically states that `--mailmap` applies the mappings while rewriting authors, committers, and taggers.

You can also place the mappings in the repository’s `.mailmap` file and run:

```bash
git filter-repo --use-mailmap
```

That is equivalent to:

```bash
git filter-repo --mailmap .mailmap
```

## Changing Only Authors, Not Committers

A mailmap applies to authors, committers, and taggers. When only the author identity should change, use a commit callback:

```bash
git filter-repo --commit-callback '
if commit.author_email == b"old-address@example.com":
    commit.author_name = b"Weng Example"
    commit.author_email = b"weng@example.com"
'
```

The `b` prefix represents a Python byte string, which is the form used by the filter-repo callback interface.

You can make the condition more exact:

```bash
git filter-repo --commit-callback '
if (
    commit.author_name == b"Weng Oldname"
    and commit.author_email == b"old-address@example.com"
):
    commit.author_name = b"Weng Example"
    commit.author_email = b"weng@example.com"
'
```

This avoids changing another contributor who happened to use the same name or a similar address.

## Changing Every Matching Email Field

An email callback can replace an address anywhere filter-repo processes an identity:

```bash
git filter-repo --email-callback '
return email.replace(
    b"old-address@example.com",
    b"weng@example.com"
)
'
```

This is concise, but broader than an author-only callback. It can affect author, committer, and tagger emails.

# Correct the Display Without Rewriting History

Sometimes the repository is already public and rewriting every commit would cause more disruption than the incorrect identity is worth.

In that case, add a `.mailmap` file without running `git filter-repo`:

```text
Weng Example <weng@example.com> <old-address@example.com>
```

Then view the corrected identities with mailmap-aware commands:

```bash
git log --use-mailmap
git shortlog --use-mailmap -sne
```

This changes how Git displays and groups identities without changing the underlying commits or their hashes. Git describes `.mailmap` as a mapping between recorded identities and canonical names or email addresses.

This is often the safest choice for established open-source repositories.

# Verifying a Rewrite

Before pushing anything, inspect the resulting identities.

List all unique author identities:

```bash
git log --all --format='%an <%ae>' |
  sort |
  uniq
```

List all unique committer identities:

```bash
git log --all --format='%cn <%ce>' |
  sort |
  uniq
```

Search for the old email:

```bash
git log --all \
  --format='%H %an <%ae> | %cn <%ce>' |
  grep 'old-address@example.com'
```

No output generally means that address no longer appears in the reachable author or committer history being searched.

You can also count commits by identity:

```bash
git shortlog --all -sne
```

For critical repositories, compare the old and new trees or run the project’s test suite before publishing rewritten history.

# Publishing Rewritten History

A rewritten branch no longer has the same linear history as the branch on the remote server. A normal push will usually be rejected.

For a single rewritten branch:

```bash
git push --force-with-lease origin main
```

`--force-with-lease` is safer than plain `--force` because it checks that the remote branch still has the value you expect. If someone else has updated the remote branch since your last fetch, the push can be rejected instead of blindly overwriting their work.

After `git filter-repo`, the `origin` remote may have been removed as a safety measure. Check:

```bash
git remote -v
```

Add it back when you are certain the rewritten repository is correct:

```bash
git remote add origin <repository-url>
```

Then push only the refs that are supposed to be replaced.

A repository-wide rewrite affecting branches and tags requires careful coordination with everyone who has a clone. Existing clones still contain the old commits and can accidentally reintroduce them. In many cases, collaborators should create a fresh clone after the rewrite.

# Choosing the Right Method

Use the smallest tool that solves the problem:

### Wrong identity only in future commits

```bash
git config user.name "Correct Name"
git config user.email "correct@example.com"
```

### Wrong author in the latest commit

```bash
git commit --amend \
  --author="Correct Name <correct@example.com>" \
  --no-edit
```

### Current committer should become the latest commit’s author

```bash
git commit --amend --reset-author --no-edit
```

### Wrong author in a few older commits

```bash
git rebase -i HEAD~N
```

Mark the commits as `edit`, amend each one, and continue the rebase.

### Wrong identity throughout a private repository

```bash
git filter-repo --mailmap authors.mailmap
```

### Correct reports without changing public history

Create `.mailmap` and use:

```bash
git log --use-mailmap
```

# Final Principle

Git history rewriting does not edit commits in place. It creates replacement commits.

That distinction explains almost everything:

- Commit hashes change.
    
- Descendant commits must also change.
    
- Existing signatures may no longer apply.
    
- Remote branches require a force-style update.
    
- Other clones retain the old history.
    
- Coordination becomes more important as the rewrite grows.
    

For one incorrect commit, use `git commit --amend`. For a few commits, use interactive rebase. For a systematic repository-wide identity correction, use `git filter-repo`. When changing published history would be too disruptive, use `.mailmap` to correct how identities are displayed without replacing the commits.