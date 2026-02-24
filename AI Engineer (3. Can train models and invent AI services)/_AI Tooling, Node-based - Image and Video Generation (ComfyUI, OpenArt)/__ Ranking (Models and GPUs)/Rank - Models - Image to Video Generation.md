True as of Feb 2026

---

## Image-to-Video Models in 2026: Local Accessibility, Capability, and Practical Deployment

### Executive summary

Modern image-to-video (I2V) systems fall into two broad families: (a) **image diffusion “backbones” extended with temporal components** (motion modules, temporal attention layers, 3D/temporal VAEs) and (b) **native video diffusion or next-frame video diffusion systems** trained directly for temporal coherence. The difference matters because **a plain image checkpoint (e.g., SD 1.5 / SDXL) is not, by itself, a video model**; it lacks temporal modeling and was not trained to maintain consistency across frames. Turning an image model into a video generator generally requires **inserting temporal layers and/or finetuning on video** data. 

In 2026, the most “run-it-locally on an average gaming PC” options are typically **FramePack** (notable for claiming 6GB VRAM minimum) and **AnimateDiff-style motion modules on SD 1.5** (short clips / looping / storyboard-friendly). Heavier open-weight models such as **Wan2.2**, **SkyReels‑V3**, and **CogVideo-style I2V checkpoints** can produce higher fidelity and longer temporal structure, but they usually require **substantial VRAM (often 16–24GB+ in practical use)**, substantial **system RAM for offload/quantization workflows**, and a CUDA-centric stack. 

At the “most capable” end, commercial systems increasingly combine video with **native audio** (dialogue/sound effects/ambience) and support first/last frame conditioning, multi-image guidance, and extension workflows: **Sora 2** by OpenAI, **Veo 3.1** by Google, and **Runway Gen‑4.5** by Runway all publicly describe native or synchronized audio capabilities (with different product constraints and access models). 

A recurring practical theme across local pipelines is **precision and offload realism**:

- **fp16/bf16** usually reduces memory footprint (float16/bfloat16 are half the size of float32) and is often the default for GPUs, but it does not guarantee speedups on every device or backend. 
- On CPU-only or certain accelerators/backends, fp16 can be **silently upcast to fp32**, show **little/no speed benefit**, or even trigger **runtime failures** (notably in some Apple MPS + float16 configurations). 
- “Low-VRAM” modes frequently trade VRAM for **system RAM + PCIe transfers**, and are often **extremely slow**. 

### Scope, definitions, and ranking method

This report focuses on **image-to-video generation** where an input image (or a small set of reference images) is used to generate a short video clip. Some systems also accept text prompts, audio, or first/last frame constraints, but the core question is whether an image can be turned into a temporally coherent sequence. 

#### What “6 seconds at 24fps” implies for compute

A 6-second, 24fps clip is **144 frames**. Many open I2V checkpoints historically generate **far fewer frames** per sampling run (for example, Stable Video Diffusion is described as generating 25 frames at 576×1024 for one of its released variants). That means “6 seconds at 24fps” often requires one of these strategies:

- generate **multiple shorter clips** and stitch them,
- generate at a lower FPS and apply **frame interpolation**, or
- use a model that natively targets ~24fps output lengths. 

#### Ranking lens

The requested ranking is **from most locally accessible to most capable**. “Locally accessible” weights: (a) minimal VRAM + realistic consumer installation, (b) open weights / runnable without cloud credits, and (c) workable inference speed with sane compromises. “Most capable” weights: (a) resolution and duration, (b) temporal consistency and controllability, and (c) integrated audio/dialogue capabilities where applicable. 

#### Reference workflow patterns (used throughout tables)

![[Pasted image 20260223184622.png]]
^ Mermaid code is:
```
flowchart TD
  A[Input image] --> B{Choose I2V approach}
  B --> C[Motion-module on image model<br/>e.g., AnimateDiff-style]
  B --> D[Native video diffusion / DiT I2V<br/>e.g., SVD, Wan2.2, SkyReels, CogVideo-style]
  B --> E[Next-frame / streaming diffusion<br/>e.g., FramePack]

  C --> F[Generate short clip windows]
  F --> G[Stitch / loop / stabilize]
  G --> H[Optional: frame interpolation to 24fps]
  H --> I[Optional: upscale / denoise]
  I --> J[Optional: add audio pipeline<br/>TTS or foley or music, or native audio if model supports]

  D --> K[Generate clip at target fps/resolution]
  K --> I
  E --> L[Generate frames/sections progressively]
  L --> G
```

The diagram reflects common open workflows described in model docs: SVD describing short clips and interpolation usage in API context, Wan2.2 describing 24fps 720p generation with optional TTS support, and FramePack describing progressive/section-based next-frame generation. 

#### Timeline snapshot of notable releases relevant to I2V

