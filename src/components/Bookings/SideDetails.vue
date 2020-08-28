<template>
<div class="col-3 pr-3">
    <div class="pl-3">
        <div class="card mb-0 bg-b" style="background-color:#F4F6F6;border:1px solid #007a5a;">
            <div class="card-header" style="border-bottom:1px solid #007a5a;">
                <div class="d-flex justify-content-between align-items-center">
                    <div><span class="h6" style="color:#007a5a;font-size:18px;"><b>Trip Balance </b> </span><span class="pl-2 text-danger" style="font-size:25px;"><b>$667</b></span></div>

                </div>
            </div>
            <div class="card-body px-5">
                <div class="row align-items-center">
                    <div class="col-sm-12">
                        <div class="progress-circle progress-lg" id="progress-performance-1" data-progress="72" data-trailwidth="4" data-text="72%" data-textclass="h3" data-color="#007a5a" style="position: relative;"><svg viewBox="0 0 100 100" style="display: block;">
                                <path d="M 50,50 m 0,-46.5 a 46.5,46.5 0 1 1 0,93 a 46.5,46.5 0 1 1 0,-93" stroke="#dc3545" stroke-width="1" fill-opacity="0"></path>
                                <path d="M 50,50 m 0,-46.5 a 46.5,46.5 0 1 1 0,93 a 46.5,46.5 0 1 1 0,-93" stroke="#007a5a" stroke-width="3" fill-opacity="0" style="stroke-dasharray: 292.273; stroke-dashoffset: 100.8366;"></path>
                            </svg>
                            <div class="" style="position: absolute; left: 50%; top: 50%; padding: 0px; margin: 0px; transform: translate(-50%, -50%); color: rgb(185, 119, 14);font-size:55px;">80% </div>
                        </div>
                    </div>

                </div>
                <br>
                <div class="row" style="border-top:1px solid #007a5a;">

                    <div class="col-6 text-center pt-3"><span class="mb-0 text-detail-bold">$900</span> <span class="d-block text-sm">Total Cost</span></div>
                    <div class="col-6 text-center pt-3" style="border-left:1px solid #007a5a;"><span class="mb-0 text-detail-bold">$6000</span> <span class="d-block text-sm">Total Paid</span></div>

                </div>
            </div>
        </div>

    </div>

    <div class="pl-3 pt-5">
        <div class="card">
            <div class="card-body p-0">
                <!-- List group -->
                <div class="list-group list-group-flush my-n3">
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Title -->
                                <h5 class="mb-0">
                                    Arrival Date
                                </h5>
                            </div>
                            <div class="col-auto">
                                <!-- Time -->
                                <time class="small text-muted" datetime="1988-10-24">
                                    6th/Jul/2020
                                </time>
                            </div>
                        </div> <!-- / .row -->
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Title -->
                                <h5 class="mb-0">
                                    Departure Date
                                </h5>
                            </div>
                            <div class="col-auto">

                                <!-- Time -->
                                <time class="small text-muted" datetime="2018-10-28">
                                    21st/Jul/2020
                                </time>

                            </div>
                        </div> <!-- / .row -->
                    </div>
                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Title -->
                                <h5 class="mb-0">
                                    Booking status
                                </h5>
                            </div>
                            <div class="col-auto">
                                <span class="badge badge-success" style="font-size:12px;">Confirmed</span>
                            </div>
                        </div> <!-- / .row -->
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Title -->
                                <h5 class="mb-0">
                                    Pax.
                                </h5>

                            </div>
                            <div class="col-auto">

                                <!-- Text -->
                                <small class="text-muted" style="font-size:15px;">
                                    5
                                </small>

                            </div>
                        </div> <!-- / .row -->
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Title -->
                                <h5 class="mb-0">
                                    No. of Days
                                </h5>

                            </div>
                            <div class="col-auto">

                                <!-- Text -->
                                <small class="text-muted" style="font-size:15px;">
                                    6
                                </small>

                            </div>
                        </div> <!-- / .row -->
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Title -->
                                <h5 class="mb-0">
                                    Booking Source
                                </h5>

                            </div>
                            <div class="col-auto">

                                <!-- Link -->
                                <a href="#!" class="small">
                                    direct
                                </a>

                            </div>
                        </div> <!-- / .row -->
                    </div>

                    <div class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col">

                                <!-- Title -->
                                <h5 class="mb-0">
                                    Cost per person
                                </h5>

                            </div>
                            <div class="col-auto">

                                <!-- Link -->
                                <a href="#!" class="small text-info" style="font-size:17px;">
                                    USD
                                    500
                                </a>
                            </div>
                        </div> <!-- / .row -->
                    </div>

                </div>
                <b-button size="sm" pill variant="outline-success" class="mt-3  mb-1 float-right">Update</b-button>

            </div>

        </div>

    </div>
    <div class="pl-4 pt-2">
        <label class="float-left" style="color:black;">Client's Message</label>
        <b-form-textarea style="overflow: hidden; overflow-wrap: break-word;  height: 150px;" id="textarea-no-resize" placeholder="type here the message from the client ..." rows="3" no-resize></b-form-textarea>
        <b-button size="sm" pill variant="outline-success" class="float-right my-1">Update</b-button>
    </div>

</div>
</template>

<style>
.card {
    margin-bottom: 1.5rem;
    border-color: #edf2f9;
    box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, .03);
}

.text-sm {
    font-size: 12px;
    font-size: 12px !important;
    text-align: left;
    color: black;
}

.text-detail-bold {
    font-size: 20px;
    font-weight: bold;
}

.list-group .list-group-item h5 {
    font-size: 15px !important;
    text-align: left;
}
</style>
