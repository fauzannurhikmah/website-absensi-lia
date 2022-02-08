<div class="main-sidebar">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="#">GE Tech</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="#">GE</a>
      </div>
      <ul class="sidebar-menu">
          <li class="menu-header">Dashboard</li>
          <li class="{{request()->routeIs('dashboard') ? 'active' :'' }}"><a class="nav-link" href="{{route('dashboard')}}"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>
          <li class="menu-header">Starter</li>
          @can('view', auth()->user())
            <li class="{{request()->routeIs('user') || request()->routeIs('create-user') || request()->routeIs('edit-user')  ? 'active' :''}}"><a class="nav-link" href="{{route('user')}}"><i class="fas fa-user-cog"></i> <span>User</span></a></li>
            {{-- <li class="{{request()->routeIs('employee') ? 'active' :''}}"><a class="nav-link" href="{{route('employee')}}"><i class="far fa-square"></i> <span>Employee</span></a></li> --}}
            <li class="{{request()->routeIs('position') ? 'active' :''}}"> <a href="{{route('position')}}" class="nav-link"><i class="fas fa-th"></i> <span>Position</span></a> </li>
          @endcan
          <li class="{{request()->routeIs('attendance') ? 'active' :''}}"> <a href="{{route('attendance')}}" class="nav-link"><i class="far fa-file-alt"></i> <span>Attendance</span></a> </li>
        </ul>
    </aside>
  </div>