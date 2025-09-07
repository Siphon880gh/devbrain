## When You Might Use Pull Requests (As an approved contributor or author)

You’ve been approved as a **contributor** (or you are the **author/maintainer**) of the repository, and you’re following best practices for collaboration:

- ✅ **Branching workflow**: Locally, you created a feature branch or fix branch instead of editing the `main` branch directly.
- ✅ **Push branch**: You pushed your branch to the remote repository (e.g., `origin/feature-xyz`).
- ✅ **Integration point**: Now you need your work merged into the `main` (or sometimes `develop`/another protected branch).

At this stage, **a pull request (PR)** is the formal way to propose merging your branch. It provides a place for:

- Code review from other contributors
- Automated checks (CI/CD pipelines, linting, tests).
- Discussion or documentation of the changes.

---

Requirement: You’ve already pushed your feature or fix branch to the remote repository. Now you’re ready to create a pull request to merge that remote branch into the remote `main` branch (or `develop` branch, if that’s your team’s workflow).

## Creating Pull Request

Click "Pull Requests" tab:
![[Pasted image 20250511031613.png]]

Then click "New pull request"
- That "Compare & pull request" is a recommendation on the type of pull request
![[Pasted image 20250511031647.png]]

At the next page, select the branch you're merging into main (usual situation):
![[Pasted image 20250511031749.png]]


Then click "Create pull request" button
![[Pasted image 20250511031536.png]]

Then you are given the opportunity to name the pull request and add details (under description):
- Click "Create pull request" button when ready
![[Pasted image 20250511031836.png]]

## Approving Pull Requests

At the same "Pull Requests" tab:

![[Pasted image 20250511032559.png]]

You can open the pull request (here is called "Another branch").

![[Pasted image 20250511032820.png]]

Then you can either choose to Merge the pull request, OR to cancel the pull request
- Merging: Note that if you have more restrictive settings on the Github repo, it may require that only a different contributing user than the pull request user can merge. You click the green "Merge pull request" button. It will appear as:
  ![[Pasted image 20250511033140.png]]
- Cancelling: Press gray "Close pull request" button. Cancelling will appear as closed:
  ![[Pasted image 20250511032907.png]]
  And you can reverse the closed pull request, by pressing the gray "Close pull request" button
  ![[Pasted image 20250511033032.png]]

---

Note you can add a comment about the merging or cancelling.