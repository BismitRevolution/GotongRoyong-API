@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fa fa-plus-circle nav-icon"></i>
                        Create a Campaign
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
                @if(Session::get('submit_create_success'))
                    <div class="col-lg-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <p>
                                    {{ Session::get('submit_create_success') }}
                                </p>
                                <p>Create User Success.</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-user-plus"></i>
                            </div>
                            <p class="small-box-footer">
                                -----
                            </p>
                        </div>
                    </div>
                @endif

                <div class="col-lg-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create a Campaign</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post"
                              enctype="multipart/form-data"
                              action="{{ url(action('PageCampaignsController@submit_create')) }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title">Title Campaign*</label>
                                    <input required type="text"
                                           id="title"
                                           name="title"
                                           class="form-control"
                                           placeholder="Input Title Campaign">
                                </div>
                                <div class="form-group">
                                    <label for="campaigner">Campaigner*</label>
                                    <select required name="campaigner"
                                            class="form-control select-data">
                                        <option value="0">
                                            Select a Campaigner
                                        </option>
                                        @foreach ($data_users as $data)
                                            <option value="{{ $data->id_user }}">
                                                {{ $data->fullname }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="editor1">Description*</label>
                                    <textarea required id="editor1"
                                              name="description">
                                        Tell description about the campaign...
                                        .
                                        .
                                        .
                                        .
                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="target">
                                        Target Donation*
                                    </label>
                                    <input required type="text"
                                           id="target"
                                           name="target"
                                           class="form-control uang"
                                           placeholder="Input Target Donation">
                                </div>
                                <div class="form-group">
                                    <label for="deadline">
                                        Campaign Deadline*
                                    </label>
                                    <div class="input-group date mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="text"

                                               name="deadline"
                                               value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                               class="form-control"
                                               placeholder="Input Deadline"
                                               id="deadline">

                                    <input type="text"

                                           name="created_at"
                                           value="{{ \Carbon\Carbon::now() }}"
                                           hidden>
                                    <input type="text"

                                           name="updated_at"
                                           value="{{ \Carbon\Carbon::now() }}"
                                           hidden>



                                    </div>
                                </div>

                                <hr/>

                                <div class="form-group" id="dynamic_field">
                                    <label for="photo"
                                           class="control-label">
                                        Campaign Image
                                    </label>

                                    <div class="row">
                                        <div class="col-lg-8">
                                            <input required type="file" class="form-control"
                                                   id="photo"
                                                   name="photo[]" placeholder="Photo">
                                        </div>
                                        <div class="col-lg-4">
                                            <button type="button"
                                                    class="btn btn-success">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-lg-6">
                                        <button type="button" name="add"
                                                id="add"
                                                class="btn btn-success
                                                btn-block btn-sm">
                                            <i class="fa fa-plus-circle"></i>
                                            add more campaign image
                                        </button>
                                    </div>
                                </div>


                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit"
                                        class="btn btn-primary btn-block">
                                    Submit
                                </button>
                            </div>
                        </form>
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

    <!-- CK Editor -->
    <script src="{{ URL::asset('adminlte/plugins/ckeditor/ckeditor.js') }}"></script>

    <script>
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            ClassicEditor
                .create(document.querySelector('#editor1'))
                .then(function (editor) {
                    // The editor instance
                })
                .catch(function (error) {
                    console.error(error)
                })

            // bootstrap WYSIHTML5 - text editor

            $('.textarea').wysihtml5({
                toolbar: { fa: true }
            })
        })
    </script>

    <script>
        //Date picker
        $('#deadline').datepicker({
            autoclose: true,
            todayHighlight : true,
            todayBtn : "linked",
            format : 'yyyy-mm-dd'
        });
        $('#datepicker1').datepicker({
            autoclose: true,
            todayHighlight : true,
            todayBtn : "linked",
            format : 'yyyy-mm-dd'
        });
        $('#datepicker2').datepicker({
            autoclose: true,
            todayHighlight : true,
            todayBtn : "linked",
            format : 'yyyy-mm-dd'
        });
        $('#datepicker3').datepicker({
            autoclose: true,
            todayHighlight : true,
            todayBtn : "linked",
            format : 'yyyy-mm-dd'
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select-data').select2();
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            var postURL = "<?php echo url('addmore'); ?>";
            var i=1;


            $('#add').click(function(){
                i++;
                $('#dynamic_field').append('' +
                    ' <div class="row" id="row'+i+'">'+
                    '<div class="col-lg-8">'+
                    '<input type="file" class="form-control"'+
                'name="photo[]" placeholder="Photo">'+
                    '</div>'+
                    '<div class="col-lg-4">'+
                    '<button type="button" name="remove" id="'+i+'"'+
                    'class="btn btn-danger btn_remove">X</button>'+
                    '</div>'+
                    '</div>'+
                    '');
                $('.select-data').select2();
                $( '.uang' ).mask('000.000.000', {reverse: true});
            });

            $(document).on('click', '.btn_remove', function(){
                var button_id = $(this).attr("id");
                $('#row'+button_id+'').remove();
            });


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('#submit').click(function(){
                $.ajax({
                    url:postURL,
                    method:"POST",
                    data:$('#add_name').serialize(),
                    type:'json',
                    success:function(data)
                    {
                        if(data.error){
                            printErrorMsg(data.error);
                        }else{
                            i=1;
                            $('.dynamic-added').remove();
                            $('#add_name')[0].reset();
                            $(".print-success-msg").find("ul").html('');
                            $(".print-success-msg").css('display','block');
                            $(".print-error-msg").css('display','none');
                            $(".print-success-msg").find("ul").append('<li>Record Inserted Successfully.</li>');
                        }
                    }
                });
            });


            function printErrorMsg (msg) {
                $(".print-error-msg").find("ul").html('');
                $(".print-error-msg").css('display','block');
                $(".print-success-msg").css('display','none');
                $.each( msg, function( key, value ) {
                    $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
                });
            }
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function(){

            // Format mata uang.

            $( '.uang' ).mask('000.000.000.000.000.000.000', {reverse: true});

        });
    </script>
@endsection
