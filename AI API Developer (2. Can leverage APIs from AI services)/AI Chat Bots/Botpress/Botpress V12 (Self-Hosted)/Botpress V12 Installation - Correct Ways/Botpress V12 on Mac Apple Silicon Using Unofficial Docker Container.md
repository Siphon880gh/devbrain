
## Why Unofficial
The official Docker container already includes the `node_modules` directory, prebuilt for x86_64 systems. There's no official ARM64 image available—so on Macs with M1/M2 chips, Docker has to emulate x86_64, which makes everything sluggish. You'll notice choppy performance and even slow startup or shutdown times (sometimes taking several minutes).

There has been multiple issues raised at the official repo on Github to provide an ARM64 image for Mac users. It's been largely a deprioritized user by their developers - probably because most users are on x86_64 and you can deploy Botpress on a live server at a secret URL to test it anyways. However, some people would prefer to try it locally on their computer first, and they're on Mac Apple Silicon (ARM64 architecture).

So Weng has build from source the `node_modules` directory on a Mac M1 Apple Silicon chip and re-build the image. It's been pushed to his Docker Hub account. 

---


## Pull from Unofficial

