@extends('frontend.profileinclude.app')
@section('content')
 <link rel="stylesheet" href="{{ asset('frontend/bussiness/css/app.css') }}">
<style type="text/css">
	.usr-msg-details {
    position: relative;
    padding-right: 40px; /* Adjust based on the size of your badge */
}

.unread-count {
    position: absolute;
    top: 50%;
    right: 10px; /* Adjust this value as needed */
    transform: translateY(-50%);
    background-color: green;
    color: white;
    border-radius: 50%;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 24px; /* Ensures the circle remains circular for single-digit numbers */
    height: 24px;
}

.modalpre {
  display: none;
      position: fixed;
    z-index: 999; 
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: #00000087; 
    align-items: center;
    justify-content: center;
}
.custom-modal-view{
	background: #fff;
	border-radius: 20px;
	padding: 20px;
	position: relative;
}
 

/* Modal image */
.modal-contentpre {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 500px;
}

/* Caption text */
#captionpre {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 500px;
  text-align: center;
  color: #000;
  padding: 10px 0;
  height: auto;
}

/* Close button */
.closepre {
  position: absolute;
  top: 3px;
  right: 10px;
  color: #000;
  font-size: 40px;
  transition: 0.3s;
}

.closepre:hover,
.closepre:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}
.loadmore {
    cursor: pointer;
}
#image-preview{
 font-family: system-ui, emoji;

 }
 .report-pop h2 {
    color: #1D2939;
    font-size: 25px;
    font-weight: 600;
    margin-top: 0;
    margin-bottom: 20px;
}
.fltre{
	position: relative;
	margin-bottom: 20px;
	display: flex;
}
.fltre input {
    height: auto;
    border-radius: 10px;
    font-size: 14px;
    width: 100%;
    margin: 0;
    background: #F1F1F7 0% 0% no-repeat padding-box;
    border: 1px solid #bfbfbf;
    max-width: 100%;
}
.fltre button {
    border: none;
    background: #007bff;
    border-radius: 11px;
    padding: 10px;
    flex: 0 0 auto;
}


.avatar-upload {
    position: relative;
    max-width: 150px;
    margin: 50px auto 10px;
}
.avatar-upload .avatar-edit {
  position: absolute;
  right: 12px;
  z-index: 1;
  top: 10px;
}
.avatar-upload .avatar-edit input {
  display: none;
}
.avatar-upload .avatar-edit input + label {
  display: inline-block;
  width: 34px;
  height: 34px;
  margin-bottom: 0;
  border-radius: 100%;
  background: #FFFFFF;
  border: 1px solid transparent;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
  cursor: pointer;
  font-weight: normal;
  transition: all 0.2s ease-in-out;
}
.avatar-upload .avatar-edit input + label:hover {
  background: #f1f1f1;
  border-color: #d6d6d6;
}
.avatar-upload .avatar-edit input + label:after {
  content: "\f040";
  font-family: 'FontAwesome';
  color: #757575;
  position: absolute;
  top: 10px;
  left: 0;
  right: 0;
  text-align: center;
  margin: auto;
}
.avatar-upload .avatar-preview {
  width: 150px;
  height: 150px;
  position: relative;
  border-radius: 100%;
  border: 6px solid #F8F8F8;
  box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
}
.avatar-upload .avatar-preview > div {
  width: 100%;
  height: 100%;
  border-radius: 100%;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}
