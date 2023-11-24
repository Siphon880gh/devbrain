
The command `java -jar bfg-1.14.0.jar` is used to execute a Java application that is packaged as a JAR (Java Archive) file, using the Java Runtime Environment (JRE). In this specific instance, the JAR file is named bfg-1.14.0.jar.
The bfg part of the filename suggests that this JAR might be the BFG Repo-Cleaner, which is a tool that can be used to remove large or troublesome blobs like git-lfs tracked files from your git repositories, making them smaller. The 1.14.0 part is likely the version number of the tool.

When you run the command:
1. java is the Java command-line tool that launches Java applications.
2. -jar tells the Java tool to interpret the following argument as a filename of a JAR file to run.
3. bfg-1.14.0.jar is the JAR file to be executed.

So if bfg-1.14.0.jar is indeed the BFG Repo-Cleaner, running this command without any additional arguments typically prints out the help message or usage information for the tool. To actually clean a repository with BFG, you would need to specify additional arguments and options along with the command, as per the tool’s documentation.

---


To make java cli work:
`java -jar bfg-1.14.0.jar`

For example move bfg-1.14.0.jar  to /usr/local/bin  so can use bfg to remove a file from git commit history.
But java -jar bfg-1.14.0.jar  didn’t work
Which makes this alias in .bash_profile useless: `alias bfg='java -jar /usr/local/bin/bfg-1.14.0.jar'

### Instructions to install the java cli

1. Check if you have java installed with java -version   Example success:
```
openjdk version "21.0.1" 2023-10-17
OpenJDK Runtime Environment Homebrew (build 21.0.1)
OpenJDK 64-Bit Server VM Homebrew (build 21.0.1, mixed mode, sharing)
```


2. Install via brew or whatever package manager your os uses:
`brew install openjdk`

3. Link appropriately (follow the command at the end of brew openjdk installation). On this particular mac:
`sudo ln -sfn /opt/homebrew/opt/openjdk/libexec/openjdk.jdk /Library/Java/JavaVirtualMachines/openjdk.jdk`

4. Make alias at .bash_profile or .zshrc, whatever is appropriate:
```
# bfg is a tool to remove large files from git history
alias bfg='java -jar /usr/local/bin/bfg-1.14.0.jar'
```