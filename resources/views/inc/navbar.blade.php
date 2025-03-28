  <nav class="navbar navbar-light sticky-top bg-light flex-md-nowrap p-0 shadow navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="/">eLS</a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-3 mb-lg-2">

          @if (auth()->check())
            <br>
          @else
          <li class="nav-item dropdown bg-light shadow">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
              Create Account
            </a>
            <ul class="dropdown-menu shadow" aria-labelledby="navbarDropdown">
              <li><a class="dropdown-item" style="color: #000000;" href="login">Login</a></li>
              <li><a class="dropdown-item" style="color: #000000;" href="register">Register</a></li>
              <li><hr class="dropdown-divider" style="color: #000000;"></li>
              <li><a class="dropdown-item" style="color: #000000;" href="about">About</a></li>
              <li><a class="dropdown-item" style="color: #000000;" href="help">FAQ</a></li>
            </ul>
          </li>
          @endif
        </ul>
      </div>

      @if (auth()->check())
        <div class="d-flex flex-wrap flex-lg-nowrap">
          <div class="nav-item">
            <li class="nav-item dropdown bg-light shadow" style="list-style: none;">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
                {{ auth()->user()->role }} {{ auth()->user()->name }}
              </a>

              <ul class="dropdown-menu shadow" aria-labelledby="navbarDropdown" style="background-color: #fafafa;">
                @if (auth()->user()->role == 'parent')
                  <a href="/ParentDashboard" style="text-decoration: none;">
                    <button type="button" class="dropdown-item" style="color: #000000; text-decoration:none;">Dashboard</button>
                  </a>
                  <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item" style="color: #f50404;text-decoration:none;">Logout</button>
                  </form>
                @endif
                <br>

                @if (auth()->user()->role == 'teacher')
                  <a href="/TeacherDashboard" style="text-decoration: none;">
                    <button type="button" class="dropdown-item" style="color: #000000; text-decoration: none;">Dashboard</button>
                  </a>
                  <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item" style="color: #000000;text-decoration:none;">Logout</button>
                  </form>
                @endif

                <br>

                @if (auth()->user()->role == 'student')
                  <a href="/StudentDashboard" style="text-decoration: none;">
                    <button type="button" class="dropdown-item" style="color: #000000; text-decoration:none;">Dashboard</button>
                  </a>
                  <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item" style="color: #000000;text-decoration:none;">Logout</button>
                  </form>
                @endif
                <br>
              </ul>
            
            </li>
          </div>
        </div>
      @endif
    </div>
  </nav>

  <!-- Add the jQuery and Bootstrap JS files -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
 


  <script src="{{ asset('js/app.js') }}"></script>

