You get the current timeline from project, even though you create an empty timeline from the media pool:

```
project_manager = resolve.GetProjectManager()
project = project_manager.GetCurrentProject()
timeline = project.GetCurrentTimeline()
```