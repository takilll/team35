<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Sidebar -->
  <div class="sidebar os-host os-theme-light os-host-resize-disabled os-host-scrollbar-horizontal-hidden os-host-scrollbar-vertical-hidden os-host-transition">
    <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 100vh;">
      <div class="os-padding">
        <div class="os-viewport os-viewport-native-scrollbars-invisible">
          <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                <img src="/img/hobbys2.png" class="img-circle elevation-2" alt="User Image">
              </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-item menu-open">
                  <a href="{{route('hobby.list')}}" class="nav-link active">
                    <p>ホーム</p>
                  </a>
                  <a href="{{route('hobby.regist')}}" class="nav-link active">
                    <p>趣味新規登録</p>
                  </a>
                  <a href="{{route('user_mypage')}}" class="nav-link active">
                  <!-- {{-- <a href="{{ route('user_mypage', ['id'=> $user->id]) }}" class="nav-link active"> --}} -->
                    <p>My投稿一覧画面</p>
                  </a>
                  <a href="{{route('user_edit')}}" class="nav-link active" name="user_edit">
                  <!-- {{-- <a href="{{ route('user_edit', ['id'=> $user->id]) }}" class="nav-link active" name="user_edit"> --}} -->
                    <p>ユーザー変更画面</p>
                  </a>
                </li>
              </ul>
            </nav>
            <!-- /.sidebar-menu -->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="test3">
    <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{url('logout')}}" class="nav-link active logout">
              <p>ログアウト</p>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <!-- /.sidebar -->
</aside>