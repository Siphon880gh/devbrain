Practice?
- If don't have an upload form, you can play with this unsecured upload form in the same environment where you would have code at (Keep the url super secret and delete once done playing!)
- Test the security checklist for uploads at [[_ Security Checklist - Upload]]
```
<!DOCTYPE html>  
<html>  
<head>  
    <title>File Upload Form</title>  
    <style>  
        body {  
            font-family: Arial, sans-serif;  
            max-width: 800px;  
            margin: 20px auto;  
            padding: 20px;  
        }  
        .upload-form {  
            border: 2px dashed #ccc;  
            padding: 20px;  
            text-align: center;  
            border-radius: 5px;  
        }  
        .message {  
            padding: 10px;  
            margin: 10px 0;  
            border-radius: 5px;  
        }  
        .success {  
            background-color: #d4edda;  
            color: #155724;  
        }  
        .error {  
            background-color: #f8d7da;  
            color: #721c24;  
        }  
        #uploadStatus {  
            margin-top: 20px;  
        }  
        .file-list {  
            margin-top: 20px;  
            text-align: left;  
        }  
        .file-item {  
            margin: 5px 0;  
            padding: 5px;  
            background: #f8f9fa;  
            border-radius: 3px;  
        }  
    </style>  
</head>  
<body>  
    <div class="upload-form">  
        <h2>Multiple File Upload</h2>  
        <div>Upload multiple files to the server.</div><br/>  
        <form id="uploadForm" method="post" enctype="multipart/form-data">  
            <input type="file" name="files[]" id="fileToUpload" multiple required>  
            <br><br>  
            <input type="submit" value="Upload Files" name="submit">  
        </form>  
        <div id="uploadStatus">  
            <?php  
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
                if (!file_exists('uploaded')) {  
                    mkdir('uploaded', 0777, true);  
                }  
                  
                $uploadedFiles = [];  
                $errors = [];  
                  
                if (isset($_FILES['files'])) {  
                    foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {  
                        $file_name = $_FILES['files']['name'][$key];  
                        $file_size = $_FILES['files']['size'][$key];  
                        $file_tmp = $_FILES['files']['tmp_name'][$key];  
                        $file_error = $_FILES['files']['error'][$key];  
                          
                        if ($file_error === 0) {  
                            $target_path = 'uploaded/' . basename($file_name);  
                            if (move_uploaded_file($file_tmp, $target_path)) {  
                                $uploadedFiles[] = $file_name;  
                            } else {  
                                $errors[] = "Failed to upload $file_name";  
                            }  
                        } else {  
                            $errors[] = "Error uploading $file_name";  
                        }  
                    }  
                }  
                  
                // Output results  
                if (!empty($uploadedFiles)) {  
                    echo '<div class="message success">Successfully uploaded files:</div>';  
                    echo '<div class="file-list">';  
                    foreach ($uploadedFiles as $file) {  
                        $filePath = 'uploaded/' . $file;  
                        $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));  
                        $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']);  
                          
                        echo '<div class="file-item">';  
                        // Detailed debug output  
                        echo '<!-- Debug: Raw filename: ' . $file . ' -->';  
                        echo '<!-- Debug: Character codes: ';  
                        for($i = 0; $i < strlen($file); $i++) {  
                            echo ord($file[$i]) . ' ';  
                        }  
                        echo ' -->';  
                          
                        // Try different XSS vectors  
                        echo '<div>' . $file . '</div>';  
                        echo '<div>' . html_entity_decode($file) . '</div>';  
                          
                        if ($isImage) {  
                            echo '<br><img src="' . $filePath . '" style="max-width: 200px; max-height: 200px; margin-top: 10px;">';  
                        }  
                        echo '</div>';  
                    }  
                    echo '</div>';  
                }  
                  
                if (!empty($errors)) {  
                    echo '<div class="message error">Errors:</div>';  
                    echo '<div class="file-list">';  
                    foreach ($errors as $error) {  
                        echo '<div class="file-item">' . htmlspecialchars($error) . '</div>';  
                    }  
                    echo '</div>';  
                }  
            }  
            ?>  
        </div>  
    </div>  
</body>  
</html>
```