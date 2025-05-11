

Edit this into .git/config if for per project:
```
[alias]  
    slog = "!f() { \  
    echo 'Main repository commits:'; \  
    git log --oneline; \  
    echo ''; \  
    git submodule foreach 'echo \"Commits for $path:\"; \  
    git log --oneline; \  
    echo \"\"'; \  
}; f"
```



If per globally, run in terminal:
```
git config --global alias.slog "!f() { echo 'Main repository commits:'; git log --oneline; echo ''; git submodule foreach 'echo \"Commits for $path:\"; git log --oneline; echo \"\"'; }; f"
```

Then running `git slog`  will list all main repo commits, followed by each respective submodule’s commits. The slog here is defined by our scripts, slog meaning submodules logs (which also includes main repo logs).