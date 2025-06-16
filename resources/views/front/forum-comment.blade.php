@foreach($data as $key=>$comment)
    <div class="comment-item">
        <div class="comment-header">
            @if(@$comment->user!= null)
                {{-- Display user avatar and name if user is authenticated --}}
                <div class="comment-avatar">
                    <img src="{{(@$comment->user->profile_photo_path)?asset('storage/'.@$comment->user->profile_photo_path):asset('front/auth/assets/img/user-img.png')}}"  width="50" height="50" style="border-radius: 18px;">
                </div>
                <div class="comment-meta">
                    <span class="comment-author">{{$comment->user->name}}</span>
                    <span class="comment-time">{{$comment->created_at->diffForHumans();}}</span>
                </div>
                
               
                @if(auth()->check() && auth()->user()->id==$comment->user_id)
                    <div class="edit-comment-btn comment-btn-act" data-id="{{ $comment->id }}" data-forum="{{ $comment->forum_id }}" data-comment="{{ $comment->comment }}">Edit</div> | 
                    <div class="comment-btn-act" onclick="deleteComment({{$comment->id}})">Delete{{$comment->email}}</div>
                @endif        
            @else
                <div class="comment-avatar">
                    <img src="{{asset('front/auth/assets/img/user-img.png')}}"  width="50" height="50" style="border-radius: 18px;">
                </div>
                <div class="comment-meta">
                    <span class="comment-author">{{$comment->name}}</span>
                    <span class="comment-time">{{$comment->created_at->diffForHumans();}}</span>
                </div>

                
                @if(@$guest['email']==$comment->email)
                    <div class="comment-btn-act"
                        data-id="{{ $comment->id }}"
                        data-forum="{{ $comment->forum_id }}"
                        data-comment="{{ $comment->comment }}">Edit</div> | 
                    <div class="comment-btn-act" onclick="deleteComment({{$comment->id}})">Delete</div>
                @endif 

            @endif
        </div>
        <div class="comment-body">
            {{ $comment->comment }}
        </div>

       

        <div class="comment-actions">
            <button class="comment-btn reply-btn">Reply 
                <img src="{{asset('front/home/assets/images/reply.svg')}}" width="20" alt="" />
            </button>
        </div>
        
        <!-- Hidden reply form -->
        <div class="reply-form mt-2" style="display: none;">

            @if(auth()->check()) 
                <form action="{{route('forumComment')}}" method="post" class="forum-comment-reply-form">   
                    @csrf
                    <input type="hidden" name="forum_id" value="{{$forumId}}">
                    <input type="hidden" name="forum_comment_id" value="{{$comment->id}}">
                    <div>
                        <textarea class="form-control mb-2" rows="2" required name="comment" id="comment" placeholder="Write a reply..."></textarea>
                    </div>
                    <button type="submit" class="btn-theme-bg forum-comment-reply-form-submit">Post Reply</button>
                </form>
            @else
                <form action="{{route('forumComment')}}" method="post" class="forum-comment-reply-form-guest">   
                    @csrf
                    <input type="hidden" name="forum_id" value="{{$forumId}}">
                    <input type="hidden" name="forum_comment_id" value="{{$comment->id}}">
                    <div>
                        <textarea class="form-control mb-2" rows="2" required name="comment" id="comment" placeholder="Write a reply..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="name" class="inner-form form-control mb-0" placeholder="Enter your name" name="name" id="name" value="{{old('name',@$guest['name'])}}" autocomplete="off">
                            
                        </div>
                    
                        <div class="col-md-4 mt-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="inner-form form-control mb-0" placeholder="Enter email address" name="email" id="email" value="{{old('email',@$guest['email'])}}" autocomplete="off">
                            
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="website" class="form-label">Website</label>
                            <input type="website" class="inner-form form-control mb-0" placeholder="Enter your website address" name="website" id="website" value="{{old('website',@$guest['website'])}}" autocomplete="off">
                            
                        </div>
                    </div></br>
                   
                    <button type="submit" class="btn-theme-bg forum-comment-reply-form-submit">Post Reply</button>
                </form>
            
            @endif
        </div>

        <!-- Comment reply list --></br>
        @if(@$comment->children && @$comment->children->count()>0)
            @foreach($comment->children as $key=>$child)
                <div class="comment-header ps-5 mb-3">
                    @if(@$child->user!= null)
                        <div class="comment-avatar">
                            <img src="{{(@$child->user->profile_photo_path)?asset('storage/'.@$child->user->profile_photo_path):asset('front/auth/assets/img/user-img.png')}}"  width="50" height="50" style="border-radius: 18px;">
                        </div>
                        <div class="comment-meta">
                            <span class="comment-author">{{$child->user->name}}</span>
                            <span class="comment-time">{{$child->created_at->diffForHumans();}}</span>
                        </div>

                        
                        @if(auth()->check() && auth()->user()->id==$child->user_id)

                            <div class="edit-comment-btn comment-btn-act"
                                    data-id="{{ $child->id }}"
                                    data-forum="{{ $child->forum_id }}"
                                    data-comment="{{ $child->comment }}">Edit</div> | 
                            <div class="comment-btn-act" onclick="deleteComment({{$child->id}})">Delete</div>
                        @endif

                    @else
                        <div class="comment-avatar">
                            <img src="{{asset('front/auth/assets/img/user-img.png')}}"  width="50" height="50" style="border-radius: 18px;">
                        </div>
                        <div class="comment-meta">
                            <span class="comment-author">{{$child->name}}</span>
                            <span class="comment-time">{{$child->created_at->diffForHumans();}}</span>
                        </div>

                        @if(@$guest['email']==$child->email)
                            <div class="edit-comment-btn comment-btn-act"
                                    data-id="{{ $child->id }}"
                                    data-forum="{{ $child->forum_id }}"
                                    data-comment="{{ $child->comment }}">Edit</div> | 
                            <div class="comment-btn-act" onclick="deleteComment({{$child->id}})">Delete</div>
                        @endif

                    @endif
                </div>
                <div class="comment-body">
                    {{ $child->comment }}
                </div>
            @endforeach
        @endif
    </div>
