Generated from: [[_Generated - Prompt for tutorials from beginner level to viral high quality]]

---

## Design Principles

1. **Platform-agnostic core** — Teach nodes, models, and workflow logic that transfer across native ComfyUI, RunComfy, and Promptus.ai.
2. **Progressive difficulty** — Chapters 0–1 are browse-and-template; Chapters 2–4 add control and production skills; Chapters 5–6 cover video and builder mastery.
3. **Explicit platform routing** — Every lesson tags where to run it: free browse, local, Promptus, or RunComfy.
4. **Project-based** — Each chapter ends with a practical output (image set, consistent character, upscaled product shot, short video, capstone workflow).
5. **Numbered folders and files** — `Chapter N - Topic/` with lessons `N.M - Title.md`.

---

## Chapter Map

| Chapter | Focus | Lessons | Capstone Output |
|---------|-------|---------|-----------------|
| **0** — Foundations and Platform Choice | Roadmap, tools, learning method, when to use what | 0.0–0.3 | Pick your primary platform for the next 4 weeks |
| **1** — First Steps and Core Concepts | Free inspiration, first generation, core nodes, prompts, mistakes | 1.0–1.4 | One successful text-to-image from a template |
| **2** — Text to Image Mastery | Models, txt2img deep dive, img2img, tuning, LoRA | 2.0–2.4 | Styled image series with LoRA + tuned sampler |
| **3** — Control and Consistency | ControlNet, character consistency, inpaint, face fix | 3.0–3.3 | Same character in 3 poses/scenes |
| **4** — Production Quality and Use Cases | Upscale, product, social formats, viral hooks | 4.0–4.3 | Platform-ready social post with upscale |
| **5** — Video and Motion | Video landscape, img2vid, txt2vid, cinematic shorts | 5.0–5.3 | 3–5 second motion clip from your image |
| **6** — Workflow Builder and Viral Mastery | Build from scratch, portability, custom nodes, strategy, capstone | 6.0–6.4 | Original reusable workflow + content batch |

**Total:** 7 chapters, 28 lessons, 1 primer.

---

## Common-Denominator Models and Nodes (2026)

These appear across local and hosted ComfyUI and map cleanly to template platforms:

| Category | Common choices | Why teach them |
|----------|----------------|----------------|
| Checkpoints | SDXL, Flux Dev/Schnell, Z-Image-Turbo | Wide template support, good quality/speed tradeoffs |
| Core nodes | Load Checkpoint, CLIP Text Encode, VAE Decode, KSampler, Empty Latent | Every txt2img workflow uses these |
| Control | ControlNet (Canny, Depth, OpenPose) | Pose and composition control |
| Add-ons | LoRA loaders | Style and subject without full fine-tune |
| Quality | Upscale (ESRGAN, Ultimate SD Upscale) | Production and social-ready resolution |
| Video | AnimateDiff, image-to-video stacks (platform-dependent) | Short-form and cinematic motion |

---

## Platform Routing Key (used in every lesson)

| Tag | When to use |
|-----|-------------|
| **Browse only** | Comfy.org, OpenArt — study workflows, no GPU needed |
| **Local ComfyUI** | Stable lessons, M1 Mac or NVIDIA GPU, free long-term |
| **Promptus.ai** | Beginner template runs, no local setup |
| **RunComfy** | CUDA-heavy, custom nodes, video, or when local setup fails |
| **Stability Matrix / InvokeAI** | Optional local setup helpers (Chapter 0 only) |

---

## Lesson File Template

Each lesson includes:

- **Learning objectives** (3–5 bullets)
- **Platform note** (dependency / CUDA / stable for most computers)
- **Steps** (numbered, actionable)
- **Beginner mistakes** (where relevant)
- **Project checkpoint** (what you should have when done)
- **Next:** wikilink to following lesson

---

## Generation Order

1. `__PRIMER - Learn by Leveling Up - ComfyUI-Like.md` — MOC entry point
2. Chapter 0 (all lessons)
3. Chapters 1–6 (sequential)

---

## Cross-Links

- Primer links to [[0.0 - Roadmap - Beginner to Viral Quality]]
- MOC ([[Z - Learn by leveling up MOC (Devbrain)]]) already references the primer
- Sibling track: `_Learn by Leveling Up - ComfyUI` (native ComfyUI node deep dives) — link where overlap exists (e.g. KSampler detail in 1.2)

---

## Status

- [x] Plan written
- [x] Primer and all 28 lessons generated