2023Stable VideoDiffusion researchrelease familydescribed as addingtemporal layers toimage diffusionbackbonesAnimateDiffintroduced as aplug-and-play motionprior module forStableDiffusion-familymodels2024SVD model cardsdocumentimage-conditionedshort clip generationand published A100inference times2025Wan2.2 releasedwith I2V/T2V/TI2Vvariants and 24fps720p claims forTI2V-5BFramePack releasedwith 6GB VRAMminimum claim andnext-frame/sectiongeneration UISora 2 announced asflagship video+audiomodelRunway Gen-4.5announced with laterupdates describingnative audio +multi-shot editing2026SkyReels‑V3 releasedwith multi-referenceI2V, video extension,and talking-avatar(image+audio)modesVeo 3.1 documentedin Gemini API with8-second outputs upto 4k and nativeaudio

Show code

These items are directly described in the Stable Video Diffusion paper/summary, AnimateDiff repo, Wan2.2 repo, FramePack repo, and the public product/API pages for Sora 2, Veo 3.1, Runway Gen‑4.5, and SkyReels‑V3. 

### Can SD 1.5 and SDXL checkpoints do image-to-video?

#### Direct answer

**Not by themselves, not in the way people mean by “image-to-video.”** A plain SD 1.5 or SDXL checkpoint is an **image generator**: it produces a single frame at a time and has no built-in objective or architecture component that forces temporal consistency across frames. If you run it frame-by-frame, you usually get flicker and identity drift because each frame is effectively a new sample. 

#### Why not, technically?

Two consistent points show up in primary sources:

1. **Video diffusion work commonly starts from an image diffusion model but requires temporal augmentation.** The Stable Video Diffusion paper explicitly notes that latent diffusion models trained for 2D images have been turned into video models by **inserting temporal layers** and finetuning on video. 
    
2. **Motion modules and video finetunes are “the missing piece.”** AnimateDiff describes itself as a “plug-and-play module turning most community text-to-image models into animation generators” without needing additional training for each downstream SD-derived model, meaning the SD checkpoint is a backbone and the motion module supplies the transferable motion prior. 
    

So: SD 1.5/SDXL checkpoints are best understood as **backbones** that can participate in I2V **when paired with** (a) motion modules (AnimateDiff-style) or (b) full video diffusion finetunes (SVD-style or larger DiT-based systems). 

### Ranked 2026 image-to-video model landscape

The ranking below is intentionally **single-axis** (local accessibility → capability). Each entry includes the required details: precision variants, VRAM/RAM expectations, CPU feasibility, platform notes, runtime ranges for the requested example tasks, audio handling, and the typical I2V workflow pattern.

#### FramePack

**Why it ranks highly for local accessibility:** it is explicitly positioned as “video diffusion, but feels like image diffusion,” with **minimum VRAM claims of 6GB** and a desktop UI. 

**Precision variants:** the repo requires GPUs that support fp16 and bf16; it also discusses the influence of quantization and “TeaCache,” implying multiple lower-precision/acceleration modes in practice. 

**VRAM and system RAM:**

- Stated minimum: **6GB GPU memory**, with RTX 30/40/50 series noted as the target GPU family. 
- The repo warns that it downloads **30GB+** of models and supports multiple attention backends; in real low-VRAM usage, available **CPU RAM becomes relevant** when aggressive offloading is used (also echoed by Diffusers “group offloading” guidance “depending on the amount of CPU RAM available”). 

**CPU feasibility:** Not realistic as CPU-only for the “144-frame” task; the project’s stated requirements assume CUDA-class GPUs. 

**CUDA / Metal / ROCm:** Effectively **CUDA-centric**: the Windows one-click package is explicitly “CUDA + PyTorch,” and hardware requirements list NVIDIA RTX 30/40/50. 

**Example runtime expectations (realistic ranges):** FramePack provides unusually concrete speed guidance:

- RTX 4090: ~2.5 seconds/frame unoptimized or ~1.5 seconds/frame with TeaCache.   
    From that, a 6s@24fps clip (144 frames) is roughly:
- **512×512, no audio:** ~4–6 minutes on a high-end GPU tier (16–24GB class, assuming similar compute to a 4090-class desktop), and **~15–30+ minutes** on laptop-class GPUs that are reported as 4× to 8× slower. 
- **1024×1024, no audio:** not specified in core docs; in practice expect a **large multiplier** (often 2×–4× or more) due to pixel/latent scaling and memory pressure, and treat it as “likely impractical” on 6–8GB tiers for 144 frames. 
- **With audio:** FramePack is fundamentally video; audio requires a separate pipeline (TTS/foley/music). 

**Workflow:** next-frame / next-frame-section generation with progressive extension (“videos will be generated longer and longer”), ideal for long-form generation and iterative preview. 

#### AnimateDiff

