const app = require('express')();
const http = require('http').Server(app);
const io = require('socket.io')(http);

io.on('connection', (socket) => {
  console.log('Bir kullanıcı bağlandı');

  socket.on('userMessage', (message) => {
    // Kullanıcıdan gelen mesajı admin'e ilet
    io.emit('adminMessage', message);
  });

  socket.on('adminMessage', (message) => {
    // Admin'den gelen mesajı kullanıcıya ilet
    io.emit('userMessage', message);
  });

  socket.on('disconnect', () => {
    console.log('Bir kullanıcı ayrıldı');
  });
});

http.listen(3000, () => {
  console.log('Socket.io server dinleniyor: https://test.emlaksepette.com');
});
