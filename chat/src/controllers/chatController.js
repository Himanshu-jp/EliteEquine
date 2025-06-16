
import axios from 'axios';
import FormData from 'form-data';
// const baseurl = 'http://localhost/elight-equine/public/api/v1/'; 
const baseurl = 'http://192.168.5.81/EliteEquine/public/api/v1/'; 
class ChatController {


    onlineOrOffline =  async (userId,type,id) => {       
        let data = new FormData();
        if(type=='online')
        {
            data.append('status',1);
            data.append('socket_id', id);
            data.append('user_id', userId);
        }
        else
        {
            data.append('user_id','');
            data.append('status', 0);
            data.append('socket_id', id);
        }

        let config = {
            method: 'post',
            maxBodyLength: Infinity,
            url: baseurl+'user-on-off',
            headers: { 
                'Accept': 'application/json', 
            },
            data : data
        };           

        const res = await axios.request(config);
        if(res.data.success==true)
        {
            return JSON.stringify({
                status: true,
                message: res.data.message,
                data: res.data.data,
            });
        }
        else
        {
            return JSON.stringify({
                status: false,
                message: res.data.message,
                data: null,
            });
        }               
    }

    roomCreate =  async (ticket_type,sender_id,receiver_id) => {       
        let data = new FormData();
        data.append('ticket_type', ticket_type);
        data.append('sender_id', sender_id);
        data.append('receiver_id', receiver_id);
        let config = {
            method: 'post',
            maxBodyLength: Infinity,
            url: baseurl+'room-create',
            headers: { 
                'Accept': 'application/json', 
            },
            data : data
        };
        const res = await axios.request(config);

        console.log("res------",res);
        if(res.data.success==true)
        {
            return JSON.stringify({
                status: true,
                message: res.data.message,
                data: res.data.data,
            });
        }
        else
        {
            return JSON.stringify({
                status: false,
                message: res.data.message,
                data: null,
            });
        }               
    }
   
    threadList =  async (info) => {       
        let data = new FormData();
        data.append('user_id', info.user_id);
        data.append('search', info.search);
        data.append('page', info.page);
        data.append('limit', info.limit);
        let config = {
            method: 'post',
            maxBodyLength: Infinity,
            url: baseurl+'thread-list',
            headers: { 
                'Accept': 'application/json', 
            },
            data : data
        };
        const res = await axios.request(config);

        if(res.data.success==true)
        {
            return JSON.stringify({
                status: true,
                message: res.data.message,
                data: res.data.data,
            });
        }
        else
        {
            return JSON.stringify({
                status: false,
                message: res.data.message,
                data: null,
            });
        }               
    }
    
    chatList =  async (info) => {  
    
        let data = new FormData();
        data.append('user_id', info.user_id);
        data.append('convenience_id', info.roomId);
        data.append('search', info.search);
        data.append('page', (info.page)?info.page:1);
        data.append('limit', (info.limit)?info.limit:10);
        
        
        let config = {
            method: 'post',
            maxBodyLength: Infinity,
            url: baseurl+'chat-detail',
            headers: { 
                'Accept': 'application/json', 
            },
            data : data
        };
        const res = await axios.request(config);
        if(res.data.success==true)
        {
            return JSON.stringify({
                status: true,
                message: res.data.message,
                data: res.data.data,
            });
        }
        else
        {
            return JSON.stringify({
                status: false,
                message: res.data.message,
                data: null,
            });
        }               
    }

    sendMessage  =  async (info) => {       
        let data = new FormData();
        data.append('user_id', info.senderId);
        data.append('to_id', info.receiveId);
        data.append('convenience_id', info.roomId);
        data.append('message', info.message);
        data.append('type', info.messageType);
        data.append('file', info.messageFile);
        // data.append('reply_id', info.reply_id);

        let config = {
            method: 'post',
            maxBodyLength: Infinity,
            url: baseurl+'send-message',
            headers: { 
                'Accept': 'application/json', 
            },
            data : data
        };
        const res = await axios.request(config);
        if(res.data.success==true)
        {
            return JSON.stringify({
                status: true,
                message: res.data.message,
                data: res.data.data,
            });
        }
        else
        {
            return JSON.stringify({
                status: false,
                message: res.data.message,
                data: null,
            });
        }           
    }

