<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">NORTHERN</a>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
          <!-- Authentication Links -->
          @if (Auth::guest())
              <li><a href="{{ url('login') }}">Login</a></li>
              {{-- <li><a href="#">Register</a></li> --}}
          @else
              <li><a href="#">{{ $user->username }}</a></li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                      {{ Auth::user()->name }} <span class="caret"></span>
                  </a>

                  <ul class="dropdown-menu" role="menu">
                      <li>
                          <a href="{{ url('logout') }}"
                              {{-- onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();" --}}>
                              Logout
                          </a>

                          {{-- <form id="logout-form" action="#" method="POST" style="display: none;">
                              {{ csrf_field() }}
                          </form> --}}
                      </li>
                  </ul>
              </li>
          @endif
      </ul>
    </div>
  </div>
</nav>