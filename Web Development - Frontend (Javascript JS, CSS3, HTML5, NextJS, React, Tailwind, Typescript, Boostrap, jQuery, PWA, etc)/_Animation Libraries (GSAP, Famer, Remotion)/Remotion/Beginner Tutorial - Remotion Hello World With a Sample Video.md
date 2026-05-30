# Beginner Tutorial: Remotion Hello World With a Sample Video

Remotion is like **React for video**: you write React components, but instead of rendering a webpage, Remotion renders frames into a video file.

A Remotion project usually has an entry file, a Root file, and one or more React components. The Root file registers one or more `<Composition>` components—the videos Remotion can preview and render. See the [Remotion docs](https://www.remotion.dev/docs).

> [!note] When to use Remotion
> Use Remotion when the final output is a video file (MP4, reel, ad, intro). For website UI animation, see [[Remotion vs Framer Motion, CSS, and GSAP - When to Use Each]].

---

## Goal

Create a 5-second video with:

- A sample video background
- Animated “Hello Remotion” text
- A small frame counter
- An exported MP4 file

---

## 1. Create a new Remotion project

Run this in your terminal:

```bash
npx create-video --yes --blank remotion-hello
cd remotion-hello
```

The `create-video` command scaffolds a new Remotion project. `--blank` uses the blank starter template.

Start Remotion Studio:

```bash
npx remotion studio
```

Remotion Studio is the local preview interface where you can scrub through the video timeline.

---

## 2. Create the video component

Create or replace `src/HelloWorld.tsx`:

```tsx
// src/HelloWorld.tsx

import React from 'react';
import {
    AbsoluteFill,
    interpolate,
    OffthreadVideo,
    spring,
    useCurrentFrame,
    useVideoConfig,
} from 'remotion';

export const HelloWorld: React.FC = () => {
    const frame = useCurrentFrame();
    const {fps} = useVideoConfig();

    const opacity = interpolate(frame, [0, 20], [0, 1], {
        extrapolateLeft: 'clamp',
        extrapolateRight: 'clamp',
    });

    const titleY = interpolate(frame, [0, 30], [60, 0], {
        extrapolateLeft: 'clamp',
        extrapolateRight: 'clamp',
    });

    const scale = spring({
        frame,
        fps,
        from: 0.85,
        to: 1,
    });

    return (
        <AbsoluteFill
            style={{
                backgroundColor: '#111',
                color: 'white',
                fontFamily: 'Arial, sans-serif',
            }}
        >
            <OffthreadVideo
                src="https://remotion.media/BigBuckBunny.mp4"
                muted
                style={{
                    width: '100%',
                    height: '100%',
                    objectFit: 'cover',
                    opacity: 0.45,
                }}
            />

            <AbsoluteFill
                style={{
                    background:
                        'linear-gradient(90deg, rgba(0,0,0,0.75), rgba(0,0,0,0.25))',
                }}
            />

            <AbsoluteFill
                style={{
                    justifyContent: 'center',
                    alignItems: 'center',
                    textAlign: 'center',
                    padding: 80,
                }}
            >
                <div
                    style={{
                        opacity,
                        transform: `translateY(${titleY}px) scale(${scale})`,
                    }}
                >
                    <h1
                        style={{
                            fontSize: 110,
                            margin: 0,
                            fontWeight: 900,
                            letterSpacing: -4,
                        }}
                    >
                        Hello Remotion
                    </h1>

                    <p
                        style={{
                            fontSize: 36,
                            marginTop: 24,
                            opacity: 0.9,
                        }}
                    >
                        React components → video frames → MP4
                    </p>

                    <p
                        style={{
                            fontSize: 24,
                            marginTop: 40,
                            opacity: 0.65,
                        }}
                    >
                        Current frame: {frame}
                    </p>
                </div>
            </AbsoluteFill>
        </AbsoluteFill>
    );
};
```

**Beginner idea:** `useCurrentFrame()` returns the current frame number. `interpolate()` maps frame ranges to values like opacity, position, or scale. See [interpolate](https://www.remotion.dev/docs/interpolate) in the docs.

---

## 3. Register the composition

Replace your Root file with `src/Root.tsx`:

```tsx
// src/Root.tsx

import React from 'react';
import {Composition} from 'remotion';
import {HelloWorld} from './HelloWorld';

export const Root: React.FC = () => {
    return (
        <>
            <Composition
                id="HelloWorld"
                component={HelloWorld}
                durationInFrames={150}
                fps={30}
                width={1920}
                height={1080}
            />
        </>
    );
};
```

This registers a composition called `HelloWorld`. At `150` frames and `30` FPS, the video is **5 seconds** long.

A `<Composition>` makes a React component renderable as a video in Remotion Studio and from the CLI. It needs an `id`, `component`, `durationInFrames`, `fps`, `width`, and `height`.

---

## 4. Register the Root in the entry file

Your entry file should look like this:

```ts
// src/index.ts

import {registerRoot} from 'remotion';
import {Root} from './Root';

registerRoot(Root);
```

The entry file is usually `src/index.ts` and must call `registerRoot()`.

---

## 5. Preview it

Run:

```bash
npx remotion studio
```

Open the `HelloWorld` composition in the sidebar. You should see the sample video background with animated text on top.

---

## 6. Render it to MP4

Run:

```bash
npx remotion render HelloWorld out/hello-world.mp4
```

The `remotion render` command renders a composition to a video file. If you omit the output path, Remotion renders into the `out` folder by default.

---

## What you just learned

This is the Remotion “Hello World” mental model:

```txt
React component
→ registered as a Composition
→ previewed in Remotion Studio
→ rendered into an MP4
```

> [!note] Frame-driven animation
> Remotion animations should be driven by the timeline frame number (`useCurrentFrame()`, `interpolate()`, `spring()`), not CSS animations. That keeps output deterministic frame by frame—required for clean video export.

---

## Next steps

- Change `durationInFrames`, `fps`, or resolution on the `<Composition>`
- Swap the sample video URL or add your own assets
- Add more compositions to `Root.tsx` for multiple exports from one project
