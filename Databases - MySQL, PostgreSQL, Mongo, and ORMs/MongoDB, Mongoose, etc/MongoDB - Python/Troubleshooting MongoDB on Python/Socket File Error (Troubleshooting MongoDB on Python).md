**MongoDB Connection Refused: Fixing the Socket File Error**

Running Python to connect to MongoDB may fail with an error like this:

```text
Failed to connect to MongoDB: 127.0.0.1:27017: [Errno 111] Connection refused (configured timeouts: socketTimeoutMS: 20000.0ms, connectTimeoutMS: 20000.0ms), Timeout: 30s, Topology Description: <TopologyDescription id: 69df0b396636e48e9cee8886, topology_type: Unknown, servers: [<ServerDescription ('127.0.0.1', 27017) server_type: Unknown, rtt: None, error=AutoReconnect('127.0.0.1:27017: [Errno 111] Connection refused (configured timeouts: socketTimeoutMS: 20000.0ms, connectTimeoutMS: 20000.0ms)')>]>
```

If you then check the MongoDB log with:

```bash
sudo tail -n 200 /var/log/mongodb/mongod.log
```

and see an error like **"Failed to unlink socket file"** with **status 14**, the issue is usually that MongoDB could not remove an old socket file before starting.

To help prevent future `mongod` service failures, keep in mind that after a server reboot, MongoDB may fail to start for the same reason. In this case, an old socket file such as `/tmp/mongodb-27017.sock` may be owned by `root` instead of the `mongodb` user, which prevents MongoDB from cleaning it up properly.

First, make sure `/tmp` has the correct permissions:

```bash
sudo chmod 1777 /tmp
```

Then check whether the MongoDB service is running. If it is stopped, remove the stale socket file and restart MongoDB so it can create a fresh one:

```bash
sudo rm -f /tmp/mongodb-27017.sock
sudo systemctl restart mongod
```

This can help restore MongoDB and prevent the same startup failure from blocking future Python connections.