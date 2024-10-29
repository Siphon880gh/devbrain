
Recommend Supervisor app config files be named with the port number ranges they use

Eg. The folder "etc/supervisor/conf.d" might have files:
app-abc-5001-5005.conf
app-def-5006-5008.conf

The port numbers in the filenames won't cause difficulties. You dont have to spell out the filename anywhere since the Supervisor main config file usually wildcards for all app config files in that folder.