
**Confidence: Low. This might break cloudpanel and you can't recover from it**

After installing Cloudpanel, it messes up all future apt installs. All future apt installs tries to finish a Cloudpanel installation:

```
Setting up cloudpanel (2.4.1-1+clp-jammy) ... cp: cannot stat '/tmp/cloudpanel/data/clp/services/nginx/systemd/clp-nginx.service': No such file or directory dpkg: error processing package cloudpanel (--configure): installed cloudpanel package post-installation script subprocess returned error exit status 1 Errors were encountered while processing: cloudpanel E: Sub-process /usr/bin/dpkg returned an error code (1)
```


**Probably what happened:**
You reinstalled Cloudpanel on the server when it had already been installed.


#solved
I no longer get the /tmp/... cloudpanel files not found whenever I run apt to install anything

You were right about me reinstalling cloudpanel. So I reinstalled cloudpanel which make it NOT create /tmp/ files on the reinstallation. The first installation had already deleted the /tmp/ files because of success. The reinstallation wouldn't create the /tmp/ files because things have already been installed.

The thing is those /tmp/ files are required for the post installation script to do the finaly copying of executables etc from /tmp/ files to their final system paths

Because it's a reinstallation of cloudpanel, then the post installation script's cp lines that copy from /tmp folder will fail

Henceforth, apt will keep trying to finish the post installation everytime I run apt even if Im not dealing with cloudpanel. Only way is either if the post install script is a success with no errors or if I remove cloudpanel which is not good because I want cloudpanel to remain

I made the post installation script blank so that when this .sh file runs then there are no errors, hence the post installation script is FINALLY done, and apt won't try to keep running it and failing on next apt uses. 

**Solution:**
Before you edit the post installation script, you may want to make a backup to feel comfortable about it: `cp /var/lib/dpkg/info/cloudpanel.postinst home/var-lib-dpkg-info-cloudpanel.postinst.backup`

Go edit the postinst
`vi /var/lib/dpkg/info/cloudpanel.postinst` and make it blank. vi can blank it with: `%d`
Save by running `wq`

Install any packages using apt. Eg. `sudo apt install python2`. It will finally succeed in finishing the post installation script. All future apt installations will no longer show this error.