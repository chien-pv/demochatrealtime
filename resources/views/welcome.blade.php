<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Chat</title>
    <style>
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
}

.chat-container {
    width: 100%;
    max-width: 500px;
    background: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 5px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 70vh;
}

.chat-header {
    background: #007bff;
    color: #fff;
    padding: 10px;
    text-align: center;
}

.chat-messages {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    border-bottom: 1px solid #ddd;
}

.chat-messages .message {
    margin-bottom: 10px;
}

.chat-messages .message p {
    margin: 0;
    padding: 10px;
    background: #f1f1f1;
    border-radius: 5px;
}

.chat-input {
    padding: 10px;
    background: #f9f9f9;
    border-top: 1px solid #ddd;
}

.chat-input form {
    display: flex;
}

.chat-input input[type="text"] {
    flex: 1;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px 0 0 5px;
    outline: none;
}

.chat-input button {
    padding: 10px;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 0 5px 5px 0;
    cursor: pointer;
    outline: none;
}

.chat-input button:hover {
    background: #0056b3;
}

    </style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="chat-container">
        <div class="chat-header">
            <h2>Web Chat</h2>
            <h3>
            {{ Auth::user()->name }}
            </h3>
            <h3>
            {{ Auth::user()->id }}
            </h3>
        </div>
        <div class="chat-messages" id="chat-messages">
            <!-- Messages will be displayed here -->
             
            
        </div>
        <div class="chat-input">
            <form action="/chat" id="chat-form">
                <input type="text" id="message-input" placeholder="Type a message..." required>
                <button id="btn-send" type="button">Send</button>
            </form>
        </div>
    </div>
    <script>
        setTimeout(function(){
            window.Echo.private('user.{{ Auth::user()->id}}')
            .listen('ChatRealtime', (e) => {
                console.log(e);
                document.getElementById("chat-messages").innerHTML+= buildMessage("{{$idchat}}", e.message);
            });
        }, 100);

        document.getElementById("btn-send").onclick = function () {
            console.log("chat");
            let mess =  document.getElementById("message-input").value;
            document.getElementById("chat-messages").innerHTML+=  buildMessage("{{Auth::user()->id}}", mess);

            fetch('http://127.0.0.1:8000/chat/{{$idchat}}/'+mess)
            .then(response => response.json())
            .then(json => {})
        }

        function buildMessage(id, message){
            return `<div class="message">
                <b>User ${id}</b>
                <p> ${message}</p>
             </div>`
        }
    </script>
</body>
</html>