You’re working on a colab and it may be way out of date with the git repo it depends on because there’s a code cell that clones the github repo, then tries to install the python package leading to errors:
```
!git clone githubRepo
```

## Repo

**Then it’s gonna get difficult:**

- Get the date of the Colab, ipynb, or Youtube tutorial you want to work. For the date of the Colab, see if there’s a YouTube video tutorial and that can be your date. Otherwise Google for that Colab to see the date it last indexed which wouldn’t be too long from it last modified.
- You’ll check if you need to install a local python version separate from your Colab python version and switch into that python version, and that version will be on or before the date, assuring compatibility. A python version could be mentioned in myproject.toml (poetry) or .python-version (pyenv), or Pipfile (pipenv but specifying the python version is optional). Make sure to switch to that python version. These package lists have versions, but you can reverse lookup the package’s version for their date on Pypi. Just get the ballpark what date the packages all converge to.

**Decide appropriate branch or a main/master commit, by date**
Get a branch or master/main commit that approx is on or before the Colab or the youtube video tutorial about the Colab. That’s the branch or commit you will clone to your computer.

If the current repo is drastically different (eg. a ui app when the video tutorial covered a cli app, then it likely had a branch. If the developer used branches for major versions like ui vs cli versions, then it’s a good route to look into branches. if the developer used branches only for features or hardly use it, then it might not be the best route to take)

Eg. Main/master commit. See all commits and get the specific commit ID based on date
(if date not specific eg. says last week, then web browser inspect it which has date)

![](https://i.imgur.com/2Enfew2.png)
If looking into branches, you need to visit the branches/all

![](https://i.imgur.com/bTkdSnI.png](https://i.imgur.com/bTkdSnI.png)  

Make sure you’re under “All” tab and not “Overview”. If Updated column shows “months ago” or “years ago”. Inspect for the date

![](https://i.imgur.com/cOBQ1Yd.png](https://i.imgur.com/cOBQ1Yd.png)

**Get into local development**  
To clone a specific branch:
```
git clone --branch <branch-name> <repository-url>
```

Or, to get the desired commit from master/main, you have to clone the default branch, then reset to the desired comment:
```
git clone <repository-url>  
cd <app>  
git reset --hard <commit-id>
```

## Python Packages

Now it’s about installing the python packages. We want python packages to match those of the older repo of the Colab document.

Determine the python versions or dates:
- Open the File Navigator on the left of the Colab document.
- If there is a requirements.txt
	- There likely is a cell that she bangs `pip install`  for the requirements.txt.
- If there is no requirements.txt
	- Your Colab document has cells that installs the packages with specific versions, , eg. `pip install <package>==13.0.0`  
		- → You’re good
	- Your Colab document has cells that installs the package without specific version, eg. `pip install <package>` 
		- **Option 1:** Switch Python and Pip
			- Make sure to switch into the appropriate python version using shebang pyenv commands so you can override colab with an older python and pip
				- Why: Colab as of Oct 19,2024 does not allow you to choose python and pip versions and they default to a specific python/pip. We can switch the python version using pyenv which is installed with their pip.
				- Why: Otherwise shebang pip install might complain the package version is not found; that’s because pip over time can deprecated and remove older versions of packages on their list. 
			- Then install with the pip cells as usual while locked into the older python version via pyenv.
		- **Option 2:** You look up Pypi to figure out appropriate versions to install, for example `pip install package_name==version_number` based on the date on or before

---

## **The rest...**

Once the python packages install successfully, the rest of the Colab document should work.