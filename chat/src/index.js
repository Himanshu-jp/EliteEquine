

import express from 'express';
import https from 'https';
import http from 'http';
import { fileURLToPath } from 'url';
import { dirname, join } from 'path';
import fs from 'fs';
import chatController from "./controllers/chatController.js";
import { Server } from "socket.io";
import cors from "cors";
import bodyParser from "body-parser";

const app = express();
const __filename = fileURLToPath(import.meta.url);
const __dirname = dirname(__filename);


// Configure your routes and middleware
app.get('/', (req, res) => {
    res.send('Hello, HTTPS!');
});

// Read the SSL certificate and private key files
// const privateKey = fs.readFileSync('/home/ssl/ssl.key', 'utf8');
// const certificate = fs.readFileSync('/home/ssl/ssl.pem', 'utf8');

// Create the HTTPS server
// const credentials = { key: privateKey, cert: certificate };
// const httpsServer = https.createServer(credentials, app);

let httpsServer = http.createServer(app);

app.use(cors());
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.set("view engine", "ejs");
let pathUrl = join(__dirname, "views");

app.set("views", pathUrl);

app.get("/messages/:senderId/:receiverId", (req, res) => {
    console.log('test');
    res.render("room", { senderId: req.params.senderId, receiverId: req.params.receiverId });
});


const io = new Server(httpsServer, {
    cors: {
        origin: '*',
    }
});
let userIdArray = []
let roomWiseData = [];
let userListArray = [];
let joinRoom = [];
let newMessageArray = [];
let connectArray = [];
let groupDetailArray = [];
let joinGroupRoom = [];
let NEWMESSAGEGROUPArray = [];
let chatDetailArray = [];
let timeForNewRequest = 1;
io.on('connection', (socket) => {

    socket.on('CONNECT', async (params) => {
       // params = JSON.parse(params);
        // console.log("*******online********",params.senderId, "online", socket.id);
        const result = await chatController.onlineOrOffline(params.senderId, "online", socket.id);
        io.to(socket.id).emit('CONNECT_RESPONSE', result)
    });

    socket.on('DISCONNECT', async () => {
        // console.log("*******offline********",0, "offline", socket.id);
        const result = await chatController.onlineOrOffline(0, "offline", socket.id);
        io.to(socket.id).emit('CONNECT_RESPONSE', result)
    });

     socket.on('ROOM_CREATE', async (params) => {
        console.log("********room create*********************", params)
        const result = await chatController.roomCreate(params.ticket_type,params.sender_id,params.receiver_id);
        io.to(socket.id).emit('ROOM_RESPONSE', result)
    });


    socket.on('THREADS_LIST', async (params) =>{
        console.log("**********Thread list**********socket**",params);
        const result = await chatController.threadList(params);
        io.to(socket.id).emit('THREADS_LIST_RESPONSE', result)
    });

    socket.on('CHAT_LIST', async (params) =>
    {
        console.log("**********Chat list*********socket***",params);
        // socket.join('Room_' + params.roomId);
        const result = await chatController.chatList(params);
        io.to(socket.id).emit('CHAT_LIST_RESPONSE', result)
    });

    socket.on('SEND_MESSAGE', async (params) => {
        console.log("**********Send message******socket******",params);
        const result = await chatController.sendMessage(params);
        io.to(socket.id).emit('SEND_MESSAGE_RESPONSE', result);
        
      
        const result1 = await chatController.getUser(params.roomId, params.senderId);
        let data = JSON.parse(result1);

        if (data && data.status === true && Array.isArray(data.data) && data.data.length > 0) {
            data.data.forEach(async (element) => {

                //------------thread list for group----------------
                var threadResult = await chatController.threadList({'user_id':element.id, 'search':'','page':1,'limit':100});
                io.to(element.socket_id).emit('THREADS_LIST_RESPONSE', threadResult);
                
                //---------chat list for user----------------
                var chatResult = await chatController.chatList({'user_id':element.id,"roomId":params.roomId, 'search':'','page':1,'limit':10});
                io.to(element.socket_id).emit('CHAT_LIST_RESPONSE', chatResult);

            });
        } else {
            console.log('No user data found or data is not an array.');
        }
    });

    /*
        socket.on('BLOCK_UNBLOCK', async (params) => {
            console.log('sdffsdfsdf');
            const result = await chatController.blockunblock(params.senderId, params.roomId, params.type);
            io.to('Room_' + params.roomId).emit('BLOCK_UNBLOCK_RESPONSE', result);
            console.log("result-------",result);
            console.log("params-------",params);
            // const result1 = await chatController.getUser(params.roomId, params.senderId);
            // let data = JSON.parse(result1);
            // console.log('getUser response data:', data);
            // if (data && data.status === true && Array.isArray(data.data) && data.data.length > 0) {
            //     data.data.forEach(async (element) => {
            //         console.log('Processing element:----', element);
            //         console.log('name:-----', name);
            //         var name = '';
            //         var result2 = await chatController.threadList(element.id, name);
            //         console.log('THREADS_LIST_RESPONSE:', result2);
            //         io.to(element.socket_id).emit('THREADS_LIST_RESPONSE', result2);
            //     });
            // } else {
            //     console.log('No user data found or data is not an array.');
            // }
        });
        

        socket.on('DELETE_GROUP', async (params) => {
            console.log('sdffsdfsdf');
            const result = await chatController.deleteGroup(params.senderId, params.roomId);
            io.to('Room_' + params.roomId).emit('DELETE_GROUP_RESPONSE', result);
            console.log("result-------",result);
            console.log("params-------",params);
        });
    */

    socket.on('READ_MESSAGE', async (params) =>
    {
        console.log("**********Read message************",params);
        const result = await chatController.readMessage(params);
        io.to('Room_'+params.roomId).emit('READ_MESSAGE_RESPONSE', result)
    });

    socket.on('DELETE_MESSAGE', async (params) =>
    {
        console.log("**********Delete message clear chat************",params);
        const result = await chatController.deleteMessage(params);
        // io.to('Room_'+params.roomId).emit('DELETE_MESSAGE_RESPONSE', result)
        io.to(socket.id).emit('DELETE_MESSAGE_RESPONSE', result);
    });

    socket.on('DELETE_SINGLE_MESSAGE', async (params) =>
    {
        console.log("**********Delete single/multiple message************",params);
        const result = await chatController.deleteSingleMessage(params);
        io.to('Room_'+params.roomId).emit('DELETE_SINGLE_MESSAGE_RESPONSE', result)
    });
});

// Start the HTTPS server
const port = 3115;
httpsServer.listen(port, () => {
    console.log(`HTTPS server is running on port ${port}`);
});