
**Examples**: Unreal Blueprint, DaVinci Fusion nodes, n8n nodes, Langflow nodes


**Some guidelines:**
- Is there a start and end node that must be certain nodes?
- What are the major groups of nodes (data manipulation, AI agents, etc)
- Is there a color code on connector arrows and nodes (eg. all red nodes, all red connectors)
- What are the types of inputs/ouputs a type of node can receive/send out.
- Is there programming or expressions allowed inside some nodes? Eg. n8n lets you type expressions into the field and also has nodes that lets you type full code in either JS or Python.

---

**What is a node's function type**:

> [!note] Quick Review: Function type
> Function Types in functional math or machine learning contexts refer to:
> - Single-input, single-output (SISO)
> - Multiple-input, single-output (MISO)
> - Multiple-input, multiple-output (MIMO)
>   
>  In the context of n8n nodes
>  In n8n, a node can either receive only one input at a time or receive all inputs at once, and the node can either output only one input at a time or output all at one time). If only one at a time, then you'll likely have to loop through iterations or it will only work with the first input (dropping all other inputs afterwards)
>  

Eg. In n8n, the SerpAPI receives three inputs and outputs three at once. Therefore, SerpAPI is MIMO.




