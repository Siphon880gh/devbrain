
This is designed to remove whitespace and newline characters, but only from the beginning and end of the string. It does not remove these characters if they are located in the middle of the string.

Trims spaces and newlines on both ends of the string:
```
let cleanedPassword = txtPassword.text!.trimmingCharacters(in: .whitespacesAndNewlines)
```