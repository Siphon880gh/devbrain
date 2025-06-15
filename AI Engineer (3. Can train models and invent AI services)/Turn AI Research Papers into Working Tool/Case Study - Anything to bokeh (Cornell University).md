
> [!note] **Nvidia GPU required**  
> This pipeline **requires CUDA**, so it won’t work on machines without an Nvidia GPU (e.g., most Macs).

---

## 🔍 Finding

You come across a page showcasing an academic paper where a research team demonstrates how to apply **bokeh**, **blur**, and **focus plane adjustments** to existing videos. It’s an exciting find—especially if you’re thinking about using blurred background videos on websites, like in hero sections, or replacing black bars in videos with a zoomed-in, aesthetically blurred version of the original footage.

👉 [https://vivocameraresearch.github.io/any2bokeh/](https://vivocameraresearch.github.io/any2bokeh/)

The project supports:

1. **Bokeh Rendering Result** – Keeps the focus plane on the subject.
2. **Custom Focal Plane** – Allows you to shift focus to any plane in the video.
3. **Custom Blur Strength** – Lets you set any defocus blur intensity.

![[Pasted image 20250615012418.png]]

The page showcases a demo like this:

![[Pasted image 20250615012354.png]]

Reading the instructions, you discover this is based on academic research. The “arXiv” button links to their Cornell-hosted paper.

Clicking the **“Code”** button leads to their GitHub repository:  
👉 [https://github.com/vivoCameraResearch/any-to-bokeh](https://github.com/vivoCameraResearch/any-to-bokeh)

> [!note]  Academic Papers and Github Links
> In academic papers, if the GitHub repo isn’t directly linked in the paper, it's usually listed on the project webpage associated with the paper.

For these instructions, you cloned the repo at commit `d625b98` (June 9, 2025, 5:28 AM PDT) from the `main` branch. It creates a folder like:

```
/Users/wengffung/dev/web/bokeh/any-to-bokeh/
```

---

## ⚙️ Setup Bokeh

From within the `any-to-bokeh` folder, follow the GitHub instructions to set up the environment:

```bash
conda create -n any2bokeh python=3.10 -y
conda activate any2bokeh

# The default CUDA version is 12.4. Modify if needed for your GPU setup.

# Install PyTorch with CUDA support.
pip install torch==2.4.1 torchvision==0.19.1 torchaudio==2.4.1 --index-url https://download.pytorch.org/whl/cu124

# Clone the repo
git clone https://github.com/vivoCameraResearch/any-to-bokeh.git
cd any2bokeh
pip install -r requirements.txt
```

---

## ⚙️ Setup SAM2

Bokeh also requires **SAM2**, available at:  
👉 [https://github.com/facebookresearch/sam2](https://github.com/facebookresearch/sam2)

You cloned the repo (main branch at commit `2b90b9f`, dated Dec 15, 2025) **from within** the Bokeh folder. It creates:

```
/Users/wengffung/dev/web/bokeh/any-to-bokeh/sam2
```

From here on:

- "Bokeh" refers to the main `any-to-bokeh` repo
- "Sam2" refers to the segmentation model dependency

> [!note] ✋ SAM2’s README suggests installing using `pip install -e .`
> The README suggests installing SAM2 using `pip install -e .` — but their project installation can cause issues with your base Python or Anaconda environment. It's safer to isolate with `pyenv`:
>
> ### Step-by-step with `pyenv`:
> 
> 1. List Python versions:
>     
>     ```bash
>     pyenv install --list | grep 3.10
>     ```
>     
> 2. Install the latest 3.10.x version:
>     
>     ```bash
>     pyenv install 3.10.13
>     pyenv virtualenv 3.10.13 sam2-env
>     pyenv activate sam2-env
>     python --version
>     ```
>     
> 3. Then install SAM2:
>     
>     ```bash
>     pip install -e .
>     ```
>     

Once installed, you'll need to download the **model checkpoints**. Inside the `sam2/checkpoints` directory, run:

```bash
./download_ckpts.sh
```

It will download several large `.pt` files like:

```
sam2.1_hiera_base_plus.pt
sam2.1_hiera_large.pt
sam2.1_hiera_small.pt
sam2.1_hiera_tiny.pt
```

---

## 🎞️ Split MP4 into Frames

Back in the Bokeh root folder, prepare your video (e.g., `input.mp4`). Copy the video into the folder and split it into frames using either `ffmpeg` or the utility provided by Bokeh:

```bash
python utils/split_mp4.py input.mp4
```

This creates a folder like `output_frames/`, containing:

```
_frame_0000.png
_frame_0001.png
_frame_0002.png
...
```

> [!note] Optional: **Initial Mask Creation for SAM2**
> 
> SAM2 lets you guide its segmentation by supplying an **initial mask** for the first frame. It’s a good idea to create this now—just in case the final results aren’t accurate. You’ll be able to tweak and improve the output later using this mask.
> 
> Extract the first frame using `ffmpeg`:
> 
> ```bash
> ffmpeg -i input.mp4 frame_0000.png
> ```
> 
> Create a manual mask for it:
> 
> ```bash
> convert frame_0000.png -fill white -draw "rectangle 100,100 300,300" -fill black -colorize 100 input_masks/frame_0001.png
> ```

---

## 🧠 Generate SAM2 Masks

Now go back into the `sam2` folder and run `vos_inference.py`:

> [!note] What `vos_inference.py` does:
> 
> Performs **Video Object Segmentation (VOS)** using:
> 
> - A directory of video frames (e.g. PNGs)
>     
> - Initial mask directory (optional, usually for the first frame)
>     
> - Outputs segmentation masks per frame into an output folder
>     

```bash
python tools/vos_inference.py \
  --base_video_dir output_frames \
  --input_mask_dir input_masks \
  --output_mask_dir output_masks \
  --sam2_cfg sam2/sam2_hiera_l.yaml \
  --sam2_checkpoint checkpoints/sam2.1_hiera_large.pt
```

---

## ❌ STOP: No CUDA? You’re Done Here (Mac Users Read This)

If you're running this on a Mac or a non-Nvidia GPU setup, you'll get an error like:

```
CUDA = False
```

Unfortunately, **SAM2 requires CUDA**, and there is no CPU fallback. Your options now are:

1. Buy a Windows/Linux machine with an **Nvidia GPU**
    
2. Use a **cloud server** (e.g. AWS EC2 with GPU)
    
3. Use a **cloud-based inference platform** that provides:
    - A web IDE
    - File navigation
    - GPU runtime


Otherwise, this pipeline stops here for you.

---

## 📏 Generate Depth Maps using Video-Depth-Anything

If you do have CUDA, continue.

Bokeh uses a script `tools/pre_process.py` to generate depth maps, but it depends on [Video-Depth-Anything](https://github.com/DepthAnything/Video-Depth-Anything).

Clone it:
- For our instructions, the latest commit was main branch on commit 37b68ad, committed on 4/25/25
```bash
git clone https://github.com/DepthAnything/Video-Depth-Anything
```

Copy the `video_depth_anything` folder into the Bokeh root so it looks like this:

```
any-to-bokeh/video_depth_anything/video_depth.py
```

Then run the script:

```bash
python tools/pre_process.py \
  --img_folder output_frames \
  --mask_folder output_masks \
  --disp_dir output/depth_maps
```

---

## ✅ Now You’re Ready

You now have all the data needed to render a video with the **bokeh effect**:

- Frame images
- SAM2 segmentation masks
- Depth maps from DepthAnything

Follow the rest of the Bokeh README for rendering options like adjusting blur, focus plane, and exporting.

---

## 📄 Summary: What You Need to Apply Bokeh Blur

|Component|Required|Description|
|---|---|---|
|**MP4 Video**|✅|Source media|
|**Extracted Frames**|✅|Video split into per-frame images|
|**SAM2 Masks**|✅|Foreground/background segmentation per frame|
|**Depth Maps**|✅|Needed for depth-aware bokeh effect|
|**Initial Mask**|❌|Optional guide for segmentation (first frame only)|

---

## 📊 CSV File Required for Rendering

Bokeh expects a `.csv` file to specify which folders to use for input frames, depth maps, and blur strength.

Example:

```csv
aif_folder,disp_folder,k
demo_dataset/videos/xxx,demo_dataset/disp/xxx,16
```

Rather than writing it manually, Bokeh provides a script to generate this `.csv` for you before inference.

---

## 🧪 How Academic Pipelines Usually Work

Academic projects often:

- Release a **paper** describing a new method.
- Include a **GitHub repo** (either in the paper or on the project website).
- Build on **other academic GitHub tools**.

That means:

- You may need to **clone multiple repos**
- Each repo may have its own **setup instructions**
- Often, some repos are used _just_ to generate intermediate files (like masks or depth maps) for the main repo to consume