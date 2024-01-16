@extends('backend.layouts.master')
@section('css_after')
    <link rel="stylesheet" href="{{asset('backend/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/js/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/js/plugins/ion-rangeslider/css/ion.rangeSlider.css')}}">
    <link rel="stylesheet" href="{{asset('backend/js/plugins/dropzone/dist/min/dropzone.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/js/plugins/flatpickr/flatpickr.min.css')}}">
    <style >
        .spinner {
            display: none;
        }
    </style>
@endsection
@section('page_action')
    <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-alt">
            <li class="breadcrumb-item"><a class="link-fx" href="{{ url('/') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a class="link-fx" href="{{ url('student/') }}">Student</a></li>
            <li class="breadcrumb-item">Add</li>
        </ol>
    </nav>
@endsection
@section('content')
    <div class="content">
        @include('backend.layouts.error_msg')
        <div class="block block-rounded">
            <div class="block-header">
                <h3 class="block-title">Add Student</h3>
            </div>

            <form class="js-validation form-prevent-multiple-submission" action="{{ url('student/store') }}" id="form" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="block block-rounded">
                    <div class="block-content block-content-full">
                        <div class="row items-push ml-10">
                            <div class="col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label for="val-username">First Name <span class="text-danger">*</span></label>
                                    <input type="text"  class="form-control input-prevent-multiple-submission" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Enter first name.." required>
                                </div>
                                <div class="form-group">
                                    <label for="val-username">Last Name <span class="text-danger">*</span></label>
                                    <input type="text"  class="form-control input-prevent-multiple-submission" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Enter last name.." required>
                                </div>
                                <div class="form-group">
                                    <label for="val-username">Email <span class="text-danger">*</span></label>
                                    <input type="email"  class="form-control input-prevent-multiple-submission" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email.." required>
                                </div>
                                <div class="form-group ">
                                    <label for="example-flatpickr-default">Date of Birth<span class="text-danger">*</span></label>
                                    <input type="text" class="js-flatpickr form-control bg-white " data-date-format="d-m-Y" id="dob" name="dob" placeholder="d-m-Y" value="{{ old('dob')}}" required>
                                </div>
                                <div class="form-group">
                                    <label for="val-username">Father Name <span class="text-danger">*</span></label>
                                    <input type="text"  class="form-control input-prevent-multiple-submission" id="father_name" name="father_name" value="{{ old('father_name') }}" placeholder="Enter father name.." required>
                                </div>
                                <div class="form-group">
                                    <label for="val-username">Mother Name <span class="text-danger">*</span></label>
                                    <input type="text"  class="form-control input-prevent-multiple-submission" id="mother_name" name="mother_name" value="{{ old('mother_name') }}" placeholder="Enter mother name.." required>
                                </div>
                                <div class="form-group">
                                    <label for="val-username">Image<span class="text-danger">*</span></label>
                                    <input type="file"  class="form-control input-prevent-multiple-submission" id="image" name="image"  placeholder="Upload a image.." required>
                                </div>
                                <div class="form-group">
                                    <label for="val-username">Birth Certificate<span class="text-danger">*</span></label>
                                    <input type="file"  class="form-control input-prevent-multiple-submission" id="birth_certificate" name="birth_certificate"  placeholder="Upload birth certificate.." required>
                                </div>
                            </div>
                        </div>

                        <!-- END Regular -->

                        <!-- Submit -->
                        <div class="row items-push">
                            <div class="col-lg-7 offset-lg-4">
                                <button type="submit" class="btn btn-alt-primary button-prevent-multiple-submission" id="submit">
                                    <i class="spinner fa fa-spinner fa-spin"></i>Save
                                </button>
                            </div>
                        </div>
                        <!-- END Submit -->
                    </div>
                </div>
            </form>
            <!-- jQuery Validation -->
        </div>
        <!-- END Dynamic Table with Export Buttons -->
    </div>
@endsection

@section('js_after')

    <script src="{{ asset('backend/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('backend/js/plugins/jquery-validation/additional-methods.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('backend/js/pages/be_forms_validation.min.js') }}"></script>
    <script>
        $('.form-prevent-multiple-submission').on('submit',function() {
            $('.button-prevent-multiple-submission').attr('disabled', 'true');
            $('.spinner').show();
        })
        $('.input-prevent-multiple-submission').on('keypress',function() {
            $('.button-prevent-multiple-submission').removeAttr('disabled');
            $('.spinner').hide();
        })
        $('.input-prevent-multiple-submission').on('change' ,function() {
            $('.button-prevent-multiple-submission').removeAttr('disabled');
            $('.spinner').hide();
        })
    </script>

    <!-- Page JS Plugins -->

    <script src="{{asset('backend/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('backend/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{asset('backend/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
    <script src="{{asset('backend/js/plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('backend/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js')}}"></script>
    <script src="{{asset('backend/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
    <script src="{{asset('backend/js/plugins/dropzone/dropzone.min.js')}}"></script>
    <script src="{{asset('backend/js/plugins/flatpickr/flatpickr.min.js')}}"></script>
    <script>jQuery(function(){One.helpers(['flatpickr', 'datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider']);});</script>

@endsection
