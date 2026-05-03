When editing inside a node, you can drag and drop from any Input into a field that supports Expressions. This makes for dynamic logic.

See this:
- 1 of..: Click and started dragging
  ![[Pasted image 20250702185840.png]]

- 2 of..: Still dragging the field towards the node's fields
  ![[Pasted image 20250702190057.png]]

- 3 of..: Dropping into the node's field
  ![[Pasted image 20250702190837.png]]

- 4 of..: Have dropped into the node's field. Node's field populated with value for that input's iteration
  ![[Pasted image 20250702185700.png]]

---

As another example, we have a multiline field here that's a Prompt for the AI Agent node:
![[Pasted image 20250702191542.png]]

You could have dragged the interestLevel into the prompt, or you could have literally typed into the prompt: `{{ $json.interestLevel }}`. Either way would have worked.