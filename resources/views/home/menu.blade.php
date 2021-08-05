<nav id="navbar" class="navbar">
    <ul>
        <li><a class="nav-link scrollto active" href="/">Home</a></li>
        
        @if($token =="kosong")
        <li><a class="nav-link scrollto" href="/masukSuplier">Login</a></li>
        <li><a class="getstarted scrollto" href="/registrasi">Daftar</a></li>
        @else
        <li><a class="nav-link scrollto" href="/suplierKeluar">Logout</a></li>
        <li><a class="nav-link scrollto" href="#about">Pengajuan</a></li>
        @endif
    </ul>
    <i class="bi bi-list mobile-nav-toggle"></i>
</nav>