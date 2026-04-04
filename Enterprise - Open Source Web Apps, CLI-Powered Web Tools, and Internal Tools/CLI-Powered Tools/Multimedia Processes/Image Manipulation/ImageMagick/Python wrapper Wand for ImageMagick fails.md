

You can access ImageMagick in the backend with PHP, Python, etc. For example, **Python’s Wand** is a python wrapper that can access imagemagick which can manipulate images

---


As for Wand, if you’re getting errors, then you need to save the MAGICK_HOME path to .bash_profile / .zshrc

Hint: you can get install path if installed via brew:
`brew --prefix imagemagick`

---



**Check Dylib Links**: The `wand` library looks for the `.dylib` files associated with ImageMagick. Verify that these files exist in a location that `wand` is checking. The typical location for these with Homebrew should be `/usr/local/lib/` or `/opt/homebrew/lib/` depending on your system architecture.

You can check this directory to ensure the ImageMagick libraries are there:

```bash
    ls /usr/local/lib/libMagick* # For Intel chips
    ls /opt/homebrew/lib/libMagick* # For Apple Silicon (M1/M2 chips)
```

If you don't find the libraries in the expected directory, you might need to link them manually or find out where Homebrew has installed them.

---

Does the python wrapper insist on finding .so file when your system is Mac? You may have to link to the dylib file if the Python keeps insisting to use .so file extension (which is typical of Linux systems but not of Mac)

