<aside class="app-sidebar bg-dark shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link"> 
            <img src="../../dist/assets/img/AdminLTELogo.png" alt="Firma Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">Firma Adı</span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2"> <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item menu-open"> <a href="#" class="nav-link active"> <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Ayarlar
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item"> <a href="{{ route('profile') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Profil</p>
                            </a>
                        </li>
                        <li class="nav-item"> <a href="{{ route('company') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Firma</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item"> <a href="{{ route('sliders') }}" class="nav-link"> <i class="nav-icon bi bi-download"></i>
                        <p>Slider</p>
                    </a> 
                </li>
                <li class="nav-item"> <a href="{{ route('sectors') }}" class="nav-link"> <i class="nav-icon bi bi-download"></i>
                        <p>Sektörler</p>
                    </a> 
                </li>
                <li class="nav-item"> <a href="{{ route('services') }}" class="nav-link"> <i class="nav-icon bi bi-download"></i>
                        <p>Hizmetler</p>
                    </a> 
                </li>
                <li class="nav-item"> <a href="{{ route('branches') }}" class="nav-link"> <i class="nav-icon bi bi-download"></i>
                        <p>Şubeler</p>
                    </a> 
                </li>
                <li class="nav-item"> <a href="{{ route('blogs') }}" class="nav-link"> <i class="nav-icon bi bi-download"></i>
                        <p>Bloglar</p>
                    </a> 
                </li>
                <li class="nav-item"> <a href="{{ route('references') }}" class="nav-link"> <i class="nav-icon bi bi-download"></i>
                        <p>Referanslar</p>
                    </a> 
                </li>
                <li class="nav-item"> <a href="{{ route('galleries') }}" class="nav-link"> <i class="nav-icon bi bi-download"></i>
                        <p>Galeri</p>
                    </a> 
                </li>
                <li class="nav-item"> <a href="{{ route('faqs') }}" class="nav-link"> <i class="nav-icon bi bi-download"></i>
                        <p>Sıkça Sorulan Sorular / FAQ</p>
                    </a> 
                </li>
            </ul> <!--end::Sidebar Menu-->
        </nav>
    </div> <!--end::Sidebar Wrapper-->
</aside>