<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Socket</title>
        <style>
            .disconnected {
                background-color: red;
            }
            .connected {
                background-color: greenyellow;
            }
        </style>
    </head>
    <body>
        <div>
            <div id="status">
                <div class="text disconnected">Disconnected</div>
            </div>
            <div id="data">

            </div>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="assets/js/intercom.js"></script>
        <script>
            var conn = new WebSocket('ws://localhost:8080');
            var intercom = Intercom.getInstance();

            conn.onopen = function(evt) {
                $('#status .text')
                        .removeClass('disconnected')
                        .addClass('connected')
                        .text('Connected');
                conn.send('listen');
            };

            conn.onmessage = function(evt) {
                var id = 'message_'+(new Date()).getTime();
                intercom.emit('message', {id:id, message:evt.data});
            };

            conn.onclose = function(evt) {
                $('#status .text')
                        .removeClass('connected')
                        .addClass('disconnected')
                        .text('Disconnected');
            };

            intercom.on('send', function(data){
                conn.send(data);
            });

            setInterval(function(){
                localStorage.setItem('ping', (new Date()).getTime());
            }, 4000);
        </script>
    </body>
</html>