input.check-lst:before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>
<div class="main-ws-sec">
		<div class="posts-section">
			<div class="post-bar p-0">	
				<div class="messages-sec">
			<div class="row">
			<div class="col-lg-4 col-md-12 no-pdd">
			<div class="msgs-list">
				<div class="msg-title">
					<h3>{{__('messages.Messages')}}</h3>
					<input type="text" class="form-control mb-0 searchthread" name="search" placeholder="Search" required>
				</div>
			    <div class="start_new_chat">
			    <a href="#" data-toggle="modal" data-target="#myModal1"> <span>+</span> {{__('messages.Start_New_Chat')}}</a>
			    <a href="#" data-toggle="modal" data-target="#groupModal"> <span>+</span> {{__('messages.Create_Group')}}</a>
				</div>
				<div class="messages-list">
					<ul id="chat-list">
						<!-- <li class="active">
							<div class="usr-msg-details">
								<div class="usr-ms-img">
									<img src="{{asset('frontend/bussiness/images/resources/m-img1.png')}}" alt="">
								</div>
								<div class="usr-mg-info">
									<h3>John Doe</h3>
									<p>Lorem ipsum dolor <img src="{{asset('frontend/bussiness/images/smley.png')}}" alt=""></p>
								</div>
							</div>
						</li>
						<li>
							<div class="usr-msg-details">
								<div class="usr-ms-img">
									<img src="{{asset('frontend/bussiness/images/resources/m-img2.png')}}" alt="">
								</div>
								<div class="usr-mg-info">
									<h3>David Vane</h3>
									<p>Vestibulum ac diam..</p>
								</div>
							</div>
						</li>
						<li>
							<div class="usr-msg-details">
								<div class="usr-ms-img">
									<img src="{{asset('frontend/bussiness/images/resources/m-img3.png')}}" alt="">
								</div>
								<div class="usr-mg-info">
									<h3>Nancy Dilan</h3>
									<p>Quam vehicula.</p>
								</div>
							</div>
						</li>
						<li>
							<div class="usr-msg-details">
								<div class="usr-ms-img">
									<img src="{{asset('frontend/bussiness/images/resources/m-img4.png')}}" alt="">
								</div>
								<div class="usr-mg-info">
									<h3>Norman Kenney</h3>
									<p>Nulla quis lorem ut..</p>
								</div>
							</div>
						</li>
						<li>
							<div class="usr-msg-details">
								<div class="usr-ms-img">
									<img src="{{asset('frontend/bussiness/images/resources/m-img5.png')}}" alt="">
								</div>
								<div class="usr-mg-info">
									<h3>James Dilan</h3>
									<p>Vivamus magna just..</p>
								</div>
							</div>
						</li>
						<li>
							<div class="usr-msg-details">
								<div class="usr-ms-img">
									<img src="{{asset('frontend/bussiness/images/resources/m-img6.png')}}" alt="">
								</div>
								<div class="usr-mg-info">
									<h3>Mike Dorn</h3>
									<p>Praesent sapien massa.</p>
								</div>
							</div>
						</li>
						<li>
							<div class="usr-msg-details">
								<div class="usr-ms-img">
									<img src="{{asset('frontend/bussiness/images/resources/m-img7.png')}}" alt="">
								</div>
								<div class="usr-mg-info">
									<h3>Patrick Morison</h3>
									<p>Convallis a pellente...</p>
								</div>
							</div>
						</li> -->
					</ul>
				</div><!--messages-list end-->
			</div><!--msgs-list end-->
			</div>
			<div class="col-lg-8 col-md-12 pd-right-none pd-left-none">
			<div class="main-conversation-box">
				<div class="message-bar-head">
					<div class="usr-msg-details booking_id w-100">
						<!-- <div class="usr-ms-img">
							<img src="{{asset('frontend/bussiness/images/resources/m-img1.png')}}" alt="">
						</div>
						<div class="usr-mg-info user_name_filed">
							<h3>John Doe <span>Bussiness</span></h3>
							<p>Online</p>
						</div> -->
					</div>
					<!-- <a href="#" title=""><i class="fa fa-ellipsis-v"></i></a> -->
					<span class="d-flex gap-2 align-items-center">
						<div class="report-dropdown">
							<a type="button" class="p-0"><i class="fa fa-ellipsis-v"></i></a>
							<ul class="drrpp sideellipes">
								<!-- <li type="button" class="deletechat">Clear Chat</li> -->
							</ul>
						</div>
					</span>
				</div><!--message-bar-head end-->
				<div class="messages-line" id="chat-details">
					<!-- <div class="main-message-box ta-right">
						<div class="message-dt">
							<div class="message-inner-dt">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec rutrum congue leo eget malesuada. Vivamus suscipit tortor eget felis porttitor.</p>
							</div>
							<span>1:08 PM</span>
						</div>
						<div class="messg-usr-img">
							<img src="{{asset('frontend/bussiness/images/resources/m-img2.png')}}" alt="">
						</div>
					</div>
					<div class="main-message-box st3">
						<div class="message-dt st3">
							<div class="message-inner-dt">
								<p>Cras ultricies ligula.<img src="{{asset('frontend/bussiness/images/smley.png')}}" alt=""></p>
							</div>
							<span>5 minutes ago</span>
						</div>
						<div class="messg-usr-img">
							<img src="{{asset('frontend/bussiness/images/resources/m-img1.png')}}" alt="">
						</div>
					</div>
					<div class="main-message-box ta-right">
						<div class="message-dt">
							<div class="message-inner-dt">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec rutrum congue leo eget malesuada. Vivamus suscipit tortor eget felis porttitor.</p>
							</div>
							<span>1:08 PM</span>
						</div>
						<div class="messg-usr-img">
							<img src="{{asset('frontend/bussiness/images/resources/m-img2.png')}}" alt="">
						</div>
					</div>
					<div class="main-message-box st3">
						<div class="message-dt st3">
							<div class="message-inner-dt">
								<p>Lorem ipsum dolor sit amet</p>
							</div>
							<span>2 minutes ago</span>
						</div>
						<div class="messg-usr-img">
							<img src="{{asset('frontend/bussiness/images/resources/m-img1.png')}}" alt="">
						</div>
					</div>
					<div class="main-message-box ta-right">
						<div class="message-dt">
							<div class="message-inner-dt">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec rutrum congue leo eget malesuada. Vivamus suscipit tortor eget felis porttitor.</p>
							</div>
							<span>1:08 PM</span>
						</div>
						<div class="messg-usr-img">
							<img src="{{asset('frontend/bussiness/images/resources/m-img2.png')}}" alt="">
						</div>
					</div>
					<div class="main-message-box st3">
						<div class="message-dt st3">
							<div class="message-inner-dt">
								<p>....</p>
							</div>
							<span>Typing...</span>
						</div>
						<div class="messg-usr-img">
							<img src="{{asset('frontend/bussiness/images/resources/m-img1.png')}}" alt="">
						</div>
					</div> -->
				</div>
				<div class="message-send-area msg-send-type">
					<form>
						<div id="text-preview" style="color: red;"></div>
						<div class="mf-field">
							<div id="image-preview"></div>
							<div class="attecmnt">
								<input type="file" id="attach-doc"><img src="{{asset('frontend/bussiness/images/attachment.svg')}}" alt="">
							</div>
							<div class="w-100">
								<input class="message-input" id="message-input" placeholder="Type your message here...">
					        <input type="hidden" class="file_type" value="TEXT"/>
					        <input type="hidden" class="message_file" value=""/>
							</div>
							
							<div class="mange-ass-v">
								<button type="button" class="emojiselect">
							<img style="width: 25px" src="{{asset('frontend/bussiness/images/happy.svg')}}" alt=""></button>
							<div id="picker" style="display: none;"></div>
							<button type="button" class="sendMessage"><img src="{{asset('frontend/bussiness/images/send_icon.svg')}}" alt=""></button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      	<div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close-btn" data-dismiss="modal"  aria-label="close" title="Close">x</button>
	        </div>
	        <div class="modal-body text-center report-pop">
	        	<h2 id="add-review-header">{{__('messages.Users')}}</h2>
	        	
							<div class="fltre">
								<input type="text" class="form-control usersearch" placeholder="Search here.." value="" id="name" name="name">
								<!-- <button type="button" class="usersearchbutton"><img src="{{asset('frontend/bussiness/images/search.svg')}}" alt=""></button> -->
							</div>
						
	        		<div id="searchResultsContainer">
              			@foreach($data as $uservalue)
							<div class="suggestion-usd">
								<div class="d-flex align-items-center">
									@if($uservalue->profile)
										<img src="{{url($uservalue->profile)}}" alt="">
									@else
										<img src="{{asset('frontend/bussiness/images/user_male_icon.png')}}" alt="">
									@endif
									<div class="sgt-text">
										<h4>{{$uservalue->first_name}}</h4>
										<span>{{$uservalue->username}}</span>
									</div>
								</div>
								<a href="javascript:void(0)" class="useradd" data-id="{{$uservalue->id}}">{{__('messages.Chat')}}</a>
							</div>
						@endforeach
					</div>
	        </div>
		</div>
    </div>
</div>

