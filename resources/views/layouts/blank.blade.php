<!doctype html>
<html>
<head>@include('includes.head')

  @yield('stylesheets')
</head>
<body>
        
    <div class="wrapper">
        <div class="sidebar"  data-background-color="brown" data-active-color="info">@include('includes.sidebar')</div>
            <div class="main-panel">


            @include('includes.header')
            <div class="content">
                 @yield('main_container')
            </div>

            <footer class="footer">
              @include('includes.footer')
            </footer>
        </div>

    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content load_modal">
                      
            </div>
        </div>
    </div>
</body>


 <!--   Core JS Files   -->
 <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('js/jquery-ui.js') }}"></script>
	<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>

	<!--  Checkbox, Radio & Switch Plugins -->
	<script src="{{ asset('js/bootstrap-checkbox-radio.js') }}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>


	<!--  Charts Plugin -->
	  <script src="{{ asset('js/chartist.min.js') }}"></script>

    <!--  Notifications Plugin    -->
    <script src="{{ asset('js/bootstrap-notify.js') }}"></script>

    <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
	<script src="{{ asset('js/paper-dashboard.js') }}"></script>



  @yield('scripts')


<script>
        
      @if (session('msg'))
          $.notify({
              icon: 'ti-check',
              message: "{{ session('msg') }}"

          },{
              type: 'info',
              timer: 4000
          });
      @endif

</script>
</html>
