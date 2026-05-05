
There are packages whose authors like to deprecate and change language entirely often. When you see a deprecated message, you may want to start figuring out the version of the packages being used, then put in your readme the specific versions

You can even use a version range with `pip install` command. Something like this:

```bash
pip install 'stevedore>=1.3.0,<1.4.0'
```

And if the package is already installed and you want to downgrade it add `--force-reinstall` like this:

```lua
pip install 'stevedore>=1.3.0,<1.4.0' --force-reinstall
```

---

More practical:
```
pip install "antigravity<1.0"
```

---

You may want to find the current version of a package when you see deprecated message. Make sure to also check the other packages' versions too if they are piped or worked together with your one package with a deprecated warning

To find the version of a currently installed package in Python, you can use one of the following methods:

1. **Using pip**:

   You can list all installed packages and their versions with the command:

   ```bash
   pip list
   ```

   To find the version of a specific package, you can use the command:

   ```bash
   pip show package_name
   ```

   Replace `package_name` with the name of the package you're interested in. This command will give you detailed information about the package, including its version.

2. **Using Python code**:

   You can also find the version of an installed package with a Python script. Most packages have a `__version__` attribute you can print out:

   ```python
   import package_name
   print(package_name.__version__)
   ```

   Replace `package_name` with the actual name of the package. Not all packages follow this convention, so this method might not work universally.

3. **Using the `pkg_resources` module**:

   The `pkg_resources` module that comes with `setuptools` can be used to find a package's version:

   ```python
   import pkg_resources
   pkg_resources.get_distribution('package_name').version
   ```

   Again, replace `package_name` with the actual name of the package.

Choose the method that best fits your needs. If you are working within a script or an application, you might prefer to use the Python code approach. If you're working on the command line and just need to quickly check a version, `pip` is very convenient.