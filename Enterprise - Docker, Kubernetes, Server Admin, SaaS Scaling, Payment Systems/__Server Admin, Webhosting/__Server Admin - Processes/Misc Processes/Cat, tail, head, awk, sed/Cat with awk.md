## Print nonempty lines:

cat | awk NF

The given bash command `cat config.yaml | awk NF` will display the content of the `config.yaml` file, but it will skip any empty lines.

  

1. `cat config.yaml`: This command reads the content of the file `config.yaml` and outputs it to the standard output (typically the terminal).

  

2. `|`: This is a pipe, which takes the output of the command on its left (in this case, `cat config.yaml`) and uses it as input for the command on its right.

  

3. `awk NF`: This is an `awk` command that processes the input line-by-line. The `NF` is a built-in variable in `awk` that represents the number of fields in the current record (by default, a record is a line and fields are separated by whitespace). When `NF` is used as a condition like this, it checks if the number of fields in the current line is non-zero. In other words, it checks if the line is not empty. If the condition is true (i.e., the line is not empty), `awk` prints the entire line.

  

---

## Extract second field in tsv or csv

  

To extract the second field from each line of a TSV (Tab-Separated Values) or CSV (Comma-Separated Values) file, skipping the first line, you can use the `awk` command in Linux or Unix. The `awk` command is highly effective for this task because it allows you to specify the field delimiter and easily select the field you're interested in.

  

For a TSV file, you can use the following command:

  

```bash

awk -F'\t' 'NR > 1 {print $2}' filename.tsv

```

  

- `-F'\t'` tells `awk` to use the tab character as the field delimiter.

- `NR > 1` ensures that the action `{print $2}` is performed only on lines where the record number (NR) is greater than 1, effectively skipping the first line.

- `{print $2}` instructs `awk` to print the second field of each record.

  

For a CSV file, the command is quite similar, but you need to change the field delimiter to a comma:

  

```bash

awk -F',' 'NR > 1 {print $2}' filename.csv

```

  

- `-F','` sets the comma as the field delimiter.

- The rest of the command works the same way as for the TSV file, skipping the first line and printing the second field of each subsequent line.

  

These commands will iterate over each line of your file, skipping the first line, and print the second field based on the specified delimiter.

  

---

  

## Caveat: Awk does not handle escaped commas

  

The basic `awk` command with `-F','` does not handle escaped commas in CSV files, which can be a common occurrence when a field contains a comma. For example, if a line in your CSV file looks like `"field1","field,2",field3`, a simple `awk -F','` will incorrectly interpret the comma within `"field,2"` as a field separator.

  

To properly handle escaped commas in CSV fields, you might need a more sophisticated approach or a different tool that's specifically designed to parse CSV files, such as `csvcut` from the `csvkit` suite or using a programming language like Python with a CSV parsing library.

  

However, if you still want to use `awk` and your CSV file is well-structured with double quotes around fields containing commas, you can try this approach with GNU awk (`gawk`), which allows the use of regular expressions for field separators:

  

```bash

gawk 'BEGIN {FPAT = "([^,]*)|(\"[^\"]+\")"; OFS = ","} NR > 1 {print $2}' filename.csv

```

  

- `FPAT` is a GNU `awk` variable that defines a field pattern. It tells `awk` to consider a field as either a sequence of non-commas (`([^,]*)`) or a sequence of characters enclosed in double quotes (`(\"[^\"]+\")`).

- `OFS` sets the output field separator as a comma.

- `NR > 1 {print $2}` skips the first line and prints the second field.

  

This approach can handle fields with commas inside them, provided that such fields are enclosed in double quotes. However, for more complex CSV parsing, especially with various special cases and escape rules, using a dedicated CSV parsing tool or library is recommended.