**Why it ranks highly for local accessibility:** it is designed to reuse SD-family models as backbones and is widely deployed through popular UIs, making it a common “first working I2V-like animation” option on consumer GPUs (especially SD 1.5-based workflows). AnimateDiff explicitly describes itself as a plug-and-play module that turns text-to-image models into animation generators. 

**Precision variants:** typically used in fp16 workflows in consumer pipelines (standard SD ecosystem practice), though the repo itself frames it as a modular add-on rather than publishing a single “fp16 checkpoint vs fp32 checkpoint” split for all components. 

**VRAM and system RAM:**

- For SDXL-based high-resolution clips, the repo states that **1024×1024×16 frames** inference usually requires **~13GB VRAM**, depending on hyperparameters and the chosen SDXL-derived model. 
- SD 1.5-based motion-module workflows can be substantially lighter; community VRAM profiling for one mainstream web UI extension reports ~4–6GB VRAM figures for 512px, 16-frame clips depending on attention backend and other toggles (this is not a universal guarantee, but it establishes feasibility on lower tiers). 

**CPU feasibility:** Not realistic for “6 seconds @ 24fps” output. Even “sequential CPU offload” strategies that reduce GPU memory are explicitly described as extremely slow in Diffusers, and AnimateDiff requires many diffusion steps across many frames. 

**CUDA / Metal / ROCm:** Works wherever SD pipelines work, but performance and kernel availability are highly dependent on backend; CUDA-equipped NVIDIA GPUs are the most reliable for throughput in practice. Apple MPS support exists in Diffusers broadly, but float16 can fail in some MPS configurations (a relevant caution for SD-family users on Mac). 

**Example runtime expectations:** The AnimateDiff repo does not publish a single canonical “seconds per clip” figure; in practice, it behaves like “SD per frame × number of frames,” with additional overhead for temporal modules. The SDXL note (“tuned hyperparameters”) underscores that sampling steps materially impact feasibility. 

- **512×512, no audio:** typically “minutes” on 8–16GB GPUs for short clips; for a full 144-frame 6s@24fps piece, expect stitching/windowing or looping. 
- **1024×1024, no audio:** aligns with the SDXL note—VRAM ~13GB for 16-frame 1024 clips, but 144 frames at that resolution is generally a multi-window / multi-pass editing problem. 
- **With audio:** not produced; add externally. 

**Workflow:** motion module + (optional) motion LoRAs + generation in short windows; then looping, keyframing, interpolation, and editing for longer sequences. 

#### Stable Video Diffusion

**Why it ranks mid-pack:** It is a canonical open I2V model family, but it is oriented toward short clips and historically has had heavier memory demands (with optimizations possible). 

**Precision variants:** A key fp16 vs fp32 detail is explicitly documented for the “1.1” line: a Stability AI-affiliated response notes that earlier files were released in fp32, but newer releases move toward fp16, stating fp32 “wastes VRAM” and does not change results for that context. 

**VRAM and system RAM:**

- The model card describes the core behavior: a latent diffusion model trained to generate **25 frames at 576×1024** given a context frame, and notes the videos are short (≤4 seconds). 
- The same card reports baseline inference times on A100 80GB: ~100s for SVD and ~180s for SVD-XT, and points out that optimizations can trade off memory/speed for lower VRAM cards. 
- Practical VRAM minima vary substantially with implementation details (decoder strategy, attention kernels, offload, etc.), which is why many real deployments treat SVD as “12–24GB class with aggressive tricks if lower.” The model card itself emphasizes that memory/speed tradeoffs exist. 

**CPU feasibility:** Possible in principle (Diffusers pipelines can run without GPU), but **not realistic** for the requested 144-frame target. Even the best-memory “sequential offload” is described as extremely slow due to repeated onload/offload cycles across diffusion steps. 

**CUDA / Metal / ROCm:** Typically deployed on CUDA GPUs; Apple MPS can help for some Diffusers pipelines, but fp16/MPS edge cases exist and are widely discussed in Diffusers issue tracking. 

**Example runtime expectations:**

- **512×512, no audio:** SVD natively targets a different resolution and limited frame counts, so producing a 6s@24fps artifact usually means stitching multiple runs and interpolating. The Stability API post describes producing 2 seconds of video (25 generated frames plus 24 frames of FILM interpolation) in an average of 41 seconds (service-side), illustrating the common “generate → interpolate” pattern. 
- **1024×1024:** not a native spec; scaling up is highly memory sensitive. 
- **With audio:** the model itself is video; audio requires separate tooling. 

**Workflow:** native I2V diffusion for short clips, often paired with separate **frame interpolation** and editorial stitching to reach higher fps/longer duration. 

#### CogVideo-style I2V models

