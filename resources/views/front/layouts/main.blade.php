{{-- @include('front/layouts/header') --}}
@include('front/layouts/loginHeader')


@yield('content')

<!-------------------------------- Script Links ------------------------------------>
<script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
    integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- //------------below script creating problem in form validtion------------------// --}}
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="{{ asset('front/auth/assets/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('front/auth/assets/js/custom-validation.js') }}"></script>

<script src="{{ asset('front/auth/assets/datepicker/jquery-ui.min.js') }}"></script>
<script src="{{ asset('front/home/assets/js/main.js') }}"></script>

@include('front/layouts/footer')


<script>
    function alertMessage(type, message) {
        Swal.fire({
            toast: true,
            title: message,
            icon: type,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    }

    $(document).ready(function() {
        // Default rating
        let selectedRating = 1;

        // Handle star click
        $('.rate i').on('click', function() {
            selectedRating = $(this).data('review');
            $(this).addClass('active').prevAll().addClass('active');
            $(this).nextAll().removeClass('active');
        });

        $('#submitReview').on('click', function() {
            // Clear previous errors
            $('.text-danger').remove();

            let productId = $('.rate').data('product-id');
            let message = $('#contactMessage').val().trim();
            let image = $('#reviewImage')[0].files[0];

            let valid = true;

            // Validate rating
            if (!selectedRating || selectedRating < 1 || selectedRating > 5) {
                $('<div class="text-danger mt-1" style="font-size:11px;">Please select a rating.</div>')
                    .insertAfter('.rate');
                valid = false;
            }

            // Validate message
            if (!message || message.length < 5) {
                $('<div class="text-danger mt-1" style="font-size:11px;">Please enter at least 5 characters in your message.</div>')
                    .insertAfter('#contactMessage');
                valid = false;
            }

            // Validate image (if provided)
            if (image) {
                const validTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'];
                if (!validTypes.includes(image.type)) {
                    $('<div class="text-danger mt-1" style="font-size:11px;">Only JPG, PNG, WEBP, or SVG images are allowed.</div>')
                        .insertAfter('#reviewImage');
                    valid = false;
                }
            }

            if (!valid) return; // Stop submission if invalid

            // Prepare form data
            let formData = new FormData();
            formData.append('product_owner_id', productId);
            formData.append('rating', selectedRating);
            formData.append('message', message);
            if (image) {
                formData.append('image', image);
            }
            formData.append('_token', '{{ csrf_token() }}');

            // Submit via AJAX
            $.ajax({
                url: '{{ route('product.rate') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('review response: ', response);

                    if (response.success) {
                        $('#WriteReview').hide();
                        Swal.fire({
                            toast: true,
                            title: response.message,
                            icon: 'success',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal
                                    .stopTimer);
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer);
                            }
                        }).then(() => {
                            $('#exampleModal').modal('hide');
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            toast: true,
                            title: response.message,
                            icon: 'error',
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal
                                    .stopTimer);
                                toast.addEventListener('mouseleave', Swal
                                    .resumeTimer);
                            }
                        });
                    }
                },
                error: function(xhr) {
                    let message = 'An error occurred';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        toast: true,
                        title: message,
                        icon: 'error',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal
                            .stopTimer);
                            toast.addEventListener('mouseleave', Swal
                                .resumeTimer);
                        }
                    });
                }
            });
        });
    });


    function showLoginModal(message) {
        Swal.fire({
            title: "EliteQuine",
            text: message,
            imageUrl: "{{ asset('front/home/assets/images/add-favorite.svg') }}",
            imageWidth: 400,
            imageHeight: 200,
            imageAlt: "EliteQuine",
            // This disables the default Swal styling for confirm button
            customClass: {
                confirmButton: ''
            },
            buttonsStyling: false, // <--- disables SweetAlert's built-in styling
            confirmButtonText: "<a href='{{ route('login') }}' class='commen_btn'>Login</a>"
        });
    }

    // add favorite
    $('.favorite-btn').on('click', function(e) {
        e.preventDefault();

        let productId = $(this).data('product-id');
        let url = `{{ url('favorite') }}` + '/' + productId;
        let $btn = $(this);

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // alert(response.message);
                if (response.favorited) {
                    $btn.addClass('favorited');
                    $btn.find("i").addClass('fa-solid').removeClass('fa-regular favorited');
                } else {
                    $btn.removeClass('favorited');
                    $btn.find("i").addClass('fa-regular favorited').removeClass('fa-solid');
                }
            },
            error: function(xhr) {
                if (xhr.status === 401) {
                    Swal.fire({
                        title: "EliteQuine",
                        text: "Please login to add favorite.",
                        imageUrl: "{{ asset('front/home/assets/images/add-favorite.svg') }}",
                        imageWidth: 400,
                        imageHeight: 200,
                        imageAlt: "EliteQuine",
                        // This disables the default Swal styling for confirm button
                        customClass: {
                            confirmButton: ''
                        },
                        buttonsStyling: false, // <--- disables SweetAlert's built-in styling
                        confirmButtonText: "<a href='{{ route('login') }}' class='commen_btn'>Login</a>"
                    });
                } else {
                    alert('Something went wrong.');
                }
            }
        });
    });
