Learned from:
https://youtu.be/3PdmLQIZpwE

## Multiple ways to get memory use results per line:
- Run and print when function finishes calling
- Save to a variable to be printed (two variants - all lines vs max mem line)
- Save to a log file to be opened
- Command Line tool to standard output

![](wrftZ0k.png)


### INSTALLATION

```
pip3 install memory-profiler
```

### Run and print when function finishes calling

See that a function declaration is decorated by the imported "profile". Upon invoking that function, python will print a table of memory usage per line (including negative memory usage, eg. deleting variables from memory stack)

```
from memory_profiler import profile, memory_usage

@profile
def myfunc():
	# ...

myfunc
```

### Save to a variable to be printed

Instead of python printing whenever a decorated function is called, you declaratively point to the function name, it'll call it, then saves it to a variable; Then you can print the variable at a later time for a table of per-line memory use. Because you declaratively point to the function name, you can audit any functions - no need to decorate functions with decorator "@profile". Code hint: In the tuple argument which is what function and what arguments, the order is function name, positional arguments, and keyword arguments.
```
from memory_profiler import profile, memory_usage

def myfunc():
	# ...

mem_usage = memory_usage(proc: (myfunc, (), {"list_size":10000}))
print(mem_usage)

```

#### Variant: Just print the max mem of the function.

It'll print the max memory use among the lines. Nuance: But it won't print the line content. Useful when you have too many function calls and you're auditing everything, versus auditing a function's lines. Code hint: Notice the optional argument `max_usage=True` after the tuple argument

```
from memory_profiler import profile, memory_usage

def myfunc():
	# ...

mem_usage = memory_usage(proc: (myfunc, (), {"list_size":10000}), max_usage=True)
print(mem_usage)
```


### Save to a log file to be opened

If you want to have log files instead of interactively debugging in real time, you can allow it to run with many users or simulations. This waiting for log files may be useful when the memory leak is difficult to replicate and happens occasionally. This will help narrow it down to a line of code after retrospectively auditing via the log files

```
from memory_profiler import profile, memory_usage

file = open("memory.log", "w+")

@profile(stream=file)
def myfunc():
	# ...

myfunc()
```


### Command Line tool to standard output

When you installed memory-profiler with pip3, you installed an importable python module as well as a command line tool (called by mprof).

Calling mprof will print the table of memory use of all functions, and will create files. The temp files created allow you to plot visually `mprof plot`. For cleanup, you can remove the temp files with `mprof clean`

![](4ksbkpr.png)


```
mprof run --python main.py
mprof plot
mprof clean
```