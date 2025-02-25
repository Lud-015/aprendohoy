<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>
    @yield('titulo')
  </title>
  <!-- Favicon -->
  <link href="{{asset('../assets/img/brand/favicon.png')}}" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="{{asset('../assets/js/plugins/nucleo/css/nucleo.css')}}" rel="stylesheet" />
  <link href="{{asset('../assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css')}}" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="{{asset('../assets/css/argon-dashboard.css?v=1.1.2')}}" rel="stylesheet" />
</head>

<body class="">

  <div class="main-content">
    <!-- Navbar -->

    <!-- End Navbar -->
    <!-- Header -->
    <div class="header pb-2 pt-2 pt-lg-2 d-flex align-items-center" style="min-height: 350px; background-image: url(../assets/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
      <!-- Mask -->

      <!-- Header container -->

    </div>
    <!-- Page content -->
    <div class="container-fluid mt--7">
      <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
          <div class="card card-profile shadow">
            <div class="row justify-content-center">
              <div class="col-lg-3 order-lg-2">
                <div class="card-profile-image">
                    @yield('avatar')
                </div>
              </div>
            </div>
            <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
              {{-- <div class="d-flex justify-content-between">
                <a href="#" class="btn btn-sm btn-info mr-4">Connect</a>
                <a href="#" class="btn btn-sm btn-default float-right">Message</a>
              </div> --}}
            </div>
            <div class="card-body pt-0 pt-md-4">
                @yield('contentPerfil')
            </div>
          </div>
        </div>
        <div class="col-xl-8 order-xl-1">
          @yield('content')
        </div>
      </div>
      <!-- Footer -->

    </div>
  </div>
  <!--   Core   -->
  <script src="{{asset('../assets/js/plugins/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('../assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <!--   Optional JS   -->
  <!--   Argon JS   -->
  <script src="{{asset('../assets/js/argon-dashboard.min.js?v=1.1.2')}}"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });
  </script>

  @include('botman.tinker')
</body>
</html>
