Having Cursor AI read a csv file to help with coding or to add more columns of enriched information (such as summarizing a row, or categorizing based on a field's information), but moving mouse over - it says that file's been condensed to fit in the context limit:
- And therefore the code or the newly enriched columns generated isn't what you expect.
  ![[Pasted image 20250706192105.png]]

Chunk them then. Maybe 25 lines at a time or more (depending on how long the columns are). You chunk them into 25 lines each, split1.csv, split2.csv, split3.csv, etc (Manually or you can write a NodeJS/Python script that does it). You could temporarily cut columns to limit size of tokens (Rainbow CSV that tabs the columns so you can CMD+OPT Down, etc shortcuts to remove columns), then paste back after enrichment. You would split the csv into multiple csv files.

In the same chat, you can remove the context `templates_enriched.csv`  and instead, attach the context `split1.csv` . Repeat the prompt for `split2.csv` , `split3.csv` , etc until satisfied.