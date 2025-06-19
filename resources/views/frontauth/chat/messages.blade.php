@extends('frontauth.layouts.main')
@section('title')
Chat Messages
@endsection
@section('content')
<style>

    .container {
    height: 100%;
    overflow: auto;
    display: flex;
    flex-direction: column-reverse;
    }
    </style>

<div class="container-fluid mt-4">
    <div class="chat-container">
        <div class="sidebar">
            <div class="top-filter">
                <div class="ms-md-auto d-flex align-items-center top-search">
                    <input type="text" class="form-control mb-0 searchthread" name="search" placeholder="Search" required>
                    <img src="{{asset('front/auth/assets/img/icons/search-icon.svg')}}">
                </div>
                {{-- <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" id="select_messages" checked="">
                    <label class="form-check-label text-dark" for="select_messages">Select all</label>
                </div> --}}
            </div>
            <div class="users">

                <div id="chat-list"></div>

                <!-- Add more users as needed -->
                {{-- <div class="bottom-filter">
                    <a href="#" class="delete-btn"><img src="{{asset('front/auth/assets/img/icons/delete.svg')}}" alt=""> Delete Selected</a>
                </div> --}}

            </div>
        </div>

        <script>
        function openChatBox(el) {
            // Mobile/tablet only
            if (window.innerWidth <= 768) {
                document.querySelector(".chat-box").classList.add("active");
                document.querySelector(".sidebar").classList.add("hidden");
            }

            // Optional: highlight selected user
            document.querySelectorAll(".user").forEach(user => user.classList.remove("active"));
            el.classList.add("active");
        }

        function goBackToSidebar() {
            document.querySelector(".chat-box").classList.remove("active");
            document.querySelector(".sidebar").classList.remove("hidden");
        }
        </script>

        <div class="chat-box">
            <div class="chat-header">
                <button class="back-btn d-md-none" onclick="goBackToSidebar()">
                    <img src="{{asset('front/auth/assets/img/icons/close-btn.svg')}}" alt="Back" width="30px" />
                </button>
                <h5 class="mb-0 booking_id">{{Auth::User()->name}}</h5>
                {{-- <a href="#" class="btn btn-primary"><img src="{{asset('front/auth/assets/img/icons/star.svg')}}" alt=""> Leave A Review</a> --}}
                {{-- <div class="usr-msg-details booking_id w-100"></div> --}}

                <span class="d-flex gap-2 align-items-center dropdown">
                    <div class="report-dropdown">
                        <a type="button"class="p-3" data-bs-toggle="dropdown" aria-expanded="false"> <i class="fa fa-ellipsis-v">.</i></a>
                        <ul class="drrpp sideellipes dropdown-menu">
                            <!-- <li type="button" class="deletechat">Clear Chat</li> -->
                        </ul>
                    </div>
                </span>

            </div>



           

            <div class="messages message-bar-head container">
                <div class="messages-line" id="chat-details"></div>
                {{-- <div class="chat-bubble">
                    January 21, 2025
                </div>
                <div class="message incoming">
                    <img src="{{asset('front/auth/assets/img/team-2.jpg')}}" alt="img">
                    <div class="incoming-box">
                        <div class="message-info">
                            <span>Meera</span>
                            <small>1:57 AM</small>
                        </div>
                        <p>Hello</p>
                    </div>
                </div>

                <div class="message outgoing">
                    <div class="message-info text-end text-secondary-emphasis pb-1">
                        <small>1:57 AM</small>
                    </div>
                    Hi - are you interested in this horse?
                </div> --}}

            </div>
            <div class="message-input">

                {{-- <input type="text" placeholder="Type a message here...">
                <button>➤</button> --}}

                <form>
                    <div id="text-preview" style="color: red;"></div>
                    <div id="image-preview"></div>
                    {{-- <div class="attecmnt">
                        <input type="file" id="attach-doc"><img src="{{asset('/front/auth/assets/img/icons/attachment.svg')}}" alt="">
                    </div> --}}
                     <span id="file-name" style="margin-left: 10px; font-size: 14px; color: #333;"></span>

                    <div class="mf-field" style="display: none;">
                        <div class="attecmnt">
                            <input type="file" id="attach-doc" style="display: none;">
                            <label for="attach-doc" style="cursor: pointer;">
                                <img src="{{ asset('/front/auth/assets/img/icons/attachment.svg') }}" alt="Attach File">
                            </label>
                        </div>
                        <div class="w-100">
                            <input class="message-input" id="message-input" placeholder="Type your message here...">
                            <input type="hidden" class="file_type" value="TEXT"/>
                            <input type="hidden" class="message_file" value=""/>
                        </div>
                        
                        <div class="mange-ass-v">
                            {{-- <button type="button" class="emojiselect">
                                <img style="width: 25px" src="{{asset('/front/auth/assets/img/icons/happy.svg')}}" alt="">
                            </button>
                            <div id="picker" style="display: none;"></div> --}}
                            <button type="button" class="sendMessage"><svg enable-background="new 0 0 24 24" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" id="fi_1933005"><path d="m8.75 17.612v4.638c0 .324.208.611.516.713.077.025.156.037.234.037.234 0 .46-.11.604-.306l2.713-3.692z"></path><path d="m23.685.139c-.23-.163-.532-.185-.782-.054l-22.5 11.75c-.266.139-.423.423-.401.722.023.3.222.556.505.653l6.255 2.138 13.321-11.39-10.308 12.419 10.483 3.583c.078.026.16.04.242.04.136 0 .271-.037.39-.109.19-.116.319-.311.352-.53l2.75-18.5c.041-.28-.077-.558-.307-.722z"></path></svg></button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

