
Briefly, Makefile is advantageous over npm because:
- It’s language gnostic. When you hear Makefile, you don’t associate it with a language. Sometimes you want to only focus on the concept of build tools
- Because it's language gnostic, the DevOps developer can figure to run the Makefile tasks first, before running any npm scripts if needed
- You can have commands on different line. In npm, a script needs to be separated with ;  or joined with &&  if multiple commands are needed.

When Make is compared against a `.sh` shell script, Make offers several benefits:

1. **Task Dependency Management**: Makefiles automatically handle task dependencies, ensuring that prerequisites are completed before a task is executed.
2. **Selective Task Execution**: Make can execute only the necessary tasks based on file changes, avoiding unnecessary re-execution.
3. **Reusability**: Makefiles can define reusable rules and targets for different parts of the project.
4. **Parallel Execution**: Make supports parallel execution of tasks using the `-j` option, speeding up build processes.
5. **Cross-Platform Compatibility**: While shell scripts are specific to certain environments, Makefiles can be more portable across systems. Makefile or make  works across Linux, Mac, Windows. Please see compatibility exceptions at
6. **Modularity**: Makefiles can be split into smaller, maintainable components using includes, improving organization.
