|Layer|Direction|Default / Limit|Adjustable?|What it means|
|---|--:|--:|--:|---|
|**Heroku inbound request timeout**|Into Heroku app|**30 seconds**|No, not directly|Heroku expects the web dyno to start returning a response within the timeout window.|
|**Heroku inbound request headers**|Into Heroku app|**16 KB max**|No|Large headers/cookies/auth tokens can be rejected before reaching n8n.|
|**Heroku inbound request body**|Into Heroku app|**10 MB max**|No|Large webhook/upload payloads sent into Heroku-hosted n8n may be rejected.|
|**Node.js core inbound body**|Into Node.js API|No friendly default body-size parser limit|N/A|Node.js handles request bodies as streams; the practical limit usually comes from framework/middleware/proxy.|
|**Express / body-parser JSON**|Into Node.js API|Common default: **100 KB**|Yes|Increase with `express.json({ limit: '10mb' })`.|
|**Fastify body limit**|Into Node.js API|Common default: **1 MiB**|Yes|Increase with `bodyLimit`.|
|**Next.js API route body parser**|Into Node.js API|Common default: **1 MB**|Yes|Increase with `bodyParser.sizeLimit`.|
|**Nginx in front of Node.js**|Into Node.js API|Often **1 MB default** if not changed|Yes|Increase with `client_max_body_size`.|