</script>


@if ($message = session('success'))
    <script>
        alertMessage('success', '{{ $message }}');
    </script>
@endif
@if ($message = session('error'))
    <script>
        alertMessage('error', '{{ $message }}');
    </script>
@endif
@if ($message = session('warning'))
    <script>
        alertMessage('warning', '{{ $message }}');
    </script>
@endif



@yield('script')

<script>
    $(function() {
        $('.datepicker').datepicker({
            dateFormat: "dd-mm-yy" // <-- Use this format for Y-m-d
        });
    });

    // $('.example_length').change(function() {
    //     $('#PaymentLog').submit();
    // });
</script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            width: '100%',
            tags: "true",
            placeholder: "Select an option",
        });
    });



    $(document).on('click', '.compare-add-button', function(e) {
        var id = $(this).data('id');

        // $('.preloader').show();
        $.ajax({
            url: '{{ url('compare') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                status: 'add'
            },
            success: function(response) {
                $('.preloader').hide();
                $('#compare-list').html(response.html);
                $("#compareModal").modal('show');
            }
        });
    });

    $(document).on('click', '.compare-remove-button', function(e) {
        var id = $(this).data('id');

        // $('.preloader').show();
        $.ajax({
            url: '{{ url('compare') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                status: 'remove'
            },
            success: function(response) {
                $('.preloader').hide();
                $('#compare-list').html(response.html); // Inject rendered HTML
                $("#compareModal").modal('show');
                if (response.total == 0) {
                    $("#compareModal").modal('hide');
                }
            }
        });
    });

    $(document).on('click', '.compare-remove-all', function(e) {
        var id = $(this).data('id');

        // $('.preloader').show();
        $.ajax({
            url: '{{ url('compare') }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                status: 'all'
            },
            success: function(response) {
                $('.preloader').hide();
                $('#compare-list').html(response.html); // Inject rendered HTML
                $("#compareModal").modal('show');
                if (response.total == 0) {
                    $("#compareModal").modal('hide');
                }
            }
        });
    });
</script>


<!-- Compare popip -->
<div class="modal fade" id="compareModal" aria-hidden="true" aria-labelledby="Compare" tabindex="-1"
    style="overflow-x: auto;">
    <div class="modal-dialog modal-xl modal-dialog-centered compare-table">
        <div class="modal-content text-center">
            <div class="modal-body p-4" style="overflow-x: auto;">

                {{-- <div class="d-flex" >
                    <div class="compare-labels compare-box"
                        style="min-width: 200px; background: #f8f9fa; font-family: Arial, sans-serif;">
                        <div class="compare-heading">
                            <h3>Compare</h3>
                            <button class="btn-theme-bg compare-remove-all" data-id="1">Clear</button>
                        </div>
                        
                        <div class="compare-row">Subcategory</div>
                        <div class="compare-row">Discipline</div>
                        <div class="compare-row">Year Born</div>
                        <div class="compare-row">Height in hands</div>
                        <div class="compare-row">Sex</div>
                        <div class="compare-row">Breed</div>
                        <div class="compare-row">Colors</div>
                        <div class="compare-row">Training & Show Experience</div>
                        <div class="compare-row">Green Eligibility</div>
                        <div class="compare-row">Qualified For</div>
                        <div class="compare-row">Current Fence Height</div>
                        <div class="compare-row">Potential Fence Height</div>
                        <div class="compare-row">Can Be Tried at Upcoming Show</div>
                        <div class="compare-row">Trial Dates Available From</div>
                        <div class="compare-row">Trial Dates To</div>
                        <div class="compare-row">Sale Price Range</div>
                        <div class="compare-row">Lease Price Range</div>
                        <div class="compare-row">Trainer</div>
                        <div class="compare-row">Facility</div>
                        <div class="compare-row">Sire Bloodlines</div>
                        <div class="compare-row">Dam Bloodlines</div>
                        <div class="compare-row">USEF #	</div>
                        <div class="compare-row">Price</div>
                    </div> --}}

                <div id="compare-list" class="d-flex">
                    {{-- Hourse compare cards will be injected here --}}
                </div>

                {{-- </div> --}}
            </div>
        </div>
    </div>
