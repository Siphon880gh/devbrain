
This is how to generate an EDL file for DaVinci and other videoediting software for importing in timelines

Notice EDLs can track cuts and dissolves (aka crossfades) but it cannot track wipes

NodeJS:
```
// Works but note that EDL Timelines in DaVinci only supports cuts (C) and dissolves (D) aka crossfades
// OTIO Timelines in DaVinci supports the Edge wipes of different angles.

const IMAGE_FILES = [
    "clip01.jpg", 
    "clip02.jpg", 
    "clip03.jpg", 
    "clip04.jpg", 
    "clip05.jpg"
];
DESIRED_CLIP_SECONDS = 10; // Desired duration of each clip in seconds

const startTimeCode = "00:00:00:00"; // User-defined start timecode for the timeline
let frame_rate = 24;
let outputPath = "./generated_edl/generated.edl"

// Array of slide indexes where you want specific transitions applied
const transitionPositions = [
    {index: 1, type: "D", duration: 24},  // Dissolve with duration
    {index: 2, type: "D"},                // Dissolve with default duration
    {index: 3, type: "C"}                 // Regular Cut
];

const DEFAULT_DISSOLVE_DURATION = 24; // Default duration for dissolve if not provided

const fs = require("fs")
function generateEDL(clipNames, durationPerClip, startTimeCode = "00:00:00:00", transitionPositions = []) {
    let edl = "TITLE: Image Sequence Timeline\nFCM: NON-DROP FRAME\n\n";

    // Helper function to convert timecode in HH:MM:SS:FF format to seconds
    function timecodeToSeconds(timecode) {
        const [hours, mins, secs, frames] = timecode.split(":").map(Number);
        const fps = typeof frame_rate !== "undefined" ? frame_rate : 24; 
        return hours * 3600 + mins * 60 + secs + frames / fps;
    }

    let currentTimelineStart = timecodeToSeconds(startTimeCode); 
    let duration = durationPerClip; 
    
    // Helper function to convert seconds to timecode in HH:MM:SS:FF format
    function secondsToTimecode(seconds) {
        const fps = frame_rate;
        let totalFrames = Math.floor(seconds * fps);
        let frames = totalFrames % fps;
        totalFrames = Math.floor(totalFrames / fps);

        let secs = totalFrames % 60;
        let mins = Math.floor(totalFrames / 60) % 60;
        let hours = Math.floor(totalFrames / 3600);

        return (
            String(hours).padStart(2, "0") + ":" +
            String(mins).padStart(2, "0") + ":" +
            String(secs).padStart(2, "0") + ":" +
            String(frames).padStart(2, "0")
        );
    }

    clipNames.forEach((clipName, index) => {
        let startTime = currentTimelineStart;
        let endTime = currentTimelineStart + duration;

        let inTime = secondsToTimecode(0); 
        let outTime = secondsToTimecode(duration); 
        let recordInTime = secondsToTimecode(startTime); 
        let recordOutTime = secondsToTimecode(endTime); 

        // Check if this clip has a specified transition
        const transition = transitionPositions.find(t => t.index === index);

        if (transition) {
            if (transition.type === "D") {
                // Dissolve
                const dissolveDuration = (transition.duration || DEFAULT_DISSOLVE_DURATION) / frame_rate;
                let dissolveStart = endTime - dissolveDuration;

                edl += `${String(index + 1).padStart(3, "0")}  AX       V     C        ${inTime} ${outTime} ${recordInTime} ${secondsToTimecode(dissolveStart)}\n`;
                edl += `M2   AX             000.0                ${inTime}\n`;
                edl += `* FROM CLIP NAME: ${clipName}\n\n`;

                edl += `${String(index + 1).padStart(3, "0")}  AX       V     D    ${String(transition.duration || DEFAULT_DISSOLVE_DURATION).padStart(3, "0")} ${inTime} ${outTime} ${secondsToTimecode(dissolveStart)} ${recordOutTime}\n`;
                edl += `M2   AX             000.0                ${inTime}\n`;
                edl += `* TO CLIP NAME: ${clipNames[index + 1]}\n\n`;

            } else if (transition.type === "C") {
                // Regular cut
                edl += `${String(index + 1).padStart(3, "0")}  AX       V     C        ${inTime} ${outTime} ${recordInTime} ${recordOutTime}  \n`;
                edl += `M2   AX             000.0                ${inTime}\n`;
                edl += `* FROM CLIP NAME: ${clipName}\n\n`;
            }
        } else {
            // Regular cut if no transition is defined
            edl += `${String(index + 1).padStart(3, "0")}  AX       V     C        ${inTime} ${outTime} ${recordInTime} ${recordOutTime}  \n`;
            edl += `M2   AX             000.0                ${inTime}\n`;
            edl += `* FROM CLIP NAME: ${clipName}\n\n`;
        }

        // Update timeline start to match the end of the current clip
        currentTimelineStart = endTime; 
    });

    return edl.trim();
}

// Write file
const generatedEDL = generateEDL(IMAGE_FILES, DESIRED_CLIP_SECONDS, startTimeCode, transitionPositions);
fs.writeFileSync(outputPath, generatedEDL);

```

It would generate relatively to a `generated_edl/generated.edl`