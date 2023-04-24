# Coding Snippets and Guides

By Weng Fei Fung. Working on making my coding snippets and guides sharable and contributable between a separate repository here and my Gamified Knowledge app at https://github.com/Siphon880gh/gamified-knowledge. Cooking up.

### Mac workflow Obsidian to Terminal: 
I am authoring the curriculum separately inside an Obsidian MD vault. I can manage the git repository by right clicking the curriculum folder in Obsidian -> Reveal in Finder -> New Terminal at Folder (on the highlighted folder in Finder). Now I can run git and other terminal commands.

### Server pipelines
My apache server has a script I can trigger from my local machine. When triggering from my local machine, it tunnels SSH then runs a script at the server to fetch then reset hard to origin/main. There is no pulling or merging because I'm not editing from the server and want to prevent the pipeline being broken by manual merge conflicts.