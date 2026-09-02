
Loop Prompting with Higgsfield MCP:
## Fill an App or Game with Images and Videos Using Higgsfield MCP and Cursor Loops

  
An app or game can feel unfinished when the interface is functional but its important moments still use generic artwork or empty boxes. Higgsfield MCP can help fill those gaps from inside Cursor: the coding agent finds a media placeholder, reads the generation instructions stored in its HTML attributes, sends the prompt to the appropriate Higgsfield image or video generator, downloads the finished asset, and inserts it into the project.

The most reliable version of this workflow uses two separate loops:
1. A **placeholder-planning loop** finds places where an image or video would improve the experience, adds standardized placeholders, and records them in an inventory.

2. A **Higgsfield-generation loop** processes that inventory, generates the assets, downloads them locally, replaces the placeholders, and verifies them in the running app or game.

Separating planning from generation makes the process easier to review, rerun, and debug. It also prevents the generator from making product-design decisions while it is supposed to be producing assets.

## 1. Install Higgsfield MCP in Cursor

Add Higgsfield as a custom HTTP MCP server in Cursor's MCP configuration:

```json
{

	"mcpServers": {
		"higgsfield": {
			"type": "http",
			"url": "https://mcp.higgsfield.ai/mcp"
		}
	}
}
```

Reload Cursor if necessary, then confirm that the Higgsfield server is connected and that its image and video tools are available to the agent. Resolve any connection or authorization prompt before starting an unattended loop.

Use a capable coding model in Cursor. The original workflow used Grok 4.5 on Max mode. The exact model is less important than its ability to inspect the repository, call MCP tools, download files, edit code, run the app, and verify the interface reliably.

## 2. Establish a standard media-placeholder contract

Every placeholder should contain enough information for either a human or an agent to understand what belongs there. At minimum, store:
- A descriptive title.
- The complete asset-generation prompt.
- The media kind: `image` or `video`.
- The intended width, height, and aspect ratio.
- The shared visual style for the project.

Use `data-media-kind` to tell the loop which Higgsfield generator to call. Store the complete prompt in `data-asset-prompt` so it can also be copied and pasted into a chat-based generator manually.

For example:
```html
<img
  src="/asset-placeholder.php?title=Telemetry%20unit&kind=image&width=640&height=360"
  width="640"
  height="360"
  alt="Telemetry unit"
  data-media-kind="image"
  data-asset-prompt="Subject: RN shift-sim landing tile for Telemetry — nursing station with central monitor bank showing multiple rhythm strips, mid-size census feel. Caption text &quot;Telemetry unit&quot;. Dimensions: 640×360px — produce the still at these pixel dimensions (2× retina optional). Style (fun medical simulation): approachable educational game art for an RN shift sim — clear readable shapes, lightly playful personality without cartoon stickers, horror, or gore; bright but clinical hospital palette; panels-first UI friendly; fictional patients/signage only (no real faces, no PHI); readable at small sizes; include any requested title as subtle in-frame caption."
>
```

A video placeholder follows the same contract but uses `data-media-kind="video"`. Its dimensions, duration, framing, motion, and any poster-image requirements should be included in the prompt.

The final prompt should follow a predictable structure:
```text
Subject: [what the asset should show]

Caption: [optional in-frame title]

Dimensions: [width × height, aspect ratio, and optional 2× output]

Motion: [video only]

Style: [the project's shared visual language]

Safety and privacy: [fictional people, no PHI, no inappropriate content]
```  

## 3. Create a lightweight PHP placeholder service

A PHP placeholder service is convenient because it does not require a build or development-server step. It can receive URL parameters such as:
- `title`
- `kind`
- `width`
- `height`
- Optionally, a URL-encoded asset prompt

The service can return a simple SVG placeholder that displays the title, media kind, and dimensions. That makes unfinished assets obvious inside the interface and gives reviewers useful information instead of showing an anonymous gray box.

For cleaner application code, pair the endpoint with a reusable PHP partial or helper. The helper should accept the title, prompt, media kind, width, and height, then generate the correct `<img>` or `<video>` markup and its data attributes. This keeps every placeholder consistent and prevents hand-written attributes from slowly drifting into different formats.

The full prompt can remain in `data-asset-prompt`, even if the placeholder endpoint only needs the shorter visible title. If the complete prompt is also passed through the URL, it should be properly URL-encoded.

## 4. Add a configuration layer for placeholders

Add a project setting that controls whether development placeholders appear. For example, a setting such as `SHOW_MEDIA_PLACEHOLDERS` can determine whether the app renders:
- The labeled placeholder during planning and development.
- The completed local image or video after generation.
- A neutral fallback when placeholders should not be exposed.