**Why they rank as “more capable but less accessible than motion modules”:** These are generally larger video models with explicit video-oriented architectures and published memory/precision knobs, but they can still be made to run on consumer GPUs via quantization/offload at steep speed costs. 

**Precision variants:** CogVideoX-5B-I2V lists inference precision options including **FP16, BF16, FP32**, and quantized modes (e.g., INT8) with several deployment paths (SAT vs Diffusers). 

**VRAM and system RAM:** Two different “truths” are documented, depending on whether you accept aggressive optimization:

- The CogVideoX-5B-I2V model card lists “single GPU memory usage” for SAT fp16 at 18GB, while Diffusers usage is documented as “from 4GB*” (with an explicit note that it was tested with all Diffusers optimizations on A100/H100, and that disabling optimizations can multiply memory use ~3×). 
- The Diffusers documentation for CogVideoX states that a **quantized CogVideoX 5B** configuration requires **~16GB of VRAM** (a more practical consumer anchor point for “not absurdly slow” use). 

Because many low-VRAM strategies offload to CPU, sufficient **system RAM** becomes important; Diffusers explicitly notes that sequential CPU offload “may work but is extremely slow.” 

**CPU feasibility:** Technically possible via offload, but generally not realistic for fast iteration; community guidance around sequential offload in similar CogVideoX contexts describes “extremely slow (1 hour+)” behavior in constrained-kernel environments. 

**CUDA / Metal / ROCm:** Production guidance is strongly CUDA/NVIDIA-coded: the model card notes testing on A100/H100 and suggests adaptability to NVIDIA Ampere and above; sample code targets CUDA explicitly. 

**Example runtime expectations:** The model card publishes A100/H100 timing at 50 steps, enabling first-principles bounding:

- CogVideoX-5B-I2V speed is listed around ~180s on A100 and ~90s on H100 under those settings.   
    Given consumer GPUs differ, the safest “realistic” guidance is:
- **512×512, 6s@24fps:** CogVideoX-5B-I2V’s published “6 seconds” spec is at **8 fps** and **720×480**, meaning 24fps output usually requires interpolation, and performance is dominated by the base generation plus interpolation overhead. 
- **1024×1024:** not supported for the I2V checkpoint described in the card (“no support for other resolutions”), so treat as N/A for that specific checkpoint. 
- **With audio:** not produced; external. 

**Workflow:** native video pipeline (text+image conditioning) with optional quantization and CPU offload; interpolation/upscaling often layered on top to reach modern delivery formats. 

#### Wan2.2

**Why it ranks as a major “capable open model” but not “most locally accessible”:** It describes 720p@24fps generation, multiple modalities (I2V/T2V/TI2V/S2V), and a wide ecosystem of acceleration/quantization projects—yet its own repository shows that some variants are extremely VRAM-hungry without multi-GPU strategies. 

**Precision variants:** The repo and ecosystem emphasize dtype conversion and multiple acceleration/quantization approaches; it also points to step-distillation models and quantized models through community works. 

**VRAM and system RAM:** The repo gives concrete VRAM guidance for different variants:

- For T2V-A14B, a single-GPU command is stated to run on **≥80GB VRAM**. 
- For the TI2V-5B model, a single-GPU command is stated to run on **≥24GB VRAM** (example: RTX 4090). 
- The repo explicitly recommends offload/model dtype conversion knobs to reduce GPU memory usage (which tends to increase CPU RAM pressure and runtime). 

Real-world system RAM sizing is less cleanly “official,” but the prevalence of offload and large checkpoint sizes makes **32–64GB** a common practical tier for stable operation in many setups (offload puts more pressure on system memory, and Diffusers warns about slowness from sequential offloading). 

**CPU feasibility:** Not realistic CPU-only for the requested clips; even “VRAM-saving” modes are GPU-first and become very slow with CPU-offload strategies. 

**CUDA / Metal / ROCm:** The repo’s code examples and pipelines target CUDA devices explicitly (e.g., `device="cuda:0"` in Diffusers pipeline examples) and rely on GPU-centric tooling; treat CUDA as the expected path for workable performance. 

**Example runtime expectations (based on published repo claims):**

- The repo states: TI2V-5B can generate a **5-second 720p** video in **under 9 minutes** on a single consumer-grade GPU without specific optimization.   
    From that, for the requested examples:
- **6 seconds @ 512×512 @ 24fps, no audio:** typically still “multi-minute,” with smaller resolution partially offset by the frame count target; practical expectation is **~5–15 minutes** on 16–24GB GPUs depending on settings and whether you can run without heavy offload. 
- **6 seconds @ 1024×1024 @ 24fps, no audio:** typically “very hard” for consumer VRAM without heavy tricks; treat as **often not feasible** on 12GB and below, and “long (tens of minutes)” even on higher tiers if it runs. 
- **With audio:** Wan2.2 includes speech-driven modes and also mentions text-to-speech support via CosyVoice for Speech-to-Video tasks; this is not “native audio generation inside the video diffusion model,” but an integrated pipeline option for obtaining an audio track. 

