@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0 text-dark">
                        <a href="{{ url(action('PageUserNGOController@list_user')) }}">
                            <i class="fa fa-arrow-circle-left nav-icon"></i>
                        </a>
                        Edit a NGO / Verified User
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
                                <p>Edit User Success.</p>
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
                            <h3 class="card-title">Edit a NGO/Verified User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" method="post"
                              enctype="multipart/form-data"
                              action="{{ url(action('PageUserNGOController@update')) }}">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="username">Username*</label>
                                    <input required type="text"
                                           id="username"
                                           name="username"
                                           class="form-control"
                                           value="{{ $data_user->username }}"
                                           placeholder="Input Username">

                                    <input hidden type="text"
                                           id="id_user"
                                           name="id_user"
                                           value="{{ $data_user->id_user }}">
                                </div>
                                <div class="form-group">
                                    <label for="email">E-mail*</label>
                                    <input required type="email"
                                           id="email"
                                           name="email"
                                           class="form-control"
                                           value="{{ $data_user->email }}"
                                           placeholder="Input Email">
                                </div>
                                <div class="form-group">
                                    <label for="password">
                                        Password
                                    </label>
                                    <input type="password"
                                           id="password"
                                           name="password"
                                           class="form-control"
                                           placeholder="Input New Password">
                                    <p class="help-block">
                                        Leave password to use previous password.
                                    </p>
                                </div>
                                <div class="form-group">
                                    <label for="fullname">Full Name*</label>
                                    <input required type="text"
                                           id="fullname"
                                           name="fullname"
                                           class="form-control"
                                           value="{{ $data_user->fullname }}"
                                           placeholder="Input Full Name">
                                </div>
                                <div class="form-group">
                                    <label for="role">Role*</label>
                                    <br/>
                                    <div class="form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="role"
                                               @if($data_user->role == 1) checked @endif
                                               id="userpahlawan" value="userpahlawan">
                                        <label class="form-check-label" for="userpahlawan">
                                            User Pahlawan - NGO/Verified
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input required class="form-check-input"
                                               type="radio"
                                               name="role"
                                               @if($data_user->role == 2) checked @endif
                                               id="admin" value="admin">
                                        <label class="form-check-label" for="admin">
                                            Admin
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="role"
                                               @if($data_user->role == 3) checked @endif
                                               id="advertiser" value="advertiser">
                                        <label class="form-check-label" for="advertiser">
                                            Advertiser
                                        </label>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="birthdate">
                                        Birth Date
                                    </label>
                                    <div class="input-group date mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fa fa-calendar"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="birthdate"
                                               value="{{ \Carbon\Carbon::parse($data_user->birthdate)->format('Y-m-d') }}"
                                               class="form-control"
                                               placeholder="Input Birth Date"
                                               id="datepicker1">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="birthplace">Birth Place</label>
                                    <input type="text"
                                           id="birthplace"
                                           name="birthplace"
                                           value="{{ $data_user->birthplace }}"
                                           class="form-control"
                                           placeholder="Input Birth Place">
                                </div>
                                <div class="form-group">
                                    <label for="gender">Gender</label>
                                    <br/>
                                    <div class="form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="gender"
                                               @if($data_user->gender == 'male') checked @endif
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
                                               @if($data_user->gender == 'female') checked @endif
                                               id="female" value="female">
                                        <label class="form-check-label"
                                               for="female">
                                            Female
                                        </label>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label for="photo"
                                           class="control-label">
                                        Photo Profile
                                    </label>

                                    <input type="file"
                                           class="form-control"
                                           id="photo"
                                           name="photo" placeholder="Photo">

                                    <p class="help-block">
                                        (Previous Photo)
                                        <span>
                                        <a href="{{ URL::asset($data_user->image_profile) }}"
                                           target="_blank">
                                            <img src="{{ URL::asset($data_user->image_profile) }}"
                                                 class="brand-image"
                                            >
                                        </a>
                                            </span>
                                    </p>
                                    <p class="help-block">
                                        Upload new Photo to replace previous Photo
                                    </p>
                                </div>


                                <hr/>

                                <div class="form-group">
                                    <label for="about">About User</label>
                                    <textarea required id="about" name="about">
                                        Tell about the user..
                                    </textarea>
                                    <script>
                                        // Replace the <textarea id="editor1"> with a CKEditor
                                        // instance, using default configuration.
                                        CKEDITOR.replace( 'about' );
                                        CKEDITOR.instances.about.setData( '<p>This is the editor data.</p>' );
                                    </script>

                                </div>

                                <div class="form-group">
                                    <label for="link">Link URL</label>
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
                                               value="{{ $data_user->my_url }}"
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
                                               value="{{ $data_user->instagram_link }}"
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
                                               value="{{ $data_user->twitter_link }}"
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
                                               value="{{ $data_user->fb_link }}"
                                               placeholder="Input Facebook Link">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="flagverified">Verified User*</label>
                                    <br/>
                                    <div class="form-check-inline">
                                        <input required class="form-check-input"
                                               type="radio"
                                               name="flagverified"
                                               @if($data_user->flag_verified == 1) checked @endif
                                               id="verified" value="verified">
                                        <label class="form-check-label" for="verified">
                                            Verified
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="flagverified"
                                               @if($data_user->flag_verified == 0) checked @endif
                                               id="not" value="not">
                                        <label class="form-check-label" for="not">
                                            Not Verified
                                        </label>
                                    </div>
                                </div>


                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit"
                                        class="btn btn-primary btn-block">
                                    Update
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

    <!-- CK Editor -->
    <script src="{{ URL::asset('adminlte/plugins/ckeditor/ckeditor.js') }}"></script>

    <script>
        $(function () {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            ClassicEditor
                .create(document.querySelector('#about'))
                .then(function (editor) {
                    // The editor instance
                    $data = "{!!  $data_user->about_me  !!}";
                    //$data = '' +
//                        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rhoncus erat non ex tempor semper aliquam non felis. Integer et quam mi. Quisque at lacinia felis, nec suscipit purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut tempor orci non mauris venenatis, quis commodo lorem interdum. Duis placerat tincidunt velit, semper varius dui tempus non. Pellentesque dictum pulvinar diam in venenatis. Quisque blandit egestas dolor, nec elementum odio pellentesque sed. Curabitur dignissim elementum turpis. Aenean ornare viverra tempus. Ut ac dignissim nunc, in imperdiet libero. Maecenas rutrum nulla ac lobortis cursus.' +
//                        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rhoncus erat non ex tempor semper aliquam non felis. Integer et quam mi. Quisque at lacinia felis, nec suscipit purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut tempor orci non mauris venenatis, quis commodo lorem interdum. Duis placerat tincidunt velit, semper varius dui tempus non. Pellentesque dictum pulvinar diam in venenatis. Quisque blandit egestas dolor, nec elementum odio pellentesque sed. Curabitur dignissim elementum turpis. Aenean ornare viverra tempus. Ut ac dignissim nunc, in imperdiet libero. Maecenas rutrum nulla ac lobortis cursus.' +
//                        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rhoncus erat non ex tempor semper aliquam non felis. Integer et quam mi. Quisque at lacinia felis, nec suscipit purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut tempor orci non mauris venenatis, quis commodo lorem interdum. Duis placerat tincidunt velit, semper varius dui tempus non. Pellentesque dictum pulvinar diam in venenatis. Quisque blandit egestas dolor, nec elementum odio pellentesque sed. Curabitur dignissim elementum turpis. Aenean ornare viverra tempus. Ut ac dignissim nunc, in imperdiet libero. Maecenas rutrum nulla ac lobortis cursus.' +
//                        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris rhoncus erat non ex tempor semper aliquam non felis. Integer et quam mi. Quisque at lacinia felis, nec suscipit purus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut tempor orci non mauris venenatis, quis commodo lorem interdum. Duis placerat tincidunt velit, semper varius dui tempus non. Pellentesque dictum pulvinar diam in venenatis. Quisque blandit egestas dolor, nec elementum odio pellentesque sed. Curabitur dignissim elementum turpis. Aenean ornare viverra tempus. Ut ac dignissim nunc, in imperdiet libero. Maecenas rutrum nulla ac lobortis cursus.';

                    editor.setData("{!!  $data_user->about_me !!}");
                })
                .catch(function (error) {
                    console.error(error)
                })


            {{--CKEDITOR.instances.editor1.setData('{{ $data_user->about_me }}');--}}

            // bootstrap WYSIHTML5 - text editor

            $('.textarea').wysihtml5({
                toolbar: { fa: true }
            })
        })

    </script>

@endsection
