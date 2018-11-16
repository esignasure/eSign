<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>eSignasure</title>
    <link rel="stylesheet" href="{{ asset('css/libs/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.min.css') }}">
</head>
<body>
    <div class="wrapper">
        <div class="text-right px-3 pt-3">
            <a href="#" class="btn access-button">Log Out</a>
        </div>
        <div class="header">
            <div class="row text-right">
                <div class="col-9">
                    <img class="mr-3" src="{{ asset('assets/image/home-icon.png') }}">
                    <img class="ml-3" src="{{ asset('assets/image/us.png') }}">
                </div>

                <div class="col-3 m-auto">
                    <span class="mr-3">01/01/2018 12:00 PM</span>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="compliant-main">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="brand mb-5">
                            <img class="mt-3" src="{{ asset('assets/image/esign-logo.png') }}">
                        </div>
                        <div class="compliant-detail pt-5">
                            <h2 class="ml-5">Welcome</h2>
                            <div class="mt-5 compliant-btn">
                                <a href="" class="btn btn-blue mr-3">Take a Tour</a>
                                <a href="" class="btn btn-blue"><i class="fa fa-cogs" aria-hidden="true"></i> manage Account</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="table-img">
                            <img src="{{ asset('assets/image/table.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div><!-- EO compliant-main -->


            <div class="quick-main mb-3" >
                <div class="py-3 text-center">
                    <h4>Quick Access</h4>
                </div>
                <div class="d-flex justify-content-between">
                    <a href="#" class="btn access-button">Blank left</a>
                    <a href="#" class="btn access-button">Sign my Document</a>
                    <a href="#" class="btn access-button">Get it Signed</a>
                    <a href="#" class="btn access-button">Send Document</a>
                    <a href="#" class="btn access-button">Message</a>
                </div>
            </div><!-- EO quick-main-->
            <div class="glance-main my-3">
                <div class="py-3 text-center">
                    <h4>At a Glance</h4>
                </div>
                <div class="row glance-sub">
                    <div class="col-8">
                        <h5>Transaction Updates</h5>
                    </div>
                    <div class="col-4">
                        <a href="" class="btn access-button  mr-3">My Updates</a>
                        <a href="" class="btn access-button access-button-red ">Dismiss</a>
                    </div>
                </div>
                <div class="row glance-sub">
                    <div class="col-8">
                        <h5>Message Notification</h5>
                    </div>
                    <div class="col-4">
                        <a href="" class="btn access-button  mr-3">Click to view</a>
                        <a href="" class="btn access-button access-button-red ">Dismiss</a>
                    </div>
                </div>
                <div class="row glance-sub">
                    <div class="col-8">
                        <h5>Account Notification & Prompts</h5>
                    </div>
                    <div class="col-4">
                        <a href="" class="btn access-button  mr-3">Click to view</a>
                        <a href="" class="btn access-button access-button-red ">Dismiss</a>
                    </div>
                </div>
                <div class="row glance-sub">
                    <div class="col-8">
                        <h5>Paused</h5>
                    </div>
                    <div class="col-4">
                        <a href="" class="btn access-button  mr-3">Continue</a>
                        <a href="" class="btn access-button access-button-red ">Dismiss</a>
                    </div>
                </div>
            </div><!-- EO glance-min -->
            <div class="walk-main">
                <div class="py-3 text-center">
                    <h4>Walk-me Tutorial</h4>
                    <p>You can browse through Walk-Me Tutorials to learn about the eSignasure idea.</p>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="list-inline">
                            {{--<li class="list-inline-item mx-2 my-3">--}}
                                {{--<div class="walk-container text-center">--}}
                                    {{--<div class="walk-bg-main">--}}
                                        {{--<div class="sample-img"></div>--}}
                                    {{--</div>--}}
                                    {{--<a href="" class="btn access-button  mb-4 mx-3">New Messages</a>--}}
                                {{--</div>--}}
                            {{--</li>--}}
                            <li class="list-inline-item mx-2 my-3">
                                <div class="walk-container text-center">
                                    <div class="my-5">
                                        <img src="{{ asset('assets/image/upload.jpg') }}" alt="">
                                    </div>
                                    <a href="" class="btn access-button  mb-4 mx-3">Upload Document</a>
                                </div>
                            </li>
                            <li class="list-inline-item mx-2 my-3">
                                <div class="walk-container text-center walk-active">
                                    <div class="my-5">
                                        <img src="{{ asset('assets/image/sign.png') }}" alt="">
                                    </div>
                                    <a href="" class="btn access-button  mb-4 mx-3">Sign Document</a>
                                </div>
                            </li>
                            <li class="list-inline-item mx-2 my-3">
                                <div class="walk-container text-center">
                                    <div class="my-5">
                                        <img src="{{ asset('assets/image/getsign.jpg') }}" alt="">
                                    </div>
                                    <a href="" class="btn access-button  mb-4 mx-3">Get it Signed</a>
                                </div>
                            </li>
                            <li class="list-inline-item mx-2 my-3">
                                <div class="walk-container text-center">
                                    <div class="my-5">
                                        <img src="{{ asset('assets/image/send.jpg') }}" alt="">
                                    </div>
                                    <a href="" class="btn access-button  mb-4 mx-3"> Send Document</a>
                                </div>
                            </li>
                            <li class="list-inline-item mx-2 my-3">
                                <div class="walk-container text-center">
                                    <div class="my-5">
                                        <img src="{{ asset('assets/image/create.jpg') }}" alt="">
                                    </div>
                                    <a href="" class="btn access-button  mb-4 mx-3">Create Template</a>
                                </div>
                            </li>
                            <li class="list-inline-item mx-2 my-3">
                                <div class="walk-container text-center">
                                    <div class="my-5">
                                        <img src="{{ asset('assets/image/add.png') }}" alt="">
                                    </div>
                                    <a href="" class="btn access-button  mb-4 mx-3">Add User</a>
                                </div>
                            </li>
                            <li class="list-inline-item mx-2 my-3">
                                <div class="walk-container text-center">
                                    <div class="my-5">
                                        <img src="{{ asset('assets/image/access.jpg') }}" alt="">
                                    </div>
                                    <a href="" class="btn access-button  mb-4 mx-3">Set Up access</a>
                                </div>
                            </li>
                            <li class="list-inline-item mx-2 my-3">
                                <div class="walk-container text-center">
                                    <div class="my-5">
                                        <img src="{{ asset('assets/image/contact.jpg') }}" alt="">
                                    </div>
                                    <a href="" class="btn access-button  mb-4 mx-3">Contacts</a>
                                </div>
                            </li>
                            <li class="list-inline-item mx-2 my-3">
                                <div class="walk-container text-center">
                                    <div class="my-5">
                                        <img src="{{ asset('assets/image/recent.jpg') }}" alt="">
                                    </div>
                                    <a href="" class="btn access-button  mb-4 mx-3">Recent Activity </a>
                                </div>
                            </li>
                            <li class="list-inline-item mx-2 my-3">
                                <div class="walk-container text-center">
                                    <div class="my-5">
                                        <img src="{{ asset('assets/image/message.jpg') }}" alt="">
                                    </div>
                                    <a href="" class="btn access-button  mb-4 mx-3">New Messages</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div><!-- EO walk-main-->
            <div class="contact-main">
                <div class="py-3 text-center">
                    <h4>Contact Support</h4>
                    <a href="" class="btn btn-blue my-3">Suggestions?</a>
                </div>
            </div>
        </div><!-- EO CONTAINER-->
    </div><!-- EO MAIN DIV -->

    <!-- jQuery 3 -->
    <script src="{{ asset('js/libs/jquery-3.2.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/libs/popper.min.js') }}"></script>
    <script src="{{ asset('js/libs/bootstrap.min.js') }}"></script>
</body>
</html>