**Workflow:** native video diffusion family with multiple tasks; user chooses TI2V-5B for single-GPU 24GB-class workflows, while larger MoE variants may require multi-GPU inference or aggressive offload/quantization. 

#### SkyReels‑V3

**Why it ranks near the top for open-weight capability:** it offers a unified suite: multi-reference image-to-video, video extension (including long extension windows), and talking-avatar generation driven by image+audio, and it positions itself as a flagship model with 720p and 24fps recommendations. 

**Precision variants:** It documents an explicit low-VRAM mode that enables **FP8 weight-only quantization and block offload**, implying baseline weights are higher precision (fp16/bf16-class) even if not spelled out line-by-line in the model card. 

**VRAM and system RAM:**

- The model card recommends “CUDA 12.8+,” which implies a modern GPU stack, and gives a strong hint about VRAM expectations: “For GPUs with lower VRAM (e.g., under 24GB), use `--low_vram`” and reduce resolution. 
- Because low-VRAM mode uses offload, system RAM becomes part of feasibility (consistent with general Diffusers offload guidance: it can make things fit but can be extremely slow). 

**CPU feasibility:** Not realistic CPU-only. 

**CUDA / Metal / ROCm:** The official install recommendation is CUDA-centric; treat this as a **CUDA-first** model in practical local setups. 

**Example runtime expectations:** SkyReels‑V3 does not publish a single “seconds per clip on X GPU” number in the official model card excerpted here; the most defensible stance is to treat it as **more compute/VRAM demanding than Wan2.2 TI2V-5B and much more demanding than FramePack/AnimateDiff**, especially for multi-reference and long extension. The card’s emphasis on quantization/offload for <24GB VRAM indicates that “consumer GPU feasible” is possible but not necessarily fast. 

- **512×512 6s@24fps:** likely not the target; recommended output is 720p, 24fps, with 5-second spec noted for reference-to-video. 
- **With audio:** talking avatar mode is explicitly driven by an audio clip (≤200 seconds) plus a portrait image; audio is an input to drive lip sync, not a generated soundtrack. 

**Workflow:** unified multimodal in-context video generation; reference images + text prompt for I2V, video extension for continuity (5–30 seconds for single-shot extension), and image+audio talking avatar. 

#### Runway Gen‑4.5

**Position in the ranking:** among the most capable in practice for creators, with strong controllability and later-described native audio and multi-shot editing, but it is not “local” in the open-weights sense.

**Precision variants:** not disclosed publicly as fp16 vs fp32 checkpoints (closed service), so treat as “not applicable / not user-selectable.” 

**VRAM/system RAM and CPU feasibility:** not applicable for the consumer because the model is served; local hardware requirements are basically “browser/app + network.” 

**CUDA / Metal / ROCm:** not applicable as an end-user requirement (service). 

**Output specs relevant to the example tasks:** Runway’s help center documents Gen‑4.5 image-to-video output as 720p at 24fps, durations 2–10 seconds, and multiple aspect ratios. 

**Audio:** Runway’s research updates for Gen‑4.5 explicitly describe native audio generation (dialogue, sound effects, background audio) and audio editing, plus multi-shot editing. 

**Runtime expectations:** Runway does not provide a single guaranteed wall-clock per clip in the official spec excerpt; real latency varies with load and plan mode. A conservative expectation, consistent with how these systems are described (short clips, interactive creation), is “minutes-level,” but exact ranges are not officially standardized in the cited spec. 

**Workflow:** image-to-video generation as a product mode with prompt + image, then possible multi-shot editing and audio editing/generation as described in later updates. 

#### Veo 3.1

**Position:** extremely capable on published specs (up to 4k, native audio, first/last frame and multi-reference), served via API/product.

**Precision variants:** closed; not published as user-selectable fp16/fp32 checkpoints. 

**VRAM/system RAM and CPU feasibility:** not applicable to end-users (service). 

**CUDA / Metal / ROCm:** not applicable for users (service). 

**Output specs:** the Gemini API documentation describes Veo 3.1 as generating **8-second** videos at **720p, 1080p, or 4k**, with **natively generated audio**, and supports “frame-specific generation” (first and/or last frames) and up to three reference images. 

**Runtime expectations:** the official doc excerpt does not provide a fixed latency number; typical service performance depends on queue and variant. 

**Workflow:** API-oriented generation with explicit support for start/end frames and reference images—very directly aligned with I2V and keyframe workflows. 

#### Sora 2

**Position:** among the most capable for “world simulation” and native audio, but served as a product/app.

**Precision variants:** not disclosed as fp16 vs fp32 checkpoints to users. 

