@extends('backend.layouts.master')
@section('css_after')

@endsection
@section('content')
    <div class="content">
        <!-- Quick Actions -->

        <div class="row">
            <div class="col-6">
                <a class="block block-rounded block-link-shadow text-center" href="{{url('user/profile/edit')}}">
                    <div class="block-content block-content-full">
                        <div class="font-size-h2 text-dark">
                            <i class="fa fa-pencil-alt"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="font-w600 font-size-sm text-muted mb-0">
                            Edit Profile
                        </p>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <a class="block block-rounded block-link-shadow text-center" href="{{url('change_password')}}">
                    <div class="block-content block-content-full">
                        <div class="font-size-h2 text-danger">
                            <i class="fa fa-lock-open"></i>
                        </div>
                    </div>
                    <div class="block-content py-2 bg-body-light">
                        <p class="font-w600 font-size-sm text-danger mb-0">
                            Change Password
                        </p>
                    </div>
                </a>
            </div>
        </div>
        <!-- END Quick Actions -->
        <!-- User Information -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">User Profile</h3>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-lg-6">
                        <!-- Billing Address -->
                        <div class="block block-rounded block-bordered">
                            <div class="block-header border-bottom">
                                <h3 class="block-title">Official Information</h3>
                            </div>
                            <div class="block-content">
                                <div class="font-size-sm">
                                    Name: {{$user->first_name.' '.$user->last_name}}<br>
                                    Email: {{$user->email}}<br><br>
                                </div>
                            </div>
                        </div>
                        <!-- END Billing Address -->
                    </div>

                    <div class="col-lg-6">
                        <!-- Shipping Address -->
                        @if($user->father_name)
                        <div class="block block-rounded block-bordered">
                            <div class="block-header border-bottom">
                                <h3 class="block-title">Personal Information</h3>
                            </div>
                            <div class="block-content">
                                <div class="font-size-sm">
                                    Father name: {{$user->father_name}}<br>
                                    Mother name: {{$user->mother_name}}<br>
                                    Date of Birth: {{$user->dob}}<br>
                                </div>

                            </div>
                        </div>
                    @endif
                        <!-- END Shipping Address -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END User Information -->

    </div>

@endsection

@section('js_after')


@endsection
