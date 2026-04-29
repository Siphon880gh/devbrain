Setup this at your .bash_profile or .z_profile:

```
# SCRIPT MANAGEMENT
# Great for managing a folder of scripts (conf, sh, etc).
# Enhances cat to show header and line numbers. Args are space separated filenames.
# No args is display all files in the current folder
hcat() {
  if [ $# -eq 0 ]; then
    for f in *; do
      [ -f "$f" ] || continue
      echo "===== $f ====="
      nl -ba "$f"
    done
  else
    for f in "$@"; do
      if [ -f "$f" ]; then
        echo "===== $f ====="
        nl -ba "$f"
      else
        echo "File not found: $f"
      fi
    done
  fi
}
```

Running the command `hcat` without filenames will show all script file contents at the present folder, along with filenames and line numbers.

With filename(s), it'll only show the file contents belonging to those filenames passed in as arguments.

**Namesake**: `cat *` would show all the files' contents in the present working directory. `hcat` is a wordplay of headers with cat command.