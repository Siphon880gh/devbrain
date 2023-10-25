
^(?!.*unaccounted).*$


<<
I have  a text file of multiple lines. How to regular search find lines that dont contain the string "unaccounted"

\>>
To find lines in a text file that don't contain the string "unaccounted", you can use regular expressions with negative lookaheads. Here's how you can do it:

1. **Using a Text Editor (e.g., Notepad++, Sublime Text, etc.)**:

   Most modern text editors have a "Find" or "Search" feature that supports regular expressions.

   - Open the text file in your text editor.
   - Open the "Find" or "Search" dialog, usually accessible via `Ctrl + F` or through a menu.
   - Enable the "Regular Expression" option or mode.
   - Enter the following pattern:
     ```
     ^(?!.*unaccounted).*$
     ```
   - Execute the search.

2. **Using `grep` on Unix-based systems (Linux, macOS)**:

   If you're on a Unix-based system, you can use the `grep` command with the `-P` (Perl-compatible regex) and `-v` (invert match) options:

   ```bash
   grep -Pv "^(?=.*unaccounted)" yourfile.txt
   ```

3. **Using Python**:

   Here's a small Python script that will print lines from a file that don't contain the string "unaccounted":

   ```python
   with open('yourfile.txt', 'r') as file:
       for line in file:
           if "unaccounted" not in line:
               print(line, end='')
   ```

Choose the method that best suits your needs and platform.