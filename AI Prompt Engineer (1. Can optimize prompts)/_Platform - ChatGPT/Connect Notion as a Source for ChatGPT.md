
## Setup

Go to Settings -> Data Controls

Settings:
![[Pasted image 20250728064940.png]]

Connectors:
![[Pasted image 20250729210733.png]]

When accepting permission, make sure you select the correct Notion workspace you're allowing ChatGPT to pull information from:
![[Pasted image 20250729210828.png]]

---

## Usage

Turn on deep research, turn off Web Search, then select Notion at Sources:
![[Pasted image 20250729210900.png]]

If you want answers strictly from your Notion, enter your prompt as so:
```
{YOUR_QUESTION}

Please use only my Notion sources. Make sure to cite the Notion source (eg. What page or database name). If the answer can't be found from Notion, then mention the information cannot be found.
```

If you want your Notion to supplement the AI's answer, enter your prompt as so:
```
{YOUR_QUESTION}

Please use my Notion sources to supplement your answer. Make sure to cite the Notion source (eg. What page or database name) if you use my sources.
```


At the right side panel is the sources:
![[Pasted image 20250729210916.png]]


---

## Limitations

As of July 2025, you can disconnect your Notion connection, but it doesn’t display which workspace it's linked to, nor does it support adding or managing multiple workspaces for data access.

limitations 1 of 2:
![[Pasted image 20250730001504.png]]

limitations 2 of 2:
![[Pasted image 20250730001438.png]]

