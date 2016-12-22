var handle = require('express')();
var app = require('http').createServer(handle),
    io = require('socket.io').listen(app),
    fs = require('fs'),
    mysql = require('mysql'),
    connectionsArray = [],
    connection = mysql.createConnection({
        host: 'localhost',
        user: 'root',
        password: 'daohaitaclf',
        database: 'ffn',
        port: 3306
    }),
    POLLING_INTERVAL = 3000,
    pollingTimer;

// If there is an error connecting to the database
connection.connect(function(err) {
    // connected! (unless `err` is set)
    if (err) {
        console.log(err);
    }
});

// creating the server ( localhost:8000 )
app.listen(8000);

/*
 *
 * HERE IT IS THE COOL PART
 * This function loops on itself since there are sockets connected to the page
 * sending the result of the database query after a constant interval
 *
 */
var messages  = [];
var user;


var getMessages = function(callback) {
    var query = connection.query('SELECT * FROM messages where user_id = ?', [userId]);
    // setting the query listeners
    query
        .on('error', function(err) {
            // Handle error, and 'end' event will be emitted after this as well
            console.log(err);
            updateSockets(err);
        })
        .on('result', function(message) {
            // it fills our array looping on each user row inside the db
            messages.push(message);
        })
        .on('end', function() {

            // loop on itself only if there are sockets still connected
            if (connectionsArray.length) {

                connection.query('SELECT * FROM users where id = ?', [userId], function(err, rows) {
                    user = rows[0];
                    updateSockets({
                        user: user,
                        messages: messages
                    });

                    callback();
                });

            } else {
                console.log('The server timer was stopped because there are no more socket connections on the app')
            }
        });
};

var pollingLoop = function() {

    var newMessages  = [];
    var query = connection.query('SELECT * FROM messages where user_id = ?', [userId]);
    // setting the query listeners
    query
        .on('error', function(err) {
            // Handle error, and 'end' event will be emitted after this as well
            console.log(err);
            updateSockets(err);
        })
        .on('result', function(message) {
            // it fills our array looping on each user row inside the db
            newMessages.push(message);
        })
        .on('end', function() {

            // loop on itself only if there are sockets still connected
            if (connectionsArray.length) {
                pollingTimer = setTimeout(pollingLoop, POLLING_INTERVAL);
                if (newMessages.length != messages.length) {
                    messages = newMessages;
                    connection.query('SELECT * FROM users where id = ?', [userId], function(err, rows) {
                        user = rows[0];
                        updateSockets({
                            user: user,
                            messages: messages
                        });
                    });
                } else {
                    console.log('Dont have any new message')
                }

            } else {
                console.log('The server timer was stopped because there are no more socket connections on the app')
            }
        });
};

var userId;
// creating a new websocket to keep the content updated without any AJAX request
io.sockets.on('connection', function(socket) {
    userId = socket.handshake.query.userId;

    console.log('Number of connections:' + connectionsArray.length);
    // starting the loop only if at least there is one user connected
    if (!connectionsArray.length) {
        getMessages(pollingLoop);
    }

    socket.on('disconnect', function() {
        var socketIndex = connectionsArray.indexOf(socket);
        console.log('socketID = %s got disconnected', socketIndex);
        if (~socketIndex) {
            connectionsArray.splice(socketIndex, 1);
        }
    });

    console.log('A new socket is connected!');
    connectionsArray.push(socket);
});

var updateSockets = function(data) {
    // adding the time of the last update
    data.time = new Date();
    console.log('Pushing new data to the clients connected ( connections amount = %s ) - %s', connectionsArray.length , data.time);
    // sending new data to all the sockets connected
    connectionsArray.forEach(function(tmpSocket) {
        tmpSocket.volatile.emit('notification', data);
    });
};

console.log('Please use your browser to navigate to http://localhost:8000');