@endforeach
<script>

    
    document.querySelectorAll('.reply-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const commentItem = btn.closest('.comment-item');
            const replyForm = commentItem.querySelector('.reply-form');
            if (replyForm) {
                replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
            }
        });
    });

    $(document).ready(function () {

        let page = `{{$data->currentPage()}}`;
        $('.forum-comment-reply-form').each(function () {
            $(this).validate({
                rules: {
                    comment: {
                        required: true,
                        maxlength: 5000
                    }
                },
                messages: {
                    comment: {
                        required: "Content field is required.",
                        maxlength: "The Content field must not be greater than 5000 characters"
                    }
                },
                errorClass: 'error text-danger',
                errorElement: 'span',

                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                },

                submitHandler: function (form) {
                    let $form = $(form);
                    let $submitBtn = $form.find('.forum-comment-reply-form-submit');

                    $submitBtn.prop('disabled', true).text('Please wait...');

                    let formData = $form.serialize();

                    $.ajax({
                        url: $form.attr('action'),
                        method: 'POST',
                        data: formData,
                        success: function (response) {
                            $submitBtn.prop('disabled', false).text('Post Reply');

                            if (response.status) {
                                $form[0].reset(); // ✅ reset current form
                                addforumCommentReply(page);

                                // Optional: Append new reply comment below this form
                                // You can call a function like:
                                // appendReplyToComment(response.data, $form.closest('.comment-item'));
                                // alert('Reply posted successfully!');
                            } else {
                                alert(response.message || 'Something went wrong');
                            }
                        },
                        error: function (xhr) {
                            $submitBtn.prop('disabled', false).text('Post Reply');
                            alert('Submission failed. Please try again.');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
       
        $('.forum-comment-reply-form-guest').each(function () {
            $(this).validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255
                    },
                    website: {
                        required: false,
                        maxlength: 255,
                        url: true,
                    },
                    comment: {
                        required: true,
                        maxlength: 5000
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your name",
                        maxlength: "Name must not exceed 255 characters"
                    },
                    website: {
                        required: "Please enter your web address",
                        maxlength: "Website must not exceed 255 characters"
                    },                    
                    email: {
                        required: "Please enter your email address",
                        email: "The email should be in the format: john@domain.tld",
                        maxlength: "Email must not exceed 255 characters"
                    },
                    comment: {
                        required: "Content field is required.",
                        maxlength: "The Content field must not be greater than 5000 characters"
                    }
                },
                errorClass: 'error text-danger',
                errorElement: 'span',

                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                },

                submitHandler: function (form) {
                    let $form = $(form);
                    let $submitBtn = $form.find('.forum-comment-reply-form-submit');

                    $submitBtn.prop('disabled', true).text('Please wait...');

                    let formData = $form.serialize();

                    $.ajax({
                        url: $form.attr('action'),
                        method: 'POST',
                        data: formData,
                        success: function (response) {
                            $submitBtn.prop('disabled', false).text('Post Reply');

                            if (response.status) {
                                $form[0].reset(); // ✅ reset current form
                                addforumCommentReply(page);

                                // Optional: Append new reply comment below this form
                                // You can call a function like:
                                // appendReplyToComment(response.data, $form.closest('.comment-item'));
                                // alert('Reply posted successfully!');

                                //----guest user-----//
                                $("#name").val(response.guest['name']);
                                $("#email").val(response.guest['email']);
                                $("#website").val(response.guest['website']);
                                
                            } else {
                                alert(response.message || 'Something went wrong');
                            }
                        },
                        error: function (xhr) {
                            $submitBtn.prop('disabled', false).text('Post Reply');
                            alert('Submission failed. Please try again.');
                            console.error(xhr.responseText);
                        }
                    });
                }
            });
        });
    });

    function addforumCommentReply(page)
    {
        infinteLoadMore(page,'reply');
    }

</script>


<script>
$(document).ready(function () {
    // Fill form and show modal
    $('.edit-comment-btn').on('click', function () {
        const commentId = $(this).data('id');
        const forumId = $(this).data('forum');
        const commentText = $(this).data('comment');

        $('#edit-comment-id').val(commentId);
        $('#edit-forum-id').val(forumId);
        $('#edit-comment-text').val(commentText);
        $('#edit-comment-error').text('');

        $('#editCommentModal').modal('show');
    });

    
});
</script>