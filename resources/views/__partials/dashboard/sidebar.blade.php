 <div class="app-menu navbar-menu">
     <!-- LOGO -->
     <div class="navbar-brand-box">
         <!-- Dark Logo-->
         <a href="{{ route('dashboard.index') }}" class="logo logo-dark">
             <span class="logo-sm">
                 <x-img src="dashboard/assets/images/logo-sm.png" alt="" height="22" />
             </span>
             <span class="logo-lg">
                 <x-img src="dashboard/assets/images/logo-dark.png" alt="" height="17" />
             </span>
         </a>
         <!-- Light Logo-->
         <a href="{{ route('dashboard.index') }}" class="logo logo-light">
             <span class="logo-sm">
                 <x-img src="dashboard/assets/images/logo-sm.png" alt="" height="22" />
             </span>
             <span class="logo-lg">
                 <x-img src="dashboard/assets/images/logo-light.png" alt="" height="17" />
             </span>
         </a>
         <button type="button" class="btn btn-sm fs-20 header-item btn-vertical-sm-hover float-end p-0"
             id="vertical-hover">
             <i class="ri-record-circle-line"></i>
         </button>
     </div>

     <div class="dropdown sidebar-user m-1 rounded">
         <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown"
             data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
             <span class="d-flex align-items-center gap-2">
                 <x-img class="header-profile-user rounded" src="dashboard/assets/images/users/avatar-1.jpg"
                     alt="Header Avatar" />
                 <span class="text-start">
                     <span class="d-block fw-medium sidebar-user-name-text">Anna Adame</span>
                     <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                             class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                             class="align-middle">Online</span></span>
                 </span>
             </span>
         </button>
         <div class="dropdown-menu dropdown-menu-end">
             <!-- item-->
             <h6 class="dropdown-header">Welcome Anna!</h6>
             <a class="dropdown-item" href="pages-profile.html"><i
                     class="mdi mdi-account-circle text-muted fs-16 me-1 align-middle"></i> <span
                     class="align-middle">Profile</span></a>
             <a class="dropdown-item" href="apps-chat.html"><i
                     class="mdi mdi-message-text-outline text-muted fs-16 me-1 align-middle"></i> <span
                     class="align-middle">Messages</span></a>
             <a class="dropdown-item" href="apps-tasks-kanban.html"><i
                     class="mdi mdi-calendar-check-outline text-muted fs-16 me-1 align-middle"></i> <span
                     class="align-middle">Taskboard</span></a>
             <a class="dropdown-item" href="pages-faqs.html"><i
                     class="mdi mdi-lifebuoy text-muted fs-16 me-1 align-middle"></i> <span
                     class="align-middle">Help</span></a>
             <div class="dropdown-divider"></div>
             <a class="dropdown-item" href="pages-profile.html"><i
                     class="mdi mdi-wallet text-muted fs-16 me-1 align-middle"></i> <span class="align-middle">Balance :
                     <b>$5971.67</b></span></a>
             <a class="dropdown-item" href="pages-profile-settings.html"><span
                     class="badge bg-success-subtle text-success float-end mt-1">New</span><i
                     class="mdi mdi-cog-outline text-muted fs-16 me-1 align-middle"></i> <span
                     class="align-middle">Settings</span></a>
             <a class="dropdown-item" href="auth-lockscreen-basic.html"><i
                     class="mdi mdi-lock text-muted fs-16 me-1 align-middle"></i> <span class="align-middle">Lock
                     screen</span></a>
             <a class="dropdown-item" href="auth-logout-basic.html"><i
                     class="mdi mdi-logout text-muted fs-16 me-1 align-middle"></i> <span class="align-middle"
                     data-key="t-logout">Logout</span></a>
         </div>
     </div>
     <div id="scrollbar">
         <div class="container-fluid">

             <div id="two-column-menu">
             </div>
             <ul class="navbar-nav" id="navbar-nav">
                 <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="{{ route('dashboard.index') }}">
                         <i class="ri-pie-chart-box-line"></i> <span>Dashboard</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="{{ route('dashboard.userBehavior') }}">
                         <i class="ri-user-line"></i> <span>User Behavior</span>
                     </a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link menu-link" href="{{ route('dashboard.analyzeErrorLogs') }}">
                         <i class="ri-bug-line"></i> <span>Error Logs</span>
                     </a>
                 </li>
             </ul>
         </div>
         <!-- Sidebar -->
     </div>

     <div class="sidebar-background"></div>
 </div>
