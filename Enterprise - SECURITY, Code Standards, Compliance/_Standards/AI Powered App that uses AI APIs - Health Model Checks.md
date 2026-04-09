For any AI-powered app that relies on multiple models, such as Openai's API

Make sure to include a command-line tool, Node.js script, or simple webpage that checks the health of all model connections.

Model availability can change over time. A model may be sunsetted, renamed, deprecated, rate-limited, temporarily unavailable, or simply not running. This is especially important when the app depends on local model servers, external APIs, or multiple providers.

The health check must clearly show which model connections are working, which failed, and which need attention, so issues are caught early before they break app functionality.