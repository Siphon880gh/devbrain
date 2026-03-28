It's recommended you setup an alias that opens the skills folder at
```
/Users/<USER>/.agents/skills
```

Note that Cursor AI, Claude, etc (per [[Recommended Setup on Mac - Npx skills]]), agreed to look into .agents path in addition to their own designated paths. There's no point setting this alias to `USERS/<USER>/.cursor/skills` which is Cursor's designated path - why not open the skill to future platforms you might install. 

You can set the alias as `cdskills`. However if you have other platforms like OpenClaw (as of 3/26/26) who hasn't yet agreed to look into that folder path, you'll need to copy the SKILL.md into their path, and then you may need to get a bit more creative with the aliases (for example, `cdocskills` for cd into openclaw skills.

Your ~/.bash_profile etc can be:
```
# - Cursor Skills
function cdskills() {
    cd ~/.agents/skills
    pwd;
}
```

Don't forget to source command that file or restart the terminal

Folders and md files you place there will be accessible in Cursor Chat. So it's a useful alias. Once the terminal cd there, you can run `open .` to open in Finder and move the skill file you found at directories like https://skills.sh