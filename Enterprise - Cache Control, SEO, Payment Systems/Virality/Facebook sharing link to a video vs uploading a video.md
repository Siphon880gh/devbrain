Note if your app makes a video and you share the link to it to the user, that link to the video hosted by a server of yours, when they paste the url to Facebook: Facebook doesn't let people play the video in the post. It'll be a thumbnail of the first frame. Here's what happens when the user clicks the .mov/.mp3/etc link posted on Facebook:
- User clicks it to open a new tab to the mp4 or whatever url then their web browser handles the file format (either by playing the video in the new tab or downloading). 
- Even pasting a youtube video url doesn't let you play the video inside facebook (it opens to youtube.com). If it's the facebook app, it opens up the youtube.com in a web view of facebook to provide a more seamless harmonized experience.

If you want your users to be able to share video your app generated that can play inside the facebook post, you can use facebook api for publishing video at
https://developers.facebook.com/docs/video-api/guides/publishing/