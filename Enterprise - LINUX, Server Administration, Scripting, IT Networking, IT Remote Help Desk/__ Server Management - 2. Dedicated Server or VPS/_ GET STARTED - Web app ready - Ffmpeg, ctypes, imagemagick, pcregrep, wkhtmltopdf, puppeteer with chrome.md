
Your online web app may perform features that your server's OS need to support.

Here are instructions on installing the most commonly needed CLI tools for web apps (ffmpeg, pcregrep, wkhtmltopdf, puppeteer + Chrome) and the OS libraries those tools need.

```toc
```

## At a glance

| Tool                      | Why you need it                                                                                                                                                                                                                                                                                                | Verify installed                                                            |
| ------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------------------------------------------------- |
| **ffmpeg**                | Convert, compress, or transcode video and audio; generate thumbnails and previews; stream or edit media. Python wrappers (e.g. `ffmpeg-python`) call the OS binary — it must exist on the server.                                                                                                              | `ffmpeg`, `ffprobe`                                                         |
| **ImageMagick**           | Convert, resize, rotate, crop, and automate image processing. Often used from PHP via the `imagick` extension, which wraps the OS install.                                                                                                                                                                     | `convert --version`, `identify --version` (`magick --version` on v7+)       |
| **pcregrep**              | Perl-compatible grep at the system level. Faster than PHP reading files and running `preg_match` — useful for log analysis, data extraction, and complex pattern matching on large text files.                                                                                                                 | `pcregrep --version`                                                        |
| **wkhtmltopdf**           | Convert HTML pages, templates, or URLs into PDFs (invoices, reports, certificates, receipts). Related tool `wkhtmltoimage` converts HTML to PNG/JPG.                                                                                                                                                           | `wkhtmltopdf --version`, `wkhtmltoimage --version`                          |
| **ctypes** (`libffi-dev`) | OS library Python uses to call C code. Required when Python packages (e.g. `ffmpeg-python`, MoviePy) interface with native libraries like FFmpeg.                                                                                                                                                              | Reinstall Python after installing `libffi-dev` if you use pyenv (see below) |
| **Puppeteer + Chrome**    | Headless Chrome renders fully styled HTML to PDF or full-page screenshots — including long scrollable pages — so layout matches the browser print dialog (Print -> Save as PDF). Linux does **not** need a desktop GUI; Puppeteer runs Chrome headlessly. Puppeteer does **not** install Chrome automatically. | `sudo find /root/.cache/puppeteer -type f -name "chrome" \| head`           |

---

## Installation and testing

### FFMPEG

- When installing ffmpeg with Python, do I need to have ffmpeg on my computer? **YES**
- Ubuntu 22:

```
sudo apt install ffmpeg  
pip install ffmpeg-python
```

- You DO NOT install with `pipenv install fmpeg` which might work but it's not the proper package that is a python wrapper to use the OS' ffmpeg

---

### ImageMagick

- Eg. Google: Ubuntu 22 install imagemagick
- Test ImageMagick (OS) works with PHP (PHP wraps around ImageMagick)

#### Test ImageMagick works at a system level

Run `convert --version` and `identify --version` (see table above).

#### Test ImageMagick works inside PHP  

