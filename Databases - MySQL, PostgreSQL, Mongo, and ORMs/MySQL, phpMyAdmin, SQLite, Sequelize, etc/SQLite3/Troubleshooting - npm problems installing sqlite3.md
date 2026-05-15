# Troubleshooting - npm problems installing sqlite3

You are installing sqlite3 for a npm project but run into one of the following errors:

## Troubleshooting - No Xcode or CLT version detected

Problem: The terminal is looking through all the paths indicated in the environment variable $PATH but still cannot find the Xcode CLI. Tools
Solution: Update $PATH variable.

Get the Xcode path
```
xcode-select --print-path
```

On Mac, you add to $PATH in either ~/.bash_profile or ~/.zshrc depending on the shell you are using. Use the path you got from --print-path and /Library/Developer/CommandLineTools:
```
export PATH="/Applications/Xcode.app/Contents/Developer:/Library/Developer/CommandLineTools:$PATH"
```

Restart the terminal or run `source ~/.bash_profile` or equivalent, to apply the settings.

To confirm the new $PATH applies, run:
```
echo $PATH
```

## Troubleshooting - No such file or directory but the file path it gives you is cut off

Notice the folder name is cut off where there'd be a space? Make sure all folders leading to the folder where you are installing sqlite3 does not have space characters. Dashes and underscores are suitable replacements for spaces.

## Troubleshooting - Libtool: unrecognized option -static

It complained about the command libtool not having the option static. Your computer may have multiple versions of libtool and it's linking to the wrong version of libtool that does not support static option.

See where libtool is linked (likely incorrectly to MAMP/LAMP if you have it installed):
```
which libtool
```

If libtool is not linked to `/usr/bin/libtool` or  `/usr/local/bin/libtool`, then you will relink it to that correct version (it's either of that depending on your Mac setup). Basically you want to hard link the wrong path so whenever the system is visiting that path, it's actually visiting the second path.

First go to the wrong path /Applications/MAMP/Library/bin/ and rename libtool to something else like libtool_original.

The ln command does not complain if the path does not exist. So find out if `/usr/bin/libtool` or `/usr/local/bin/libtool` exists by using `ls`:
```
ls /usr/bin/libtool
ls /usr/local/bin/libtool
```

When you are sure you have the right paths, then create the symbolic link:
```
sudo ln -s /Applications/MAMP/Library/bin/libtool /usr/bin/libtool
```