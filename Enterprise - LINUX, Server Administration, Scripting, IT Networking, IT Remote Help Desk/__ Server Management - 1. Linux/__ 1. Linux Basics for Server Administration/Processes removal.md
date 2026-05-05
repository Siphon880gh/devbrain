
Kill all running processes that has the name __

`pkill -f gunicorn`
(Background: -f matches against the arguments of the process too)

or

`pkill -9 -f gunicorn`
(Background: -9 is a forceful kill instead of waiting for the process to finish cleaning up, which in some cases hang because it is too bugged to clean. Without cleaning, some apps can lead to data corruption, or this could lead to overusing file storage space)

You can go by port number
`ps aux | grep 5001`
– then
`sudo kill <pid>`

----


You can confirm is empty with
`pgrep someProcess`
or
`ps aux | grep someProcess`
(Background: ps shows all processes and aux is adding more columns to be shown, but piping with | grep will filter in only certain lines in the output)

