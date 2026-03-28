SFTP/FTP may be slow when uploading many files.

A quicker way would be to zip or tar a folder of your files, upload that zip/tar/tar.gz to the destination folder, THEN unarchived it at the server via terminal SSH. Make sure the files go to where they need (eg. not another layer of folder).

For zip/tar/tar.gz commands, refer to:
[[Archiving with Zip - Upload faster excluding .git and node_modules]]
[[Archiving with Tar - Upload faster excluding .git and node_modules]]