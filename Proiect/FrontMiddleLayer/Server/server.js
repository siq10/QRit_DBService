const express = require('express');
const cors = require("cors");
const fs = require('fs');
const https = require('https');

var certOptions = {
    key: fs.readFileSync('certs/server.key'),
    cert: fs.readFileSync('certs/server.crt'),
    ca: fs.readFileSync("certs/ca.pem"),
    requestCert: true,
    rejectUnauthorized: false
}

const app = express();
const bodyParser = require('body-parser');

app.use(bodyParser.json());

app.use(bodyParser.urlencoded({
    extended: true
}));

app.use(cors());

const users = require('./routes/api/users');

app.use('/api/users',users);

const places = require('./routes/api/places');

app.use('/api/places',places);

// Changes needed for production
if (process.env.NODE_ENV === "production")
{
    app.use(express.static(__dirname + '/public'))

    app.get(/.*/, (req,res) => res.sendFile(_dirname + '/public/index.html'))
}
const port = process.env.PORT || 5000;


var server = https.createServer(certOptions, app).listen(port, () => console.log("Server started on port " + port));