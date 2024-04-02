@extends('layouts.master')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center my-5">
            <div class="col-md-8">
                <div class="card border-primary">
                    <div class="card-header bg-info text-white p-1">
                        <h5>Scheme & Guidelines</h5>
                    </div>
                    <div class="card-body bg-gradient-info p-0">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th style="width:50%" class="text-center">Title</th>
                                        <th class="text-center">Download</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Notice for Inviting 4th Round of Applications</strong></td>
                                        <td>
                                            <ul>
                                                <li><a href="{{ asset('docs/Notice-PLI-BD-Round-4.pdf') }}" target="_blank"
                                                        title="A PDF file that opens in new window. To know how to open PDF file refer Help section located at bottom of the site.">4th
                                                        Round Application Notice<span
                                                            class="right badge badge-pill badge-danger">New</span></a>
                                                </li>
                                                <li><a href="{{ asset('docs/CORRIGENDUM.pdf') }}" target="_blank"
                                                        title="A PDF file that opens in new window. To know how to open PDF file refer Help section located at bottom of the site.">CORRIGENDUM<span
                                                            class="right badge badge-pill badge-danger">New</span></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Notice for Inviting 3rd Round of Applications </strong></td>
                                        <td>
                                            <ul>
                                                <li><a href="{{ asset('docs/Notice-PLI-BD-Round-3_Last_date_Extension2.pdf') }}"
                                                        target="_blank"
                                                        title="A PDF file that opens in new window. To know how to open PDF file refer Help section located at bottom of the site.">Notice
                                                        for time extension (Round 3rd Application Last date 30/04/2022 )</a>
                                                </li>
                                                <li><a href="{{ asset('docs/Notice-PLI-BD-Round-3_Last_date_Extension.pdf') }}"
                                                        target="_blank"
                                                        title="A PDF file that opens in new window. To know how to open PDF file refer Help section located at bottom of the site.">Notice
                                                        for time extension (Round 3rd Application )</a>
                                                </li>
                                                <li><a href="{{ asset('docs/Notice-PLI-BD-Round-3.pdf') }}" target="_blank"
                                                        title="A PDF file that opens in new window. To know how to open PDF file refer Help section located at bottom of the site.">Details
                                                        of Eligible Products for 3rd Round </a>
                                                </li>
                                                <li><a href="{{ asset('docs/extension.pdf') }}" target="_blank"
                                                        title="A PDF file that opens in new window. To know how to open PDF file refer Help section located at bottom of the site.">
                                                        Notice for time extension</a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Notice for Inviting 2nd Round of Applications</strong></td>
                                        <td>
                                            <ul>
                                                <li><a href="{{ asset('docs/Notice-for-PLI-BD.pdf') }}" target="_blank"
                                                        title="A PDF file that opens in new window. To know how to open PDF file refer Help section located at bottom of the site.">Details
                                                        of Eligible Products for 2nd Round</a>
                                                    <br><a href="{{ asset('docs/Ofloxacin.pdf') }}" target="_blank"
                                                        title="A PDF file that opens in new window. To know how to open PDF file refer Help section located at bottom of the site.">
                                                        Notice for inclusion of new product- Ofloxacin</a>

                                                    <br><a href="{{ asset('docs/Notice.pdf') }}" target="_blank"
                                                        title="A PDF file that opens in new window. To know how to open PDF file refer Help section located at bottom of the site.">
                                                        Notice for inclusion of new product- Erythromycin Thiocynate
                                                        (TIOC)</a>
                                                    <br><a
                                                        href="{{ asset('docs/Revised notice for PLI Scheme for Bulk Drugs.pdf') }}"
                                                        target="_blank"
                                                        title="A PDF file that opens in new window.
                                                        To know how to open PDF file refer Help
                                                        section located at bottom of the site.">
                                                        Notice for inclusion of new product- CDA</a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><strong>Scheme Notification</strong></td>
                                        <td>
                                            <ul>
                                                <li><a href="{{ asset('docs/Gazettee notification of bulk drug schemes.pdf') }}"
                                                        target="_blank"
                                                        title="A PDF file that opens in new window. To know how to open PDF file refer Help section located at bottom of the site.">Gazette
                                                        Notification</a></li>
                                            </ul>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td><strong>Guidelines</strong></td>
                                        <td>
                                            <ul>
                                                <li><a href="{{ asset('docs/BD Guidelines.pdf') }}" target="_blank"
                                                        title="A PDF file that opens in new window. To know how to open PDF file refer Help section located at bottom of the site.">
                                                        Scheme Guidelines</a></li>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Banck A/C Details for Fee Payment</strong></td>
                                        <td>
                                            <div class="table-responsive p-0 m-0">
                                                <table class="table table-sm table-bordered table-hover">
                                                    <tbody>
                                                        <tr>
                                                            <th>ACCOUNT NAME</th>
                                                            <td>IFCI PLI BULK DRUGS</td>
                                                        </tr>
                                                        <tr>
                                                            <th>ACCOUNT NO.</th>
                                                            <td>3859475896</td>
                                                        </tr>
                                                        <tr>
                                                            <th>Name of the Bank</th>
                                                            <td>Central Bank of India</td>
                                                        </tr>
                                                        <tr>
                                                            <th>BRANCH CODE</th>
                                                            <td>1410</td>
                                                        </tr>
                                                        <tr>
                                                            <th>BRANCH IFSC CODE</th>
                                                            <td>CBIN0281410</td>
                                                        </tr>
                                                        <tr>
                                                            <th>BRANCH NAME</th>
                                                            <td>Nehru Place</td>
                                                        </tr>
                                                        <tr>
                                                            <th>ADDRESS</th>
                                                            <td>59, Shakuntala Building, Nehru Place , New Delhi-110019</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Contact Email </strong></td>
                                        <td>
                                            <ul>
                                                <li>bdpli[at]ifciltd[dot]com</li>
                                                <li>pharma-bureau[at]gov[dot]in</li>
                                                <li></li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
