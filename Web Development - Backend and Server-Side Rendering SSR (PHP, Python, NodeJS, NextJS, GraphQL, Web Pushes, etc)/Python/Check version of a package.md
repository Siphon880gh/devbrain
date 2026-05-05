In Python, you can check the version of an installed module using the module's `__version__` attribute or by using the `pkg_resources` module provided by `setuptools`. Not all modules have a `__version__` attribute, but many popular ones do. Here's how you can check the version using both methods:

### Using `__version__` Attribute

Most well-maintained Python modules provide a `__version__` attribute. You can access it like this:

```python
import some_module

print(some_module.__version__)
```

Replace `some_module` with the name of the module you're interested in. If the module follows standard practices, this will print the version number.

### Using `pkg_resources` Module

If the module does not provide a `__version__` attribute, or you want another way to check, you can use `pkg_resources`:

```python
import pkg_resources

version = pkg_resources.get_distribution('some_module').version
print(version)
```

Again, replace `some_module` with the name of the module. This method works by querying the package metadata installed by `pip`.

### Example

If you want to check the version of a well-known module like `numpy`, you could use:

```python
import numpy

print(numpy.__version__)
```

Or:

```python
import pkg_resources

print(pkg_resources.get_distribution('numpy').version)
```

Both methods should give you the version number of `numpy`.

### Note

- Not all modules define a `__version__` attribute. If you encounter an `AttributeError`, it means the module does not have this attribute, and you should use the `pkg_resources` method.
- The `pkg_resources` method requires that the module was installed using a tool that records package metadata, like `pip`. This method might not work with modules installed in other ways (e.g., manually copying files).
- Always ensure that you have `setuptools` installed in your environment, as `pkg_resources` is a part of `setuptools`. Most Python environments, especially those that use `pip`, will have `setuptools` installed by default.