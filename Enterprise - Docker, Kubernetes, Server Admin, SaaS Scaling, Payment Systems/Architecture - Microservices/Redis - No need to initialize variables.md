Eg `r.incr('active_users')`

You did not have to explicitly initialize `active_users` before incrementing it. If the key does not exist in Redis, the incr command will automatically create the key with a value of 1. If the key does exist, it simply increments the current value.