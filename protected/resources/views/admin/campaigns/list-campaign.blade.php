@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fa fa-th-list nav-icon"></i>
                        List All Campaigns
                    </h1>
                </div><!-- /.col -->
                {{--<div class="col-sm-6">--}}
                {{--<ol class="breadcrumb float-sm-right">--}}
                {{--<li class="breadcrumb-item"><a href="#">Home</a></li>--}}
                {{--<li class="breadcrumb-item active">Starter Page</li>--}}
                {{--</ol>--}}
                {{--</div><!-- /.col -->--}}
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @if(Session::get('submit_update_success'))
                        <div class="col-lg-6">
                            <!-- small box -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <p>
                                        {{ Session::get('submit_update_success') }}
                                    </p>
                                    <p>Update Campaign Success.</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-plus-circle"></i>
                                </div>
                                <p class="small-box-footer">
                                    -----
                                </p>
                            </div>
                        </div>
                    @endif
                        @if(Session::get('submit_delete_success'))
                            <div class="col-lg-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <p>
                                            {{ Session::get('submit_delete_success') }}
                                        </p>
                                        <p>Delete Campaign Success.</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-plus-circle"></i>
                                    </div>
                                    <p class="small-box-footer">
                                        -----
                                    </p>
                                </div>
                            </div>
                        @endif
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fa fa-th-list nav-icon"></i>
                                List All Campaigns
                            </h3>

                            {{--<div class="card-tools">--}}
                            {{--<div class="input-group input-group-sm" style="width: 150px;">--}}
                            {{--<input type="text" name="table_search" class="form-control float-right" placeholder="Search">--}}

                            {{--<div class="input-group-append">--}}
                            {{--<button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover" id="tableusers">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-nowrap">Campaigner</th>
                                    <th class="text-nowrap">Created At</th>
                                    <th class="text-nowrap">Title</th>
                                    <th class="text-nowrap">Description</th>
                                    <th class="text-nowrap">Target Donation</th>
                                    <th class="text-nowrap">Deadline</th>
                                    <th class="text-nowrap">Status</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @for($j=0,$i=1;$i<=count($data_campaigns);$i++,$j++)
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>
                                <img src="{{ URL::asset($data_campaigns[$j]->image_profile) }}"
                                     class="brand-image">
                                            {{ $data_campaigns[$j]->fullname }}
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($data_campaigns[$j]
                                                                        ->created_at)
                                                                        ->diffForHumans()  }}
                                        </td>
                                        <td>{{ str_limit($data_campaigns[$j]->title,30) }}</td>
                                        <td>
                                            {{ str_limit(strip_tags($data_campaigns[$j]
                                                            ->description),30) }}
                                        </td>

                                        <td>
                                            <p class="uang">
                                            {{ $data_campaigns[$j]->target_donation }}
                                            </p>
                                        </td>
                                        <td>
                                            {{\Carbon\Carbon::parse($data_campaigns[$j]
                                                                        ->deadline)
                                                                        ->toFormattedDateString()  }}
                                        </td>
                                        <td>
                                            @if($data_campaigns[$j]->complete_sts == 0)
                                                Completed
                                                @elseif($data_campaigns[$j]->complete_sts == 1)
                                                Not Completed Yet
                                            @endif
                                        </td>
                                        <td>

                                            <button type="button"
                                                    onclick="window.location= '{{ url(action('PageCampaignsController@edit_campaign',$data_campaigns[$j]->id_campaign)) }}'"
                                                    class="btn btn-primary btn-sm">Edit
                                            </button>

                                            <form method="post" action="{{ url(action('PageCampaignsController@delete_campaign')) }}">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="id_user"
                                                       value="{{ $data_campaigns[$j]->id_user }}">
                                                <input type="hidden" name="id_campaign"
                                                       value="{{ $data_campaigns[$j]->id_campaign }}">
                                                <button class="btn btn-danger btn-sm" type="submit">
                                                    Delete
                                                </button>
                                            </form>

                                        </td>

                                    </tr>
                                @endfor


                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            {{--end row 1--}}


        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('new-scripts')

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker         : true,
                timePickerIncrement: 30,
                format             : 'MM/DD/YYYY h:mm A'
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker(
                {
                    ranges   : {
                        'Today'       : [moment(), moment()],
                        'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month'  : [moment().startOf('month'), moment().endOf('month')],
                        'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate  : moment()
                },
                function (start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //iCheck for checkbox and radio inputs
            $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass   : 'iradio_minimal-blue'
            })
            //Red color scheme for iCheck
            $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
                checkboxClass: 'icheckbox_minimal-red',
                radioClass   : 'iradio_minimal-red'
            })
            //Flat red color scheme for iCheck
            $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass   : 'iradio_flat-green'
            })

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            //Timepicker
            $('.timepicker').timepicker({
                showInputs: false
            })
        })
    </script>

    <script>
        $(function () {
            $("#tableusers").DataTable();
//            $('#tableusers').DataTable({
//                "paging": true,
//                "lengthChange": false,
//                "searching": false,
//                "ordering": true,
//                "info": true,
//                "autoWidth": false
//            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){

            // Format mata uang.

            $( '.uang' ).mask('000.000.000.000.000.000.000', {reverse: true});

        });
    </script>
@endsection