</div>

 <style>
        .ad-lister-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 12px;
            cursor: pointer;
        }

        .ad-lister-checkbox .form-check-input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            border: 1px solid #000;
        }

        .ad-lister-checkbox span {
            font-size: 18px;
            line-height: 1;
        }

        .toggle-list {
            display: none;
            margin-left: 0;
            margin-bottom: 0;
        }

        .toggle-list ul {

            padding-left: 0;
            list-style: none;
            margin: 10px 0 !important;
        }

        .toggle-list ul li {
            list-style-type: decimal;
            margin-bottom: 4px;
            font-size: 15px;
            color: #000;
        }

        .toggle-list ul li {
            list-style: none;
            margin-bottom: 4px;
        }

        .show {
            display: block;
        }

        .form-check-input:checked[type="checkbox"] {
            --form-check-bg-image: linear-gradient(195deg, #b2a179 0%, #b2a179 100%);
        }

        .lister-checkbox-box {
            display: flex;
            justify-content: space-around;
            padding: 20px 0px;
        }
    </style>

<div class="modal fade" id="notificationModalnextLevel" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 p-3">
            <div class="modal-header border-0">
                <h5 class="modal-title">Are you an Ad Lister or Ad Viewer?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body p-0 notificationModalnextLevelHtml">


            </div>


            <div class="modal-footer border-0 justify-content-end">
                <button type="submit" class="btn btn-primary btn-save testerer">Save</button>
                {{-- <button type="button" class="btn btn-save " data-bs-dismiss="modal">Close</button> --}}
            </div>


        </div>
    </div>
</div>


      <div class="modal fade" id="notificationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 p-3">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Select Your Notifications Settings</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
<form action="{{ route("updateNotificationData") }}" method="post" >
@csrf
                <div class="modal-body notificationModalnextLevelHtmlInner">
                
                </div>

                <div class="modal-footer border-0 justify-content-end">
                    <button type="submit" class="btn btn-save" 
                        aria-label="Close">Save</button>
                </div>
            </form>
            </div>
        </div>
    </div>
<script>
    $('body').on('click', '.go-to-notify-on', function() {
        

        $.ajax({
            url: '{{ route('notificationModalnextLevel') }}',
            type: 'get',
            dataType: "json",
            data: {
                "categories": 'categories',
            },
            beforeSend: function() {},
            success: (response) => {
                     $('#notificationModalnextLevel').modal('show')
                     $('.notificationModalnextLevelHtml').html(response.html)


            },
        })

    })

     $('body').on('click', '.testerer', function() {
        if($('.check_series:checked').length == '0'){
                     $('.notificationModalnextLevelHtmlInner').html('')
    return false;
}
    

          var check_series=[];
            $('.check_series:checked').each(function(){
              check_series.push($(this).val())
            })

        $.ajax({
            url: '{{ route('check_seriesCheck') }}',
            type: 'get',
            dataType: "json",
            data: {
                "check_series": check_series.join(','),
            },
            beforeSend: function() {},
            success: (response) => {
                     $('#notificationModalnextLevel').modal('hide')
                     $('#notificationModal').modal('show')

           $('.notificationModalnextLevelHtmlInner').html(response.contents)
            },
        })

    })

    
</script>
</body>

</html>
