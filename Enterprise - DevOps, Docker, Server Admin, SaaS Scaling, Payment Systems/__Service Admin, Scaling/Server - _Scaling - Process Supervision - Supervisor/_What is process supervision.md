
"_Process supervision_ is the ability to manage (long lived) _processes or_ rather daemons and be able to get (automated) _process_ restart if needed, be it a process crash or signal misuse."
https://wiki.gentoo.org/wiki/Process_supervision

This ability is from process control systems. An example is: Supervisor

Why important to scaling:
- With much traffic and servers, it increases the chance of crashing. Process supervision would restart the process.
- Also can control how many instances of the process
	- Eg. Supervisor 6: `numprocs` [controls](http://supervisord.org/configuration.html) how many processes supervisord will run at the same time. If you just want to run a simple program, you'd leave this unset; the default is 1. http://supervisord.org/configuration.html
-