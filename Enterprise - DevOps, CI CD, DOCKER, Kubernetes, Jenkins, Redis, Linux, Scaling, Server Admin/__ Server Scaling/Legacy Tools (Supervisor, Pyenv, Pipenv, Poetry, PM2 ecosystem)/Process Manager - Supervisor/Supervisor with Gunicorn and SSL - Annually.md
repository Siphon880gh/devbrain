
Annually when you change SSL certs, the supervisor that keeps the gunicorn with SSL cert process (and its worker processes) going needs to be updated

Your supervisor runs a .sh file that runs gunicorn with the cert filepaths. Update the certfile paths of the gunicorn command

Hot tip:
If you have personal notes you refer to whenever you renew your SSL, it should also mention updating the sh file that supervisor manages, particularly the gunicorn command with the SSL cert file paths