# Coding Snippets and Guides

By Weng Fei Fung. Working on making my coding snippets and guides sharable and contributable between a separate repository here and my front app at https://wengindustry.com/devbrain

### Mac workflow Obsidian to Terminal: 
I am authoring the curriculum separately inside an Obsidian MD vault. I can manage the git repository by right clicking the curriculum folder in Obsidian -> Reveal in Finder -> New Terminal at Folder (on the highlighted folder in Finder). Now I can run git and other terminal commands.

### Enhanced markdown for brain notes app
- Having `[[TOPIC_TITLE]]` will create a link that opens topic of such name
- Having this syntax will add collapsible sections (HTML equivalent of details>summary+\*):
```
> [!note] HEADING
> Content
> Content
```
- Having this KaTeX (subset of LateX) or AsciiMath syntax will format math equations into easy to read format (Like exponentials are rendered as actually superscripts):
```
`$E = mc^2$`
`@(1/2[1-(1/2)^n])/(1-(1/2))=s_n@`
```

### Server pipelines
My apache server has a script I can trigger from my local machine. ~~When triggering from my local machine, it tunnels SSH then runs a script at the server to fetch then reset hard to origin/main.~~ I created a npm script called `deploy` to streamline the server pipeline and it works by staging and committing most recent files changes, pushing to Github repository, then opening a PHP file with the secret token to have the remote server perform a git fetch and git reset. There is no pulling or merging because I'm not editing from the server and want to prevent the pipeline from being broken when there's a chance of merge conflicts that require manual interaction from the user.

In order for the server pipeline to work, I made sure there is good file permissions at SSH that allows the script uploaded by my FTP’s user’s group to have group write permissions to the folder the script write files to. If the script or the folder doesn’t have the same group ownership, I make sure they do by changing the group owners recursively on the folder with ``sudo chgrp -R GROUP FOLDER`.`` Finally, I made sure the owner group has write permission on the folder `sudo chmod -R g+w FOLDER`. In addition, since I occasionally connect remotely into SSH with root access, I add root to that group in case I might edit files on the fly during a SSH session (like vim, nano, emacs): `usermod -a -G GROUP root`