This allows the team to inspect unfinished media work without accidentally presenting development labels to users. The generation loop should not report completion merely because placeholders are hidden; it should use the inventory and source attributes to determine whether they were actually replaced.

## 5. Enforce one consistent visual style and appropriate dimensions

The shared style should not be left to the generator to rediscover for every asset. Define it once, then have the local skill append it to every image and video prompt.

For a fun medical simulation, the shared style might specify:
```text
Approachable educational game art for an RN shift simulation; clear, readable shapes; lightly playful personality without cartoon stickers, horror, or gore; bright but clinical hospital palette; panels-first and UI-friendly composition; fictional patients and signage only; no real faces or PHI; readable at small sizes; include requested titles as subtle in-frame captions.
```

The prompt should also reflect the actual media slot. A department-selection tile may need a 16:9 landscape image, while a bedside procedure slot may need a taller crop. The agent should inspect the component, CSS, or rendered interface and include the appropriate dimensions and aspect ratio in `data-asset-prompt`.

When higher-density output would help, the prompt can request a 2× retina asset while preserving the intended display ratio. Do not request arbitrary dimensions that conflict with the layout.

## 6. Create a local agent skill for media opportunities

Create a local skill such as:
```text
.agents/skills/media-placeholder-planner/SKILL.md
```

The skill should teach the agent how to:
- Scan the app or game for moments where media adds real value.
- Avoid filling every available space with unnecessary artwork.
- Choose between an image and a video.
- Read the actual component dimensions or aspect ratio.
- Write the subject, caption, dimensions, motion, style, privacy, and safety instructions.
- Use the PHP placeholder partial instead of duplicating markup.
- Apply the same style block to every prompt.
- Add or update the placeholder inventory.
- Verify that newly added placeholders render correctly.

High-value opportunities in a medical simulation could include:
- Department or unit choices at the beginning of the game.
- Critical laboratory results.
- Code Blue or rapid-response events.
- Patient assessments and bedside procedures.
- Equipment setup or treatment decisions.
- Major transitions, achievements, or adverse events.

Some media can occupy the patient-treatment area while a procedure is being performed, but it should not obscure controls, clinical data, or essential instructions.

If the project maintains a README for local skills, update it with the skill's purpose, expected placeholder attributes, shared style, inventory location, and loop commands. Keep the authoritative operating instructions in `SKILL.md`.

## 7. Maintain a Markdown inventory of every placeholder

Create a file such as `ASSET_PLACEHOLDERS.md`. This becomes the human-readable work queue and makes manual replacement possible when an asset is supplied outside Higgsfield.

The inventory should record:

| Field | Purpose |
| --- | --- |
| ID | Stable identifier for the placeholder |
| Screen or component | Where it appears |
| Title | Human-readable asset name |
| Media kind | Image or video |
| Dimensions | Width, height, and aspect ratio |
| Prompt | Full generation prompt or source-file reference |
| Status | Placeholder, generated, rejected, approved, or replaced |
| Local asset | Final project-relative file path |
| Review notes | Quality or correction requirements |

When a user supplies an image or video manually, the agent can locate the matching inventory entry, copy the asset into the correct local directory, replace the placeholder, and update its status.

## 8. Run the placeholder-planning loop

Use the first loop to add the infrastructure and identify suitable media opportunities. Ask Cursor to create a file such as `AGENTS_LOOP-Add-Media-Placeholders.md` from this prompt:

```text
Create or update the local media-placeholder-planner skill and use it to add image or video placeholders at high-value points in this app or game.

Use the project's reusable PHP placeholder service or partial. Every placeholder must include:
- a descriptive title;
- data-media-kind set to image or video;
- a complete data-asset-prompt containing the subject, optional caption, appropriate dimensions and aspect ratio, video motion instructions when applicable, the shared project style, and privacy/safety constraints.

Inspect the actual UI or its CSS to determine appropriate dimensions. Apply the same visual style to every prompt. Do not add decorative media where it would clutter the interface or obscure controls.

Maintain ASSET_PLACEHOLDERS.md with the placeholder ID, location, title, media kind, dimensions, prompt, status, and eventual local asset path.

One tick is one reviewed placeholder opportunity: identify it, implement it, add it to the inventory, run the app, and verify that it renders correctly.

Stop when all meaningful screens have been reviewed and no additional high-value media opportunities remain. Stop for human review if placement requires a subjective product decision or if the same implementation or verification failure cannot be fixed after 10 attempts.
```

