<!DOCTYPE html>
<html>
@include('layouts._head')

@yield('extra_style')
<body>
  @include('layouts._script')

  @yield('extra_script')

	<div class="background-loading">
	  {{-- ..Loading.. --}}
	  <div id="loader"></div>
	</div>

	<div class="main-wrapper">
    <div class="app" id="app">
    	@include('layouts._sidebar')

    	@yield('content')

    	@include('layouts._footer')
    </div>
  </div>

</body>
</html>