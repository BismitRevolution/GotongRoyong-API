@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">
                        <i class="fa fa-plus-circle nav-icon"></i>
                        Create an Ads Content
                    </h1>
                </div><!-- /.col -->

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
                                <p>Create Ads Content Success.</p>
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

                <div class="col-lg-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create an Ads Content</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post"
                              enctype="multipart/form-data"
                              action="{{ url(action('PageAdsController@submit_content')) }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="title_ads">
                                        Title Ads Content*
                                    </label>
                                    <input required type="text"
                                           id="title_ads"
                                           name="title_ads"
                                           class="form-control"
                                           placeholder="Input Title Ads Content">
                                </div>
                                <div class="form-group">
                                    <label for="campaigner">Advertiser*</label>
                                    <select required name="id_advertiser"
                                            class="form-control select-data">
                                        <option value="0">
                                            Select an Advertiser
                                        </option>
                                        @foreach ($data_advertisers as $data)
                                            <option value="{{ $data->id }}">
                                                {{ $data->advertiser_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="target_url">Target Ads URL</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-link"></i>
                                            </span>
                                        </div>
                                        <input type="text"
                                               id="target_url"
                                               name="target_url"
                                               class="form-control"
                                               placeholder="Input Target URL">
                                    </div>
                                </div>



                                <div class="form-group">
                                    <label for="ads_content"
                                           class="control-label">
                                        Ads Content (Video/Image)*
                                    </label>

                                    <input required type="file"
                                           class="form-control"
                                           id="ads_content"
                                           name="ads_content"
                                           placeholder="Ads Content">
                                </div>


                                <div class="form-group">
                                    <label for="bg_img"
                                           class="control-label">
                                        Background Image Ads Content
                                    </label>

                                    <input type="file"
                                           class="form-control"
                                           id="bg_img"
                                           name="bg_img"
                                           placeholder="Background Image">
                                </div>

                                <div class="form-group">
                                    <label for="logo_ads"
                                           class="control-label">
                                        Logo Ads*
                                    </label>

                                    <input required type="file"
                                           class="form-control"
                                           id="logo_ads"
                                           name="logo_ads"
                                           placeholder="Logo Advertising/er">
                                </div>

                                <div class="form-group">
                                    <label for="category">
                                        Ads Category*
                                    </label>
                                    <br/>
                                    <div class="form-check-inline">
                                        <input required class="form-check-input"
                                               type="radio"
                                               name="category"
                                               id="image" value="0">
                                        <label class="form-check-label"
                                               for="image">
                                            Image
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="category"
                                               id="video" value="1">
                                        <label class="form-check-label"
                                               for="video">
                                            Video
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="duration">Duration*</label>
                                    <div class="input-group date mb-3">
                                        <input required type="number"
                                               id="duration"
                                               name="duration"
                                               class="form-control"
                                               placeholder="Input Duration">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-clock-o">
                                                    in seconds
                                                </i>
                                            </span>
                                        </div>
                                    </div>
                                </div>


                                <hr/>

                                <div class="form-group">
                                    <label for="editor1">Ads Description</label>
                                    <textarea id="editor1" name="description">
                                        Tell description about the ads content...
                                        .
                                        .
                                        .
                                        .
                                    </textarea>
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
@endsection
