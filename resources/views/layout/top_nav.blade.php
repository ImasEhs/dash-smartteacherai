<!-- Navbar -->
<div class="navbar-custom" style="margin-left: 0;">
  <div class="topbar container-fluid d-flex align-items-center justify-content-between">

<!-- Brand -->
<div class="d-flex align-items-center gap-2">
  <!-- Toggle button for mobile -->
  <button class="btn btn-primary d-lg-none button-toggle-menu" id="sidebarToggle">
    <i class="bi bi-list"></i>
  </button>

  <a href="{{ route('dashboard') }}" class="logo logo-dark text-decoration-none">
    <div class="brand">SMARTEACHER <span>AI</span></div>
  </a>
</div>

    <input type="text" class="form-control w-50 d-none d-md-block" placeholder="Cari konten pembelajaran">

    <!-- Right Menu -->
    <ul class="topbar-menu d-flex align-items-center gap-3">

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="account-user-avatar">
                                @if(isset($user) && $user->avatar)
                                    <img src="{{ URL::asset($user->avatar) }}" alt="user-image" width="32" height="32" class="rounded-circle" style="object-fit: cover;">
                                @else
                                    <img src="{{ URL::asset('assets/images/users/avatar-1.jpg') }}" alt="user-image" width="32" height="32" class="rounded-circle" style="object-fit: cover;">
                                @endif
                            </span>
                            <span class="d-lg-flex flex-column gap-1 d-none">
                                <h5 class="my-0">{{ Session::get('name') }}</h5>
                                <h6 class="my-0 fw-normal">{{ Session::get('role') }}</h6>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                            <!-- item-->
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>


                            <!-- item-->
                            <a href="{{ route('logout') }}" class="dropdown-item">
                                <i class="mdi mdi-logout me-1"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-notification-3-line font-22"></i>
                            @if(isset($notifications) && $notifications->count() > 0)
                                <span class="noti-icon-badge"></span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                            <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 font-16 fw-semibold"> Notifikasi</h6>
                                    </div>
                                    @if(isset($notifications) && $notifications->count() > 0)
                                    <div class="col-auto">
                                        <span class="badge bg-danger rounded-pill">{{ $notifications->count() }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="px-2" style="max-height: 300px; overflow-y: auto;" data-simplebar>

                                @if(isset($notifications) && $notifications->count() > 0)
                                    @foreach($notifications as $notif)
                                        <a href="{{ $notif['link'] }}" class="dropdown-item p-0 notify-item card read-noti shadow-none mb-2 mt-2">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <div class="notify-icon bg-primary-light text-primary">
                                                            <i class="{{ $notif['icon'] ?? 'ri-notification-3-line' }} font-22"></i>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 text-truncate ms-2">
                                                        <h5 class="noti-item-title fw-semibold font-14">{{ $notif['title'] }} <small class="fw-normal text-muted ms-1">{{ $notif['time'] }}</small></h5>
                                                        <small class="noti-item-subtitle text-muted" style="white-space: normal;">{{ $notif['message'] }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="text-center p-3 text-muted">
                                        <i class="ri-notification-off-line font-24"></i>
                                        <p class="mb-0 mt-2">Belum ada notifikasi baru.</p>
                                    </div>
                                @endif
                                
                            </div>

                        </div>
                    </li>
                </ul>
  </div>
</div>