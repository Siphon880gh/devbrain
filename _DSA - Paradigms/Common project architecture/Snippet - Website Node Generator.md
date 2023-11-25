# Website node generators

How to generate a webpage from passing parameters to a node script.

We run node script with parameters for name and github username. Those parameters are destructured into variables from the array of sliced argv which belongs to the process module. Next, those variables get passed to a function generatePage. That function generatePage returns a template literal that interpolates those variables into a multiline text. The returned text is captured into console.log on the first phase. In the second phase, use fs.writeFile(FILE_PATH, "utf-8", optionalErrorHandler) to write a HTML extension file.