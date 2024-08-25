
To get a list of all the packages you've installed via `apt`, you can use the following command in your terminal:

```bash
apt list --installed
```

This will output a list of all the installed packages along with their version numbers and descriptions.

If you want to filter out packages that were manually installed (excluding dependencies), you can use:

```bash
comm -23 <(apt-mark showmanual | sort) <(apt-mark showauto | sort)
```

**CAVEAT**: This command will list only those packages that were explicitly installed by you, not automatically installed as dependencies.