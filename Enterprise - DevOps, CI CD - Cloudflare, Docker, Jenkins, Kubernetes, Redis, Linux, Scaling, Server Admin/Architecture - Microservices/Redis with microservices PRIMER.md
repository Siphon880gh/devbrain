
Redis is great for sharing state between microservices, queueing users when traffic is beyond capacity, etc. It is an in-memory data structure store that can be used as a database, cache, and message broker. Redis promises sub-millisecond latency performance because of their core architecture and design principles, such as in-memory storage, efficient data structures, and a single-threaded event loop.

Redis itself is made in C. You have to search how to install for your OS distro. When it comes to NodeJS or Python, you have to look for the package that wraps and communicates with Redis.

debian 12 install redis
```
sudo apt install redis
```


---

Redis can be used with nodejs, python, etc but for this example we are using python which means specifically we need to install the python redis wrapper

python’s:
```
pip install  redis
```
If you’re using pyenv-virtualenv with pipenv: `pipenv install redis`  while your shell is in the virtual environment

You can use Redis with microservices in different ways:
