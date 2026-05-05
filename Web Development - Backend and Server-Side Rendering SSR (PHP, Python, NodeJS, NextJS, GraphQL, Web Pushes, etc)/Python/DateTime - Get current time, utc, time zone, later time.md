Keypoints:
- Notice I set the timezone as PST (-8 in that case):

Timestamps:
- November 22, 2024, 11:54 PM
	```
	local_time.strftime("%B %d, %Y, %I:%M %p")
	```

- 2024-11-22 17:54:22
	```
	local_time.strftime("%Y-%m-%d %H:%M:%S")
	```

---


Get current time:  

```

from datetime import datetime, timezone, timedelta

  

local_time = datetime.now(timezone(timedelta(hours=-8)))

formatted_time = local_time.strftime("%B %d, %Y, %I:%M %p")

print("Today in PST: ")

print(formatted_time)

```

Get time in UTC time (Coordinated, Universal Time). For example:

```
from datetime import datetime

utc_time = datetime.utcnow() # 2024-11-27 10:53:12.111088
formatted_time = utc_time.strftime("%B %d, %Y, %I:%M %p")
print("Today in UTC: ")
print(formatted_time)
```

Get x days later:

```

from datetime import datetime, timezone, timedelta

  

three_days_later = local_time + timedelta(days=3) # approximate 1 month as 30 days

three_days_later = three_days_later.strftime("%B %d, %Y, %I:%M %p")

print("Three days later in PST: ")

print(three_days_later)

```

---

Dev Get one month later

Some months it’s 28-31 days, so use relative month instead of relative to days

```
from datetime import datetime, timezone, timedelta
import calendar

local_time = datetime.now(timezone(timedelta(hours=-8)))

# Extract current year and month
year = local_time.year
month = local_time.month

# Determine the next month and year
if month == 12:  # If December, wrap around to January of the next year
    next_month = 1
    next_year = year + 1
else:
    next_month = month + 1
    next_year = year

# Get the number of days in the next month
days_in_next_month = calendar.monthrange(next_year, next_month)[1]

# Adjust the day to ensure it doesn't exceed the maximum in the next month
day = min(local_time.day, days_in_next_month)

# Create the datetime object for one month later
one_month_later = datetime(next_year, next_month, day, 
                            local_time.hour, local_time.minute, local_time.second, 
                            tzinfo=local_time.tzinfo)

# Format the date into the desired string format
formatted_time = one_month_later.strftime("%B %d, %Y, %I:%M %p")
return formatted_time
```

---

Note on making time zone a variable

NO! Doesnt behave like you expect

```
TIME_ZONE_CONSTANT = -8
local_time = datetime.now(timezone(timedelta(hours=TIME_ZONE_CONSTANT))
```

YES:  

```
TIME_ZONE_CONTEXT = timedelta(hours=-8)
local_time = datetime.now(timezone(TIME_ZONE_CONTEXT))
```