<div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close-btn" data-dismiss="modal" aria-label="close" title="Close">x</button>
            </div>
            <div class="modal-body text-center report-pop">
                <h2 id="add-review-header" class="grouptext">{{__('messages.Create_New_Group')}}</h2>
                <form id="userForm" method="POST" action="{{route('bussiness.creategroup')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="modalType" id="modalType" value="create">

                	<div class="avatar-upload grp-icon">
				        <div class="avatar-edit">
				            <input type='file' name="group_image" id="imageUpload" accept=".png, .jpg, .jpeg" />
				            <label for="imageUpload"></label>
				        </div>
				        <div class="avatar-preview">
				            <div id="imagePreview" style="background-image: url(http://i.pravatar.cc/500?img=7);">
				            </div>
				        </div>
				    </div>
                <div class="fltre">
                    <input type="text" class="form-control" placeholder="Enter group name.." value="" id="groupName" name="groupName">
                    <button type="submit" class="btn btn-primary">{{__('messages.Create')}}</button>
                </div>
                <!-- <div class="fltre">
                	
                    <input type="text" class="form-control bg-white groupusersearch" placeholder="Search user" value="">
                    <button type="button" class="groupusersearchbutton"><img src="https://v5.checkprojectstatus.com/circlequay/public/frontend/bussiness/images/search.svg" alt=""></button>
                   
                </div> -->
                
                		
                    <div id="searchResultsContainer" class="groupsearchresult">
                        @foreach($groupdata as $uservalue)
                        <div class="suggestion-usd">
                            <div class="d-flex align-items-center w-100">
                                @if($uservalue->profile)
                                    <img src="{{url($uservalue->profile)}}" alt="">
                                @else
                                    <img src="{{asset('frontend/bussiness/images/user_male_icon.png')}}" alt="">
                                @endif
                                <div class="sgt-text w-100">
                                    <h4>{{$uservalue->first_name}}</h4>
                                    <span>{{$uservalue->username}}</span>
                                </div>
                                <input type="checkbox" name="selectedUsers[]" value="{{$uservalue->id}}" class="check-lst">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="editgroupModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close-btn" data-dismiss="modal" aria-label="close" title="Close">x</button>
            </div>
            <div class="modal-body text-center report-pop">
                <h2 id="add-review-header" class="grouptext">{{__('messages.Edit')}}</h2>
                <form id="userForm" method="POST" action="{{route('bussiness.updategroup')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="modalType" id="modalType" value="edit">

                    <input type="hidden" name="roomId" id="roomId" value="">
                	<div class="avatar-upload grp-icon">
				        <div class="avatar-edit">
				            <input type='file' name="group_image" id="editimageUpload" accept=".png, .jpg, .jpeg" />
				            <label for="editimageUpload"></label>
				        </div>
				        <div class="avatar-preview">
				            <div id="editimagePreview" style="background-image: url(http://i.pravatar.cc/500?img=7);">
				            </div>
				        </div>
				    </div>
                <div class="fltre">
                    <input type="text" class="form-control" placeholder="Enter group name.." value="" id="groupName" name="groupName">
                    <button type="submit" class="btn btn-primary updatebtn">{{__('messages.Update')}}</button>
                </div>
                <!-- <div class="fltre">
                	
                    <input type="text" class="form-control bg-white groupusersearch" placeholder="Search user" value="">
                    <button type="button" class="groupusersearchbutton"><img src="https://v5.checkprojectstatus.com/circlequay/public/frontend/bussiness/images/search.svg" alt=""></button>
                   
                </div>  -->

            	<div id="editsearchResultsContainer"  class="groupsearchresult">
          
				</div>


            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editgroupModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close-btn" data-dismiss="modal" aria-label="close" title="Close">x</button>
            </div>
            <div class="modal-body text-center report-pop">
                <!-- <h2 id="add-review-header" class="grouptext">{{__('messages.Edit')}}</h2> -->
                <form id="userForm" method="POST" action="{{route('bussiness.updategroup')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="modalType" id="modalType" value="edit">

                    <input type="hidden" name="roomId" id="roomId" value="">
                	<!-- <div class="avatar-upload grp-icon">
				        <div class="avatar-edit">
				            <input type='file' name="group_image" id="editimageUpload" accept=".png, .jpg, .jpeg" />
				            <label for="editimageUpload"></label>
				        </div>
				        <div class="avatar-preview">
				            <div id="editimagePreview" style="background-image: url(http://i.pravatar.cc/500?img=7);">
				            </div>
				        </div>
				    </div> -->
               <!--  <div class="fltre">
                    <input type="text" class="form-control" placeholder="Enter group name.." value="" id="groupName" name="groupName" disabled>
                    <button type="submit" class="btn btn-primary updatebtn" disabled>{{__('messages.Update')}}</button>
                </div> -->
                <!-- <div class="fltre">
                	
                    <input type="text" class="form-control bg-white groupusersearch" placeholder="Search user" value="">
                    <button type="button" class="groupusersearchbutton"><img src="https://v5.checkprojectstatus.com/circlequay/public/frontend/bussiness/images/search.svg" alt=""></button>
                   
                </div>  -->

            	<div id="editsearchResultsContainer1"  class="groupsearchresult">
          
				</div>


            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close-btn" data-dismiss="modal" aria-label="close" title="Close">x</button>
            </div>
            <div class="modal-body text-center report-pop">
                <img class="mt-5" src="images/del-lrg.svg" alt="">
                <h2 id="add-review-header" class="mt-4">{{__('messages.Leave_group')}}</h2>
                <p>{{__('messages.Are_you_sure_do_you_want_to')}}<br>{{__('messages.Leave_group')}}?</p>
                <button type="submit" class="cont-n d-block" id="confirmLeave">{{__('messages.Yes')}}</button>
                <a href="javascript::void();" class="close-btn" data-dismiss="modal" aria-label="close">{{__('messages.Not_Now')}}</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close-btn" data-dismiss="modal" aria-label="close" title="Close">x</button>
            </div>
            <div class="modal-body text-center report-pop">
                <img class="mt-5" src="images/del-lrg.svg" alt="">
                <h2 id="add-review-header" class="mt-4">{{__('messages.Delete')}}</h2>
                <p>{{__('messages.Are_you_sure_you_want_to_delete_this_message')}}<br>{{__('messages.Doing_so_will_remove_it_for_everyone')}}</p>
                <button type="submit" class="cont-n d-block" id="confirmDelete">{{__('messages.Yes')}}</button>
                <a href="javascript::void();" class="close-btn" data-dismiss="modal" aria-label="close">{{__('messages.Not_Now')}}</a>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal8" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close-btn" data-dismiss="modal" aria-label="close" title="Close">x</button>
            </div>
            <div class="modal-body text-center report-pop">
                <img class="mt-5" src="images/del-lrg.svg" alt="">
                <h2 id="add-review-header" class="mt-4">{{__('messages.Block')}}</h2>
                <p>{{__('messages.Are_you_sure_you_want_to_block_this_user')}}<br>{{__('messages.Blocking_will_prevent_them_from_sending_you_any_further_messages')}}</p>
                <button type="submit" class="cont-n d-block" id="confirmBlock">{{__('messages.Yes')}}</button>
                <a href="javascript::void();" class="close-btn" data-dismiss="modal" aria-label="close">{{__('messages.Not_Now')}}</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal9" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close-btn" data-dismiss="modal" aria-label="close" title="Close">x</button>
            </div>
            <div class="modal-body text-center report-pop">
                <img class="mt-5" src="images/del-lrg.svg" alt="">
                <h2 id="add-review-header" class="mt-4">{{__('messages.Clear_chat')}}</h2>
                <p>{{__('messages.Are_you_sure_you_want_to_clear_the_chat')}}<br>{{__('messages.This_will_remove_all_messages_from_the_conversation')}}</p>
                <button type="submit" class="cont-n d-block" id="confirmDeletechat">{{__('messages.Yes')}}</button>
                <a href="javascript::void();" class="close-btn" data-dismiss="modal" aria-label="close">{{__('messages.Not_Now')}}</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal10" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close-btn" data-dismiss="modal" aria-label="close" title="Close">x</button>
            </div>
            <div class="modal-body text-center report-pop">
                <img class="mt-5" src="images/del-lrg.svg" alt="">
                <h2 id="add-review-header" class="mt-4">{{__('messages.Delete')}}</h2>
                 <p>{{__('messages.Are_you_sure_you_want_to_delete_the_chat')}}<br>{{__('messages.This_will_permanently_remove_the_entire_conversation')}}</p>
                <button type="submit" class="cont-n d-block" id="confirmDeletemychat">{{__('messages.Yes')}}</button>
                <a href="javascript::void();" class="close-btn" data-dismiss="modal" aria-label="close">{{__('messages.Not_Now')}}</a>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal11" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close-btn" data-dismiss="modal" aria-label="close" title="Close">x</button>
            </div>
            <div class="modal-body text-center report-pop">
                <img class="mt-5" src="images/del-lrg.svg" alt="">
                <h2 id="add-review-header" class="mt-4">{{__('messages.Delete')}}</h2>
                <p>{{__('messages.Are_you_sure_you_want_to_delete_the_group')}}<br>{{__('messages.This_will_permanently_remove_the_entire_conversation')}}</p>
                <button type="submit" class="cont-n d-block" id="confirmdeletegroup">{{__('messages.Yes')}}</button>
                <a href="javascript::void();" class="close-btn" data-dismiss="modal" aria-label="close">{{__('messages.Not_Now')}}</a>
            </div>
        </div>
    </div>
</div>

<div id="imageModal" class="modalpre">
	<div class="custom-modal-view">
  <span class="closepre">&times;</span>
  <img class="modal-contentpre" id="modalImage">
  <div id="captionpre"></div>
