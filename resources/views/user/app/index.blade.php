@extends('layouts.user.dashboard-master')

@section('title')
    Applications Dashboard
@endsection

@push('styles')
    <link href="{{ asset('css/app/application.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app/progress.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card border-success">
                <div class="card-header bg-gradient-success">
                    Sample Application Form
                </div>
                <div class="card-body p-2">
                    <div class="row">
                        <div class="col-md-5">
                            <h6 class="text-danger">Please view the <b>Sample Application Form</b> before Proceeding.</h6>
                        </div>
                        <div class="col-md-5 justify-content-center">
                            <a href="{{ asset('docs/app/sample.pdf') }}" target="_blank" download="sample.pdf"
                                class="btn btn-sm btn-outline-primary float-centre">Sample Form</a>
                            <a href="{{ asset('docs/app/Undertakings_Certificates.pdf') }}" target="_blank"
                                download="Undertakings_Certificates.pdf"
                                class="btn btn-sm btn-outline-primary float-centre ml-4">Undertakings & Certificates</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <!-- Current Application-->
            <div class="card border-primary">
                <div class="card-header text-white bg-primary border-primary">
                    <h5>Applications</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="example" class="table table-sm table-striped table-bordered table-hover">
                                    <thead>
                                        <th colspan="7" class="text-center text-danger text-bold bg-light">Round-IV
                                            Application</th>
                                        <tr class="table-primary">
                                            <th class="w-65 text-center">Sr No</th>
                                            <th class="col-3 text-center">Eligible Product</th>
                                            <th class="col-3 text-center">Application No</th>
                                            <th class="w-65 text-center">Status</th>
                                            <th class="col-auto text-center">Creation Date</th>
                                            <th class="col-auto text-center">Last Update</th>
                                            <th class="w-65 text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $var = 1;
                                        @endphp
                                        @foreach ($prods->sortBy('product') as $prod)
                                            @if ($prod->round == '4')
                                                {{-- this define only eligible product, selected during the registration --}}
                                                {{-- {{dd($prod->round )}} --}}
                                                @foreach ($apps as $app)
                                                    @if ($app->eligible_product == $prod->id)
                                                        <tr>
                                                            <td class="w-65 text-center">{{ $var++ }}</td>
                                                            <td>{{ $prod->product }}</td>
                                                            <td>{{ $app->app_no }}</td>
                                                            @if ($app->status == 'D')
                                                                <td style="background-color: #f3cccc;"
                                                                    class="w-65 text-center">Draft</td>
                                                            @elseif($app->status == 'S')
                                                                <td style="background-color: #97f58a;"
                                                                    class="w-65 text-center">Submitted</td>
                                                            @elseif($app->status == 'A')
                                                                <td class="w-65 text-center">Under Process</td>
                                                            @else
                                                                <td class="w-65 text-center">Not Created</td>
                                                            @endif
                                                            <td class="text-center">
                                                                {{ date('d/m/Y', strtotime($app->created_at)) }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ date('d/m/Y', strtotime($app->updated_at)) }}
                                                            </td>
                                                            <td>
                                                                @if ($app->status == 'D')
                                                                    @if (Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2022-08-24 23:59:00')))
                                                                        <button type="button"
                                                                            class="btn btn-warning btn-sm btn-block"
                                                                            data-toggle="modal"
                                                                            data-target="#editModal{{ $app->id }}">
                                                                            Edit
                                                                        </button>
                                                                        @include('user.partials.editModal')
                                                                    @endif
                                                                @elseif($app->status == 'S')
                                                                    <a href="{{ route('applications.show', $app->id) }}"
                                                                        class="btn btn-success btn-sm btn-block">View</a>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                                @if (!in_array($prod->id, $createdProdApps))
                                                    <tr>
                                                        <td class="w-65 text-center">{{ $var++ }}</td>
                                                        <td>{{ $prod->product }}</td>
                                                        <td class="w-65 text-center"></td>
                                                        <td class="w-65 text-center">Not Created</td>
                                                        <td class="w-65 text-center"></td>
                                                        <td class="w-65 text-center"></td>
                                                        @if (Carbon\Carbon::now()->lt(Carbon\Carbon::parse('2022-08-24 23:59:00')))
                                                            <td>
                                                                <a href="{{ route('applications.create', $prod->id) }}"
                                                                    class="btn btn-warning btn-sm btn-block">Create</a>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endif
                                            @endif
                                        @endforeach
                                    </tbody>
                                    {{--Add by Ajaharuddin Ansari--}}
                                    <tbody>
                                        {{-- Round-3 Application --}}
                                        <th colspan="7" class="text-center text-danger text-bold bg-light">Round-III
                                            Application</th>
                                        @foreach ($prods->sortBy('product') as $prod)
                                        @if ($prod->round == '3')
                                            @foreach ($apps1 as $app)
                                                @if ($app->eligible_product == $prod->id and $app->round == '3')
                                                    <tr>
                                                        <td class="w-65 text-center">{{ $var++ }}</td>
                                                        <td>{{ $prod->product }}</td>
                                                        <td>{{ $app->app_no }}</td>
                                                        @if($app->status=='S')
                                                        <td style="background-color: #97f58a;" class="w-65 text-center">
                                                            Submitted</td>
                                                        @else
                                                        <td style="background-color: yellow;" class="w-65 text-center">
                                                            Draft</td>
                                                        @endif
                                                        <td class="text-center">
                                                            {{ date('d/m/Y', strtotime($app->created_at)) }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ date('d/m/Y', strtotime($app->updated_at)) }}
                                                        </td>
                                                        <td>
                                                            @if ($app->status == 'S')
                                                                <a href="{{ route('applications.show', $app->id) }}"
                                                                    class="btn btn-success btn-sm btn-block">View</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tbody>
                                        {{-- Round-2 Application --}}
                                        <th colspan="7" class="text-center text-danger text-bold bg-light">Round-II
                                            Application</th>
                                        @foreach ($prods->sortBy('product') as $prod)
                                        @if ($prod->round == '2')
                                            @foreach ($apps1 as $app)
                                                @if ($app->eligible_product == $prod->id and $app->round == '2')
                                                    <tr>
                                                        <td class="w-65 text-center">{{ $var++ }}</td>
                                                        <td>{{ $prod->product }}</td>
                                                        <td>{{ $app->app_no }}</td>
                                                        @if($app->status=='S')
                                                        <td style="background-color: #97f58a;" class="w-65 text-center">
                                                            Submitted</td>
                                                        @else
                                                        <td style="background-color: yellow;" class="w-65 text-center">
                                                            Draft</td>
                                                        @endif
                                                        <td class="text-center">
                                                            {{ date('d/m/Y', strtotime($app->created_at)) }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ date('d/m/Y', strtotime($app->updated_at)) }}
                                                        </td>
                                                        <td>
                                                            @if ($app->status == 'S')
                                                                <a href="{{ route('applications.show', $app->id) }}"
                                                                    class="btn btn-success btn-sm btn-block">View</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                            @endif
                                        @endforeach
                                    </tbody>
                                    <tbody>
                                        {{-- Round-1 Application --}}
                                        <th colspan="7" class="text-center text-danger text-bold bg-light">Round-I
                                            Application</th>
                                        @foreach ($prods->sortBy('product') as $prod)
                                            @foreach ($apps1 as $app)
                                                @if ($app->eligible_product == $prod->id and $app->round == '1')
                                                    <tr>
                                                        <td class="w-65 text-center">{{ $var++ }}</td>
                                                        <td>{{ $prod->product }}</td>
                                                        <td>{{ $app->app_no }}</td>
                                                        @if($app->status=='S')
                                                        <td style="background-color: #97f58a;" class="w-65 text-center">
                                                            Submitted</td>
                                                        @else
                                                        <td style="background-color: yellow;" class="w-65 text-center">
                                                            Draft</td>
                                                        @endif
                                                        <td class="text-center">
                                                            {{ date('d/m/Y', strtotime($app->created_at)) }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ date('d/m/Y', strtotime($app->updated_at)) }}
                                                        </td>
                                                        <td>
                                                            @if ($app->status == 'S')
                                                                <a href="{{ route('applications.show', $app->id) }}"
                                                                    class="btn btn-success btn-sm btn-block">View</a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                                {{--Add by Ajaharuddin Ansari--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endpush
