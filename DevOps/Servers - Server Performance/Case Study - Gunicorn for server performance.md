
16 cores at 250mb will max out the 4gb ram (random access memory that juggles pieces of information the computer remember, in order to do compute work)

But you can’t simply set to 16 workers if you don’t have enough CPU cores because it would compete with other processes. You generally set to 2-4x the number of cores.

---


Refer to [[Gunicorn Primer]] for implementing Gunicorn