</div>
</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('socket.io.js')}}"></script>
<script>

	function readURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function(e) {
	            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
	            $('#imagePreview').hide();
	            $('#imagePreview').fadeIn(650);
	        }
	        reader.readAsDataURL(input.files[0]);
	    }
	}
	function editreadURL(input) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function(e) {
	            $('#editimagePreview').css('background-image', 'url('+e.target.result +')');
	            $('#editimagePreview').hide();
	            $('#editimagePreview').fadeIn(650);
	        }
	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$("#imageUpload").change(function() {
	    readURL(this);
	});
	$("#editimageUpload").change(function() {
	    editreadURL(this);
	});
	

	$(document).ready(function(){
		$('.message-bar-head').hide();
        $('.mf-field').hide();
		$(".report-dropdown").click(function(){
		    $(".drrpp").toggle();
		});

	  	$('.usersearch').keyup(function (e) {
	        e.preventDefault();
	        var searchdata = $('.usersearch').val(); 
	        $.ajax({
	            type:'POST',
	            dataType:'json',
	            url:"{{ route('bussiness.usersearch') }}",
	            data:{
	                searchdata:searchdata,
	                _token:'{{ csrf_token() }}'
	            },
	            success:function(response){
	                if (response.status) {
		                $('#searchResultsContainer').html(response.html);
		            } else {
		                $('#searchResultsContainer').html('<p>No users found.</p>');
		            }
	            }
	        });
	    });

		var selectedUsers = [];
		$('.groupusersearchbutton').click(function (e) {
		    e.preventDefault();
		    var searchdata = $(this).siblings('.groupusersearch').val();
		    var modalType = $(this).closest('form').find('#modalType').val();
		    var selectedUsers = [];
		    
		    if (modalType === 'edit') {
		        selectedUsers = $(this).closest('form').find('.check-lst:checked').map(function() {
		            return $(this).val();
		        }).get();
		    }

		    $.ajax({
		        type: 'POST',
		        dataType: 'json',
		        url: "{{ route('bussiness.groupusersearch') }}",
		        data: {
		            searchdata: searchdata,
		            modalType: modalType,
		            selectedUsers: selectedUsers,
		            _token: '{{ csrf_token() }}'
		        },
		        success: function(response) {
		            if (response.status) {
		                $('.groupsearchresult').html(response.html);
		            } else {
		                $('.groupsearchresult').html('<p>No users found.</p>');
		            }
		        }
		    });
		});

		$(document).on('change', '.check-lst', function() {
		    var userId = $(this).val();
		    if ($(this).is(':checked')) {
		        selectedUsers.push(userId);
		    } else {
		        var index = selectedUsers.indexOf(userId);
		        if (index !== -1) {
		            selectedUsers.splice(index, 1);
		        }
		    }
		});
	});

	$(document).ready(function() {
	    $('#userForm').on('submit', function(e) {
	        var isValid = true;
	        if ($('#groupName').val().trim() === '') {
	            alert('Group name is required');
	            isValid = false;
	        }
	        if ($('input[name="selectedUsers[]"]:checked').length === 0) {
	            alert('Select at least one user');
	            isValid = false;
	        }

	        if (!isValid) {
	            e.preventDefault();
	        }else{
	        	var selectedUsersInput = '<input type="hidden" name="selectedUsers" value="' + selectedUsers.map(function() {
			        return this.value;
			    }).get().join(',') + '">';
			    $(this).append(selectedUsersInput);

			    this.submit();
	        }
	    });
	});

function openModal(imgSrc) {
  var modal = document.getElementById("imageModal");
  var modalImg = document.getElementById("modalImage");
  modal.style.display = "flex";
  modalImg.src = imgSrc;
}

// When the user clicks on <span> (x), close the modal
var span = document.getElementsByClassName("closepre")[0];
span.onclick = function() { 
  var modal = document.getElementById("imageModal");
  modal.style.display = "none";
}

$(document).on('click', '#chat-details img', function() {
  var imgSrc = $(this).attr('src');
  openModal(imgSrc);
});

