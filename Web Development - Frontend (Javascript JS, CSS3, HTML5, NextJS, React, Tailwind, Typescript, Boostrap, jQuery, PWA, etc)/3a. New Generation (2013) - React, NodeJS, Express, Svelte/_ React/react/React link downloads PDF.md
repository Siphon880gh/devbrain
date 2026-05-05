Using `file-saver` in a React application to save a PDF when clicking a button involves a few steps:

1. **Install the necessary packages**

Firstly, if you haven’t already, you need to install `file-saver`. 

```bash
npm install file-saver --save
```

2. **Use file-saver in your React Component**

Here's a simple example of how you might use this in a React component:

```jsx
import React from 'react';
import { saveAs } from 'file-saver';

const SavePDFButton = () => {
    const savePDF = () => {
        // Fetch the PDF as a blob
        fetch('/path/to/your/pdf/file.pdf')
            .then(response => response.blob())
            .then(blob => {
                saveAs(blob, 'desired-filename.pdf');
            })
            .catch(error => {
                console.error("Error fetching the PDF:", error);
            });
    };

    return <button onClick={savePDF}>Save PDF</button>;
}

export default SavePDFButton;
```

In this example, we’re fetching a PDF as a blob (binary large object) from some path, and then using the `saveAs` function from `file-saver` to trigger the download of that blob as a file with the specified name.

3. **Error handling and feedback**

While the above code will work for many use cases, in a real-world scenario, you would probably want to handle potential errors more gracefully, maybe give the user some feedback if the PDF is taking a while to download, or inform them if there’s an issue. 

4. **PDF Generation**

The example assumes that you already have a PDF file hosted somewhere. If you need to generate a PDF on-the-fly in the browser, consider using a library like `pdfmake` or integrating with a backend service that generates PDFs.

5. **Integrate into your application**

Finally, use the `SavePDFButton` component in your application wherever you need the download functionality.

```jsx
import React from 'react';
import SavePDFButton from './SavePDFButton';

const App = () => {
    return (
        <div>
            <h1>Your App</h1>
            <SavePDFButton />
        </div>
    );
}

export default App;
```

Now, when you click the "Save PDF" button in your application, it will trigger the download of the specified PDF file.