<nav class="navbar navbar-expand-md navbar-light">
    <div class="container">
        <span class="navbar-brand">
            {{ $title }}
        </span>
        <button class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarSupportedContent" 
            aria-controls="navbarSupportedContent" 
            aria-expanded="false" 
            aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" 
            id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown d-none d-md-block">
                    <a id="navbarDropdown" 
                        class="nav-link dropdown-toggle" 
                        href="#" role="button" 
                        data-bs-toggle="dropdown" 
                        aria-haspopup="true" 
                        aria-expanded="false" 
                        v-pre>
                        {{ Auth::user()->username }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" 
                        aria-labelledby="navbarDropdown">
                        <!-- consolidated system -->
                        <a href="/" 
                            class="dropdown-item">
                            {{ __('Home') }}
                        </a>
                    </div>
                </li>
                <li class="nav-item d-block d-md-none">
                    <div aria-labelledby="navbarDropdown">
                        <a href="/" 
                            class="dropdown-item">
                            {{ __('Home') }}
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>