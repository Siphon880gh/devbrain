
CentOS uses both `rpm` and `yum` as part of its package management system.

1. **RPM (RPM Package Manager)** - This is the low-level tool used for installing, uninstalling, and managing individual software packages. RPM handles the basic package management, including checking for dependencies at a fundamental level.
    
2. **YUM (Yellowdog Updater, Modified)** - This is the higher-level tool that works on top of RPM. Yum manages software repositories and dependencies more comprehensively and user-friendly than RPM by itself. It automatically resolves dependencies and retrieves the necessary packages from its configured repositories.
    

Both tools are used in conjunction, with YUM providing a more convenient and robust interface for managing the packages that RPM handles at a more basic level. There hasn't been a shift away from this setup; rather, CentOS and other similar distributions use YUM to enhance the capabilities of RPM.