<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="#" class="img-circle elevation-2" alt="#">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        {{-- Dashboard --}}
        <li class="nav-item">
          <a href="{{ route('dashboard')}}" class="nav-link {{request()->routeIs('dashboard') ? 'active' : ''}}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              {{__('message.Dashboard')}}
            </p>
          </a>
        </li>
        {{-- Role --}}
        <li class="nav-item {{request()->routeIs('roles.*') ? 'menu-open' : ''}}">
          <a href="#" class="nav-link {{request()->routeIs('roles.*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-user-tag"></i>
            <p>
              {{__('message.Role')}}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('roles.index')}}" class="nav-link {{request()->routeIs('roles.index') ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('message.List')}}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('roles.create')}}" class="nav-link {{request()->routeIs('roles.create') ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('message.Create')}}</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- Department --}}
        <li class="nav-item {{request()->routeIs('departments.*') ? 'menu-open' : ''}}">
          <a href="#" class="nav-link {{request()->routeIs('departments.*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              {{__('message.Department')}}
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('departments.index')}}" class="nav-link {{request()->routeIs('departments.index') ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('message.List')}}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('departments.create')}}" class="nav-link {{request()->routeIs('departments.create') ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('message.Create')}}</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- Subject --}}
        <li class="nav-item {{request()->routeIs('subjects.*') ? 'menu-open' : ''}}">
          <a href="#" class="nav-link {{request()->routeIs('subjects.*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Subject
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('subjects.index')}}" class="nav-link {{request()->routeIs('subjects.index') ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('message.List')}}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('subjects.create')}}" class="nav-link {{request()->routeIs('subjects.create') ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('message.Create')}}</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- Student --}}
        <li class="nav-item {{request()->routeIs('students.*') ? 'menu-open' : ''}}">
          <a href="#" class="nav-link {{request()->routeIs('students.*') ? 'active' : ''}}">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Student
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('students.index')}}" class="nav-link {{request()->routeIs('students.index') ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('message.List')}}</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('students.create')}}" class="nav-link {{request()->routeIs('students.create') ? 'active' : ''}}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{__('message.Create')}}</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- Logout --}}
        <li class="nav-item">
          <a href="{{route('logout')}}" onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                  {{__('message.Logout')}}
              </p>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
          </a>
      </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>