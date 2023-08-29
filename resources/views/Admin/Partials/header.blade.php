<?php

use App\Models\AdminNotification;

function getNotification(){
    $noti = AdminNotification::orderBy('id','Desc')->get();
    return $noti;
}

function NotificationCount(){
    $count = AdminNotification::where('is_seen','=',0)->count();
    return $count;
}
?>


<div id="layoutSidenav_content">
    <main>
        <nav class="sb-topnav navbar navbar-expand bg-white justify-content-between ps-4">
            <a class="d-block d-md-none order-1 order-lg-0 me-4 me-lg-0 text-dark bg-transparent" id="sidebarToggle" href="#!"><i
                    class="material-icons">
                    subject
                </i></a>
            <div class="logo-sm ">
                <img src="{{asset('panel/assets/images/logo.png')}}" alt="">
            </div>
            <ul class="navbar-nav ms-auto ms-md-0 me-3 align-items-center">

                <li class="nav-item dropdown profile">
                    <a class="nav-link dropdown-toggle caret-none d-flex align-items-center gap-2" id="navbarDropdown"
                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <img
                            src="{{asset('panel/assets/images/avatar.svg')}}" alt="">
                        <div>
                            <h6 class="font-weight-700 m-0">@if(Session::has('admin')){{Session::get('admin')['fullname']}}@endif</h6>
                            <small class="text-muted">visit profile</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{route('admin.profile.index')}}">
                                <div class="cover-profile-dropdown d-flex align-items-center gap-2">
                                    <img src="{{asset('panel/assets/images/icons/edit.svg')}}" alt="">
                                    <p>Edit Profile</p>
                                </div>
                            </a>
                        </li>
                        <li>
                              <a class="dropdown-item" href="{{route('admin.logout')}}">
                                <div class="cover-profile-dropdown d-flex align-items-center gap-2">
                                    <img src="{{asset('panel/assets/images/icons/logout.svg')}}" alt="">
                                    <p>logout</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                
                
                <li class="nav-item dropdown bell position-relative">
                    
                <a href="#" class="nav-link dropdown-toggle caret-none" data-bs-toggle="dropdown" role="button" id="navbarDropdown" aria-expanded="false">
                    <div style="    display: flex;
    align-items: center;
    gap: 5px;">
                        <i class="bi bi-bell-fill font-19px font-md-21px"></i>
                    ({{NotificationCount()}})
                    </div>
                    </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <div>
                    Notifications
                    <!--<a href="#." class="secondary-anchor">Mark all as read</a>-->
                  </div>
                  <div class="cover-notifications">
                      @foreach(getNotification() as $noti)
                      <li>
                      <a href="{{route('admin.isseen',$noti->id)}}" class="dropdown-item {{$noti->is_seen == 0 ? 'active' : '' }}">
                        <div class="inner-notification">
                          <h6>{{$noti->title}}</h6>
                          <p>New signup request received from {{$noti->pharmacy_name}}</p>
                          <p>{{ \Carbon\Carbon::parse($noti->created_at)->addHours(4)->diffForHumans() }}</p>
                        </div>
                      </a>
                    </li>
                      @endforeach
                    
                  
                  </div>
                </ul>
              </li>
            </ul>
        </nav>