@endsection

@section('script')


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('socket.io.js')}}"></script>
<!-- <style>
   .report-dropdown {
      position: relative;
    }

    .report-dropdown .drrpp {
      display: none;
      position: absolute;
      right: 0;
      top: 100%;
      background-color: #fff;
      border: 1px solid #ccc;
      padding: 0;
      margin: 0;
      list-style: none;
      width: 150px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      z-index: 100;
    }

    .report-dropdown:hover .drrpp {
      display: block;
    }

    .report-dropdown .drrpp li {
      padding: 10px;
        cursor: pointer;
        transition: background 0.2s;
        font-size: 14px;
        font-weight: 400;
            }

    .report-dropdown .drrpp li:hover {
      background-color: #f1f1f1;
    }
</style> -->





<script>
    
        $(document).ready(function () {
            setTimeout(function () {
                $('.thread_details').first().trigger('click');
                console.log("Page loaded, first thread selected after delay.");
            }, 1000); // 4000 ms = 4 seconds
        });


    // Initialize the emoji picker
    // $('#picker').emojioneArea({
    //     pickerPosition: "bottom",
    //     tonesStyle: "bullet"
    // });

    // Handle file input change
    $('#attach-doc').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $('.message_file').val(fileName);
        $('#file-name').text(fileName);
        $('#image-preview').show();
    });

    // Handle emoji selection
    // $(document).on('click', '.emojiselect', function() {
    //     $('#picker').toggle();
    // });

