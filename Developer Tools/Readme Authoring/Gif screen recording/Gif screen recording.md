Screen recording converted to GIF then placed on README.md. That is much better than static screenshots.

There are many approaches. The one approach I find the best so far is QuickTime -> Cloud Convert

A. QuickTime -> Cloud Convert
 1. Record the screen with QuickTime Player.
 2. Convert the video file to GIF at https://cloudconvert.com/mp4-to-gif

If you link the `![image](/assets/***.gif)` and it doesn't show, you may have passed the allowed filesize by Github which is 10mb as of 8/2020.

B. QuickTime -> FFmpeg
 1. Record the screen with QuickTime Player.
 2. Convert the video file to gif using FFmpeg. This example uses `video.mov` converts it as `demo.gif`:

320 resolution
720
1080p
```
ffmpeg -i zz.mp4 -vf scale=1080:-1 -r 10 -f image2pipe -vcodec ppm - | convert -delay .75 -loop 0 - gif:- | convert -layers Optimize - demo.gif
```

Notice the scale is small. The -1 makes sure to keep aspect ratio. I also set delay to .75 to increase the speed of the screen recording, further reducing file size. You can google these options.

If your gif surpassed the 10mb limit on Github:
1. Record shorter video clip and/or record part of the screen rather than full screen.
2. Export to the lowest resolution possible at the Export option in QuickTime Player.
3. Convert the video to gif using ffmpeg while playing with different options. An option can be speeding up the GIF which will shorten its duration. Another option can be lowering the scale.
4. Use online tools like https://www.iloveimg.com/compress-image/compress-gif and iloveimg's crop and resize tools.
5. If the above fails, you can play around with imagemagick with things such as speeding up the gif.

---

To adjust the speed and size of your GIF, you can modify the `-delay` value and `scale` in the `ffmpeg` command. Here’s a modified version:

1. **Slow it down** by increasing the `-delay` value in the `convert` command (higher values will make it slower).
2. **Make it larger** by adjusting the `scale` filter in the `ffmpeg` command.

Here’s an example command with adjustments:

```bash
ffmpeg -i z.mov -vf scale=640:-1 -r 10 -f image2pipe -vcodec ppm - | convert -delay 10 -loop 0 gif:- | convert -layers Optimize demo.gif
```

### Explanation:
- **`scale=640:-1`**: This will resize the video to 640 pixels wide, with the height scaled to maintain aspect ratio. Adjust `640` to your desired width.
- **`-delay 10`**: This value slows down the frame rate. Increase the value to make it slower (e.g., `-delay 20` for slower animation).

This should create a slower, larger GIF. Let me know if you need more customization!

---

To increase the quality of a GIF created with `ffmpeg`, you can:

1. **Increase the Frame Rate**: Increase the frames per second (`fps`), but keep in mind this can make the file size larger.
2. **Use a Higher Resolution**: Ensure the `scale` filter uses a higher resolution.
3. **Use the `-q:v` Option**: This option sets the video quality (lower values are higher quality for GIF encoding).

Here’s an example command:

```bash
ffmpeg -i z.mov -vf "scale=800:-1, fps=15" -q:v 2 demo.gif
```

### Explanation:
- **`scale=800:-1`**: Sets a larger width (800 pixels in this case) to improve the resolution of the GIF.
- **`fps=15`**: Sets the frame rate to 15 fps, giving smoother motion (you can adjust this value based on your preference and file size limits).
- **`-q:v 2`**: Sets high quality (values range from 2 to 31, where 2 is the best quality for GIF output in `ffmpeg`).

For finer quality control, using ImageMagick with specific dithering and color optimization options can also help. Here's a combined example with `ffmpeg` and `convert`:

```bash
ffmpeg -i z.mov -vf scale=800:-1 -r 15 frames/frame_%04d.png
convert -delay 6 -loop 0 frames/frame_*.png -dither FloydSteinberg -colors 256 -layers Optimize demo.gif
rm frames/frame_*.png
```

This approach uses `-dither FloydSteinberg` and limits colors to `256` to maintain high quality without excessive file size.

---

To produce a **high-quality GIF**, the most effective method involves leveraging FFmpeg's built-in capabilities, particularly its **palette generation** feature. This ensures optimal color usage and smoother playback.

Here’s a detailed, **high-quality workflow**:

1. **Step 1: Generate a High-Quality Palette**

A color palette ensures the GIF uses the most accurate colors possible from the video. Run this command:

```bash
ffmpeg -i zz.mov -vf "fps=30,scale=640:-1:flags=lanczos,palettegen" palette.png
```

- **`fps=30`**: Sets the frame rate to 30 FPS for smooth animation. Adjust as needed for your source file.
- **`scale=640:-1`**: Increases the resolution to 640 pixels wide (keeping aspect ratio). You can go higher depending on your needs.
- **`flags=lanczos`**: Uses a high-quality scaling algorithm.

2. **Step 2: Create the GIF Using the Palette**

**Use the generated palette to create a high-quality GIF:**

```bash
ffmpeg -i zz.mov -i palette.png -lavfi "fps=30,scale=640:-1:flags=lanczos [x]; [x][1:v] paletteuse" -loop 0 demo.gif
```

- **`paletteuse`**: Applies the color palette for optimal quality.
- **`loop=0`**: Makes the GIF loop infinitely.
- You can adjust `fps` and `scale` to balance quality and file size.

 3. **Optional: Reduce File Size Without Losing Quality**

If the GIF size is too large, slightly reduce the frame rate (`fps`) or resolution (`scale`):

 **Lower Frame Rate (but still smooth):**

```bash
ffmpeg -i zz.mov -i palette.png -lavfi "fps=20,scale=640:-1:flags=lanczos [x]; [x][1:v] paletteuse" -loop 0 demo.gif
```

**Lower Resolution:**

```bash
ffmpeg -i zz.mov -i palette.png -lavfi "fps=30,scale=480:-1:flags=lanczos [x]; [x][1:v] paletteuse" -loop 0 demo.gif
```

**Example of a Complete Command Sequence**

```bash
ffmpeg -i zz.mov -vf "fps=30,scale=640:-1:flags=lanczos,palettegen" palette.png
ffmpeg -i zz.mov -i palette.png -lavfi "fps=30,scale=640:-1:flags=lanczos [x]; [x][1:v] paletteuse" -loop 0 demo.gif
```

---

### Why This Method Produces Better Quality

1. **Palette Optimization**: Ensures the best colors for the GIF from the video.
2. **Lanczos Scaling**: High-quality resizing method avoids pixelation.
3. **Higher Frame Rate**: Makes animations smoother.
4. **FFmpeg's Efficient Compression**: Keeps quality high while optimizing file size.

Let me know how it looks or if you'd like further refinements!