    /*
    blockunblock  =  async (userId,roomId,type) => {       
        let data = new FormData();
        data.append('user_id', userId);
        data.append('convenience_id', roomId);
        data.append('type', type);
      
        let config = {
            method: 'post',
            maxBodyLength: Infinity,
            url: baseurl+'block-unblock',
            headers: { 
                'Accept': 'application/json', 
            },
            data : data
        };
        const res = await axios.request(config);
        if(res.data.success==true)
        {
            return JSON.stringify({
                status: true,
                message: res.data.message,
                data: res.data.data,
            });
        }
        else
        {
            return JSON.stringify({
                status: false,
                message: res.data.message,
                data: null,
            });
        }           
    }
        
    deleteGroup  =  async (userId,roomId) => {       
        let data = new FormData();
        data.append('user_id', userId);
        data.append('convenience_id', roomId);
     
        let config = {
            method: 'post',
            maxBodyLength: Infinity,
            url: baseurl+'delete-Group',
            headers: { 
                'Accept': 'application/json', 
            },
            data : data
        };
        const res = await axios.request(config);
        if(res.data.success==true)
        {
            return JSON.stringify({
                status: true,
                message: res.data.message,
                data: res.data.data,
            });
        }
        else
        {
            return JSON.stringify({
                status: false,
                message: res.data.message,
                data: null,
            });
        }           
    }
    */

    getUser = async (roomId,senderId) => {
        let data = new FormData();
        data.append('convenience_id', roomId);
        data.append('user_id', senderId);

        let config = {
            method: 'post',
            maxBodyLength: Infinity,
            url: baseurl+'getUser',
            headers: { 
                'Accept': 'application/json', 
            },
            data : data
        };
        const res = await axios.request(config);
        if(res.data.success==true)
        {
            return JSON.stringify({
                status: true,
                message: res.data.message,
                data: res.data.data,
            });
        }
        else
        {
            return JSON.stringify({
                status: false,
                message: res.data.message,
                data: null,
            });
        }     
    }

    readMessage = async (info) => {
        let data = new FormData();
        data.append('user_id', info.senderId);
        data.append('convenience_id', info.roomId);
        data.append('type', info.type);

        let config = {
            method: 'post',
            maxBodyLength: Infinity,
            url: baseurl+'message-read',
            headers: { 
                'Accept': 'application/json', 
            },
            data : data
        };

        const res = await axios.request(config);
        if(res.data.success==true)
        {
            return JSON.stringify({
                status: true,
                message: res.data.message,
                data: res.data.data,
            });
        }
        else
        {
            return JSON.stringify({
                status: false,
                message: res.data.message,
                data: null,
            });
        }    
    }

    deleteMessage = async (info) => {
        let data = new FormData();
        data.append('user_id', info.senderId);
        data.append('convenience_id', info.roomId);
        data.append('message_id', info.messageId);
        data.append('type',info.type);

        let config = {
            method: 'post',
            maxBodyLength: Infinity,
            url: baseurl+'message-delete',
            headers: 
            { 
                'Accept': 'application/json', 
            },
            data : data
        };

        const res = await axios.request(config);
        if(res.data.success==true)
        {
            return JSON.stringify({
                status: true,
                message: res.data.message,
                data: res.data.data,
            });
        }
        else
        {
            return JSON.stringify({
                status: false,
                message: res.data.message,
                data: null,
            });
        }    
    }

    deleteSingleMessage = async (info) => {
        let data = new FormData();
        data.append('user_id', info.senderId);
        data.append('convenience_id', info.roomId);
        data.append('message_id', info.messageId);
       
        let config = {
            method: 'post',
            maxBodyLength: Infinity,
            url: baseurl+'message-single-delete',
            headers: 
            { 
                'Accept': 'application/json', 
            },
            data : data
        };

        const res = await axios.request(config);
        if(res.data.success==true)
        {
            return JSON.stringify({
                status: true,
                message: res.data.message,
                data: res.data.data,
            });
        }
        else
        {
            return JSON.stringify({
                status: false,
                message: res.data.message,
                data: null,
            });
        }    
    }

}

export default new ChatController();
