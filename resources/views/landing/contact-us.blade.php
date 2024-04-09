@extends('layouts.master')
@section('content')
<style>
    p{
        font-size: 15px;
    }
</style>

<div class="container">
    <div class="row">
       
        <div class="col-md-9 offset-md-2 my-2">
            <div style="height: 20px; clear:both;"></div>
            <h3><span><i class="fas fa-info-circle"></i></span>Contact Us</h3>
            <h6 class="my-2">Office Timings – 09:30 AM – 05:30 PM (Monday – Friday)</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card my-2">
                <div class="card-header bg-info text-white">
                    Registered Office Address
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-lg-4">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3504.690221664613!2d77.2498622645081!3d28.549029482450816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390ce3c59b2e8e17%3A0xb9d54a6d9773171e!2sIFCI%20Limited!5e0!3m2!1sen!2sin!4v1589832596740!5m2!1sen!2sin"
                                width="350" height="250" frameborder="0" style="border:0;" allowfullscreen=""
                                aria-hidden="false" tabindex="0"></iframe>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <b>For General support kindly contact on:</b>
                            <p class="ml-3"><i class="fas fa-user mr-3"></i> Contact Person : Shivam Kumar </p>
                            <p class="ml-3" style="margin-top:-10px;"><i class="fas fa-phone mr-3"></i> Phone : +91 9643590975 </p>
                            <p class="ml-3" style="margin-top:-10px;"><i class="fas fa-envelope mr-3"></i> Email : shivam[dot]kumar[at]ifciltd[dot]com </p>
                            <p class="ml-3"><strong>IFCI Limited</strong><br>
                                IFCI Tower,61 Nehru Place,
                                <br>New Delhi-110 019.
                                <br>Enquiry Mail : bdpli[at]ifciltd[dot]com
                            </p>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <b>For technical support kindly contact on:</b>
                            <p class="ml-2"><i class="fas fa-envelope mr-3"></i> Email : advisory[dot]support[at]ifciltd[dot]com</p>
                            <p class="ml-2" style="margin-top:-10px;"><i class="fas fa-phone mr-3"></i> Phone : + 91 9870200156 , + 91 11 2623 0203  &nbsp;&nbsp;<b>[Only Office Hours]</b></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div style="height: 30px; clear:both;"></div>
</div>


@endsection