## Model parameter size

To run AI on your computer, you must have a powerful computer. There are always the 8B models, however they have low accuracy. From there, the model choices scale up quickly to 11B, 70B, 90B, 405B. 

Mobile is 1B and 3B, however more inaccurate.

Those parameters are how much weight and biases are allowed which allows the model to understand the world when relating different tokens to each other.

Another limiting factor is whether you have a GPU chip and what kind. That's going to determine what you type into PyTorch or Tensorflow to select the correct device and algorithm to run the AI training or AI inferencing on. It could range from slow to out of memory, if you choose incorrectly. The next section is guidelines on selecting device for AI

---

## Guidelines on selecting device for AI


When your code runs the model, it may load from a vector database if there was RAG (augmented the model with pdfs, txt's, etc). But you also select how the processing works -  Metal for Mac, CUDA for NVIDIA GPUs, CUDA (with ROCm toolkit installed) for AMD GPUs.

Mac BookPro M1 chips (shared cpu and gpu chip)
- Apple M1 chip has an integrated GPU. The M1's GPU is designed to provide high-performance graphics and computational capabilities, and it is built directly into the system-on-chip (SoC)
- Metal is a low-level, high-performance graphics API developed by Apple, designed to allow developers to directly access the GPU for rendering and computation tasks on Apple devices, including macOS, iOS, iPadOS, and tvOS.
- No more OpenCL on Mac. Apple has deprecated OpenCL in favor of Metal. However, it may still work for certain legacy applications, though it’s not recommended for new projects on Apple Silicon.

Windows with NVIDIA gpu chip
- if you want to use CUDA on a Windows machine, you must have an NVIDIA GPU. CUDA is a proprietary technology developed by NVIDIA, and it is specifically designed to work with NVIDIA GPUs.
- CUDA is powerful primarily because it enables efficient parallel processing on NVIDIA GPUs. It also has other optimizations that make sense for the type of math operations done in AI for high throughput.
- You can use DirectML, but CUDA preferred.

On Windows without NVIDIA gpu chip: TensorFlow with DirectML enables TensorFlow to run on non-NVIDIA GPUs that use DirectX 12 and OpenCL, particularly on AMD and Intel GPUs. By installing and configuring TensorFlow-DirectML, you can run models on these GPUs rather than relying solely on NVIDIA's CUDA.

Windows with AMD gpu chip:
- Use **Intel oneAPI** or **DirectML**. 

Windows with Intel gpu chip:
- Use **Intel oneAPI** (xpu) or **DirectML**. 
- DirectML can also accelerate machine learning on Intel integrated GPUs.

Windows without any gpu chip or a dedicated gpu chip or a well known integrated gpu chip (M1 sharing gpu with cpu)
- Frameworks like TensorFlow and PyTorch can automatically switch to CPU computation when no supported GPU is detected.

Choose one of these lines or a variation of to select your device where your model will run (cpu or gpu, and what type if applicable) - note not exhaustive

**PyTorch (does not support DirectML and OpenCL)**
```
# Check if Intel's oneAPI GPU is available device = torch.device('xpu' if torch.xpu.is_available() else 'cpu')


# Fallback to CPU if CUDA or xpu is not available
device = torch.device('cuda' if torch.cuda.is_available() else 'xpu' if torch.xpu.is_available() else 'cpu')


# Automatically uses DirectML for GPU if available, otherwise falls back to CPU device_name = "/gpu:0" if tf.test.is_gpu_available() else "/cpu:0"

```


**TensorFlow (does support DirectML)**
```
# Check if any GPU with DirectML is available
physical_devices = tf.config.experimental.list_physical_devices('GPU')

if physical_devices:
    print("Using GPU with DirectML")
    device_name = '/GPU:0'  # Use the first GPU
else:
    print("Using CPU")
    device_name = '/CPU:0'  # Fallback to CPU
```