Run it with:
```text
/loop run AGENTS_LOOP-Add-Media-Placeholders.md exactly
```

Review the resulting placeholders in the running app before generating assets. This is the best point to remove unnecessary media, change dimensions, refine prompts, or adjust where the artwork will appear.

## 9. Run the Higgsfield-generation loop

Once the placeholder plan is approved, create `AGENTS_LOOP-Higgsfield-Fill-Media.md` with the following instructions:

```text
# Objective

Use Higgsfield MCP to replace every approved image and video placeholder in this app or game with a completed local asset.

# One tick

1. Read ASSET_PLACEHOLDERS.md and find the next approved unfinished placeholder.

2. Inspect the source element and read data-media-kind and data-asset-prompt.

3. Confirm that the prompt contains the subject, appropriate dimensions and aspect ratio, shared visual style, and privacy/safety requirements.

4. If data-media-kind is image, use the appropriate Higgsfield image generator. If it is video, use the appropriate Higgsfield video generator.

5. Generate the asset.

6. Download it into an appropriate local project asset directory using a stable descriptive filename.

7. Replace the placeholder with the local image or video while preserving accessibility text, dimensions, responsive behavior, and layout.

8. Update ASSET_PLACEHOLDERS.md with the local path and status.

9. Run the app and inspect the asset in its real interface location. Verify that it loads, fits, and does not break the screen.

10. Continue immediately to the next unfinished approved placeholder.

# Visual acceptance

Do not accept an asset merely because a file was generated and loaded. Flag output that is low quality, inconsistent with the shared style, logically or medically wrong, inappropriate for the scene, unreadable, badly cropped, distorted, or placed incorrectly.

# Stop conditions

- STOP_DONE: every approved placeholder has been replaced and technically verified; provide a final list for human visual review.

- STOP_HUMAN: required prompt information is missing, a subjective decision is necessary, or final visual approval is required.

- STOP_ERROR_BUDGET: the same generation, download, replacement, or verification problem remains unresolved after 10 fix attempts. Summarize each attempt and the best next action.
```

Run it with:
```text
/loop run AGENTS_LOOP-Higgsfield-Fill-Media.md exactly
```

Cursor may stop after each tick or after a reasonable number of ticks—for example, five, depending on your app. To keep it running until completion or until a defined stop condition is met, use this prompt instead:
```
/loop run AGENTS_LOOP-Higgsfield-Fill-Media.md, draining the loop
```

One completed and verified asset is a natural tick. The successful stop condition is that every approved placeholder in the inventory has been replaced.

If Cursor pauses and asks whether it should continue even though no stop condition has fired, telling it to **“drain the loop”** means to keep processing ticks until the work is complete or another defined stop condition is reached. Use this only after confirming that the loop's scope and generation behavior are correct.

## 10. Inspect every picture and video inside the app or game

Automated file generation is not visual approval. Open every affected screen and inspect each asset in context. Check that:
- The subject, action, and setting match the intended event.
- Clinical or logical details make sense.
- Characters, equipment, anatomy, text, and signage are not visibly wrong.
- The shared style remains consistent across departments and scenes.
- Captions are readable, correctly spelled, and subtle enough for the interface.
- The crop, aspect ratio, resolution, and placement fit the component.
- Videos have suitable framing, motion, duration, and playback behavior.
- No media covers controls, patient information, or essential instructions.
- No real face, PHI, inappropriate content, horror, or unintended gore appears.
- All paths are local, all assets load, and no placeholder remains accidentally.

This step matters because an asset can pass every technical check and still be obviously wrong. A medical illustration might, for example, show an awake and conversational patient during a Code Blue. The file exists and renders, but it fails the scene.

There is also an important model-quality caveat: **if Higgsfield chooses or routes a job to a low-quality image or video model, the result may not look good.** A detailed prompt cannot fully compensate for a weak generation model. Reject poor outputs and regenerate them with a better model or replace them manually.

Do not mark the project complete until the generated media has been checked in the actual running app or game.

## 11. Running the loops safely

Looped generation can consume substantial model usage. Check progress periodically, especially during the first several assets, to make sure the agent is using the intended style, dimensions, file locations, and generator type.

If you interrupt a loop, do so between ticks after the current asset has been downloaded, inserted, verified, and recorded in the inventory. Keep the Cursor conversation history so the agent can resume with the same context. Git commits at meaningful checkpoints also make it easier to compare changes or revert a broken batch.

The loop is an accelerator, not the final art director. The placeholder contract, shared style, inventory, stop conditions, and human visual review are what turn automated generation into a dependable production workflow.