const socket = io("https://circlequay.com:3115");
    var userrole = '{{Auth()->user()->role}}';
    if(userrole == 'staff'){
    	var SENDER_ID = '{{Auth()->user()->parent_id}}';
    }else{
    	var SENDER_ID = '{{Auth()->user()->id}}';
    }
	
  	var RECEIVER_ID = '';
  	var  ROOM_ID = "";  


	socket.emit("CONNECT",{'senderId':SENDER_ID} );
	socket.on('CONNECT_RESPONSE', (res) => {
	        console.log(res);
	});

	

        $(document).on('click', '.useradd', function(e) {
            e.preventDefault();
            var userId = $(this).data('id'); 
 
            $.ajax({
	            type:'POST',
	            dataType:'json',
	            url:"{{ route('bussiness.useradd') }}",
	            data:{
	                userId:userId,
	                _token:'{{ csrf_token() }}'
	            },
	            success:function(response){
	                if(response.status){
	                	console.log(response);
	                	$("#myModal1").modal('hide');
	                	SENDER_ID = response.data.from_id;
	                	RECEIVER_ID = parseInt(response.data.to_id);
	                	ROOM_ID = response.data.room_id;

	                	threadList(SENDER_ID, name);
	                }
	            }
	        });
        });
   

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

	function dateFormate(date){
	    const day = new Date(date);
	    const m = ["January", "February", "March", "April", "May", "June",
	    "July", "August", "September", "October", "November", "December"];
	    const str_op = day.getDate() + ' ' + m[day.getMonth()] + ' ' + day.getFullYear();
	    return str_op;
	}


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
		            alert('Please enter the message');
		            return false
		        }
		        else
		        {
		            message_file = $('.message_file').val();
		            if(message_file=='' && type != 'TEXT')
			        {
			            alert('Please Choose file');
			            return false
			        } 
		                     
		            socket.emit("SEND_MESSAGE", 
		            	{'senderId':SENDER_ID,'receiveId':RECEIVER_ID,'roomId':ROOM_ID,'message':message,'messageType':type,'messageFile':message_file});
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
	            alert('Please enter the message');
	            return false
	        }
	        else
	        {
	            message_file = $('.message_file').val();
	            if(message_file=='' && type != 'TEXT')
		        {
		            alert('Please Choose file');
		            return false
		        } 
	                     
	            socket.emit("SEND_MESSAGE", 
	            	{'senderId':SENDER_ID,'receiveId':RECEIVER_ID,'roomId':ROOM_ID,'message':message,'messageType':type,'messageFile':message_file});
	            $('.message-input').val('');
	            $('.file_type').val('TEXT');
	            $('.message_file').val('');
	            $('#picker').hide();
	        }
	    
    });

    socket.on('SEND_MESSAGE_RESPONSE', (res) => {
    	chat_type = $('.usr-roomid').attr('data-chat_type');
    	ROOM_ID = $('.usr-roomid').attr('data-roomid');
        let result = JSON.parse(res);   
        $('.message-bar-head').show();
        	$('.mf-field').show();
        console.log(result,'sendmsg');   
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
            let localDateTime = UTCtoLocal(data.created_at)
            if(data.file_type=='IMAGE')
              {
                file = `<img src="${data.file}" width="100"><br/>`;
              }
              else if(data.file_type=='Video')
              {
                file = `<video width="100px" controls><source src="${data.file}" type="video/mp4"></video><br/>`;
              }
              else if(data.file_type=='PDF')
              {
                file = `<iframe src="${data.file}" width="100" height="100"></iframe><br/>`;
              }

              if (data.file_type != 'TEXT') {
	            	downloadIcon = `<a href="${data.file}" download class="hideimgmodal"><img src="{{asset('frontend/bussiness/images/download-1.svg')}}" alt="Download" class="download-msg-iocn"></a>`;
	            	}

        	if(chat_type == 'SINGLE'){

	            if(parseInt(data.from_id)==parseInt(SENDER_ID))
	            {
		            html1 =  `<div class="main-message-box ta-right" data-msgid="${data.id}">
							<div class="message-dt">
									<div class="message-inner-dt">
									 	<img id="singledelete" data-msgid="${data.id}" src="{{asset('frontend/bussiness/images/delet00000000452.svg')}}" alt="">
										<p class="chat-emoji">${file}${message}</p>
										${downloadIcon}
									</div>
									<span>  ${localDateTime}</span>
								</div>
								<div class="messg-usr-img">
									<img src="${data.sender.profile}" alt="">
								</div>
							</div>`;
		        }
	            if(parseInt(data.from_id)!=parseInt(SENDER_ID))
	            {
	              	html2= `<div class="main-message-box st3" data-msgid="${data.id}">
							<div class="message-dt st3">
								<div class="message-inner-dt">
									<p class="chat-emoji">${file}${message}</p>
									${downloadIcon}
								</div>
								<span> ${localDateTime}</span>
							</div>
							<div class="messg-usr-img">
								<img src="${data.sender.profile}" alt="">
							</div>
						</div>`;
	            }
         	}else{
         		if(parseInt(data.from_id)==parseInt(SENDER_ID))
            	{
		            html1 =  `<div class="main-message-box ta-right" data-msgid="${data.id}">
							<div class="message-dt">
									<div class="message-inner-dt">
										<img  id="singledelete" data-msgid="${data.id}" src="{{asset('frontend/bussiness/images/delet00000000452.svg')}}" alt="">
										<p class="chat-emoji">${file}${message}</p>
										${downloadIcon}
									</div>
									<span>You ${localDateTime}</span>
								</div>
								<div class="messg-usr-img">
									<img src="${data.sender.profile}" alt="">
								</div>
							</div>`;
		        }
	            if(parseInt(data.from_id)!=parseInt(SENDER_ID))
	            {
              		html2= `<div class="main-message-box st3" data-msgid="${data.id}">
						<div class="message-dt st3">
							<div class="message-inner-dt">
								<p class="chat-emoji">${file}${message}</p>
								${downloadIcon}
							</div>
							<span>${data.sender.first_name} ${data.sender.last_name} ${localDateTime}</span>
						</div>
						<div class="messg-usr-img">
							<img src="${data.sender.profile}" alt="">
						</div>
					</div>`;
                }
         	}
           	$('#chat-details').append(html0+html1+html2);
           	//$(".chat-history-body").animate({ scrollTop: $('.chat-history-body').prop("scrollHeight")}, 1000);
           	$("#chat-details").animate({ scrollTop: $('#chat-details').prop("scrollHeight") }, 1000);
           	socket.emit("THREADS_LIST", {'senderId':SENDER_ID, 'name': ''});
           	// socket.emit("THREADS_LIST", SENDER_ID,'');
        }
    }
  });



  	$(document).on('keyup','.searchthread',function(){

        var name = $(this).val();
        threadList(SENDER_ID, name);
    });


  	function threadList(SENDER_ID,name)
	{
		console.log("name---frontend",name);
	    socket.emit("THREADS_LIST",{'senderId':SENDER_ID, 'name': name} );
	}
    var active = '';
    threadList(SENDER_ID,'');


    socket.on('THREADS_LIST_RESPONSE', (res) => {
        let result = JSON.parse(res);
        console.log(result,',lklo');
    
        if(result.status==true)
        {
          let  html= ``;
          result.data.map(function(data,i){
          	// if(i == 0){
          	// 	localStorage.setItem("firstthread", JSON.stringify(data));
          	// }

            console.log(data,i);
         
            if(data.id==ROOM_ID )
            {
              active = 'active';
            }
            else{
              active = '';
            }
            if(data.type=="SINGLE")
            {
              if(data.chatuser[0].get_user && data.chatuser[1].get_user)
              {
                console.log(data,'----');
                var  user_name = '';
                var  profile = '';
                var is_online = 'offline';

   
                if(data.chatuser[0].get_user && parseInt(data.chatuser[0].user_id) != parseInt(SENDER_ID))
                {
               
                  var RECEIVERID = data.chatuser[0].get_user.id ? data.chatuser[0].get_user.id:  data.chatuser[0].get_user.id;  
                  user_name = data.chatuser[0].get_user.name ? data.chatuser[0].get_user.name:  data.chatuser[0].get_user.email;  
                  profile = data.chatuser[0].get_user.profile_image ? data.chatuser[0].get_user.profile_image: 'https://v5.checkprojectstatus.com/circlequay/public/frontend/bussiness/images/user_male_icon.png';  
                  user_role  = data.chatuser[0].get_user.user_role;
                  if(parseInt(data.chatuser[0].get_user.is_online) == 1)
                  {
                    is_online = 'online'
                  }
                }
                if(data.chatuser[1].get_user &&  parseInt(data.chatuser[1].user_id) != parseInt(SENDER_ID))
                {
                  var RECEIVERID = data.chatuser[1].get_user.id ? data.chatuser[1].get_user.id:  data.chatuser[1].get_user.id;
                  user_name = data.chatuser[1].get_user.name ? data.chatuser[1].get_user.name : data.chatuser[0].get_user.email;
                  profile = data.chatuser[1].get_user.profile_image ? data.chatuser[1].get_user.profile_image: 'https://v5.checkprojectstatus.com/circlequay/public/frontend/bussiness/images/user_male_icon.png';  
                  user_role  = data.chatuser[1].get_user.user_role;
                  if(parseInt(data.chatuser[1].get_user.is_online) == 1)
                  {
                    is_online = 'online'
                  }
                }
                var ticket_type = 'Booking No. : ';
             
                if(data.ticket_type=='Query')
                {
                  ticket_type = 'Ticket No. : ';
                }
            
            
            html+=`<li class="thread_details chat-contact-list-item ${active}"  data-room_id="${data.id}" data-receiver_id="${RECEIVERID}" data-room_id="${data.id}" data-ticket_type="${data.ticket_type}" data-ticket_id="${data.ticket_id}" data-usre_name="${user_name}" data-user_profile="${profile}" data-user_online="${is_online}" data-user_role ="${user_role}" data-type ="${data.type}" data-isblock ="${data.is_block}" data-isblockuser ="${data.is_block_user_id}" data-fromid ="${data.from_id}">
					<div class="usr-msg-details">
						<div class="usr-ms-img">
							<img src="${profile}" alt="">
						</div>
						<div class="usr-mg-info">
							<h3>${user_name}<span></span></h3>
							<p>${data.last_message.length > 20 ? data.last_message.substr(0,20)+'..' : data.last_message}</p>
							${data.total_unread > 0 ? `<span class="unread-count">${data.total_unread}</span>` : ''}
						</div>
					</div>
				</li>`;

              user_name ='';
              profile ='';
              is_online = 'offline';
              }
            }else{
            	var RECEIVERID = 0;
            	user_name = data.group_name;
                profile = data.group_image;
                user_role  = 'Group';
                is_online = data.chatuser.length + ' Users';
                // if(parseInt(data.chatuser[0].get_user.is_online) == 1)
                //   {
                //     is_online = 'online'
                //   }
                // }
                var ticket_type = 'Booking No. : ';
             
                if(data.ticket_type=='Query')
                {
                  ticket_type = 'Ticket No. : ';
                }

                html+=`<li class="thread_details chat-contact-list-item ${active}"  data-room_id="${data.id}" data-receiver_id="${RECEIVERID}" data-room_id="${data.id}" data-ticket_type="${data.ticket_type}" data-ticket_id="${data.ticket_id}" data-usre_name="${user_name}" data-user_profile="${profile}" data-user_online="${is_online}" data-user_role ="${user_role}" data-type ="${data.type}" data-fromid ="${data.from_id}">
					<div class="usr-msg-details" data-isblock ="${data.is_block}" data-isblockuser ="${data.is_block_user_id}">
						<div class="usr-ms-img">
							<img src="${profile}" alt="">
						</div>
						<div class="usr-mg-info">
							<h3>${user_name}<span></span></h3>
							<p>${data.last_message.length > 20 ? data.last_message.substr(0,20)+'..' : data.last_message}</p>
							${data.total_unread > 0 ? `<span class="unread-count">${data.total_unread}</span>` : ''}
						</div>
					</div>
				</li>`;

              user_name ='';
              profile ='';
              is_online = 'offline';
            }
          })

          $('#chat-list').html(html);
        }
        else{
          let html =`<h6 class="text-muted mb-0"></h6>`;

          $('#chat-list').html(html);
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
                  user_profile = data.chatuser[0].get_user.profile_image ? data.chatuser[0].get_user.profile_image: 'https://stage.tasksplan.com/lastMntapp/public/users/images/169502909053.png';  
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
                  user_profile = data.chatuser[1].get_user.profile_image ? data.chatuser[1].get_user.profile_image: 'https://stage.tasksplan.com/lastMntapp/public/users/images/169502909053.png';  

                  user_role  = data.chatuser[1].get_user.user_role;
                  if(parseInt(data.chatuser[1].get_user.is_online) == 1)
                  {
                    is_online = 'online'
                  }
            }
               
	    $('.chat-contact-list-item').removeClass('active');
	    $(this).addClass('active');
	    
	    $('.booking_id').html(`
			<div class="usr-ms-img">
				<img src="${user_profile}" alt=""  data-toggle="modal" data-target="#groupModal">
			</div>
			<div class="usr-mg-info user_name_filed">
				<h3  data-toggle="modal" data-target="#groupModal">${user_name}<span>${user_role}</span></h3>
				<p>${is_online}</p>
			</div>
		`);

	    $('#chat-details').html('');
	    mesageList = '';
	    socket.emit("CHAT_LIST", {'senderId':SENDER_ID,'roomId':ROOM_ID,'page':page=1});
    }

    // $(document).on('click', '.leavenow', function(e) {
    //   e.preventDefault();
    //   var roomId = $('.usr-roomid').data('roomid');
      
    //     $.ajax({
    //       type:'POST',
    //       dataType:'json',
    //       url:"{{ route('bussiness.leavenow') }}",
    //       data:{
    //           roomId:roomId,
    //           _token:'{{ csrf_token() }}'
    //       },
    //       success:function(response){
    //           if(response.status){
    //           	window.location.reload();
    //           }
    //       }
    //   });
    // });
    $(document).on('click', '.leavenow', function(e) {
    	e.preventDefault();
    	$('#myModal6').modal('show');
	});
  	
	$(document).on('click', '#confirmLeave', function(e) {
    	e.preventDefault();
    	var roomId = $('.usr-roomid').data('roomid');

	    $.ajax({
	        type: 'POST',
	        dataType: 'json',
	        url: "{{ route('bussiness.leavenow') }}",
	        data: {
	            roomId: roomId,
	            _token: '{{ csrf_token() }}'
	        },
	        success: function(response) {
	            if (response.status) {
	                window.location.reload();
	            }
	        }
	    });
	});

    $(document).on('click', '.userblock', function(e) {
      e.preventDefault();
      var ROOM_ID = $('.usr-roomid').data('roomid');
      $('#myModal8').modal('show');
      
    });
    $(document).on('click', '#confirmBlock', function() {
	    $('#myModal8').modal('hide');
	    socket.emit("BLOCK_UNBLOCK", 
	            	{'senderId':SENDER_ID,'roomId':ROOM_ID,'type':'block'});
	});
    
    $(document).on('click', '.userunblock', function(e) {
      e.preventDefault();
      // var roomId = $('.usr-roomid').data('roomid');
      
      //   $.ajax({
      //     type:'POST',
      //     dataType:'json',
      //     url:"{{ route('bussiness.userunblock') }}",
      //     data:{
      //         roomId:roomId,
      //         _token:'{{ csrf_token() }}'
      //     },
      //     success:function(response){
      //         if(response.status){
      //         	// socket.emit("CHAT_LIST", {'senderId':SENDER_ID,'roomId':roomId,'page':page=1});
      //         	// socket.emit("THREADS_LIST",{'senderId':SENDER_ID, 'name': ''} );
      //         	window.location.reload();
      //         }
      //     }
      // });
      var ROOM_ID = $('.usr-roomid').data('roomid');
      socket.emit("BLOCK_UNBLOCK", 
	            	{'senderId':SENDER_ID,'roomId':ROOM_ID,'type':'unblock'});
    });
    socket.on('BLOCK_UNBLOCK_RESPONSE', (res) => {
        let result = JSON.parse(res);   
        console.log(result);
        
        var isblockuser = result.data.is_block_user_id;
        var is_block = result.data.is_block;
        if(is_block == 0){
        	$('.mf-field').show();
        	$('.sideellipes').html(`<li type="button" class="userblock">Block</li>
								<li type="button" class="deletechat">Clear Chat</li>
								<li type="button" class="deletemychat">Delete Chat</li>`);
        }else{
        	$('.mf-field').hide();
        	if(isblockuser){
	  			if(isblockuser == SENDER_ID){
	  				$('.sideellipes').html(`<li type="button" class="userunblock">Unblock</li>
								<li type="button" class="deletechat">Clear Chat</li><li type="button" class="deletemychat">Delete Chat</li>`);
	  			}else{
	  				$('.sideellipes').html(`<li type="button" class="">Blocked</li>
								<li type="button" class="deletechat">Clear Chat</li><li type="button" class="deletemychat">Delete Chat</li>`);
	  			}
	  		}else{
	  			$('.sideellipes').html(`<li type="button" class="userblock">Block</li>
								<li type="button" class="deletechat">Clear Chat</li><li type="button" class="deletemychat">Delete Chat</li>`);
	  		}
        }
        
  	});




  	var mesageList  = '';
	var setDate ='';


	$(document).on('click','.deletechat',function(){
	    ROOM_ID = $('.usr-roomid').attr('data-roomid');
	    RECEIVER_ID = $('.thread_details').attr('data-receiver_id');
	    $('#myModal9').modal('show');
	    // socket.emit("DELETE_MESSAGE", {'senderId':SENDER_ID,'roomId':ROOM_ID,'messageId':0,'type':'all'});
	    
		// socket.on('DELETE_MESSAGE_RESPONSE', (res) => {
		// 	result = JSON.parse(res);
		// 	console.log(result);
		// 	console.log(result.data);
		// 	console.log(result.data.sender_id);
		// 	console.log('senderid',SENDER_ID);
		// 	if(result.data.sender_id == SENDER_ID){
		// 		$('#chat-details').html('');
		// 		// 	socket.emit("CHAT_LIST", {'senderId':SENDER_ID,'roomId':ROOM_ID,'page':page=1});
		// 		socket.emit("THREADS_LIST",{'senderId':SENDER_ID, 'name': ''} );
		// 	}
		// });

	});

	$(document).on('click', '#confirmDeletechat', function() {
	    $('#myModal9').modal('hide');
	    socket.emit("DELETE_MESSAGE", {'senderId':SENDER_ID,'roomId':ROOM_ID,'messageId':0,'type':'all'});
	    
		socket.on('DELETE_MESSAGE_RESPONSE', (res) => {
			result = JSON.parse(res);
			console.log(result);
			console.log(result.data);
			console.log(result.data.sender_id);
			console.log('senderid',SENDER_ID);
			if(result.data.sender_id == SENDER_ID){
				$('#chat-details').html('');
				// 	socket.emit("CHAT_LIST", {'senderId':SENDER_ID,'roomId':ROOM_ID,'page':page=1});
				socket.emit("THREADS_LIST",{'senderId':SENDER_ID, 'name': ''} );
			}
		});
	});



	$(document).on('click','.deletegroup',function(){
	    ROOM_ID = $('.usr-roomid').attr('data-roomid');
	    $('#myModal11').modal('show');
	    // socket.emit("DELETE_GROUP", 
	    //         	{'senderId':SENDER_ID,'roomId':ROOM_ID});
	    
	});

	$(document).on('click', '#confirmdeletegroup', function() {
	    $('#myModal11').modal('hide');
	    socket.emit("DELETE_GROUP", 
	            	{'senderId':SENDER_ID,'roomId':ROOM_ID});
	    
	});
	socket.on('DELETE_GROUP_RESPONSE', (res) => {
        let result = JSON.parse(res);   
        window.location.reload();
    
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
        socket.emit("THREADS_LIST",{'senderId':SENDER_ID, 'name': ''} );
	});

	$(document).on('click','.thread_details',function(){
			setDate ='';
			console.log(SENDER_ID);
			$('.message-bar-head').show();
        	//$('.mf-field').show();
			$(this).find('.unread-count').hide();
		    ROOM_ID = $(this).attr('data-room_id');
		    RECEIVER_ID = $(this).attr('data-receiver_id');

		    var ticket_id  = $(this).data('ticket_id');
		    var ticket_type  = $(this).data('ticket_type');
		    var usre_name  = $(this).data('usre_name');
		    var user_profile  = $(this).data('user_profile');
		    var user_online  = $(this).data('user_online');
		    var user_role  = $(this).data('user_role');
		    var chat_type  = $(this).data('type');
		    var isblock  = $(this).data('isblock');
		    var isblockuser  = $(this).data('isblockuser');
		    var fromid = $(this).data('fromid');

		  

		    $('.chat-contact-list-item').removeClass('active');
		    $(this).addClass('active');
		    if(isblock == 1){
			    $('.mf-field').hide();
			}else{
				$('.mf-field').show();
			}
		    $('.booking_id').html(`
						<div class="usr-ms-img usr-roomid" data-roomid="${ROOM_ID}" data-isblock = "${isblock}" data-isblockuser = "${isblockuser}" data-chat_type="${chat_type}">
							<img src="${user_profile}" alt="">
						</div>
						<div class="usr-mg-info user_name_filed">
							<h3>${usre_name}<span>${user_role}</span></h3>
							<p>${user_online}</p>
						</div>
					`);
				    if (chat_type === 'SINGLE') {
			    		if(isblockuser){
				  			if(isblockuser == SENDER_ID){
				  				$('.sideellipes').html(`<li type="button" class="userunblock">Unblock</li>
											<li type="button" class="deletechat">Clear Chat</li><li type="button" class="deletemychat">Delete Chat</li>`);
				  			}else{
				  				$('.sideellipes').html(`<li type="button" class="">Blocked</li>
											<li type="button" class="deletechat">Clear Chat</li><li type="button" class="deletemychat">Delete Chat</li>`);
				  			}
				  		}else{
				  			$('.sideellipes').html(`<li type="button" class="userblock">Block</li>
											<li type="button" class="deletechat">Clear Chat</li><li type="button" class="deletemychat">Delete Chat</li>`);
				  		}
				  	}else{
				  		if(fromid == SENDER_ID){
				  			$('.sideellipes').html(`<li type="button" class="deletechat">Clear Chat</li><li type="button" class="deletegroup">Delete Group</li>`);
				  		}else{
				  			$('.sideellipes').html(`<li type="button" class="deletechat">Clear Chat</li><li type="button" class="leavenow">Leave Now</li>`);
				  		}
				  	}
					if (chat_type === 'GROUP') {
						//if(fromid == SENDER_ID){
						    $('.booking_id').addClass('clickable');

						    $('.booking_id').off('click').on('click', function() {
						        $.ajax({
						            url: '{{route("customer.groupdetail")}}', // replace with your actual URL
						            method: 'GET',
						            data: { roomId: ROOM_ID },
						            success: function(data) {
						                var group = data.group;
						                var members = data.members;
						                var allUsers = data.allUsers;


						                $('#editgroupModal .avatar-preview div').css({
						                    'background-image': `url(${group.group_image})`,
						                    'background-size': 'cover',
						                    'background-position': 'center'
						                });
						                $('#editgroupModal #groupName').val(group.group_name);
						                
						                $('#editgroupModal #roomId').val(group.id);
						                const BASE_URL = `${window.location.origin}/circlequay/`;
						                allUsers.sort((a, b) => {
							                var aIsSelected = members.some(member => member.user_id === a.id);
							                var bIsSelected = members.some(member => member.user_id === b.id);
							                return bIsSelected - aIsSelected;
							            });
						                var membersHtml = '';
						                if(fromid == SENDER_ID){
							                allUsers.forEach(function(user) {
							                var isSelected = members.some(member => member.user_id === user.id);
							                   console.log('User ID:', user.id, 'Is Selected:', isSelected);
							                    membersHtml += `
							                        <div class="suggestion-usd">
							                            <div class="d-flex align-items-center w-100">
							                                <img src="${user.profile ? BASE_URL + user.profile : '{{asset("frontend/bussiness/images/user_male_icon.png")}}'}" alt="">
							                                <div class="sgt-text w-100">
							                                    <h4>${user.first_name}</h4>
							                                    <span>${user.username}</span>
							                                </div>
							                                <input type="checkbox" name="editselectedUsers[]" value="${user.id}" class="check-lst" ${isSelected ? 'checked' : ''}>
							                            </div>
							                        </div>
							                    `;
							                });
							            }else{
							            	members.forEach(function(user) {
							                    membersHtml += `
							                        <div class="suggestion-usd">
							                            <div class="d-flex align-items-center w-100">
							                                <img src="${user.userdata.profile ? BASE_URL + user.userdata.profile : '{{asset("frontend/bussiness/images/user_male_icon.png")}}'}" alt="">
							                                <div class="sgt-text w-100">
							                                    <h4>${user.userdata.first_name}</h4>
							                                    <span>${user.userdata.username}</span>
							                                </div>
							                                
							                            </div>
							                        </div>
							                    `;
							                });
							            }
						                

						                
						                if(fromid == SENDER_ID){
						                	$('#editgroupModal').modal('show');
						                	$('#editsearchResultsContainer').html(membersHtml);
						                }else{
						                	$('#editgroupModal1').modal('show');
						                	$('#editsearchResultsContainer1').html(membersHtml);
						                }
						            }
						        });
						    });
						//}
					} else {
					    $('.booking_id').removeClass('clickable');
					    $('.booking_id').off('click');
					}


		    socket.emit("READ_MESSAGE", {'senderId':SENDER_ID,'roomId':ROOM_ID,'messageId':0,'type':'all'});
		    socket.on('READ_MESSAGE_RESPONSE', (res) => {
		    });

		    $('#chat-details').html('');
		    mesageList = '';
		    socket.emit("CHAT_LIST", {'senderId':SENDER_ID,'roomId':ROOM_ID,'page':page=1});
		  });

		  $(document).on('click','.loadmore',function(){
		    page = page+1;
		    socket.emit("CHAT_LIST", {'senderId':SENDER_ID,'roomId':ROOM_ID,'page':page});
		});

		socket.on('CHAT_LIST_RESPONSE', (res) => {
	    let result = JSON.parse(res);
	    $('.message-bar-head').show();
        	//$('.mf-field').show();
	    chat_type = $('.usr-roomid').attr('data-chat_type');

	    console.log(result,'chat list');
	        if(result.status==true)
	        {
	        if(result.data.last_page != page)
	        {
	          var html5 = '<div class="loadmore text-center">View more</div><br/>'; 
	        }
	        else{
	          var html5 = '';
	        }
	        const arr = result.data.data;
	        var html4 = '';
	        $('.messqage-type-section').show();
	        arr.sort((a, b) => a.id - b.id);
	        arr.map(function(data){
	            console.log(data);
	            var html1 = '';
	            var html2 = '';
	            var html0 = '';
	          
	            var message = data.message;
	            var file = '';
	            var downloadIcon = '';
	              if(data.file_type=='IMAGE')
	              {
	                file = `<img src="${data.file}" width="100"><br/>`;
	              }
	              else if(data.file_type=='Video')
	              {
	                file = `<video width="100px" controls><source src="${data.file}" type="video/mp4"></video><br/>`;
	              }
	              else if(data.file_type=='PDF')
	              {
	                file = `<iframe src="${data.file}" width="100" height="100"></iframe><br/>`;
	              }
	              
	              if(setDate != dateFormate(data.created_at))
	              {
	                console.log(data.date);
	                setDate = dateFormate(data.created_at);
	                html0 = `<div class="col-12 text-center"><div class="btn btn-success  btn-sm" style="padding: 4px !important; font-size: 10px;">${dateFormate(data.created_at)}</div></div>`;
	              }
	              else{
	                html0 = '';
	              }
	              let localDateTime = UTCtoLocal(data.created_at);

	              if (data.file_type != 'TEXT') {
	            	downloadIcon = `<a href="${data.file}" download class="hideimgmodal"><img src="{{asset('frontend/bussiness/images/download-1.svg')}}" alt="Download" class="download-msg-iocn"></a>`;
	            	}
	           if(chat_type == 'SINGLE'){
            		if(parseInt(data.from_id)==parseInt(SENDER_ID))
	            	{
	            
		            html1 =  `<div class="main-message-box ta-right" data-msgid="${data.id}">
						<div class="message-dt grop-chat">
						
								<div class="message-inner-dt">
									
									    <img  id="singledelete" data-msgid="${data.id}" src="{{asset('frontend/bussiness/images/delet00000000452.svg')}}" alt="">
									
									<p class="chat-emoji">${file}${message}</p>
									${downloadIcon}
								</div>
								<span > ${localDateTime}</span> 
							</div>
							<div class="messg-usr-img">
								<img src="${data.sender.profile_image}" alt="">
							</div>
						</div>`;
		            }
		            if(parseInt(data.from_id)!=parseInt(SENDER_ID))
		            {
		                html2= `<div class="main-message-box st3" data-msgid="${data.id}">
							<div class="message-dt grop-chat st3">
							
								<div class="message-inner-dt"> 
									<p class="chat-emoji">${file}${message}</p>
									${downloadIcon}
								</div>
								<span > ${localDateTime}</span>
							</div>
							<div class="messg-usr-img">
								<img src="${data.sender.profile_image}" alt="">
							</div>
						</div>`;


		            }
	        	}else{
	        		if(parseInt(data.from_id)==parseInt(SENDER_ID))
	            	{
	            
		            html1 =  `<div class="main-message-box ta-right" data-msgid="${data.id}">
						<div class="message-dt grop-chat">
						
								<div class="message-inner-dt">
									
									    <img id="singledelete" data-msgid="${data.id}" src="{{asset('frontend/bussiness/images/delet00000000452.svg')}}" alt="">
									
									<p class="chat-emoji">${file}${message}</p>
									${downloadIcon}
								</div>
								<span >You ${localDateTime}</span> 
							</div>
							<div class="messg-usr-img">
								<img src="${data.sender.profile_image}" alt="">
							</div>
						</div>`;
		            }
		            if(parseInt(data.from_id)!=parseInt(SENDER_ID))
		            {
		                html2= `<div class="main-message-box st3" data-msgid="${data.id}">
							<div class="message-dt grop-chat st3">
							
								<div class="message-inner-dt"> 
									<p class="chat-emoji">${file}${message}</p>
									${downloadIcon}
								</div>
								<span >${data.sender.name} ${localDateTime}</span>
							</div>
							<div class="messg-usr-img">
								<img src="${data.sender.profile_image}" alt="">
							</div>
						</div>`;


		            }
	        	}	

	                      html4 = html4+html0+html1+html2;
	          });
	          
	          mesageList = html4+mesageList;
	    
	          $('#chat-details').html(html5+mesageList);
	          if(page==1)
	          {
	            // $(".chat-history-body").animate({ scrollTop: $('.chat-history-body').prop("scrollHeight")}, 1000);
	            $("#chat-details").animate({ scrollTop: $('#chat-details').prop("scrollHeight") }, 1000);
	          }

	        }
	        else
	        {
	        let html =`<li class="chat-contact-list-item chat-list-item-0">
	                        <h6 class="text-muted mb-0">${result.message}</h6>
	                      </li>`;
	        }
	  });
	
	
	$(document).on('click','.deletemychat',function(){
		$('#myModal10').modal('show');
		
    });
    $(document).on('click', '#confirmDeletemychat', function() {
	    $('#myModal10').modal('hide');
	    ROOM_ID = $('.usr-roomid').attr('data-roomid');
        $.ajax({
            url: '{{route("customer.deletemychat")}}',
            method: 'post',
            data:{
	            roomId:ROOM_ID,
	            _token:'{{ csrf_token() }}'
	        },
           
            success: function(data) {
                window.location.reload();
            }
        });
	});

	$(document).on('change','#attach-doc',function(){
        var form = new FormData();
        form.append("attachment",$(this)[0].files[0]);

        var settings = {
            "url": "{{url('api/fileUpload')}}",
            "method": "POST",
            "timeout": 0,
            "headers": {
            },
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form
        };

        $.ajax(settings).done(function (response) {
            var data = JSON.parse(response);
            console.log(data);
            if(data.success==true)
            {
                $('.message_file').val(data.data.image);
                $('.file_type').val(data.data.type);

                $('#image-preview').show();
                var imageUrl = "{{ asset('/') }}" + data.data.image;
                console.log(imageUrl,'asdfdfdfd');
               	if(data.data.type == 'IMAGE'){
                	var imgPreview = '<img src="' + imageUrl + '" alt="Image Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;">';
                }
                if(data.data.type == 'Video'){
                	var imgPreview = '<video width="200px" controls><source src="' + imageUrl + '" alt="Video Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;" type="video/mp4"></video>';
                }
                if(data.data.type == 'PDF'){
                	var imgPreview = '<iframe src="' + imageUrl + '" alt="Pdf Preview" style="max-width: 200px; max-height: 200px; margin-top: 10px;"></iframe>';
                }
                $('#image-preview').html(imgPreview);
	            
            }else{
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