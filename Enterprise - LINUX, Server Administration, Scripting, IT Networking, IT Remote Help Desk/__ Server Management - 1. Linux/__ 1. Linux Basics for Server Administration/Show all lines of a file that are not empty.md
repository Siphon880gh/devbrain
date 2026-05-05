Command
```
cat <filename> | awk NF
```


Example:
```
cat config.yaml | awk NF
```


  
The Bash command `cat config.yaml | awk NF` performs the following actions:

1. **`cat config.yaml`:** This part uses the `cat` command to read the contents of a file named `config.yaml`. The `cat` (short for concatenate) command is commonly used in Unix-like operating systems to display the contents of a file, concatenate files, and redirect output in terminal or command line environments.
    
2. **`|`:** This is a pipe. It takes the output of the command on its left (in this case, `cat config.yaml`) and passes it as input to the command on its right.
    
3. **`awk NF`:** This part uses the `awk` command, a powerful text processing and pattern scanning language. `awk` processes and analyzes text line by line. `NF` is a built-in variable in `awk` that represents the number of fields in the current record (where a record is typically a line). In the context of `awk NF`, it acts as a condition that returns true if the number of fields in a line is non-zero (i.e., the line is not empty). When used this way without any action specified, `awk` defaults to printing the line. So, `awk NF` will print all lines that are not empty.
    

In summary, this command reads the contents of `config.yaml`, and then `awk NF` filters out all the empty lines, printing only the lines that contain text. This can be useful for viewing a configuration file while ignoring blank lines that might be present for formatting or readability.