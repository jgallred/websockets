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

        </style>
    </head>
    <body>
        <div>
            <div id="data">

            </div>
        </div>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="assets/js/intercom.js"></script>
        <script>
            function SocketManager() {
                this._checkArbitrator();
                this._startCheck();
            }

            SocketManager.prototype._startArbitrator = function() {
                localStorage.setItem('ping', (new Date()).getTime());
                window.open('http://localhost/websockets/public/client', '', 'height=30,width=200');
            };

            SocketManager.prototype._startCheck = function() {
                var self = this;
                setInterval(function(){
                    self._checkArbitrator();
                }, 5000);
            };

            SocketManager.prototype._checkArbitrator = function() {
                var ping = localStorage.getItem('ping');
                var now = (new Date()).getTime();
                if (!ping || now - ping > 5000) {
                    this._startArbitrator();
                }
            };

            var mgr = new SocketManager();



            var messages = 0;
            var intercom = Intercom.getInstance();
            var socketMessages = {};

            intercom.on('message', function(data){
                var message = data.message,
                    id = data.id;

                if (typeof socketMessages[id] === 'undefined') {
                    return;
                }

                socketMessages[id] = message;

                if (messages === 10) {
                    messages = 0;
                    $('#data').empty();
                }
                messages++;
                $('#data').append('<p>'+message+'</p>');
            });

            function send(message) {
                intercom.emit('send', message);
            }
        </script>
    </body>
</html>