Because often ImageMagick is included in PHP (Even CloudPanel's PHP application)

##### 1. Create PHP script

Create a file named `test_imagemagick.php` with the following content:  
  
```php  
<?php  
// Check if the ImageMagick extension is loaded  
if (extension_loaded('imagick')) {  
echo "ImageMagick extension is loaded.\n";  
// Create an instance of the Imagick class  
$imagick = new Imagick();  
  
// Check ImageMagick version  
$version = $imagick->getVersion();  
echo "ImageMagick version: " . $version['versionString'] . "\n";  
  
// Create a blank image to test further functionality  
$imagick->newImage(100, 100, new ImagickPixel('white'));  
$imagick->setImageFormat('png');  
  
// Write the image to a file  
$outputFile = 'test_image.png';  
if ($imagick->writeImage($outputFile)) {  
echo "ImageMagick is working. Test image created at $outputFile\n";  
} else {  
echo "ImageMagick is installed but failed to create a test image.\n";  
}  
} else {  
echo "ImageMagick extension is not loaded.\n";  
}  
?>  
```  
  
##### 2. Run the PHP script from the terminal or web browser
  
Open your terminal and navigate to the directory where you saved the `test_imagemagick.php` file. Then, run the script using the PHP command:  
  
```sh  
php test_imagemagick.php  
```

Or visit that php page in the web browser  
  
You could get success (either terminal or web browser):

ImageMagick extension is loaded.  
ImageMagick version: ImageMagick 6.9.11-60 Q16 x86_64 2021-01-25 https://imagemagick.org  
ImageMagick is working. Test image created at test_image.png  

^ creates a gray test_image.png square

##### 3. Interpret the output  
  
The script will output whether the ImageMagick extension is loaded, the version of ImageMagick, and whether it was able to create a test image. Here’s an example of what the output might look like:  
  
```  
ImageMagick extension is loaded.  
ImageMagick version: ImageMagick 7.0.10-10 Q16 x86_64 2020-05-05  
ImageMagick is working. Test image created at test_image.png  
```  
  
##### **Troubleshooting**: ImageMagick extension is not loaded

If you see `ImageMagick extension is not loaded`, it means that the ImageMagick PHP extension (`imagick`) is not installed or enabled in your PHP configuration.  

Installing the Imagick PHP extension  
  
- **On local development macOS (using Homebrew):**  
```sh  
brew install imagemagick  
brew install php-imagick  
```  

- **On local development Windows:**  
1. Download the correct DLL for your PHP version from the [PECL repository]([https://pecl.php.net/package/imagick](https://pecl.php.net/package/imagick)).  
2. Place the DLL file in the `ext` directory of your PHP installation.  
3. Enable the extension in your `php.ini` file by adding or uncommenting the line:  
`extension=php_imagick.dll`

- **On Ubuntu/Debian:**  
```sh  
sudo apt update  
sudo apt install imagemagick php-imagick  
sudo systemctl restart apache2 # or restart php-fpm if you use it  
```  
  
Restart your web server or PHP service.  

Rerun the `test_imagemagick.php` script to ensure everything is set up correctly.  

----

### **PCRegrep**

PCRE (Perl 5 Compatible Regular Expression Library)

Eg. Google: Ubuntu 22 install PCRegrep  

As for Ubuntu 22 or Debian 12:

```
sudo apt-get install libpcre3 libpcre3-dev -y
sudo apt install libpcre3 libpcre3-dev -y
sudo apt install pcregrep -y
```

**Test PCRegrep works with PHP**

```
<?php  
if (!`which pcregrep 2>/dev/null`) {  
  echo "Error: Your server does not support pcregrep.";  
} else {  
  echo "Success: Your server supports pcregrep.";  
}  
?>
```

----

### **Library: ctypes**

Python libraries may use ctypes a lot  

ffmpeg-python and MoviePy interacts with ffmpeg which needs to be installed on the system. The FFmpeg system itself, being a collection of multimedia libraries and tools written in C. The ctypes module in Python is specifically for interfacing with C libraries from Python code.

```
sudo apt-get install libffi-dev  
```


Note if you already installed python under pyenv, you need to reinstall the python

```
pyenv uninstall 3.12.4  
pyenv install 3.12.4  
```

^ [https://stackoverflow.com/questions/27022373/python3-importerror-no-module-named-ctypes-when-using-value-from-module-mul](https://stackoverflow.com/questions/27022373/python3-importerror-no-module-named-ctypes-when-using-value-from-module-mul)

^You can get the current version of your pyenv: `cat .python-version`

----

### **wkhtmltopdf**

Eg. Google: Ubuntu 22 install wkhtmltopdf

As for Ubuntu 22 or Debian 12:

```bash
sudo apt update
sudo apt install wkhtmltopdf -y
```

**Example usage**

Convert a URL to PDF:

```bash
wkhtmltopdf https://example.com output.pdf
```

Convert a local HTML file:

```bash
wkhtmltopdf input.html output.pdf
```

**Test wkhtmltopdf works with PHP**

```php
<?php
if (!`which wkhtmltopdf 2>/dev/null`) {
  echo "Error: Your server does not support wkhtmltopdf.";
} else {
  echo "Success: Your server supports wkhtmltopdf.";
}
?>
```

Note: Some installs from default package managers may not support every advanced option, especially features that depend on patched Qt. For basic HTML-to-PDF generation, the normal `apt install wkhtmltopdf` approach is usually the first thing to try. ([Debian Packages](https://packages.debian.org/bookworm/wkhtmltopdf?utm_source=chatgpt.com "Debian -- Details of package wkhtmltopdf in bookworm"))

----

### **Puppeteer + Chrome**

Use Puppeteer when you need predictable PDF or screenshot output from a real webpage — modern CSS, gradients, images, and long scrollable content included. Puppeteer launches **headless** Chrome on Linux, then opens the webpage, then opens the Print dialog, then does the equivalent of changing the printer to "Save as PDF".

No desktop environment or GUI is required on the Linux server.

Compared to `wkhtmltopdf`, headless Chrome handles current web styling more reliably and can capture full-page screenshots or PDFs that reflect exactly what the page looks like in a browser.

#### PDF generation workflow (example)

PDF reports can be produced in two steps:

1. **HTML report** — Your backend builds a fully styled HTML document first (e.g. a function like `buildReportHtml()` in `lib/generate-report.js` writes layout, CSS, gradients, badges, images, etc. to a file such as `report.html`).
2. **PDF export** — Puppeteer launches headless Chrome and uses its print engine to render that HTML and save a PDF. The output matches the web report — the same result as choosing “Save as PDF” in the browser print dialog.

Puppeteer does **not** install Chrome automatically. Chrome must be installed separately on any machine that generates PDFs.

#### Production: Install Chrome (global cache)

On the production server, Chrome and its cache are installed globally under `/root/.cache/puppeteer`. Run as root:

```bash
# Create the Puppeteer cache directory
sudo mkdir -p /root/.cache/puppeteer
sudo chown -R root:root /root/.cache/puppeteer

# Install Chrome from the project directory
cd /path/to/your/project
sudo -H npx puppeteer browsers install chrome --install-deps
```

Verify Chrome is present:

```bash
sudo find /root/.cache/puppeteer -type f -name "chrome" | head
```

Restart the app so PM2 picks up the environment:

```bash
pm2 restart all --update-env
```

#### Project-level Chrome (recommended long-term)

For better logging and a cleaner long-term setup, install Chrome and its cache at the project level instead of globally. Create a project-local cache directory, install Chrome into it, and point Puppeteer at that path via environment variable or launch config.
