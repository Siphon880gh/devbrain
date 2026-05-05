cannot load library 'libcairo.so.2': dlopen(libcairo.so.2, 0x0002): tried: 'libcairo.so.2' (no such file),


The error message indicates that Python is unable to find the libcairo.so.2 shared library file on your macOS system. On macOS, shared libraries use the .dylib extension rather than .so, which is typical on Linux systems.


Create a symlink (if necessary):
As a last resort, if the Python package is stubbornly looking for a .so file, you might need to create a symbolic link from libcairo.so.2 to libcairo.dylib. This is not a standard solution and should be done with caution as it could potentially interfere with other operations on your system.
shCopy code
ln -s /path/to/libcairo.dylib /usr/local/lib/libcairo.so.2

^ actually you need to correct the paths (second path is what the error complained about whose path it can’t find, and the first path is homebrew prefixed path)

Ends up being on this current Mac:
sudo ln -s /opt/homebrew/opt/cairo/lib/libcairo.2.dylib /opt/homebrew/opt/libcairo.so.2 