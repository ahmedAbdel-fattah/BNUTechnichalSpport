<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href="{{ url('/dashboard') }}"><img src="{{ URL::asset('assets/img/brand/logo.png') }}" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href="{{ url('/dashboard') }}"><img src="{{ URL::asset('assets/img/brand/logo-white.png') }}" class="main-logo dark-theme" alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <div class="">
                    <img alt="user-img" class="avatar avatar-xl brround"
                    src="{{ auth()->user()->profile_image ? asset('uploads/profile_images/' . auth()->user()->profile_image) : asset('assets/img/faces/6.jpg') }}">

                        </div>
                <div class="user-info">
                    <h4 class="font-weight-semibold mt-3 mb-0">{{ Auth::user()->name }}</h4>
                    <span class="mb-0 text-muted">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>
        <ul class="side-menu">
            <li class="side-item side-item-category">النظام</li>
            <li class="slide">
                <a class="side-menu__item" href="{{ url('/dashboard') }}"><span class="side-menu__label">الرئيسية</span></a>
            </li>

            @can('view tickets')
                <li class="side-item side-item-category">التذاكر</li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/tickets') }}"><span class="side-menu__label">قائمة التذاكر</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/tickets/create') }}"><span class="side-menu__label">إنشاء تذكرة جديدة</span></a>
                </li>
            @endcan

            @can('view reports')
                <li class="side-item side-item-category">التقارير</li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/reports') }}"><span class="side-menu__label">تقارير التذاكر</span></a>
                </li>
            @endcan

              @can('view settings')
              <li class="side-item side-item-category">الإعدادات</li>
              <li class="slide">
                  <a class="side-menu__item" href="{{ url('/departments') }}"><span class="side-menu__label">إدارة الأقسام</span></a>
              </li>
              <li class="slide">
                  <a class="side-menu__item" href="{{ url('/categories') }}"><span class="side-menu__label">إعدادات الفئات</span></a>
              </li>
          @endcan

            @can('view users')
                <li class="side-item side-item-category">إدارة المستخدمين</li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/users') }}"><span class="side-menu__label">قائمة المستخدمين</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ url('/roles') }}"><span class="side-menu__label">صلاحيات المستخدمين</span></a>
                </li>
            @endcan


        </ul>
    </div>
</aside>
<!-- main-sidebar -->
