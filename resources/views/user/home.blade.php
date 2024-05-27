@extends('layouts.user.dashboard-master')
@section('title')
    Dashboard
@endsection

@section('content')
<div class="container-fluid pt-2">
    <div class="row justify-content-center">
            {{-- <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>
                </div>
            </div> --}}

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-gradient-info">
                        Claim Form Instructions:-
                    </div>

                    <ol type="i" class="m-3">

                        {{-- <li>
                            <a href="https://plimedicaldevices.ifciltd.com/video/PLI_MD_Claim_form.docx"
                                style="color: red;"><span class="badge badge-secondary">New</span> Click on this link to
                                read document for Incentive Claim Form</a>
                        </li> --}}

                        <li>
                            <a href="#videoModal" class="simple-link" data-toggle="modal" style="color: red;"><span
                                    class="badge badge-secondary">New</span> Click on this link to watch Tutorial Video for
                                Incentive Claim Form</a>
                        </li>
                    </ol>


                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        data-backdrop="static" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <div class="col-md-11">
                        <div class="col-md-0 offset-md-3" style="text-align: center">
                            <span style="color:#DC3545;font-size:17px"><b>Tutorial Video for Incentive Claim Form</b></span>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="">
                            <div class="card-body">
                                <video id="tutorialVideo" width="100%" height="100%" controls controlsList="nodownload">
                                    <source src="video/PLI_BD_CLAIM_PPT.mp4" type="video/mp4">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    $('#videoModal').on('shown.bs.modal', function() {
        var video = document.getElementById('tutorialVideo');
        video.play();
    });
    // JavaScript to pause video when modal is closed
    $('#videoModal').on('hidden.bs.modal', function() {
        var video = document.getElementById('tutorialVideo');
        video.pause();
    });
    document.addEventListener('contextmenu', function(e) {
        e.preventDefault();
    });
</script>

<script>
    // Function to open video modal with specific video URL
    function openVideoModal(videoUrl) {
        // Set the src attribute of the video source with the video URL
        document.getElementById('videoSource').src = videoUrl;
        // Load and play the video
        document.getElementById('videoPlayer').load();
        // Show the modal
        $('#videoModal').modal('show');
    }

    // Function to close video modal
    function closeVideoModal() {
        
        // Pause the video
        document.getElementById('videoPlayer').pause();
        // Clear the src attribute of the video source
        document.getElementById('videoSource').src = '';
        // Hide the modal
        $('#videoModal').modal('hide');
    }
</script>
