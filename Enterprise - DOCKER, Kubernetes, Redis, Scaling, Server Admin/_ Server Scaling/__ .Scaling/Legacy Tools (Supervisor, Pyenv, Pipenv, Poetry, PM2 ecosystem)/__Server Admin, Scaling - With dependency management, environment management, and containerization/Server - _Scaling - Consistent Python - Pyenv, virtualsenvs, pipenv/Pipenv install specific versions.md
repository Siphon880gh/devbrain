For example:
```
pipenv install elevenlabs==0.1.1
pipenv install openai==0.8.0
```


- See if you have a problem: Open Pipfile and you'll see the package versions if you had specified them in `pipenv install package_name===1.2.0`, for example. You unlikely had specified versions so the packages could be set to `*`. 
- How to correct `*` to the version: Run `pipenv run pip show opencv-python` , for example, which gives you the version. Then modify the Pipfile, `opencv-python = "==3.4.7.28"`, for example.