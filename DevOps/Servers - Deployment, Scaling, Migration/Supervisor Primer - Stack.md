
Usually you have **Supervisor** to manage an instance of .sh script

---

That .sh script appends relevant paths to **$PATH**.

Then the .sh script activates the **python version with pyenv**, then activates the virtual environment of **pipenv**

Finally, the .sh file runs **gunicorn** with x number of process workers, and might activate multithread

---

The gunicorn runs an intermediate** wsgi.py** python script, which runs Flask **python script** (or a normal non-Flask python script).