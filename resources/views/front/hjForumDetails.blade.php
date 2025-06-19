@extends('front.layouts.main')
@section('title')
HJ Forum Details
@endsection
@section('content')


<section class="single-banner">
    <img src="{{asset('front/home/assets/images/hj-forum-bg.jpg')}}" class="banner-bg w-100" alt="">
    {{-- <img src="{{asset('storage/'.$forum->image)}}" class="banner-bg w-100" alt=""> --}}
    <div class="container">
        <div class="banner-container">
            <h1 class="text-light">H/J Forum Details</h1>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        {{-- <div class="col-lg-5 mx-auto">
            <div class="top-form">
                <div class="search-box w-100 d-flex position-relative">
                    <input type="text" placeholder="Search for" class="form-control" />
                    <img class="icon-input" src="{{asset('front/home/assets/images/search-icon.svg')}}">
                    <div class="position-absolute top-0 end-0">
                        <button class="search-btn w-100 h-100">Search</button>
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="info-desc">
            <h3 class="horse-info-heading">{{@$forum->title}}</h3>
            <p class="text-secondary">{{@$forum->description}}</p>

            <div class="info-desc-footer">
                <ul class="d-flex gap-3 justify-content-start">
                    <li><span> <img src="{{asset('front/home/assets/images/icons/user.png')}}" width="20" alt="" /></span> &nbsp;{{@$forum->user->name}}</li>
                    <li><span> <img src="{{asset('front/home/assets/images/calendar-icon.svg')}}" alt="" /></span>  {{@$forum->created_at->format('d M Y h:m a')}}
                    </li>
                </ul>
            </div>
        </div>


        <!------------Comments add / view section---------->
        <div class="comment-section">                        
            <!-- Comment Form -->
            @if(auth()->check()) 
                <div class="comment-form">
                    <h4 class="comment-form-title">Write a Comment</h4>
                    <form action="{{route('forumComment')}}" method="post" id="forum-comment-form">   
                        @csrf                
                        <input type="hidden" name="forum_id" value="{{$forum->id}}">
                        <div>
                            <textarea class="comment-textarea form-control mb-2" rows="6" name="comment" id="comment" placeholder="Write your comment here...">{{old('comment')}}</textarea>    
                            @if($errors->has('comment'))
                                <span class="error text-danger">{{$errors->first('comment')}}</span>
                            @endif  
                        </div>                                    
                        <button type="submit" class="comment-submit-btn" id="forum-comment-form-submit">Post Comment</button>
                    </form>
                </div>
            @else
                <div class="comment-form">
                    <h4 class="comment-form-title">Write a Comment</h4>
                    <form action="{{route('forumComment')}}" method="post" id="forum-comment-form-guest">   
                        @csrf                
                        <input type="hidden" name="forum_id" value="{{$forum->id}}">
                        <div>
                            <textarea class="comment-textarea form-control mb-2" rows="6" name="comment" id="comment" placeholder="Write your comment here...">{{old('comment')}}</textarea>    
                            @if($errors->has('comment'))
                                <span class="error text-danger">{{$errors->first('comment')}}</span>
                            @endif  
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mt-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="name" class="inner-form form-control mb-0" placeholder="Enter your name" name="name" id="name" value="{{old('name', @$guest['name'] ?? '')}}"  autocomplete="off">                                            
                            </div>

                            <div class="col-md-4 mt-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="inner-form form-control mb-0" placeholder="Enter email address" name="email" id="email" value="{{old('email', @$guest['email'] ?? '')}}" autocomplete="off">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="website" class="inner-form form-control mb-0" placeholder="Enter your website address" name="website" id="website" value="{{old('website', @$guest['website'] ?? '')}}" autocomplete="off">                                            
                            </div>
                        </div>
                        
                        <button type="submit" class="comment-submit-btn" id="forum-comment-form-submit">Post Comment</button>
                    </form>
                </div>
            @endif

            

            <!-- Comment Item -->
            <hr/>
            <h3 class="comment-section-title">Comments</h3>

            <!-- Comment list -->
            <div id="data-wrapper"></div>
            <span id="noComments">No comments have been posted for this forum.</span>
            
            <div class="col-lg-12 mx-auto mt-4">
                <nav aria-label="Page navigation example" style="display: none;" id="commentPagination">
                    <div class="Page navigation example">
                        <ul class="pagination d-flex justify-content-center align-items-center">
                            <li>
                                <span class="loadMorePreviousButton" onclick="previousLoadMore();"><< Previous</span>&nbsp;&nbsp;&nbsp;&nbsp;
                            </li>
                            <li>
                                    <span class="loadMoreNextButton" onclick="nextLoadMore();">Next >></span>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</section>


<!----------------Edit comment box------------->
<!-- Edit Comment Modal -->
<div class="modal fade" id="editCommentModal" tabindex="-1" aria-labelledby="editCommentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="edit-comment-form">
      @csrf
      <input type="hidden" name="comment_id" id="edit-comment-id">
      <input type="hidden" name="forum_id" id="edit-forum-id">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCommentModalLabel">Edit Comment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <textarea name="comment" class="form-control" id="edit-comment-text" rows="5" placeholder="Edit your comment..."></textarea>
          <span class="text-danger error" id="edit-comment-error"></span>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="edit-comment-submit">Update Comment</button>
        </div>
      </div>
    </form>
  </div>
</div>



<!----------------Edit comment box-------------->

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
        integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

 <script>
   
    $(document).ready(function () {
        $("#forum-comment-form").validate({
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
                $('#forum-comment-form-submit').prop('disabled', true).text('Please wait...');
                let formData = $(form).serialize();

                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#forum-comment-form-submit')
                            .prop('disabled', false)
                            .text('Post Comment');

                        if (response.status) {
                            // Optionally reset form and append comment
                            $(form)[0].reset();
                            addforumComment(page);
                            $("#noComments").hide();
                            $("#data-wrapper").show();

                        } else {
                            alert(response.message || 'Something went wrong');
                        }
                    },
                    error: function (xhr) {
                        $('#forum-comment-form-submit').prop('disabled', false).text('Post Comment');

                        // Show error message
                        alert('Submission failed. Please try again.');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
       
       //-----for guest user comment form validation----//
        $("#forum-comment-form-guest").validate({
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
                email: {
                    required: "Please enter your email address",
                    email: "The email should be in the format: john@domain.tld",
                    maxlength: "Email must not exceed 255 characters"
                },
                website: {
                    required: "Please enter your web address",
                    maxlength: "Website must not exceed 255 characters"
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
                $('#forum-comment-form-submit').prop('disabled', true).text('Please wait...');
                let formData = $(form).serialize();

                $.ajax({
                    url: $(form).attr('action'),
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        $('#forum-comment-form-submit')
                            .prop('disabled', false)
                            .text('Post Comment');

                        if (response.status) {
                            // Optionally reset form and append comment
                            $(form)[0].reset();
                            addforumComment(page);
                            $("#noComments").hide();
                            $("#data-wrapper").show();

                            //----guest user-----//
                            $("#name").val(response.guest['name']);
                            $("#email").val(response.guest['email']);
                            $("#website").val(response.guest['website']);

                        } else {
                            alert(response.message || 'Something went wrong');
                        }
                    },
                    error: function (xhr) {
                        $('#forum-comment-form-submit').prop('disabled', false).text('Post Comment');

                        // Show error message
                        alert('Submission failed. Please try again.');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });

</script>

<script>

    var page = 1;
    infinteLoadMore(page);

    function nextLoadMore(){       
        document.getElementById("forum-comment-form-submit").scrollIntoView({ behavior: 'smooth' });
        page++;
        infinteLoadMore(page,'');
    }
    function previousLoadMore(){  
        document.getElementById("forum-comment-form-submit").scrollIntoView({ behavior: 'smooth' });     
        page--;
        infinteLoadMore(page,'');
    }

    function addforumComment(page)
    {
        infinteLoadMore(page,'add');
    }
    
    
    function infinteLoadMore(page,status) {
        $('.preloader').show();
        if(page==1){
            $('.loadMorePreviousButton').hide();
        }else{
            $('.loadMorePreviousButton').show();
        }
        $.ajax({
                url: '{{ url("forumCommentListing",$forum->id) }}'+ "?page=" + page,
                datatype: "html",
                type: "get",
            })
            .done(function (response) {
                 $('.preloader').hide();

                 if(response.total>0){
                    $("#noComments").hide();
                }
                if(response.totalPages>0 && response.total>10){    
                    $('#commentPagination').show();
                    
                    if (response.html == '' || response.totalPages==page) {
                        $("#data-wrapper").html(response.html);
                        $('.preloader').hide();
                        $('.loadMoreNextButton').hide();
                        $('.loadMorePreviousButton').show();
                        $('#data-wrapper').append("We don't have more data to display.");
                        return;
                    }else{
                        $('.loadMoreNextButton').show();
                    }
                }
                $('.preloader').hide();
                if(status=="add"){
                    $("#data-wrapper").html(response.html);
                }else{
                    $("#data-wrapper").html(response.html);
                }

                

            })
            .fail(function (jqXHR, ajaxOptions, thrownError) {
                $('.preloader').hide();
                console.log('Server error occured');
            });
    }


    function deleteComment(id){
        var href = $(this).data('href');
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

                    $.ajax({
                    url: `{{url('forumCommentDelete')}}`  + '/' + id,
                    method: 'GET',
                    data: {},
                    success: function (response) {
                        if (response.status) {
                            Swal.fire("EliteQuine", "Comment removed successfully.", "success");
                            addforumComment(page);
                        } else {
                            Swal.fire("EliteQuine", response.message, "error");
                        }
                    },
                    error: function (xhr) {
                        Swal.fire("EliteQuine", "Submission failed. Please try again.", "error");
                        console.error(xhr.responseText);
                    }
                });

            }
        })
    }

     // Submit AJAX for updating comment
    $('#edit-comment-form').on('submit', function (e) {
        e.preventDefault();
        $('#edit-comment-submit').prop('disabled', true).text('Updating...');

        $.ajax({
            url: "{{ route('forumComment.update') }}", // Define this route in Laravel
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                if (response.status) {
                    $('#editCommentModal').modal('hide');
                    addforumCommentReply(page)
                } else {
                    $('#edit-comment-error').text(response.message || 'Something went wrong.');
                }
            },
            error: function (xhr) {
                const errors = xhr.responseJSON.errors;
                if (errors && errors.comment) {
                    $('#edit-comment-error').text(errors.comment[0]);
                }
            },
            complete: function () {
                $('#edit-comment-submit').prop('disabled', false).text('Update Comment');
            }
        });
    });


</script>

@endsection