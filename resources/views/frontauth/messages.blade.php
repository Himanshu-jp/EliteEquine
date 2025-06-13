@extends('frontauth.layouts.main')
@section('title')
Your Ads
@endsection
@section('content')


<div class="container-fluid mt-4">
    <div class="chat-container">
        <div class="sidebar">
            <div class="top-filter">
                <div class="ms-md-auto d-flex align-items-center top-search">
                    <input type="text" class="form-control mb-0" placeholder="Filter by advert / user...">
                    <img src="{{asset('front/auth/assets/img/icons/search-icon.svg')}}">
                </div>
                <div class="form-check my-2">
                    <input class="form-check-input" type="checkbox" id="select_messages" checked="">
                    <label class="form-check-label text-dark" for="select_messages">Select all</label>
                </div>
            </div>
            <div class="users">
                <div class="user">
                    <img src="{{asset('front/auth/assets/img/team-1.jpg')}}" />
                    <div>
                        <div class="user-name">Emily</div>
                        <div class="last-seen">February 15, 2025</div>
                        <div class="text-muted">Hi - are you interested in this horse?</div>
                    </div>
                </div>
                <hr class="horizontal dark my-1">
                <div class="user active" onclick="openChatBox(this)">
                    <img src="{{asset('front/auth/assets/img/team-2.jpg')}}" />
                    <div>
                        <div class="user-name">Liam</div>
                        <div class="last-seen">January 27, 2025</div>
                        <div class="text-muted">Hi - are you interested in this horse?</div>
                    </div>
                </div>
                <hr class="horizontal dark my-1">
                <div class="user">
                    <img src="{{asset('front/auth/assets/img/team-3.jpg')}}" />
                    <div>
                        <div class="user-name">Meera</div>
                        <div class="last-seen">January 11, 2025</div>
                        <div class="text-muted">Hi - are you interested in this horse?</div>
                    </div>
                </div>
                <hr class="horizontal dark my-1">
                <div class="user">
                    <img src="{{asset('front/auth/assets/img/team-4.jpg')}}" />
                    <div>
                        <div class="user-name">Sophia</div>
                        <div class="last-seen">January 10, 2025</div>
                        <div class="text-muted">Hi - are you interested in this horse?</div>
                    </div>
                </div>
                <hr class="horizontal dark my-1">
                <div class="user">
                    <img src="{{asset('front/auth/assets/img/team-5.jpg')}}" />
                    <div>
                        <div class="user-name">Max</div>
                        <div class="last-seen">January 10, 2025</div>
                        <div class="text-muted">Hi - are you interested in this horse?</div>
                    </div>
                </div>
                <hr class="horizontal dark my-1">
                <div class="user">
                    <img src="{{asset('front/auth/assets/img/team-5.jpg')}}" />
                    <div>
                        <div class="user-name">Max</div>
                        <div class="last-seen">January 10, 2025</div>
                        <div class="text-muted">Hi - are you interested in this horse?</div>
                    </div>
                </div>
                <hr class="horizontal dark my-1">
                <div class="user">
                    <img src="{{asset('front/auth/assets/img/team-5.jpg')}}" />
                    <div>
                        <div class="user-name">Max</div>
                        <div class="last-seen">January 10, 2025</div>
                        <div class="text-muted">Hi - are you interested in this horse?</div>
                    </div>
                </div>
                <hr class="horizontal dark my-1">
                <div class="user">
                    <img src="{{asset('front/auth/assets/img/team-5.jpg')}}" />
                    <div>
                        <div class="user-name">Max</div>
                        <div class="last-seen">January 10, 2025</div>
                        <div class="text-muted">Hi - are you interested in this horse?</div>
                    </div>
                </div>
                <hr class="horizontal dark my-1">
                <!-- Add more users as needed -->
                <div class="bottom-filter">
                    <a href="#" class="delete-btn"><img src="{{asset('front/auth/assets/img/icons/delete.svg')}}" alt=""> Delete Selected</a>
                </div>

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


                <h5 class="mb-0">Ty | 9yo 17h Westfalian Gelding | Hunter, Equitation Horse For Sale</h5>
                <a href="#" class="btn btn-primary"><img src="{{asset('front/auth/assets/img/icons/star.svg')}}" alt=""> Leave A Review</a>
            </div>
            <div class="messages">
                <div class="chat-bubble">
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
                </div>
            </div>
            <div class="message-input">
                <input type="text" placeholder="Type a message here...">
                <button>➤</button>
            </div>

        </div>
    </div>
</div>
@endsection

@section('script')

@endsection