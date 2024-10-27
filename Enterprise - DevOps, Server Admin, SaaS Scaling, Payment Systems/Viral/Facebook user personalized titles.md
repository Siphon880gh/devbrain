
You can generate a php file per share so you can customize the thumbnail and description and title on Facebook. Next time user clicks share, you can check the php file exists yet before proceeding at generating it. Then that should be the url the visitor shares

```
async function generatePNGShare(outputPath, name, plug) {  
  
    const result = (async () => {  
        try {  
            // Define imagePath by replacing .php with .png in outputPath  
            const imagePath = outputPath.replace(/\.php$/, '.png');  
  
            // Check if the image file exists  
            if (!fs.existsSync(imagePath)) {  
                throw new Error(`Image file does not exist at ${imagePath}`);  
            }  
  
            // Get the image filename for HTML usage  
            const imageFilename = path.basename(imagePath);  
  
            // Generate the PHP file content  
            const phpContent = `  
<!DOCTYPE html>  
<html lang="en">  
<head>  
    <title>${name}'s Unique Picture</title>  
    <meta name="description" content="See my unique picture!" />  
    <meta name="keywords" content="keyword1, keyword2" />  
  
    <!-- Open Graph Meta Tags for Social Previews -->  
    <meta property="og:title" content="${name}'s Unique Picture" />  
    <meta property="og:description" content="See my unique picture!" />  
    <meta property="og:image" content="${imageFilename}" />   
    <meta property="og:image:alt" content="${name}'s Unique Picture" />  
    <meta property="og:url" content="https://generate-unique-picture.app/" />  
    <meta property="og:type" content="website" />  
  
    <!-- Twitter -->  
    <meta name="twitter:card" content="summary_large_image" />  
  
    <!-- Favicon/Icon -->  
    <link rel="shortcut icon" href="https://generate-unique-picture.app/favicon.ico" />  
    <link href="//cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">  
</head>  
<body>  
    <h1 class="text-center text-lg mb-6 mt-12">${name}'s Unique Picture</h1>  
    <div class="flex flex-row justify-center">  
        <img src="${imageFilename}" alt="${name}'s Unique Picture" />  
    </div>  
    <div class="text-center mt-6">          
        <a href="${plug}" target="_blank">  
            <button class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded">  
            Get your own Unique Picture!  
            </button>  
        </a>  
    </div>  
    <p class="text-center mt-8 mx-auto" style="max-width:460px;">Benefits of why you want a unique picture... Lorem ipsum...</p>  
</body>  
</html>  
`;  
  
            // Write the PHP content to outputPath  
            fs.writeFileSync(outputPath, phpContent);  
  
            console.log('PHP file generated successfully.');  
            return { status: "success", outputPath: outputPath };  
        } catch (error) {  
            console.error('Error processing images:', error);  
            return { status: "error", message: error.message };  
        }  
    })();  
  
    return result;  
  
} // generatePNGShare
```