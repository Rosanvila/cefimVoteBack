# websocket
- npm install ws.
  - create a server.js file
 
          const WebSocket = require('ws');
            const server = new WebSocket.Server({ port: 8080 }, () => {
            console.log('WebSocket server started on port 8080');
            });
        
          server.on('connection', (socket) => {
          console.log('New connection');
        
              socket.on('message', (message) => {
                  console.log('Received message:', message);
                  socket.send('Echo: ' + message);
              });
        
              socket.on('close', () => {
                  console.log('Connection closed');
              });
          });