**VRAM/system RAM and CPU feasibility:** not applicable to end-users (service). 

**CUDA / Metal / ROCm:** not applicable to end-users. 

**Audio:** the product announcement describes Sora 2 as a “video and audio generation model” with synchronized dialogue and sound effects. 

**Runtime expectations:** an OpenAI help-center article states it may take **up to a minute** for Sora to generate a video after submitting a prompt (service-side). 

**Workflow:** product/app-based creation, including “upload yourself” style image-driven creation mentioned in the announcement, aligning with I2V use. 

### Performance, precision, and system requirement tables

This section consolidates the above into tables and adds explicit fp16 vs fp32 guidance and the requested hardware-tier timing ranges. Where a model’s official docs do not publish a precise figure, the table uses conservative “range bands” and labels the main driver of uncertainty (offload, interpolation, service queue).

#### Model attribute comparison table

|Model|Typical I2V mechanism|Precision variants available to user|Practical VRAM tier to target|System RAM tier to target|CPU-only feasible?|CUDA / Metal / ROCm notes|Audio produced by model?|
|---|---|---|---|---|---|---|---|
|FramePack|next-frame / section-based progressive diffusion|fp16/bf16-capable GPU required; quantization/acceleration modes discussed|**6GB minimum** stated; 8–12GB more comfortable|16–32GB+ suggested when offloading is used|No (practically)|NVIDIA RTX 30/40/50 requirement implies CUDA-first|No (external audio pipeline)|
|AnimateDiff|motion module added to SD-family backbone|SD ecosystem fp16/fp32 common; SDXL path cites VRAM expectations|SDXL: ~13GB for 1024×1024×16 frames; SD1.5 clips can run lower|16–32GB|No (practically)|Works best on CUDA; MPS can be tricky with fp16 on some configs|No (external)|
|Stable Video Diffusion|native I2V diffusion for short clips|fp16 vs fp32 explicitly discussed for SVD 1.1 line|commonly 12–24GB class in practice; depends heavily on implementation|16–32GB+ if offload|No (practically)|CUDA typical; MPS support varies; fp16 MPS issues exist|No (external)|
|CogVideoX-5B-I2V|native video diffusion pipeline|FP16/BF16/FP32 + INT8 options documented|~16GB VRAM for quantified 5B noted; heavier if no optimizations|32GB+ if offload-heavy|No (practically)|Explicit CUDA usage and NVIDIA testing emphasized|No (external)|
|Wan2.2 TI2V-5B|native TI2V (text+image) video diffusion|multiple dtype conversion + distillation/quant ecosystem|**24GB VRAM** stated for single-GPU TI2V-5B command|32–64GB commonly used when offloading|No (practically)|CUDA pipeline examples; multi-GPU acceleration described|Not natively; optional TTS pipeline exists for speech workflows|
|SkyReels‑V3|unified multimodal: ref images→video, extension, talking avatar|FP8 low-VRAM quantization mode documented|≥24GB implied by “under 24GB use low_vram + reduce resolution”|32–64GB if offload|No (practically)|CUDA 12.8+ recommended|Talking-avatar is audio-driven (audio input), not soundtrack generation|
|Runway Gen‑4.5|hosted I2V + editing modes|not user-selectable|N/A (service)|N/A|N/A|N/A|Yes (native audio generation + editing described)|
|Veo 3.1|hosted video model with ref images + keyframes|not user-selectable|N/A (service)|N/A|N/A|N/A|Yes (native audio in API docs)|
|Sora 2|hosted video+audio model with image-driven creation|not user-selectable|N/A (service)|N/A|N/A|N/A|Yes (dialogue + SFX described)|

Sources for the factual fields above are the primary model pages/docs: FramePack repo, AnimateDiff repo, SVD model card + fp16 discussion, CogVideoX model card + Diffusers docs, Wan2.2 repo, SkyReels‑V3 model card, Runway Gen‑4.5 help + Runway research update, Veo 3.1 Gemini API docs, and Sora help + product page. 

#### Timing tables by hardware tier

These tables target your requested tasks:

- **Task A:** 6s @ 24fps @ **512×512**, video-only.
- **Task B:** Task A **with audio** (either native audio model, or external audio pipeline).
- **Task C:** 6s @ 24fps @ **1024×1024**, video-only (often impractical locally).

Because not every model natively generates 144 frames at 512×512, “time” includes common necessary steps such as stitching or interpolation when that is the standard workflow (e.g., SVD + interpolation patterns). 

##### 6GB GPU tier

