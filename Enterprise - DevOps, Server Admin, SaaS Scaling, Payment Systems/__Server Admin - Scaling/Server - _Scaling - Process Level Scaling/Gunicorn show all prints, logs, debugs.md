
Have gunicorn show all prints

1. That makes sure python doesnt buffer the prints (which it does by default)
```
PYTHONUNBUFFERED=1 gunicorn...  
```

  
2. Have console logs and errors show on the same terminal showing that gunicorn  is running (debug level and up includes info warn and critical). Add to the gunicorn command:
```
--log-level=debug --capture-output  
```

3. And you may want to worker 1 and thread 1 for testing purposes
   
4. In a virtual env? You may want a sh file that activates the virtual env before gunicorn if necessary then you test by running that sh file
   
5. You may want to have a package.json script that runs the sh file or the gunicorn command when you run: `npm run test`
