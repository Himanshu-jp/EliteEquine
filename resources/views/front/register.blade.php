<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{asset('front/auth/assets/img/logos/logo.svg')}}">
    <title>Elite Equine - Sign Up</title>
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link href="{{asset('front/auth/assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('front/auth/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link id="pagestyle" href="{{asset('front/auth/assets/css/material-dashboard.css?v=3.2.0')}}" rel="stylesheet" />

    <!-- new -->
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/2.6.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href="{{asset('front/auth/assets/css/custom.css')}}">
</head>

<body>

    <section class="login-section d-flex justify-content-center align-items-center">
        <div class="container ">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div class="login-section-form">
                        <a href="{{route('home')}}">
                            <img src="{{asset('front/auth/assets/img/logos/logo.svg')}}" class="logo" alt="logo">
                        </a>
                        <div class="section-form-heading mb-4">
                            <h2>Register</h2>
                        </div>

                        <form action="{{ route('registerPost') }}" method="post" class="row g-3 needs-validation error"
                            id="register-form">
                            @csrf
                            <div class="row form-group">
                                <div class="col-lg-6">
                                    <label for="">Username <span class="text-danger">*</span></label>
                                    <input class="form-control inner-form" name="name" placeholder="Enter Username"
                                        value="{{old('name')}}" type="text" autocomplete="off">
                                    @if($errors->has('name'))
                                    <span class="error text-danger">{{$errors->first('name')}}</span>
                                    @endif
                                </div>

                                <div class="col-lg-6">
                                    <label for="">Email <span class="text-danger">*</span></label>
                                    <input class="form-control inner-form" placeholder="Enter email address"
                                        value="{{old('email')}}" name="email" type="email" autocomplete="off">
                                    @if($errors->has('email'))
                                    <span class="error text-danger">{{$errors->first('email')}}</span>
                                    @endif
                                </div>

                            </div>
                            <div class="row form-group">
                                <div class="col-lg-6 Password-form">
                                    <label for="">Password <span class="text-danger">*</span></label>
                                    <input class="form-control inner-form" placeholder="Enter Password" value=""
                                    type="password" name="password" id="password">
                                    <div class="icon_eye">
                                            <img src="{{asset('front/auth/assets/img/eyeoff.svg')}}" class="toggle-password-input" data-toggle="#password" alt="Toggle Password">
                                    </div>

                                    <span toggle="#password-field" class="bi bi-eye field-icon toggle-password"></span>
                                    @if($errors->has('password'))
                                    <span class="error text-danger">{{$errors->first('password')}}</span>
                                    @endif
                                </div>
                                <div class="col-lg-6 Password-form">
                                    <label for="">Confirm Password <span class="text-danger">*</span></label>
                                    <input class="form-control inner-form" placeholder="Enter Password" value=""
                                    type="password" name="password_confirmation" id="password_confirmation">
                                    <div class="icon_eye">
                                        <img src="{{asset('front/auth/assets/img/eyeoff.svg')}}" class="toggle-password-input" data-toggle="#password_confirmation" alt="Toggle Password">
                                    </div>
                                    <span toggle="#password-field" class="bi bi-eye field-icon toggle-password"></span>
                                </div>
                            </div>

                            <div class="mt-3">
                                <h6>Opt in to notificaitons </h6>
                               <div class="d-flex align-items-center gap-3">
                                <div class="form-check pe-0">
                                    <input class="form-check-input" type="radio" name="opt_in_notification"
                                        id="flexRadioDefault1" onchange="toggleBox(this)" value="yes"
                                        {{ old('opt_in_notification') == 'yes' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault1">Yes</label>
                                </div>

                                <div class="form-check pe-0">
                                    <input class="form-check-input" type="radio" name="opt_in_notification"
                                        id="flexRadioDefault2" onchange="toggleBox(this)" value="no"
                                        {{ old('opt_in_notification') == 'no' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexRadioDefault2">No</label>
                                </div>
                            </div>
                                @if ($errors->has('opt_in_notification'))
                                <div class="alert alert-danger mt-2">
                                    {{ $errors->first('opt_in_notification') }}
                                </div>
                                @endif

                                {{-- @if($errors->has('contact'))
                                    <span class="error text-danger">{{$errors->first('contact')}}</span>
                                @endif --}}

                                <!-- Hidden Box with 3 Checkboxes -->
                                <!-- <div id="hiddenBox" class="mt-3" style="display: none;">                                    
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="sms" value="1"
                                                id="sms" {{ old('sms') == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="sms">SMS</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="mobile" value="1"
                                                id="mobile" {{ old('mobile') == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mobile">Mobile App</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="mail" value="1"
                                                id="mail" {{ old('mail') == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="mail">Email</label>
                                        </div>
                                    </div>
                                    <div id="contact-error" class="text-danger mt-1"></div>
                                    <input type="text" name="contact_group" id="contact_group" style="visibility:hidden;position: absolute;"/>


                                    @if($errors->has('contact'))
                                    <span class="error text-danger">{{$errors->first('contact')}}</span>
                                    @endif
                                </div> -->

                                <div class="modal fade" id="notificationModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 p-3">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title">Select Your Notifications Settings</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>


                                        <div class="modal-body">
                                            <div class="lister-checkbox-box">
                                                <div>

                                                    <label class="ad-lister-checkbox">
                                                        <input class="form-check-input" type="checkbox" id="email1">
                                                        <span>Ad Lister</span>
                                                    </label>
                                                    <div class="toggle-list" id="list-email1">
                                                        <ul>
                                                        <li>Subscription Expiring</li>
                                                        <li>Payment Received</li>
                                                        <li>Direct Message</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            <div>

                                                <label class="ad-lister-checkbox">
                                                    <input class="form-check-input" type="checkbox" id="email2">
                                                    <span>Ad Viewer</span>
                                                </label>
                                                <div class="toggle-list" id="list-email2">
                                                    <ul>
                                                    <li>Listing Matching Saved Search Appears</li>
                                                    <li>Auction Ending on Bidding Item</li>
                                                    <li>Direct Messaging</li>
                                                    </ul>
                                                </div>  
                                            </div>
                                            </div>

                                            <!-- Checkbox 2 -->
                                        </div>

                                        <div class="modal-footer border-0 justify-content-end">
                                            <button type="button" class="btn btn-save" data-bs-dismiss="modal" aria-label="Close">Save</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <button class="btn btn-primary w-100" type="submit" id="register-form-submit">Register</button>
                        </form>
                        <h6 class="text-center">Already have an account, <a href="{{route('login')}}"><ins class="text-gold">Login
                                    here</ins></a>
                        </h6>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="{{asset('front/auth/assets/img/login-site-img.jpg')}}" class="login-img w-100" alt="img-1">
                </div>
            </div>
        </div>
    </section>


<style>
    
</style>
    <!-- <--------------------------------------------// js CDN & files--------------------------------------------->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"
        integrity="sha512-KFHXdr2oObHKI9w4Hv1XPKc898mE4kgYx58oqsc/JqqdLMDI4YjOLzom+EMlW8HFUd0QfjfAvxSL6sEq/a42fQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
    $(document).ready(function() {

        var checkRadio = document.getElementById('flexRadioDefault1').checked;
        if (checkRadio) {
            toggleBox();
        }

        $.validator.addMethod("strongPassword", function(value, element) {
                return this.optional(element) ||
                    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/.test(value);
            },
            "Password must contain at least 1 uppercase letter, 1 lowercase letter, 1 number, and 1 special character."
        );


        $.validator.addMethod("requireOneContact", function(value, element, params) {
            // Only validate if "yes" is selected
            if ($("input[name='opt_in_notification']:checked").val() === "yes") {
                return $("input[name='sms']:checked").length > 0 ||
                    $("input[name='mobile']:checked").length > 0 ||
                    $("input[name='mail']:checked").length > 0;
            }
            return true; // Skip check if opt-in is "no"
        }, "Select at least one method (SMS, Mobile App, or Email)");


        $("#register-form").validate({
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
                password: {
                    required: true,
                    strongPassword: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
                opt_in_notification: {
                    required: true,
                },
                contact_group: {
                    requireOneContact: true
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
                password: {
                    required: "Please enter your password",
                    minlength: "Password must be at least 8 characters"
                },
                password_confirmation: {
                    required: "Please confirm your password",
                    equalTo: "Passwords do not match"
                },
                opt_in_notification: {
                    required: "Option in to notifications is required",
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
            errorPlacement: function(error, element) {
                if (element.attr("name") === "contact_group") {
                    console.log('abc');
                    error.appendTo("#contact-error");
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                $('#register-form-submit').prop('disabled', true).text('Please wait...');
                form.submit();
            }
        });
    });
    </script>

    <script>

    function toggleBox() {
        var yesRadio = document.getElementById('flexRadioDefault1');
        var hiddenBox = document.getElementById('hiddenBox');

        if (yesRadio.checked) {
            hiddenBox.style.display = 'block'; // Show
        } else {
            hiddenBox.style.display = 'none'; // Hide
        }
    }
    </script>


    <div id="hiddenBox" class="mt-3" style="display: none;">

    </div>

 <style>
    .ad-lister-checkbox {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 10px;
      cursor: pointer;
    }

    .ad-lister-checkbox .form-check-input {
      width: 18px;
      height: 18px;
      cursor: pointer;
      border: 1px solid #000;
    }

   .toggle-list {
    display: none;
    margin-left: 0;
    margin-bottom: 0;
}

   .toggle-list ul {
    padding-left: 0; 
    list-style: none;
    margin: 0 !important;
}

    .toggle-list ul li {
        list-style: none;
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
   <script>
    $(document).ready(function () {
      $(".toggle-password-input").click(function () {
        var input = $($(this).attr("data-toggle"));
        var img = $(this);
 
        if (input.attr("type") === "password") {
          input.attr("type", "text");
          img.attr("src", "{{ asset('front/auth/assets/img/aye.svg') }}");
        } else {
          input.attr("type", "password");
          img.attr("src", "{{ asset('front/auth/assets/img/eyeoff.svg') }}");
        }
      });
    });
  </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ✅ Then your custom JS -->
<script>
  function toggleBox(el) {
    if (el.value === "yes") {
      const modalElement = document.getElementById('notificationModal');
      if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
      } else {
        console.error("Modal element not found");
      }
    }
  }
</script>
<script>
    const checkbox1 = document.getElementById("email1");
    const list1 = document.getElementById("list-email1");

    const checkbox2 = document.getElementById("email2");
    const list2 = document.getElementById("list-email2");

    checkbox1.addEventListener("change", () => {
      list1.classList.toggle("show", checkbox1.checked);
    });

    checkbox2.addEventListener("change", () => {
      list2.classList.toggle("show", checkbox2.checked);
    });
  </script>
</body>

</html>