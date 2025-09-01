Vi is a useful cli text editor to quickly edit/create/read text files.

Git? Vi is needed for more advance commands in Git cli. For example, you can change a list of commit history and it's displayed in a temporarily opened text file for you to rewrite in vi.

- When you are in INSERT MODE, you edit the text and move the text cursor with arrow keys, both like you would on a text editor. Copy and paste shortcut commands work though it may be limited by the shell are you using.

- When you are in COMMAND MODE, you can either type or press commands.

- Typing : will let you type command(s) at the bottom of the CLI text screeen.
- :%d delete all lines
- :wq means to write and quit vi
- :q! means to quit vi without saving.
- Press enter to commit the commands (leave blank to exit out of typing commands)

In addition to writing commands, you can press commands.
- D pressed twice deletes a line of text.
- W lets you jump forward a word. 
- B jumps back a word.
- $ jumps to end of a line (think Regular Expression)
- ^ jumps to start of a line (think Regular Expression)

Searching in command mode is a combination of writing and pressing commands.
- Type / instead of :
- Example: /token
- Commit with Enter
- N pressed searches next match
+ SHIFT+N pressed goes to previous match

SWITCH beteween the modes:
- Escape from Insert mode goes to Command Mode
- A / I pressed from Command Mode goes to Insert Mode
    - I inserts text left of the text cursor.
    - A inserts text right of the text cursor, aka append.

Here is a cheat sheet for vi:
http://www.atmos.albany.edu/daes/atmclasses/atm350/vi_cheat_sheet.pdf