// const socket = io("http://192.168.5.81:3115/");
const socket = io("https://v1.checkprojectstatus.com:3115/");

    
    var SENDER_ID = '{{Auth()->user()->id}}';
  	var RECEIVER_ID = '';
  	var ROOM_ID = "";  


    // -----------------------------Connetion / disconnect 001------------------- //
	socket.emit("CONNECT",{'senderId':SENDER_ID} );
	socket.on('CONNECT_RESPONSE', (res) => {
	    let loginUser = JSON.parse(res);
        console.log("Login User : "+ loginUser.data.name)
	});


    // -----------------------------Thread List 002------------------------------ //
    function threadList(SENDER_ID,search)
	{
	    socket.emit("THREADS_LIST",{'user_id':SENDER_ID, search:search,page:1,limit:100} );
	}
    var active = '';
    threadList(SENDER_ID,'');

    socket.on('THREADS_LIST_RESPONSE', (res) => {
        let result = JSON.parse(res);
        console.log(result, '*********THREADS_LIST_RESPONSE*****');

        if (result.status == true) {
            let html = `
            <div class="d-flex justify-content-between align-items-center mb-2 ms-4">
                <div class=>
                    <input type="checkbox" id="select-all"> <label for="select-all">Select All</label>
                </div>
                <div class="bottom-filter">
                    <a href="#" class="delete-btn" id="delete-selected"><img src="{{asset('front/auth/assets/img/icons/delete.svg')}}" alt=""> Delete Selected</a>
                </div>
            </div>
            <div id="user-list">`;

            result.data.map(function (data, i) {
                let active = (data.convenience_id == ROOM_ID) ? 'active' : '';

                if (data.chatuser) {
                    let user_name = data.chatuser.name || data.chatuser.email;
                    let profile = data.chatuser.profile_photo_path || `{{ asset('front/auth/assets/img/user-img.png') }}`;
                    let is_online = parseInt(data.chatuser.is_online) === 1 ? 'online' : 'offline';
                    let date = data.updated_at ? dateFormate(data.updated_at) : '';
                    let lastMessage = data.last_message.length > 20 ? data.last_message.substr(0, 20) + '..' : data.last_message;
                    let receiverId = data.chatuser.id;

                    html += `
                        <div class="thread_details chat-contact-list-item user ${active}" 
                            data-room_id="${data.convenience_id}" 
                            data-receiver_id="${receiverId}" 
                            data-usre_name="${user_name}" 
                            data-user_profile="${profile}" 
                            data-user_online="${is_online}">

                            <input type="checkbox" class="user-checkbox me-2" value="${data.convenience_id}">
                            <img src="${profile}" />
                            <div>
                                <div class="user-name">${user_name} <span>${(data.total_unread > 0) ? data.total_unread : ''}</span></div>
                                <div class="last-seen">${date}</div>
                                <div class="text-muted">${lastMessage}</div>
                            </div>
                        </div>
                        <hr class="horizontal dark my-1">`;
                }
            });

            html += `</div>`;
            $('#chat-list').html(html);

            // Handle select all
            $('#select-all').on('change', function () {
                $('.user-checkbox').prop('checked', $(this).prop('checked'));
            });

            // Uncheck "select all" if one item is manually unchecked
            $(document).on('change', '.user-checkbox', function () {
                if (!$(this).prop('checked')) {
                    $('#select-all').prop('checked', false);
                }
            });

            // Handle delete selected
            $('#delete-selected').on('click', function () {
                const selected = $('.user-checkbox:checked').map(function () {
                    return $(this).val();
                }).get();

                if (selected.length === 0) {
                    // alert("Please select at least one chat to delete.");
                    Swal.fire("EliteQuine", "Please select at least one chat to delete.", "error");
                    return;
                }
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            
                            console.log("Deleting:", selected); // For debug
                            // Example AJAX call to delete
                            $.ajax({
                                url: "{{url('api/v1/deleteMultipleUser')}}",
                                method: 'POST',
                                data:{
                                    roomId:selected,
                                    user_id:SENDER_ID,
                                    _token:'{{ csrf_token() }}'
                                },
                                success: function (res) {
                                    // alert("Chats deleted successfully.");
                                    Swal.fire("EliteQuine", "Selected chats deleted successfully.", "success");
                                    socket.emit("THREADS_LIST", {'user_id':SENDER_ID, search:'',page:1,limit:100});
                                    // Optionally refresh chat list
                                },
                                error: function () {
                                    // alert("Failed to delete chats.");
                                    Swal.fire("EliteQuine", "Failed to delete chats.", "error");
                                }
                            });

                        }
                    })
                });
        } else {
            $('#chat-list').html(`<h6 class="text-muted mb-0">No chats found.</h6>`);
        }
    });

    //----showing time ----//
    function timeAgo(time_ago) {
	    const timeAgoDate = new Date(time_ago).getTime();
	    console.log(time_ago,'time')
	    const curTime = Date.now();
	    const timeElapsed = curTime - timeAgoDate;
	    const seconds = Math.floor(timeElapsed / 1000);
	    const minutes = Math.floor(seconds / 60);
	    const hours = Math.floor(minutes / 60);
	    const days = Math.floor(hours / 24);
	    const weeks = Math.floor(days / 7);
	    const months = Math.floor(days / 30.44); 
	    const years = Math.floor(days / 365.25);

	    if (seconds <= 60) {
	        return "just now";
	    } else if (minutes <= 60) {
	        if (minutes === 1) {
	            return "1 minute ago";
	        } else {
	            return `${minutes} minutes ago`;
	        }
	    } else if (hours <= 24) {
	        if (hours === 1) {
	            return "1 hour ago";
	        } else {
	            return `${hours} hrs ago`;
	        }
	    } else if (days <= 7) {
	        if (days === 1) {
	            return "yesterday";
	        } else {
	            return `${days} days ago`;
	        }
	    } else if (weeks <= 4.3) {
	        if (weeks === 1) {
	            return "1 week ago";
	        } else {
	            return `${weeks} weeks ago`;
	        }
	    } else if (months <= 12) {
	        if (months === 1) {
	            return "1 month ago";
	        } else {
	            return `${months} months ago`;
	        }
	    } else {
	        if (years === 1) {
	            return "1 year ago";
	        } else {
	            return `${years} years ago`;
	        }
	    }
	}

    //-----for utc to local time convertions---//
    function UTCtoLocal(dateTime){
	    let localDate = new Date(dateTime+' UTC');

	    let day = localDate.getDate();
	    let month = localDate.getMonth() + 1; 
	    let year = localDate.getFullYear();

	    day = day < 10 ? '0' + day : day;
	    month = month < 10 ? '0' + month : month;
	  
	    var date = year+'-'+month+'-'+day+' ';
	    var localDateTime = '';
	    if(localDate.getHours() >= 12)
	    {
	      if(localDate.getHours()-12  < 10)
	      {
	        localDateTime =  localDateTime+'0'+(localDate.getHours()-12);
	      }
	      else
	      {
	        localDateTime =  localDateTime+''+(localDate.getHours()-12);
	      }
	      if(localDate.getMinutes()  < 10)
	      {
	        localDateTime =  localDateTime+':0'+(localDate.getMinutes());
	      }
	      else
	      {
	        localDateTime =  localDateTime+':'+(localDate.getMinutes());
	      }
	      return localDateTime = timeAgo(date+localDateTime+' PM');
	    }
	    else
	    {
	      if(localDate.getHours()  < 10)
	      {
	        localDateTime =  localDateTime+'0'+(localDate.getHours());
	      }
	      else
	      {
	        localDateTime =  localDateTime+''+(localDate.getHours());
	      }
	      if(localDate.getMinutes()  < 10)
	      {
	        localDateTime =  localDateTime+':0'+(localDate.getMinutes());
	      }
	      else
	      {
	        localDateTime =  localDateTime+':'+(localDate.getMinutes());
	      }
	      return localDateTime = timeAgo(date+localDateTime+' AM');
	    }
	}
    //--- for showing date in an format=------//
	function dateFormate(date){
	    const day = new Date(date);
	    const m = ["January", "February", "March", "April", "May", "June",
	    "July", "August", "September", "October", "November", "December"];
	    const str_op = day.getDate() + ' ' + m[day.getMonth()] + ' ' + day.getFullYear();
	    return str_op;
	}

 
    $(document).on('click', '.thread_details', function() {
        setDate = '';
        $('.message-bar-head').show();
        //$('.mf-field').show();
        $(this).find('.unread-count').hide();
        ROOM_ID = $(this).attr('data-room_id');
        RECEIVER_ID = $(this).attr('data-receiver_id');

        var ticket_id = $(this).data('ticket_id');
        var ticket_type = $(this).data('ticket_type');
        var usre_name = $(this).data('usre_name');
        var user_profile = $(this).data('user_profile');
        var user_online = $(this).data('user_online');
        var user_role = $(this).data('user_role');
        var chat_type = $(this).data('type');
        var isblock = $(this).data('isblock');
        var isblockuser = $(this).data('isblockuser');
        var fromid = $(this).data('fromid');



        $('.chat-contact-list-item').removeClass('active');
        $(this).addClass('active');
        if (isblock == 1) {
            $('.mf-field').hide();
        } else {
            $('.mf-field').show();
        }

        $('.booking_id').html(`
            <div class="usr-ms-img usr-roomid" data-roomid="${ROOM_ID}" data-isblock = "${isblock}" data-isblockuser = "${isblockuser}" data-chat_type="${chat_type}">
                <h3>
                    <img src="${user_profile}" alt="" style="height:50px; width:50px;" class="rounded-circle" data-toggle="modal" data-target="#groupModal">
                    ${usre_name}
                </h3>
            </div>
        `);

        $('.sideellipes').html(`
            <li type="button" class="deletechat dropdown-item">Clear Chat</li>
            <li type="button" class="deletemychat dropdown-item">Delete Chat</li>
        `);
        
        $('.booking_id').removeClass('clickable');
        $('.booking_id').off('click');
        

        
        socket.emit("READ_MESSAGE", {
            'senderId': SENDER_ID,
            'roomId': ROOM_ID,
            'type': 'all'
        });
        socket.on('READ_MESSAGE_RESPONSE', (res) => {});
        

        $('#chat-details').html('');
        mesageList = '';
        socket.emit("CHAT_LIST", {
            'user_id': SENDER_ID,
            'roomId': ROOM_ID,
            'search': "",
            'page': page = 1,
            "limit":10
        });
    });



    $(document).on('click', '.loadmore', function() {
        page = page + 1;
        socket.emit("CHAT_LIST", {
            'user_id': SENDER_ID,
            'roomId': ROOM_ID,
            'search': "",
            'page': page,
            "limit":10
        });
    });

    socket.on('CHAT_LIST_RESPONSE', (res) => {
        let result = JSON.parse(res);
        $('.message-bar-head').show();
        //$('.mf-field').show();
        chat_type = $('.usr-roomid').attr('data-chat_type');

        console.log(result, 'chat list');
        if (result.status == true) {
            if (result.data.last_page != page) {
                var html5 = '<div class="loadmore text-center">View more</div><br/>';
            } else {
                var html5 = '';
            }
            const arr = result.data.data;
            var html4 = '';
            $('.messqage-type-section').show();
            arr.sort((a, b) => a.id - b.id);
            arr.map(function(data) {

                var html1 = '';
                var html2 = '';
                var html0 = '';

                var message = data.message;
                var file = '';
                var downloadIcon = '';
                if (data.file_type == "IMAGE") {
                    file = `<img src="${data.file}" width="100"><br/>`;
                } else if (data.file_type == "VIDEO") {
                    file = `<video width="100px" controls><source src="${data.file}" type="video/mp4"></video><br/>`;
                } else if (data.file_type == "DOC") {
                    file = `<iframe src="${data.file}" width="100" height="100"></iframe><br/>`;
                }

                if (setDate != dateFormate(data.updated_at)) {
                    setDate = dateFormate(data.updated_at);
                    html0 = `<div class="col-12 text-center"><div class="btn btn-success  btn-sm" style="padding: 4px !important; font-size: 10px;">${dateFormate(data.updated_at)}</div></div>`;
                } else {
                    html0 = '';
                }
                let localDateTime = timeAgo(data.updated_at);

                if (data.file_type != 'TEXT') {
                    downloadIcon = `<a href="${data.file}" download class="hideimgmodal"><img src="{{asset('/front/auth/assets/img/icons/download.svg')}}" alt="Download" class="download-msg-iocn"></a>`;
                }

                if (parseInt(data.from_id) == parseInt(SENDER_ID)) {

                    
                    html1 = `
                    <div class="messages" data-msgid="${data.id}">
                        <div class="message outgoing">
                            <div class="message-info text-end text-secondary-emphasis pb-1">
                                <small>${localDateTime}</small>
                            </div>
                            ${data?.message}
                            <a href="${data.file}" target="_blank" class="message-info text-end text-secondary-emphasis pb-1">${file}</a>
                        </div>
                    </div>`;
                    
                }
                if (parseInt(data.from_id) !== parseInt(SENDER_ID)) {                    
                    html2 = `
                            <div class="messages" data-msgid="${data.id}">
                                <div class="message incoming">
                                    <img src="${data.sender.profile_photo_path}"  alt="img">
                                    <div class="incoming-box">
                                        <div class="message-info">
                                            <small>${localDateTime}</small>
                                        </div>
                                        ${data?.message}
                                        <a href="${data.file}" class="message-info" target="_blank">${file}</a>
                                    </div>
                                </div>
                            </div>`;
                }
                html4 = html4 + html0 + html1 + html2;
            });


            // if (page == 1) {
                mesageList = html4;
            // }else{
            //     mesageList = html4 + mesageList;
            // }

            $('#chat-details').html(html5 + mesageList);
            
            if (page == 1) {
                // $(".chat-history-body").animate({ scrollTop: $('.chat-history-body').prop("scrollHeight")}, 1000);
                $("#chat-details").animate({
                    scrollTop: $('#chat-details').prop("scrollHeight")
                }, 1000);
            }

        } else {
            let html = `<li class="chat-contact-list-item chat-list-item-0">
                <h6 class="text-muted mb-0">${result.message}</h6>
            </li>`;
        }
    });

    // =============================================CHAT DONE======================================================================

    $(document).keypress(function (e) {
        var key = e.which;
        if(key == 13)  // the enter key code
        {
        	e.preventDefault();
            var message = $('#message-input').val();
	        var type = $('.file_type').val();
	        $('#image-preview').hide();
	        var isblockuser = $('.usr-roomid').data('isblockuser');
	        var isblock = $('.usr-roomid').data('isblock');
	       	
		        if(message=='' && type == 'TEXT')
		        {
                    $('#text-preview').html('Please enter the message');
            	    $('#text-preview').fadeIn(400).delay(2000).fadeOut(400);
		            return false
		        }
		        else
		        {
		            message_file = $('.message_file').val();
		            if(message_file=='' && type != 'TEXT')
			        {
                        $('#text-preview').html('Please Choose file');
            	        $('#text-preview').fadeIn(400).delay(2000).fadeOut(400);
			            return false
			        } 
		            socket.emit("SEND_MESSAGE", {'senderId':SENDER_ID,'receiveId':RECEIVER_ID,'roomId':ROOM_ID,'message':message,'messageType':type,'messageFile':message_file});
		            $('.message-input').val('');
		            $('.file_type').val('TEXT');
		            $('.message_file').val('');
		            $('#picker').hide();
		        }
		    
        }
    });

    $(document).on('click','.sendMessage',function(){
    	var isblock = $('.usr-roomid').data('isblock');
    	var isblockuser = $('.usr-roomid').data('isblockuser');
        var message = $('#message-input').val();
        var type = $('.file_type').val();
        $('#image-preview').hide();
        
        if(message=='' && type == 'TEXT')
        {
            $('#text-preview').html('Please enter the message');
            $('#text-preview').fadeIn(400).delay(2000).fadeOut(400);
            return false
        }
        else
        {
            message_file = $('.message_file').val();
            if(message_file=='' && type != 'TEXT')
            {
                $('#text-preview').html('Please Choose file');
            	$('#text-preview').fadeIn(400).delay(2000).fadeOut(400);
                return false
            } 
            console.log({'senderId':SENDER_ID,'receiveId':RECEIVER_ID,'roomId':ROOM_ID,'message':message,'messageType':type,'messageFile':message_file});
            socket.emit("SEND_MESSAGE", {'senderId':SENDER_ID,'receiveId':RECEIVER_ID,'roomId':ROOM_ID,'message':message,'messageType':type,'messageFile':message_file});
            $('.message-input').val('');
            $('.file_type').val('TEXT');
            $('.message_file').val('');
            $('#picker').hide();
            document.getElementById('file-name').textContent = '';
        }
	    
    });

    socket.on('SEND_MESSAGE_RESPONSE', (res) => {
    	// chat_type = $('.usr-roomid').attr('data-chat_type');
    	// ROOM_ID = $('.usr-roomid').attr('data-roomid');
        let result = JSON.parse(res);   
        $('.message-bar-head').show();
        $('.mf-field').show();
        if(result.data.convenience_id==ROOM_ID){
            if(result.status==true)
            {
                var data =  result.data;
                var html1 = '';
                var html2 = '';
                var html0 = '';
                
                var message = data.message; 
                var file = '';
                var downloadIcon = '';
                let localDateTime = timeAgo(data.updated_at)
                if(data.file_type=='IMAGE')
                {
                    file = `<img src="{{asset('/storage/')}}/${data.file}" width="100"><br/>`;
                }
                else if(data.file_type=='VIDEO')
                {
                    file = `<video width="100px" controls><source src="{{asset('/storage/')}}/${data.file}" type="video/mp4"></video><br/>`;
                }
                else if(data.file_type=='DOC')
                {
                    file = `<iframe src="{{asset('/storage/')}}/${data.file}" width="100" height="100"></iframe><br/>`;
                }

                if (data.file_type != 'TEXT') {
                    downloadIcon = `<a href="{{asset('/storage/')}}/${data.file}" download class="hideimgmodal"><img src="{{asset('frontend/bussiness/images/download-1.svg')}}" alt="Download" class="download-msg-iocn"></a>`;
                }

                

                if(parseInt(data.from_id)==parseInt(SENDER_ID))
                {
                    html1 = `
                            <div class="messages"  data-msgid="${data.id}">
                                <div class="message outgoing">
                                    <div class="message-info text-end text-secondary-emphasis pb-1">
                                        <small>${localDateTime}</small>
                                    </div>
                                    ${data?.message}
                                    <a href="{{asset('/storage/')}}/${data.file}" target="_blank" class="message-info text-end text-secondary-emphasis pb-1">${file}</a>
                                </div>
                            </div>`;

                }
                if(parseInt(data.from_id)!=parseInt(SENDER_ID))
                {
                    html2 = `
                        <div class="messages" data-msgid="${data.id}">
                            <div class="message incoming">
                                <img src="${data.sender.profile_photo_path}"  alt="img">
                                <div class="incoming-box">
                                    <div class="message-info">
                                        <small>${localDateTime}</small>
                                    </div>
                                    ${data?.message}
                                    <a href="{{asset('/storage/')}}/${data.file}" class="message-info" target="_blank">${file}</a>
                                </div>
                            </div>
                        </div>`;
                }
                $('#chat-details').append(html0+html1+html2);
                socket.emit("THREADS_LIST", {'user_id':SENDER_ID, search:'',page:1,limit:100});
            }
        }
    });



  	$(document).on('keyup','.searchthread',function(){
        var search = $(this).val();
        if(search.length > 3) {
            threadList(SENDER_ID, search);
        }else if(search.length == 0) {
            threadList(SENDER_ID, '');
        }
    });


  	
    
    var firstthread = localStorage.getItem("firstthread");
    
    if(firstthread){
    	var data = JSON.parse(firstthread);
    	ROOM_ID = data.id
    	var  user_name = '';
        var  profile = '';
        var is_online = 'offline';
    	if(data.chatuser[0].get_user && parseInt(data.chatuser[0].user_id) != parseInt(SENDER_ID))
            {
            	var RECEIVER_ID = data.chatuser[0].get_user.id ? data.chatuser[0].get_user.id:  data.chatuser[0].get_user.id;  
                  user_name = data.chatuser[0].get_user.name ? data.chatuser[0].get_user.name:  data.chatuser[0].get_user.email;  
                  user_profile = data.chatuser[0].get_user.profile_image ? data.chatuser[0].get_user.profile_image: `{{asset('front/auth/assets/img/user-img.png')}}`;  
                  user_role  = data.chatuser[0].get_user.user_role;
                  if(parseInt(data.chatuser[0].get_user.is_online) == 1)
                  {
                    is_online = 'online'
                  }
            }
        if(data.chatuser[1].get_user &&  parseInt(data.chatuser[1].user_id) != parseInt(SENDER_ID))
            {
            	  var RECEIVER_ID = data.chatuser[1].get_user.id ? data.chatuser[1].get_user.id:  data.chatuser[1].get_user.id;
                  user_name = data.chatuser[1].get_user.name ? data.chatuser[1].get_user.name : data.chatuser[0].get_user.email;
                  user_profile = data.chatuser[1].get_user.profile_image ? data.chatuser[1].get_user.profile_image: `{{asset('front/auth/assets/img/user-img.png')}}`;  

                  user_role  = data.chatuser[1].get_user.user_role;
                  if(parseInt(data.chatuser[1].get_user.is_online) == 1)
                  {
                    is_online = 'online'
                  }
            }
               
	    $('.chat-contact-list-item').removeClass('active');
	    $(this).addClass('active');
	    
	    // $('.booking_id').html(`
		// 	<div class="usr-ms-img">
		// 		<img src="${user_profile}" alt=""  data-toggle="modal" data-target="#groupModal">
		// 	</div>
		// 	<div class="usr-mg-info user_name_filed">
		// 		<h3 data-toggle="modal" data-target="#groupModal">${user_name}</h3>
		// 	</div>
		// `);

        $('.booking_id').html(`
            <div class="usr-ms-img usr-roomid" data-roomid="${ROOM_ID}">
                <h3>
                    <img src="${user_profile}" alt="" style="height:50px; width:50px;" class="rounded-circle" data-toggle="modal" data-target="#groupModal">
                    ${usre_name}
                </h3>
            </div>
        `);

	    $('#chat-details').html('');
	    mesageList = '';
	    socket.emit("CHAT_LIST", {'senderId':SENDER_ID,'roomId':ROOM_ID,'page':page=1});
    }
    

    
    // $(document).on('click', '.leavenow', function(e) {
    // 	e.preventDefault();
    // 	$('#myModal6').modal('show');
	// });
  	
	// $(document).on('click', '#confirmLeave', function(e) {
    // 	e.preventDefault();
    // 	var roomId = $('.usr-roomid').data('roomid');

	//     $.ajax({
	//         type: 'POST',
	//         dataType: 'json',
	//         url: "",
	//         data: {
	//             roomId: roomId,
	//             _token: '{{ csrf_token() }}'
	//         },
	//         success: function(response) {
	//             if (response.status) {
	//                 window.location.reload();
	//             }
	//         }
	//     });
	// });

    // $(document).on('click', '.userblock', function(e) {
    //   e.preventDefault();
    //   var ROOM_ID = $('.usr-roomid').data('roomid');
    //   $('#myModal8').modal('show');
      
    // });
    // $(document).on('click', '#confirmBlock', function() {
	//     $('#myModal8').modal('hide');
	//     socket.emit("BLOCK_UNBLOCK", 
	//             	{'senderId':SENDER_ID,'roomId':ROOM_ID,'type':'block'});
	// });
    
    // $(document).on('click', '.userunblock', function(e) {
    //   e.preventDefault();
    
    //   var ROOM_ID = $('.usr-roomid').data('roomid');
    //   socket.emit("BLOCK_UNBLOCK",{'senderId':SENDER_ID,'roomId':ROOM_ID,'type':'unblock'});
    // });

   
  	var mesageList  = '';
	var setDate ='';

    //-----------------clear chat-----------------//
	$(document).on('click','.deletechat',function(){
        ROOM_ID = $('.usr-roomid').attr('data-roomid');
        RECEIVER_ID = $('.thread_details').attr('data-receiver_id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            if (result.isConfirmed) {
                socket.emit("DELETE_MESSAGE", {'senderId':SENDER_ID,'roomId':ROOM_ID,'messageId':0,'type':'all'});    
                socket.on('DELETE_MESSAGE_RESPONSE', (res) => {
                    result = JSON.parse(res);
                    // console.log(result);
                    if(result.data.sender_id == SENDER_ID){
                        $('#chat-details').html('');
                        // 	socket.emit("CHAT_LIST", {'senderId':SENDER_ID,'roomId':ROOM_ID,'page':page=1});
                        socket.emit("THREADS_LIST",{'user_id':SENDER_ID, search:'',page:1,limit:100} );
                    }
                });
            }
        })
    });




	
	$(document).on('click','.hideimgmodal',function(){
  		$('#imageModal').hide();
	});
	

  	//for single msg delete
  	let msgIdToDelete = null;
	let roomIdToDelete = null;
	$(document).on('click', '#singledelete', function() {
	    $('#imageModal').hide();
	    msgIdToDelete = $(this).attr('data-msgid');
	    roomIdToDelete = $('.thread_details').attr('data-room_id');
	    $('#myModal7').modal('show');
	});

	$(document).on('click', '#confirmDelete', function() {
	    $('#myModal7').modal('hide');
	    if (msgIdToDelete && roomIdToDelete) {
	        socket.emit("DELETE_SINGLE_MESSAGE", {'senderId': SENDER_ID, 'roomId': roomIdToDelete, 'messageId': msgIdToDelete});
	    }
	});

  	socket.on('DELETE_SINGLE_MESSAGE_RESPONSE', (res) => {
		result = JSON.parse(res);
		let messageId = result.data.messageId;
        $(`.main-message-box[data-msgid='${messageId}']`).remove();
        socket.emit("THREADS_LIST",{'user_id':SENDER_ID, search:'',page:1,limit:100} );
	});

	
	$(document).on('click','.deletemychat',function(){
       
		Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                ROOM_ID = $('.usr-roomid').attr('data-roomid');
                $.ajax({
                    url: "{{url('api/v1/deletemychat')}}",
                    method: 'post',
                    data:{
                        roomId:ROOM_ID,
                        user_id:SENDER_ID,
                        _token:'{{ csrf_token() }}'
                    },
                    
                    success: function(data) {
                        console.log(data);
                        if(data.status){
                            window.location.reload();
                        }
                    }
                });
            }
        })
    });

	$(document).on('change','#attach-doc',function(){

        const fileName = this.files[0]?.name || '';
        document.getElementById('file-name').textContent = fileName;
        
        var form = new FormData();
        form.append("attachment",$(this)[0].files[0]);
        form.append("_token",`{{ csrf_token() }}`);

        var settings = {
            "url": "{{url('api/v1/fileUpload')}}",
            "method": "POST",
            "timeout": 0,
            "headers": {
            },
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
        };

        // $.ajax(settings).done(function (response) {
        //     var data = JSON.parse(response);
        //     console.log(data);
        //     if(data.success==true)
        //     {
        //         $('.message_file').val(data.data.image);
        //         $('.file_type').val(data.data.type);

        //         $('#image-preview').show();
        //          var imageUrl = "{{ asset('/storage/') }}" +"/"+ data.data.image;
        //         var thumbnail = "{{ asset('/storage/') }}" +"/"+ data.data.thumbnail;
        //         console.log(imageUrl,'asdfdfdfd');
        //        	if(data.data.type == 'IMAGE'){
        //         	var imgPreview = '<img src="' + imageUrl + '" alt="Image Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;">';
        //         }
        //         if(data.data.type == 'VIDEO'){
        //         	var imgPreview = '<video width="200px" controls><source src="' + imageUrl + '" alt="Video Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;" type="video/mp4"></video>';
        //         }
        //         if(data.data.type == 'DOC'){
        //         	var imgPreview = '<iframe src="' + imageUrl + '" alt="Pdf Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;"></iframe>';
        //         }
        //         $('#image-preview').html(imgPreview);
	            
        //     }else{
        //         $('#image-preview').html("");
        //         document.getElementById('file-name').textContent = "";
        //     	$('#text-preview').html(data.message);
        //     	$('#text-preview').fadeIn(400).delay(2000).fadeOut(400);
        //     }
        // });


        $.ajax(settings).done(function (response) {
            var data = JSON.parse(response);
            console.log(data);

            if (data.success == true) {
                $('.message_file').val(data.data.image);
                $('.file_type').val(data.data.type);

                $('#image-preview').show();

                var imageUrl = "{{ asset('/storage/') }}" + "/" + data.data.image;

                let imgPreview = '';
                if (data.data.type == 'IMAGE') {
                    imgPreview = '<img src="' + imageUrl + '" alt="Image Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;">';
                } else if (data.data.type == 'VIDEO') {
                    imgPreview = '<video width="200px" controls style="margin-top:10px;"><source src="' + imageUrl + '" type="video/mp4"></video>';
                } else if (data.data.type == 'DOC') {
                    imgPreview = '<iframe src="' + imageUrl + '" style="max-width: 200px; max-height: 200px; margin-top: 10px;"></iframe>';
                }

                // Add remove button
                let removeBtn = '<button type="button" id="remove-preview"><svg height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg" id="fi_6467134"><g id="Flat_Color" data-name="Flat Color"><circle cx="12" cy="12" fill="#e63946" r="10"></circle><path d="m13.41 12 2.3-2.29a1 1 0 0 0 -1.42-1.42l-2.29 2.3-2.29-2.3a1 1 0 0 0 -1.42 1.42l2.3 2.29-2.3 2.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l2.29-2.3 2.29 2.3a1 1 0 0 0 1.42 0 1 1 0 0 0 0-1.42z" fill="#edebea"></path></g></svg></button>';

                $('#image-preview').html(imgPreview + removeBtn);

                // Add event listener to remove button
                $(document).on('click', '#remove-preview', function () {
                    $('#image-preview').html('');
                    $('.message_file').val('');
                    $('.file_type').val('TEXT');
                    $('#file-name').text('');
                });

            } else {
                $('#image-preview').html("");
                document.getElementById('file-name').textContent = "";
                $('#text-preview').html(data.message);
                $('#text-preview').fadeIn(400).delay(2000).fadeOut(400);
            }
        });


    });


   $(document).ready(function() {
    // Function to hide the picker
    function hidePicker() {
        $('#picker').hide();
    }

    // When clicking anywhere on the document body
    $(document).on('click', function(event) {
        // Check if the clicked element is not the picker or its descendants
        if (!$(event.target).closest('#picker').length && !$(event.target).is('.emojiselect')) {
            hidePicker();
        }
    });
    
    // When clicking on the picker itself
    $('#picker').on('click', function(event) {
        hidePicker();
        event.stopPropagation(); // Prevent this click from bubbling up to the document
    });

    // When clicking on the emojiselect
    $('.emojiselect').on('click', function(event) {
        $('#picker').toggle();
        event.stopPropagation(); // Prevent this click from bubbling up to the document
    });
    });

</script>
@endsection