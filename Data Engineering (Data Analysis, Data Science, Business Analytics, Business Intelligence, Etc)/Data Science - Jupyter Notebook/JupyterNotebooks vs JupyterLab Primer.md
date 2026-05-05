Aka Get Started

Jupyter lets you make notebooks that have markdown text but also incorporates graphs and equations that can run dynamically. You can publish into PDF, etc. The language is based in python. The editing philosophy is combo of VIM and Excel. There's an edit/command mode and you have a vertical stack of cells where you enter either "labels" (really, markdown text) or "formula's" (really, code).

JupyterLab is the next generation of the Jupyter Notebook. It's a different GUI and provides more: It aims at fixing many usability issues of the Notebook, and it greatly expands its scope. JupyterLab offers a general framework for interactive computing and data science in the browser, using Python, Julia, R, or one of many other languages.

But, Jupyter notebook seems easier to use/learn. So make two aliases so you can choose between the favors:

alias jl='jupyter-lab'
alias jn='jupyter notebook'

You can start with jn.

Learning objectives:
- How to start a new notebook:
![](XEqGPU2.png)
URL at http://localhost:9999/tree
- Each line is a cell. So the cells go vertical.
- You can run all cells aka lines or only the ones you select
- There is edit mode that lets you edit a cell. Then there's command mode where you're not editing but doing things such as running a cell
	- You can also switch modes by clicking inside a cell for edit mode or outside a cell for command mode.
- You can copy and paste cells. If you copy to a text file, they appear as text. Copy this to your notebook:
```
[{"metadata":{"trusted":true},"cell_type":"code","source":"# Comment (Not Heading)\nprint('hi');","execution_count":null,"outputs":[]},{"metadata":{},"cell_type":"markdown","source":"# Heading"}]
```


- A cell can render markdown text (such as large headline), or it can run code producing a calculation or pictures or graphs. There are two types of cells: Code and Markdown

![](QQgclcD.png)

You select the cell you're changing:
![](fIvifmM.png)

^ As you can see, the command shortcuts are Y and M

- There is rendered vs non-rendered mode:
It's a mater of selecting a cell in command mode then pressing CMD+Enter
![](BRmu2Dp.png)


Using the same command on a code cell (instead of a markdown cell) will evaluate:
![](NFUPllx.png)




- So with all the cells rendered/calculated/executed, the whole composite looks like a notebook for business / scientists, etc
https://youtu.be/HW29067qVWk

For Notebook examples, google: Jupyter notebooks gallery

