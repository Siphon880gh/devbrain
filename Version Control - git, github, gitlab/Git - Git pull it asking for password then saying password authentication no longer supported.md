
Check if your git remote origin points to a http or a ssh styled URL. It must be ssh styled URL to use passwordless ssh authentication. To setup passwordless ssh authentication globally, refer to [[Git - New computer or server that needs to connect with passwordless SSH authentication]]


Check that your Git remote URL is using the SSH format, not the HTTPS format. Run:
```
git remote -v
```

If you see URLs starting with `https://`, you need to change them to the SSH format. Copy it from your github repo page. Looks similar to:
```
git remote set-url origin git@github.com:your-username/your-repository.git
```

Now try git pulling