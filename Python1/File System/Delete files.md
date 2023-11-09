How to remove files safely:
```
 if os.path.exists(file_path):
  os.remove(file_path)
```

Practical:
```
import os

def cleanup(file_path):
 if os.path.exists(file_path):
  os.remove(file_path)

# Function to clean up intermediate files
cleanup(temp_video_path)
```