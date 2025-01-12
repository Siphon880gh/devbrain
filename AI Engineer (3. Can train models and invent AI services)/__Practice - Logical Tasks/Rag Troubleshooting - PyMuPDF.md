
## MyMuPDF module not found from script importing it

### Because of pathing

If you get an error about PyMuPDF module not found... that shouldn’t be the case. It could be another python version is overriding the poetry’s python. So the python version that doesn’t have PyMuPDF is interpretting the script which tries to import PyMuPDF

See if the path to the poetry python is before other python versions because python will be found from left to right from first entry to final entry (`poetry env list` to get a hint whats the folder name called). Run this to see path:
```
python -c "import sys; print(sys.path)"
```

Add and make sure it’s the final PYTHONPATH if any exists at your .bash_profile, .zsrc, etc. Please adjust X.Y to the version number you saw from syst.path:
```
# Poetry  
if command -v poetry &> /dev/null  
then  
        export PYTHONPATH=$(poetry env info --path)/lib/python3.10/site-packages:$PYTHONPATH  
fi
```

Exit and go back into then try poetry shell (Sourcing doesnt work)

You can confirm with above sys.path printing command and/or `pip show PyMuPDF`  to see if pip sees the file

Try ingest.py script or whatever script is analyzing your PDF again. if fails, the problem may be with the pymupdf installation. 

### Because of platform specific PyMuPDF missing
If the package appears installed when you check with pip, but your script claims the package can't be found, you should still install with the platform specific .whl\* file

> [!note] .whl name-sake
> .whl is the final binary of the Python package, thinking back to a cheese wheel that can be easily distributed, like with pip - Python has a lot of Monty Python jokes.

Eg. Apple Macs M1's wheel is named `PyMuPDF-1.24.11-cp38-abi3-macosx_11_0_arm64.whl`. 

Go here to find your correct .whl file.
[https://pypi.org/project/PyMuPDF/#files](https://pypi.org/project/PyMuPDF/#files)  

^ If curious, someone explaining the platform specific .whl files as the fix:
[https://stackoverflow.com/questions/68644003/pymupdf-modulenotfounderror#answer-68837200](https://stackoverflow.com/questions/68644003/pymupdf-modulenotfounderror#answer-68837200)  

With the .whl file in the app’s folder, then run pip in the app’s folder like this in order to install from the compiled .whl file:
Note - Make sure you're in poetry shell if you're using poetry

```
pip install PyMuPDF-<...>.whl
```

Eg.
```
pip install PyMuPDF-1.24.11-cp38-abi3-macosx_11_0_arm64.whl
```

That should fix your problem!

---

## Appendum

There's a way to really know if downloading a .whl file specific to your platform and architecture is the fix.

You can quickly do so by running `import fitz`\* which comes included with pymupdf and is pymupdf's legacy fall back, but most importantly, it gives more detailed errors. 


> [!note] fitz name-sake
> Read more here: https://pymupdf.readthedocs.io/en/latest/tutorial.html#note-on-the-name-fitz


You can run in terminal instead of in a py file if it's easier:
```
python -c "import fitz"
```

It may give you an error about “but is an incompatible architecture (have 'x86_64', need 'arm64’))” or any architecture problems

PyMuPDF which extracts information from PDF files using system-level libraries and optimizations. Ideally when you installed PyMuPDF, it should compile from the source code into the appropriate whl file based on your architecture, but since that didn’t happen, you can download the .whl file specific to your platform instead.


A pass is when no message back:
```
python -c "import fitz"
```

