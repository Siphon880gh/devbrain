
Here I have a DNode that represents nodes in linked list. Each node contains a data of name, text, textLeft, and textRight. This is because the name is the name of the node, text is its description, and textLeft and textRight explains if any, connections to the left and right nodes, respectively.

Types of array of a Type DNode, String returned function, String variables:

```
   type DNode = {  
      prev: (DNode | null)[];  
      next: (DNode | null)[];  
      data: {  
        name: string;        // Mandatory 'name' property  
        text?: string;       // Optional 'text' property  
        textLeft?: string;   // Optional 'textLeft' property  
        textRight?: string;  // Optional 'textRight' property  
      };  
      listMemberships?: Set<number>; // Set to keep track of which lists the node belongs to  
    };  
  
  function createHTML(heads: DNode[]): String {  
    let html:String = "";  
    // Render each list and append it to the container  
    heads.forEach((head, index) => {  
      let listContent = renderNode(head, index + 1);  
      // document.getElementById('linkedListsContainer')!.innerHTML += listContent;  
      html+=listContent;  
    });  
  
    return html;  
  } // createHTML
```