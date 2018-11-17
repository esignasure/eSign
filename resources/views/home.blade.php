<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <title>eSignasure - Home</title>
    <base href="/">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/libs/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">
</head>

<body>
    <div class="wrapper ">
        <div class="text-right px-3 pt-3">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();"
               class="btn access-button main-btn logout font-blue-light-14">Log Out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </div>
        <div class="header text-right">
            <div class="list-inline">
                <div class="list-inline-item">
                    <img class="icon-head"  src="{{ asset('assets/image/home-icon.png') }}">
                    <img class="ml-3 icon-head"  src="{{ asset('assets/image/us.png') }}">
                </div>
                <div class="list-inline-item time-container">
                    <span class="mr-3 font-blue-light-14">01/01/2018 12:00 PM</span>
                </div>
            </div>
        </div>

        <div class="container-fluid position-relative">
            <div class="brand">
                <a href="#"><img class="mt-3" src="{{ asset('assets/image/esign-logo.png') }}"></a>
            </div>

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
    </div>

    <!-- jQuery 3 -->
    <script src="{{ asset('js/libs/jquery-3.2.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/libs/popper.min.js') }}"></script>
    <script src="{{ asset('js/libs/bootstrap.min.js') }}"></script>
</body>
</html>
