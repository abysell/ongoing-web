const http = require('http');
const fs = require('fs');
const path = require('path');

// 1. Load .env variables manually
try {
    const envPath = path.join(__dirname, '.env');
    if (fs.existsSync(envPath)) {
        const envContent = fs.readFileSync(envPath, 'utf8');
        envContent.split('\n').forEach(line => {
            // Match line format KEY=VALUE
            const match = line.match(/^\s*([^#=]+)\s*=\s*(.*)$/);
            if (match) {
                const key = match[1].trim();
                let val = match[2].trim();
                // strip quotes if present
                if ((val.startsWith('"') && val.endsWith('"')) || (val.startsWith("'") && val.endsWith("'"))) {
                    val = val.slice(1, -1);
                }
                process.env[key] = val;
            }
        });
        console.log('✅ Loaded environment variables from .env');
    } else {
        console.warn('⚠️ No .env file found in project root.');
    }
} catch (e) {
    console.error('❌ Error loading .env file:', e);
}

const PORT = 3000;
const MIME_TYPES = {
    '.html': 'text/html',
    '.css': 'text/css',
    '.js': 'text/javascript',
    '.json': 'application/json',
    '.png': 'image/png',
    '.jpg': 'image/jpeg',
    '.jpeg': 'image/jpeg',
    '.gif': 'image/gif',
    '.svg': 'image/svg+xml',
    '.txt': 'text/plain',
    '.ico': 'image/x-icon'
};

const server = http.createServer(async (req, res) => {
    // 2. Handle API route
    if (req.url.split('?')[0] === '/api/chat' && req.method === 'POST') {
        try {
            let body = '';
            req.on('data', chunk => {
                body += chunk.toString();
            });
            req.on('end', async () => {
                try {
                    req.body = JSON.parse(body);
                } catch (e) {
                    req.body = {};
                }
                
                // Set up API handler mock response object
                const resMock = {
                    statusCode: 200,
                    headers: {},
                    setHeader: function(name, value) {
                        this.headers[name] = value;
                        return this;
                    },
                    status: function(code) {
                        this.statusCode = code;
                        return this;
                    },
                    json: function(data) {
                        res.statusCode = this.statusCode;
                        for (const name in this.headers) {
                            res.setHeader(name, this.headers[name]);
                        }
                        res.setHeader('Content-Type', 'application/json');
                        res.end(JSON.stringify(data));
                        return this;
                    },
                    end: function(data) {
                        res.statusCode = this.statusCode;
                        for (const name in this.headers) {
                            res.setHeader(name, this.headers[name]);
                        }
                        res.end(data);
                        return this;
                    }
                };

                try {
                    // Import handler file dynamically to prevent caching issues during changes
                    delete require.cache[require.resolve('./api/chat.js')];
                    const chatHandler = require('./api/chat.js');
                    await chatHandler(req, resMock);
                } catch (err) {
                    console.error('❌ Error in API handler:', err);
                    res.statusCode = 500;
                    res.setHeader('Content-Type', 'application/json');
                    res.end(JSON.stringify({ error: 'Internal server error', details: err.message }));
                }
            });
        } catch (err) {
            console.error('❌ Error reading request body:', err);
            res.statusCode = 500;
            res.end('Error');
        }
        return;
    }

    // 3. Serve static files
    let urlPath = req.url.split('?')[0];
    if (urlPath === '/') {
        urlPath = '/index.html';
    }
    
    let filePath = path.join(__dirname, urlPath);
    
    // Safety check to prevent directory traversal
    if (!filePath.startsWith(__dirname)) {
        res.statusCode = 403;
        res.setHeader('Content-Type', 'text/plain');
        res.end('403 Forbidden');
        return;
    }

    fs.stat(filePath, (err, stats) => {
        if (err || !stats.isFile()) {
            res.statusCode = 404;
            res.setHeader('Content-Type', 'text/plain');
            res.end('404 Not Found');
            return;
        }

        const ext = path.extname(filePath).toLowerCase();
        const contentType = MIME_TYPES[ext] || 'application/octet-stream';
        
        res.statusCode = 200;
        res.setHeader('Content-Type', contentType);
        fs.createReadStream(filePath).pipe(res);
    });
});

server.listen(PORT, () => {
    console.log(`\n🚀 OnGoing Dev Server running at: http://localhost:${PORT}/`);
    console.log(`💬 Chatbot endpoint active at:  http://localhost:${PORT}/api/chat`);
    console.log(`⌨️  Press Ctrl+C to stop the server.\n`);
});
