<nav class="navbar navbar-expand-md">
    <div class="container-fluid mx-2">
        <div class="navbar-header w-100">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#toggle-navbar"
                aria-controls="toggle-navbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="uil-bars text-white"></i>
            </button>
            <div class="d-flex justify-content-between w-100">
                <a class="navbar-brand" href="#">admin<span class="main-color">Adidas</span></a>
                <div>
                    {{-- condition : if the user is loged in --}}
                    @if (session('LoggedUser'))
                    
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger  ">Logout</button>
                    </form>
                    @else
                    <a class="btn btn-primary" href="{{ route('auth.login') }}">SignIn</a>
                    <a class="btn btn-warning" href="{{ route('auth.signin') }}">SignUp</a>
                    @endif
                    {{-- if the user is loged in --}}
                    

                    {{-- else --}}

                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="toggle-navbar">

        </div>
    </div>
</nav>
