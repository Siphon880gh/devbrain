
You create an empty timeline from the media pool, even though you get the current timeline from project

```
project_manager = resolve.GetProjectManager()
project = project_manager.GetCurrentProject()
media_pool = project.GetMediaPool()

media_pool.CreateEmptyTimeline("Timeline 1")
timeline = project.GetCurrentTimeline()
```