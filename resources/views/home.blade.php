@extends('layouts.main')
@section('title', 'Home')
@section('content')
    <div class="container-fluid position-relative">
        <?php
            // @TODO:: this is temp solution due to lack of time, please find with valid standard
            $fullUrl = Request::path();
            $subUrl = explode('/', $fullUrl);
            $url = $subUrl[0];
        ?>
        <div class="brand {{ $url != 'home' ? 'd-none' : '' }}" >
            <a href="{{ route('home') }}"><img class="mt-3" src="{{ asset('assets/image/esign-logo.png') }}"></a>
        </div>
        {{--<div class="search-box">
            <form>
                <input class="form-control" type="search" placeholder="Search...">
                <input type="submit" name="submit" class="d-none">
            </form>
        </div>--}}


        <div class="main-container welcome-box-margin">
            <div class="row">
                <div class="col-lg-6 col-md-5 col-12 m-auto">
                    <div class="welcome-box pt-5 text-center">
                        <h2>Welcome!</h2>
                        <div class="mt-2 compliant-btn">
                            <a href="#" class="btn btn-blue main-btn mr-md-3 mt-4">Take a Tour</a>
                            <a href="#" class="btn btn-blue main-btn mt-4"><img class="manage-acc" src="{{ asset('assets/image/manage-account.png') }}"> manage Account</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-7 col-12 meeting-wrapper">
                    <div class="table-img text-right">
                        <img class="meeting-responsive" src="{{ asset('assets/image/meeting.png') }}" alt="meeting">
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="quick-head">
                <div class="main-container">
                    <div class="quick-main mb-3" >
                        <div class="py-3 text-center pb-4">
                            <h4 class="title-text">Quick Access</h4>
                        </div>
                        <div class="d-flex justify-content-between quick-buttons">
                            <a href="#" class="btn access-button main-btn">Upload Document</a>
                            <a href="#" class="btn access-button main-btn">Sign my Document</a>
                            <a href="#" class="btn access-button main-btn">Get it Signed</a>
                            <a href="#" class="btn access-button main-btn">Send Document</a>
                            <a href="#" class="btn access-button main-btn">Message</a>
                        </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            {{--At a glance section started--}}
            <div class="main-container">
                <div class="text-center pt-5">
                    <h4 class="title-text">At a Glance</h4>
                </div>

                {{--Transaction update section--}}
                <div class="glance-sub">
                    <div class="text-notification-wrapper"><h5 class="text-20-light">Transaction Updates</h5></div>
                    <div class="btn-notification-wrapper">
                        <a href="#" class="btn access-button main-btn  mr-3">My Updates</a>
                        <a href="#" class="btn access-button main-btn access-button btn-red">Dismiss</a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                {{--Message notification section--}}
                <div class="glance-sub">
                    <div class="text-notification-wrapper"><h5 class="text-20-light">Message Notification</h5></div>
                    <div class="btn-notification-wrapper">
                        <a href="#" class="btn access-button main-btn  mr-3">Click To View</a>
                        <a href="#" class="btn access-button main-btn access-button btn-red">Dismiss</a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                {{--Account notification section--}}
                <div class="glance-sub">
                    <div class="text-notification-wrapper"><h5 class="text-20-light">Account Notification & Prompts</h5></div>
                    <div class="btn-notification-wrapper">
                        <a href="#" class="btn access-button main-btn  mr-3">Click To View</a>
                        <a href="#" class="btn access-button main-btn access-button btn-red">Dismiss</a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                {{--Paused section--}}
                <div class="glance-sub">
                    <div class="text-notification-wrapper"><h5 class="text-20-light">Paused</h5></div>
                    <div class="btn-notification-wrapper">
                        <a href="#" class="btn access-button main-btn  mr-3">Continue</a>
                        <a href="#" class="btn access-button main-btn access-button btn-red">Dismiss</a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            {{--At a glance section end--}}

            {{--Walk me tutorial section started--}}
            <div class="main-container pr-0">
                <div class="text-center pt-5">
                    <h4 class="title-text">Walk-me Tutorial</h4>
                    <p class="text-details pb-5">You can browse through Walk-Me Tutorials to learn about the eSignasure idea.</p>
                </div>
                <div>
                    <div class="walk-me-box-container">
                        <div class="box-details">
                            <div class="walk-container text-center">
                                <div class="walk-bg-main">
                                    <div class="bg-style upload-doc cmn-margin"></div>
                                </div>
                                <a href="#" class="btn access-button main-btn mt-acc-cmn mx-3">Upload Document</a>
                            </div>
                        </div>
                        <div class="box-details">
                            <div class="walk-container walk-active text-center">
                                <div class="walk-bg-main">
                                    <div class="bg-style sign-doc cmn-margin"></div>
                                </div>
                                <a href="#" class="btn access-button main-btn mt-acc-cmn mx-3">Sign Document</a>
                            </div>
                        </div>
                        <div class="box-details">
                            <div class="walk-container text-center">
                                <div class="walk-bg-main">
                                    <div class="bg-style get-signed cmn-margin"></div>
                                </div>
                                <a href="#" class="btn access-button main-btn mt-acc-cmn mx-3">Get it Signed</a>
                            </div>
                        </div>
                        <div class="box-details">
                            <div class="walk-container text-center">
                                <div class="walk-bg-main">
                                    <div class="bg-style send-doc cmn-margin"></div>
                                </div>
                                <a href="#" class="btn access-button main-btn mt-acc-cmn mx-3">Send Document</a>
                            </div>
                        </div>
                        <div class="box-details">
                            <div class="walk-container text-center">
                                <div class="walk-bg-main">
                                    <div class="bg-style create-temp cmn-margin"></div>
                                </div>
                                <a href="#" class="btn access-button main-btn mt-acc-cmn mx-3">Create Template</a>
                            </div>
                        </div>
                        <div class="box-details">
                            <div class="walk-container text-center">
                                <div class="walk-bg-main">
                                    <div class="bg-style add-user cmn-margin"></div>
                                </div>
                                <a href="#" class="btn access-button main-btn mt-acc-cmn mx-3">Add User</a>
                            </div>
                        </div>
                        <div class="box-details">
                            <div class="walk-container text-center">
                                <div class="walk-bg-main">
                                    <div class="bg-style set-access cmn-margin"></div>
                                </div>
                                <a href="#" class="btn access-button main-btn mt-acc-cmn mx-3">Set up Access</a>
                            </div>
                        </div>
                        <div class="box-details">
                            <div class="walk-container text-center">
                                <div class="walk-bg-main">
                                    <div class="bg-style contact cmn-margin"></div>
                                </div>
                                <a href="#" class="btn access-button main-btn mt-acc-cmn mx-3">Contacts</a>
                            </div>
                        </div>
                        <div class="box-details">
                            <div class="walk-container text-center">
                                <div class="walk-bg-main">
                                    <div class="bg-style recent-activity cmn-margin"></div>
                                </div>
                                <a href="#" class="btn access-button main-btn mt-acc-cmn mx-3">Recent Activity</a>
                            </div>
                        </div>
                        <div class="box-details">
                            <div class="walk-container text-center">
                                <div class="walk-bg-main">
                                    <div class="bg-style new-message cmn-margin"></div>
                                </div>
                                <a href="#" class="btn access-button main-btn mt-acc-cmn mx-3">New Messages</a>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            {{--Walk me tutorial section end--}}
            <div class="contact-main">
                <div class="py-3 text-center">
                    <h4 class="title-text">Contact Support</h4>
                    <a href="#" class="btn btn-blue main-btn suggestion my-3">Suggestions?</a>
                </div>
            </div>

        </div>

    </div><!-- EO container-fluid -->
        <!-- EO CONTAINER-->
    </div><!-- EO MAIN DIV -->
@endsection


