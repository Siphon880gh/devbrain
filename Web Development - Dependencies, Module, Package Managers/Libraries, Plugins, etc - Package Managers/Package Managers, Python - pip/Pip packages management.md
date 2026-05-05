See all packages
pip freeze > requirements.txt

This will give you locally installed packages
pip freeze --local > requirements.txt
But likely it’ll still list too many packages. In that case, next time use a virtual environment to install pip packages to make this more manageble

And you can install off the requirements.txt with:
pip install -r requirements.txt

---

See all packages
pip list

See if a package exists / was installed with pip
 pip list | grep numpy


---

Many packages are installed off https://pypi.org/

If version compatibility issues, visit the two packages and see the Release History to align the version numbers with their respective dates in your pip installation 

---

To install a specific version
```
pip install package_name==version_number
```