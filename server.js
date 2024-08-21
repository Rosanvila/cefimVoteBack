const WebSocket = require('ws');
const os = require('os');

// Function to get the local IP address
function getLocalIpAddress() {
    const interfaces = os.networkInterfaces();
    for (const name of Object.keys(interfaces)) {
        for (const iface of interfaces[name]) {
            if (iface.family === 'IPv4' && !iface.internal) {
                return iface.address;
            }
        }
    }
    return 'localhost';
}

const ipAddress = getLocalIpAddress();
const port = 8080;

const server = new WebSocket.Server({port: port}, () => {
    console.log(`WebSocket server started on ws://${ipAddress}:${port}`);
});

server.on('connection', (socket, req) => {
    const clientIp = req.socket.remoteAddress;
    console.log(`New connection from ${clientIp}`);

    socket.on('message', (message) => {
        console.log(`Received message from ${clientIp}: ${message}`);
        // Broadcast the message to all connected clients
        server.clients.forEach(client => {
            if (client.readyState === WebSocket.OPEN) {
                client.send('Echo: ' + message);
            }
        });
    });

    socket.on('close', () => {
        console.log(`Connection closed from ${clientIp}`);
    });

    socket.on('error', (error) => {
        console.error(`Connection error from ${clientIp}: ${error.message}`);
    });
});