
Goal of v4 (Released Jan 2025) is to make setup super quick. But they got rid of config file. And they changed how the commands are written, often without you knowing because you could be using the older command and it doesn't work.

Tailwindcss' documentation is lacking and ChatGPT as of 4/2025 is outdated and doesn't admit it.

v4 is too aggressive with breaking changes. They got rid of "npx tailwindcss init" that creates tailwind.config.js. Used to be in earlier v4, you can add a `@config` line in your css to point to your tailwind.config.js, but they got rid of that too in later v4 versions. They also got rid of `--config` so your tailwindcss command can't point to a config file. There is no tailwind.config.js at all at the most current v4 iteration as of 4/2/2025

Instead of a _tailwind_._config_.js file, you can configure all of your customizations directly in the CSS file where you import Tailwind:
	- https://tailwindcss.com/blog/tailwindcss-v4