|Model|Task A: 6s 512×512 video-only|Task B: with audio|Task C: 6s 1024×1024 video-only|
|---|---|---|---|
|FramePack|**Likely feasible**; expect ~20–40 min depending on how closely your GPU matches the “laptop 4×–8× slower than 4090” guidance|Add external audio pass (typically seconds–minutes)|Likely impractical (time/memory blow-up)|
|AnimateDiff (SD1.5)|Short-window clips feasible; full 144-frame output usually requires multi-window generation and editing; “minutes → tens of minutes”|External audio|Generally impractical|
|Stable Video Diffusion|Often not feasible without extreme offload; even then very slow|External audio|Not realistic|
|CogVideo-style I2V|Possible only with aggressive offload/quantization; typically very slow|External audio|Not supported for the cited 720×480-only I2V checkpoint|
|Wan2.2 / SkyReels‑V3|Not realistic|—|—|

The 6GB feasibility anchors are: FramePack’s explicit 6GB minimum and relative speed guidance, plus general diffusion offload warnings (extremely slow) when forcing large pipelines onto small VRAM. 

##### 8GB GPU tier

|Model|Task A: 6s 512×512 video-only|Task B: with audio|Task C: 6s 1024×1024 video-only|
|---|---|---|---|
|FramePack|Often feasible; ~15–30+ min on many laptop-class GPUs|External audio|Often impractical|
|AnimateDiff (SD1.5)|Often feasible for short clips; long 144-frame sequences are editing-heavy|External audio|Usually impractical|
|Stable Video Diffusion|Highly variable; may require offload and still be very slow|External audio|Not realistic|
|CogVideo-style I2V|Possible with heavy optimization; still slow|External audio|Not supported for the cited I2V checkpoint|
|Wan2.2 / SkyReels‑V3|Not realistic|—|—|

The 8GB story is essentially “FramePack and motion-module SD-based approaches first; everything else becomes ‘fit-at-any-cost’ and slow.” 

##### 12GB GPU tier

|Model|Task A: 6s 512×512 video-only|Task B: with audio|Task C: 6s 1024×1024 video-only|
|---|---|---|---|
|FramePack|~10–20 min plausible depending on GPU class|External audio|Often impractical without major compromises|
|AnimateDiff (SDXL starts to become viable for short clips)|SD 1.5 very workable; SDXL short clips feasible per ~13GB-class note (borderline)|External audio|Often impractical for long sequences|
|Stable Video Diffusion|Sometimes feasible with optimizations; expect “slow minutes” per clip window|External audio|Very difficult|
|CogVideo-style I2V|With quantization/offload, may be feasible; still slow|External audio|Not supported for the cited I2V checkpoint|
|Wan2.2 TI2V-5B|Generally not feasible at full spec|External audio / optional TTS workflow|Not realistic|
|SkyReels‑V3|Generally not feasible|—|—|

Anchors: AnimateDiff SDXL VRAM note, CogVideoX VRAM guidance in Diffusers docs, and the reality that SVD/Wan2.2/SkyReels describe heavier targets or explicit >24GB guidance for comfortable operation. 

##### 16–24GB GPU tier

|Model|Task A: 6s 512×512 video-only|Task B: with audio|Task C: 6s 1024×1024 video-only|
|---|---|---|---|
|FramePack|~4–10 min (depends on TeaCache/attention kernels)|External audio|Sometimes feasible but costly (often 2×–4× slower or worse)|
|AnimateDiff|Comfortable for both SD1.5 and SDXL short windows; 144-frame sequences still benefit from windowing/editing|External audio|Potentially feasible but heavy|
|Stable Video Diffusion|Feasible for short clips; 6s@24fps typically requires stitching/interpolation steps|External audio|Difficult; heavy|
|CogVideoX-5B-I2V|Practical with ~16GB-class setups in quantized mode; base generation is “minutes-scale”|External audio|Not supported for the cited fixed-resolution I2V checkpoint|
|Wan2.2 TI2V-5B|**24GB-class target**; repo claims 5s 720p under 9 min on single consumer GPU (baseline)|Optional TTS pipeline for speech workflows; otherwise external audio|Generally impractical at 1024×1024 for 144 frames|
|SkyReels‑V3|Borderline; official guidance suggests <24GB requires FP8 + offload + lowered resolution|Audio-driven talking avatars (audio input), no native soundtrack|Very difficult|

Anchors: FramePack seconds-per-frame guidance, Wan2.2 “under 9 minutes” claim and 24GB VRAM claim, CogVideoX quantized ~16GB VRAM note, SkyReels “under 24GB use low_vram FP8 offload,” and SVD A100 timing scale plus memory tradeoff note. 

##### CPU-only modern i7 / Ryzen 7 tier

CPU-only for 6-second 24fps video diffusion is generally **not a realistic target** in 2026 for these models. The strongest evidence is indirect but consistent: the best-known “memory rescue” tactics in Diffusers (sequential CPU offload) are documented as extremely slow, and even GPU users describe these techniques as last-resort for fitting models, not for speed. 

If you must do CPU-only, you should expect **hours per clip** for diffusion-based video generation at meaningful quality—so the practical recommendation is “use cloud” for anything beyond toy demos. 

