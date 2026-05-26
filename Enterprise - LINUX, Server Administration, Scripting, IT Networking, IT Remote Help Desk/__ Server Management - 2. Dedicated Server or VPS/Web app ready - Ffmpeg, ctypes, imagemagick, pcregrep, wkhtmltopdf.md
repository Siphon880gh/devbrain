
Your online web app may perform features that your server's OS need to support

Here are instructions on installing the most commonly needed cli tools for web apps (ffpmeg, pcregrep) and the OS libraries that those cli tools need

```toc
```

## Summary List
### ffmpeg:
- **Video and Audio Processing**: Convert, compress, or transcode video and audio files to different formats. For example, you could use `ffmpeg` to convert uploaded video files to a web-friendly format like MP4.
- **Thumbnails and Previews**: Generate thumbnail images or preview clips from video files.
- **Streaming**: Stream live video or process live video streams.
- **Editing**: Perform basic editing tasks like trimming, cropping, or merging video and audio files.
- **TEST exists** on your OS/server: Run in command: `ffmpeg`  and `ffprobe` 

### ImageMagick:
- **Image Conversion**: Convert images from one format to another.  
- **Editing**: Resize, rotate, crop, and modify images.  
- **Screenshot Capture**: Take screenshots and save them in various image formats.  
- **Automation**: Automate image processing tasks in scripts.  
- **TEST exists** on your OS/server: Run in command: `convert --version`  and  `identify --version` 
- `magick --version`  doesnt exist until ImageMagick version 7 and above

### pcregrep:
- **Namesake**: Pearl 5 Compatible Regular Expression + Grep. Enhanced grep.
- **Log Analysis**: Search through large log files using complex regular expressions to extract useful information or detect patterns.
- **Why pcregrep over standard way:** 
- PHP standard way is to read the directory then file_get_contents and perform preg_match. This is ineffective
- Using `pcregrep` in PHP for pattern matching in text files can be more useful than the standard way of searching through files. `pcregrep` is a command-line utility that uses Perl Compatible Regular Expressions (PCRE), which are more powerful and flexible compared to traditional regular expressions with the system level “grep” command. Not only that, it runs at the system level (not needing PHP to read in the files).

- **Data Extraction**: Extract specific data from text files, such as configuration files or user-submitted content, based on advanced pattern matching.
- **Validation**: Validate text input against complex patterns, ensuring that the data conforms to specific formats before processing it further.
- **TEST exists** on your OS/server: Run in command: `pcregrep --version` 

### wkhtmltopdf

- **HTML to PDF Conversion**: Convert HTML pages, templates, or URLs into PDF files. For example, you could use `wkhtmltopdf` to generate invoices, reports, contracts, certificates, receipts, or downloadable documents from web pages.
    
- **URL to PDF**: Generate a PDF directly from a live webpage URL.
    
    ```bash
    wkhtmltopdf https://example.com output.pdf
    ```
    
- **Local HTML to PDF**: Convert a local HTML file into a PDF.
    
    ```bash
    wkhtmltopdf input.html output.pdf
    ```
    
- **Useful for Web Apps**: Helpful when a PHP, Node.js, Python, or other backend app needs to create printable/downloadable PDFs from existing HTML templates.
    
- **Preserves Web Styling**: Supports many CSS styles, images, tables, headers, footers, and page layouts, making it useful for document generation from designed HTML.
    
- **Headers and Footers**: Can add page numbers, dates, titles, custom headers, and custom footers to generated PDFs.
    
- **Batch/Automation**: Can be used in server-side scripts, cron jobs, or backend workflows to automatically generate PDFs.
    
- **wkhtmltoimage**: The related tool `wkhtmltoimage` can convert HTML pages or URLs into image files like PNG or JPG.
    
- **TEST exists** on your OS/server: Run in command:
    
    ```bash
    wkhtmltopdf --version
    ```
    
    and
    
    ```bash
    wkhtmltoimage --version
    ```

---

## FFMPEG
- When installing ffmpeg with python, do I need to have ffmpeg on my computer? YES
- Ubuntu 22
```
sudo apt install ffmpeg  
pip install ffmpeg-python
```

- You DO NOT install with `pipenv install fmpeg` which might work but it's not the proper package that is a python wrapper to use the OS' ffmpeg
- Installation success testing instructions in the summary list above

---

## ImageMagick
- Eg. Google: Ubuntu 22 install imagemagick
- Test ImageMagick (OS) works with PHP (PHP wraps around ImageMagick)

To test if ImageMagick can be accessed in PHP from the terminal, you can create a simple PHP script that checks for the presence of the ImageMagick extension and its functionality. Here’s a step-by-step guide:  

### Test ImageMagick works at a system level

Installation success testing instructions in the summary list

### Test ImageMagick works inside PHP  

Because often ImageMagick is included in PHP (Even CloudPanel's PHP application)

#### 1. Create PHP script

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
  
#### 2. Run the PHP script from the terminal or web browser
  
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

#### 3. Interpret the output  
  
The script will output whether the ImageMagick extension is loaded, the version of ImageMagick, and whether it was able to create a test image. Here’s an example of what the output might look like:  
  
```  
ImageMagick extension is loaded.  
ImageMagick version: ImageMagick 7.0.10-10 Q16 x86_64 2020-05-05  
ImageMagick is working. Test image created at test_image.png  
```  
  
#### **Troubleshooting**: ImageMagick extension is not loaded

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

## **PCRegrep**

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

---

## **Library: ctypes**

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

^ [https://stackoverflow.com/questions/27022373/python3-importerror-no-module-named-ctypes-when-using-value-from-module-mul](https://stackoverflow.com/questions/27022373/python3-importerror-no-module-named-ctypes-when-using-value-from-module-mul)

^You can get the current version of your pyenv: `cat .python-version`

---

## **wkhtmltopdf**

Eg. Google: Ubuntu 22 install wkhtmltopdf

`wkhtmltopdf` is a command-line tool that converts HTML pages, local HTML files, or URLs into PDF files. It is commonly used for generating invoices, reports, contracts, certificates, receipts, and other downloadable PDFs from web apps. ([wkhtmltopdf](https://wkhtmltopdf.org/?utm_source=chatgpt.com "wkhtmltopdf"))

As for Ubuntu 22 or Debian 12:

```bash
sudo apt update
sudo apt install wkhtmltopdf -y
```

Optional related tool:

```bash
wkhtmltoimage --version
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

**Test version directly in command line**

```bash
wkhtmltopdf --version
```

Note: Some installs from default package managers may not support every advanced option, especially features that depend on patched Qt. For basic HTML-to-PDF generation, the normal `apt install wkhtmltopdf` approach is usually the first thing to try. ([Debian Packages](https://packages.debian.org/bookworm/wkhtmltopdf?utm_source=chatgpt.com "Debian -- Details of package wkhtmltopdf in bookworm"))