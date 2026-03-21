
  
Replicate:

When you run:
```
pipenv install package_name
```



Then you got a MemoryError:  
```
...  
  File "/root/.pyenv/versions/3.6.15/envs/app4/lib/python3.6/site-packages/pipenv/patched/notpip/_vendor/cachecontrol/controller.py", line 145, in cached_request  
    resp = self.serializer.loads(request, cache_data)  
  File "/root/.pyenv/versions/3.6.15/envs/app4/lib/python3.6/site-packages/pipenv/patched/notpip/_vendor/cachecontrol/serialize.py", line 97, in loads  
    return getattr(self, "_loads_v{}".format(ver))(request, data)  
  File "/root/.pyenv/versions/3.6.15/envs/app4/lib/python3.6/site-packages/pipenv/patched/notpip/_vendor/cachecontrol/serialize.py", line 184, in _loads_v4  
    cached = msgpack.loads(data, raw=False)  
  File "/root/.pyenv/versions/3.6.15/envs/app4/lib/python3.6/site-packages/pipenv/patched/notpip/_vendor/msgpack/fallback.py", line 129, in unpackb  
    ret = unpacker._unpack()  
  File "/root/.pyenv/versions/3.6.15/envs/app4/lib/python3.6/site-packages/pipenv/patched/notpip/_vendor/msgpack/fallback.py", line 671, in _unpack  
    ret[key] = self._unpack(EX_CONSTRUCT)  
  File "/root/.pyenv/versions/3.6.15/envs/app4/lib/python3.6/site-packages/pipenv/patched/notpip/_vendor/msgpack/fallback.py", line 671, in _unpack  
    ret[key] = self._unpack(EX_CONSTRUCT)  
  File "/root/.pyenv/versions/3.6.15/envs/app4/lib/python3.6/site-packages/pipenv/patched/notpip/_vendor/msgpack/fallback.py", line 625, in _unpack  
    typ, n, obj = self._read_header(execute)  
  File "/root/.pyenv/versions/3.6.15/envs/app4/lib/python3.6/site-packages/pipenv/patched/notpip/_vendor/msgpack/fallback.py", line 468, in _read_header  
    obj = self._read(n)  
  File "/root/.pyenv/versions/3.6.15/envs/app4/lib/python3.6/site-packages/pipenv/patched/notpip/_vendor/msgpack/fallback.py", line 376, in _read  
    ret = self._buffer[i : i + n]  
MemoryError
```
  

### Clear the Cache

Sometimes, a corrupted cache can cause resolution failures. You can clear the pip cache by running:

pipenv --rm  
pip cache purge  
pipenv install