#### Runtime vs VRAM chart

The chart below uses FramePack because it is one of the few projects that publishes both a **minimum VRAM requirement** and a **seconds-per-frame** reference point on a known GPU, plus relative slowdown estimates for laptop GPUs. Values are approximate midpoints for Task A (6s@24fps, 144 frames, video-only) and assume the “4×–8× slower on laptops” guidance for lower tiers. 

Estimated runtime vs VRAM tier (FramePack, 6s@24fps, 512×512, video-only)6GB8GB12GB16GB24GB4035302520151050minutes (median estimate)

Show code

### Practical recommendations for running locally

#### Safe default settings for local I2V

Across the open-source models surveyed, the most robust “don’t crash your machine” posture is:

- Keep resolution conservative (many open checkpoints have a “native” working resolution; deviating upward can destroy feasibility). This is explicit in several docs: CogVideoX-5B-I2V notes a fixed resolution, Wan2.2 provides explicit 720p sizes, and SkyReels‑V3 recommends 720p with guidance to lower resolution in low-VRAM mode. 
- Prefer batch size 1 and generate shorter clips, then extend via windowing/stitching or model-native extension modes where available (SkyReels extension, Veo extension, Runway multi-shot editing). 
- Treat CPU offload as a “fit it, not speed it” tool; Diffusers explicitly characterizes sequential CPU offload as extremely slow. 

#### fp16 vs fp32 guidance, including the required caveat

**Baseline rule:** fp16/bf16 usually reduces memory footprint because 16-bit floats are half the size of float32, which tends to improve feasibility on GPUs. 

**What you can safely say about quality:** At least in the SVD 1.1 context, an official response indicates fp32 did not improve results and mainly wasted VRAM, which is consistent with many diffusion inference setups where fp16 is “good enough” for sampling. 

**Critical caveat (requested): fp16 on CPU may not speed up and may cause errors.** There are three distinct failure/“no benefit” modes documented in authoritative sources:

- **Upcasting / promotion to float32:** PyTorch AMP documentation describes cases where ops run in float32 if inputs are mixed float16/float32 (promotion behavior), which can erase expected fp16 gains. 
- **CPU fp16 support gaps:** An OpenAI CLIP issue describes patching fp16 operations to fp32 when loading on CPU because “PyTorch does not support all fp16 operations” on CPU in that context—illustrating why fp16 may not work as intended off-GPU. 
- **Device/backend runtime errors:** Diffusers issue tracking documents MPS failures when using float16 in some settings, demonstrating that lower precision can increase the odds of backend-specific runtime errors (especially relevant for Macs). 

**Practical action:** default to fp16/bf16 on CUDA GPUs, but if you see unexplained NaNs, black frames, or backend errors, test fp32 (or different kernels) as a stability fallback—accepting the VRAM and speed costs. 

#### When to use cloud instead of local

Use cloud (or hosted tools) when any of these are true:

- You need **native audio** aligned with video (dialogue/SFX/ambience). This is explicitly described for Veo 3.1, Sora 2, and Runway Gen‑4.5 updates. 
- You need **4k** output or strong long-range temporal consistency without building a complicated stitching pipeline (Veo 3.1 explicitly describes 4k outputs; many open models remain 720p-class or fixed-res). 
- Your local workflow depends on extreme offload, because the best-known offload mode is documented as “extremely slow.” 

#### Troubleshooting checklist for common failures

**Out-of-memory (OOM) on GPU**

- Reduce resolution first (SkyReels explicitly advises lowering from 720p to 540p/480p in low-VRAM mode; Wan2.2 exposes memory-related flags for GPU reduction). 
- Enable offload modes, understanding they may become extremely slow (Diffusers). 
- Prefer quantized/optimized variants where documented (CogVideoX and Wan2.2 ecosystems both reference INT8/quantization paths). 

**fp16 runtime errors / strange outputs (especially non-CUDA backends)**

- On Apple MPS, test float32 if float16 fails; float16 failures are documented in Diffusers issue tracking. 
- If you must offload to CPU, be prepared for fp16 to be patched/upcast to fp32 in some stacks and for speed to collapse. 

**Non-CUDA issues (kernel availability / extreme slowness)**

- If you fall back to sequential CPU offload, treat it as last resort; it is explicitly described as extremely slow and can turn generation into an hour-scale task. 

**“Why can’t I reach 6 seconds at 24fps?”**

- Verify your base model’s native frame count and fps. Some models are trained for short clips (SVD) or lower fps (CogVideoX-5B-I2V’s published 8 fps setting), so you will need interpolation or segment stitching.


---

*Weng's personal ChatGPT thread on developing these notes: https://chatgpt.com/c/699c3c27-9274-8328-828b-6bac8716ffff*