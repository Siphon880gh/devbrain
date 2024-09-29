
Here you can copy video track 1's clips to an existing empty video track 2

Free DaVinci does not allow you to copy the durations

```
# Requirement: You have clips at Video track 1
# Select the other video track and it'll duplicate the clips from video track 1 into there
# Free version: Unfortunately the durations aren't copying on free version so I've commented out SetEnd

# Media types
ENUM_MEDIA_TYPES = {
    "VIDEO": 1,
    "AUDIO": 2,
    "AUDIOVISUAL": 3,
    "SUBTITLE": 4,
}

resolve = app.GetResolve()
projectManager = resolve.GetProjectManager()

# Get the active project
project = projectManager.GetCurrentProject()

# Get the current timeline
timeline = project.GetCurrentTimeline()

# Get the media pool
media_pool = project.GetMediaPool()

# Get all clips on video track 1
track1_clips = timeline.GetItemListInTrack("video", 1)

print("GetStartTimecode:", timeline.GetStartTimecode())

# Iterate through each clip on video track 1 and copy it to video track 2
for clip in track1_clips:
    # Get the media pool item associated with the clip
    media_pool_item = clip.GetMediaPoolItem()

    # Get the start frame and duration of the clip
    start_frame = clip.GetStart()
    duration = clip.GetDuration()
    end_frame = start_frame + duration

    print("start_frame:", start_frame)
    print("duration:", duration)
    print("end_frame:", end_frame)
    # print("GetLeftOffset:", clip.GetLeftOffset())
    # print("GetRightOffset:", clip.GetRightOffset())

    # Create a new clip on video track 2 with the same start and end frames
    clip_info = {
        "mediaPoolItem": media_pool_item,
        "startFrame": 0,
        "endFrame": 115,
        "trackIndex" : 2,
        "recordFrame" : 86400,
        "mediaType": ENUM_MEDIA_TYPES["VIDEO"]
    }

    # meta_data = media_pool_item.GetClipProperty()
    # print(meta_data)

    # Append the clip to track 2
    media_pool.AppendToTimeline([clip_info])
    # end_frames.append(end_frame)
    # media_pool_item.SetStart(start_frame)
    # media_pool_item.SetEnd(end_frame)

    # Retrieve the newly added clip on track 2
    # track2_clips = timeline.GetItemListInTrack("video", 2)
    # new_clip = track2_clips[-1]  # The last clip added is the new one
    # new_clip.SetEnd(value)

print("Clips copied from track 1 to track 2 with correct durations.")

```