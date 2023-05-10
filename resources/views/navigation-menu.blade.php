    <!----======== CSS ======== -->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css' )}}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboardProfile.css' )}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" />
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <!--<img src="images/logo.png" alt="">-->
            </div>

            <span class="logo_name">YairAyala</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="#">
                        <i class="uil uil-estate"></i>
                        <span class="link-name">Dahsboard</span>
                    </a></li>
                <li><a href="#">
                        <i class="uil uil-files-landscapes"></i>
                        <span class="link-name">Content</span>
                    </a></li>
                <li><a href="#">
                        <i class="uil uil-chart"></i>
                        <span class="link-name">Analytics</span>
                    </a></li>
                <li><a href="#">
                        <i class="uil uil-thumbs-up"></i>
                        <span class="link-name">Like</span>
                    </a></li>
                <li><a href="#">
                        <i class="uil uil-comments"></i>
                        <span class="link-name">Comment</span>
                    </a></li>
                <li><a href="#">
                        <i class="uil uil-share"></i>
                        <span class="link-name">Share</span>
                    </a></li>
            </ul>

            <ul class="logout-mode">
                <li><a href="#">
                        <i class="uil uil-signout"></i>
                        <span class="link-name">Logout</span>
                    </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                        <span class="link-name">Dark Mode</span>
                    </a>

                    <div class="mode-toggle">
                        <span class="switch"></span>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>

            <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div>

            <img class="rounded-full h-12 w-12  object-cover" src="{{ Auth::user()->profile_photo_path }}" onclick="menuToggle();" alt="unsplash image">
            <div class="action">
                <!-- <div class="profile" onclick="menuToggle();">
                    <img src="{{ Auth::user()->profile_photo_path }}" />
                </div> -->
                <div class="menu">
                    <h3>{{ Auth::user()->name }}<br /><span>admin</span></h3>
                    <ul>
                        <li>
                            <img src="{{ asset('assets/icons/user.png' )}}" /><a href="{{ route('profile.show') }}">My profile</a>
                        </li>
                        <!-- <li>
                            <img src="{{ asset('assets/icons/edit.png' )}}" /><a href="#">Edit profile</a>
                        </li>
                        <li>
                            <img src="{{ asset('assets/icons/envelope.png' )}}" /><a href="#">Inbox</a>
                        </li>
                        <li>
                            <img src="{{ asset('assets/icons/settings.png' )}}" /><a href="#">Setting</a>
                        </li>
                        <li><img src="{{ asset('assets/icons/question.png' )}}" /><a href="#">Help</a></li> -->
                        <li>
                            <img src="{{ asset('assets/icons/log-out.png' )}}" />
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf
                                <a href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="dash-content">
            <!-- contenido -->
            @yield('content')
        </div>
    </section>
    <script>
        function menuToggle() {
            const toggleMenu = document.querySelector(".menu");
            toggleMenu.classList.toggle("active");
        }
    </script>
    <script src="{{ asset('assets/js/dashboard.js' )}}"></script>
    <!--<script src="script.js"></script>-->