@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">
                        <i class="fa fa-user-plus nav-icon"></i>
                        Create an Advertiser
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
                                <p>Create Advertiser Success.</p>
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
                            <h3 class="card-title">Create an Advertiser</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post"
                              enctype="multipart/form-data"
                              action="{{ url(action('PageAdsController@submit_advertiser')) }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="username">Username
                                        Advertiser/Institute*
                                    </label>
                                    <input required type="text"
                                           id="username"
                                           name="username"
                                           class="form-control"
                                           placeholder="Input Username">
                                </div>
                                <div class="form-group">
                                    <label for="email_ads">E-mail
                                        Advertiser/Institute*</label>
                                    <input required type="email"
                                           id="email_ads"
                                           name="email_ads"
                                           class="form-control"
                                           placeholder="Input Email Advertiser">
                                </div>
                                <div class="form-group">
                                    <label for="password">Password*</label>
                                    <input required type="password"
                                           id="password"
                                           name="password"
                                           class="form-control"
                                           placeholder="Input Password">
                                </div>
                                <div class="form-group">
                                    <label for="advertiser_name">Advertiser /
                                        Institute Name*</label>
                                    <input required type="text"
                                           id="advertiser_name"
                                           name="advertiser_name"
                                           class="form-control"
                                           placeholder="Input Full Name">
                                </div>
                                <div class="form-group">
                                    <label for="role">Role*</label>
                                    <br/>
                                    <div class="form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="role"
                                               id="advertiser" value="advertiser">
                                        <label class="form-check-label" for="advertiser">
                                            Advertiser
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="photo"
                                           class="control-label">
                                        Photo Profile Advertiser / Institute*
                                    </label>

                                    <input required type="file"
                                           class="form-control"
                                           id="photo"
                                           name="photo" placeholder="Photo">

                                </div>

                                <div class="form-group">
                                    <label for="editor1">
                                        About Advertiser / Institute
                                    </label>
                                    <textarea required id="editor1"
                                              name="advertiser_desc">
                                        Tell description about the advertiser...
                                        .
                                        .
                                        .
                                        .
                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="kuota">
                                        Kuota Ads Content*
                                    </label>
                                    <input required type="number"
                                           id="kuota"
                                           name="kuota"
                                           class="form-control"
                                           placeholder="Input Kuota Ads Content">
                                </div>

                                <hr style="background-color: blue;"/>

                                <div class="form-group">
                                    <label for="fullname">
                                        Name of PIC*</label>
                                    <input required type="text"
                                           id="fullname"
                                           name="fullname"
                                           class="form-control"
                                           placeholder="Input Full Name">
                                </div>

                                <div class="form-group">
                                    <label for="email_pic">E-mail PIC*</label>
                                    <input required type="email"
                                           id="email_pic"
                                           name="email_pic"
                                           class="form-control"
                                           placeholder="Input Email of PIC">
                                </div>

                                <div class="form-group">
                                    <label for="no_hp">No HP PIC*</label>
                                    <input required type="text"
                                           id="no_hp"
                                           name="no_hp"
                                           class="form-control"
                                           placeholder="Input No HP of PIC">
                                </div>

                                <div class="form-group">
                                    <label for="birthdate">
                                        Birth Date PIC
                                    </label>
                                    <div class="input-group date mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="birthdate"
                                               {{--value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"--}}
                                               class="form-control"
                                               placeholder="Input Birth Date"
                                               id="datepicker1">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="birthplace">
                                        Birth Place PIC
                                    </label>
                                    <input type="text"
                                           id="birthplace"
                                           name="birthplace"
                                           class="form-control"
                                           placeholder="Input Birth Place">
                                </div>
                                <div class="form-group">
                                    <label for="gender">
                                        Gender PIC
                                    </label>
                                    <br/>
                                    <div class="form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="gender"
                                               id="male" value="male">
                                        <label class="form-check-label"
                                               for="male">
                                            Male
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="gender"
                                               id="female" value="female">
                                        <label class="form-check-label"
                                               for="female">
                                            Female
                                        </label>
                                    </div>

                                </div>

                                <hr style="background-color: blue;"/>

                                <div class="form-group">
                                    <label for="link">Link URL Profile
                                        of Advertiser / Institute</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-link"></i>
                                            </span>
                                        </div>
                                        <input type="text"
                                               id="link"
                                               name="link"
                                               class="form-control"
                                               placeholder="Input Link">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="link">Instagram Link</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-instagram"></i>
                                            </span>
                                        </div>
                                        <input type="text"
                                               class="form-control"
                                               name="instagram"
                                               placeholder="Input Instagram Link">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="link">Twitter Link</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-twitter"></i>
                                            </span>
                                        </div>
                                        <input type="text"
                                               class="form-control"
                                               name="twitter"
                                               placeholder="Input Twitter Link">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="link">Facebook Link</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-facebook"></i>
                                            </span>
                                        </div>
                                        <input type="text"
                                               class="form-control"
                                               name="facebook"
                                               placeholder="Input Facebook Link">
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
@endsection
