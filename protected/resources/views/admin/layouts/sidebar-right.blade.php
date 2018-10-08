<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <h5>Rohmat Taufik</h5>
        <p>Admin</p>
        {{--<button type="button" onclick="window.location='/'" class="btn btn-danger">--}}
            {{--Logout--}}
        {{--</button>--}}

        <button type="button" class="btn btn-danger"
           onclick="event.preventDefault();
           document.getElementById('logout-form').submit();
        ">
            {{ __('Logout') }}
        </button>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</aside>
<!-- /.control-sidebar -->