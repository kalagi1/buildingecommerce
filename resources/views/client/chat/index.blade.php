<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canlı Destek</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        #chat-box {
            width: 300px;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 10px;
            background-color: #fff;
            height: 400px;
            overflow-y: scroll;
        }

        #message-input {
            width: 300px;
            margin: 10px auto;
            padding: 10px;
        }

        #send-btn {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div id="chat-box"></div>

    <div id="message-input">
        <input type="text" id="message" placeholder="Mesajınızı yazın...">
        <button onclick="sendMessage()" id="send-btn">Gönder</button>
    </div>

    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        var socket = io("http://127.0.0.1:8000/");

        function sendMessage() {
            var message = $('#message').val();
            if (message.trim() !== '') {
                socket.emit('chat message', message);
                $('#message').val('');
            }
        }

        socket.on('chat message', function (msg) {
            console.log(msg);
            $('#chat-box').append('<p>' + msg + '</p>');
            $("#chat-box").scrollTop($("#chat-box")[0].scrollHeight);
        });
    </script>

</body>
</html>
