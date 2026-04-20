<ul class="category-tree">
    <!-- Access Point -->
    <li class="category-item">
        <div class="category-item-header" onclick="toggleCategory(this)">
            <span class="category-name">
                <i class="fas fa-chevron-right"></i>
                <i class="fas fa-wifi"></i>
                Access Point
            </span>
            <span class="category-counts">
                <span class="count-inuse">24</span>
                <span class="count-instore">21</span>
                <span class="count-inrepair">1</span>
                <span class="text-muted">2</span>
            </span>
        </div>
        <ul class="category-subtree">
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=ap&model=cisco" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-wifi ms-4"></i>
                            Cisco AP
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">12</span>
                            <span class="count-instore">8</span>
                            <span class="count-inrepair">0</span>
                            <span class="text-muted">1</span>
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=ap&model=ubiquiti" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-wifi ms-4"></i>
                            Ubiquiti AP
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">12</span>
                            <span class="count-instore">13</span>
                            <span class="count-inrepair">1</span>
                            <span class="text-muted">1</span>
                        </span>
                    </div>
                </a>
            </li>
        </ul>
    </li>
    
    <!-- Chromebook -->
    <li class="category-item">
        <a href="{{ route('admin.actifs.index') }}?type=pc&brand=chromebook" class="text-decoration-none">
            <div class="category-item-header">
                <span class="category-name">
                    <i class="fas fa-chevron-right"></i>
                    <i class="fas fa-laptop"></i>
                    Chromebook
                </span>
                <span class="category-counts">
                    <span class="count-inuse">8</span>
                    <span class="count-instore">7</span>
                    <span class="count-inrepair">0</span>
                    <span class="text-muted">0</span>
                </span>
            </div>
        </a>
    </li>
    
    <!-- Cisco Catos Switch -->
    <li class="category-item">
        <a href="{{ route('admin.actifs.index') }}?type=reseau&brand=cisco&model=catos" class="text-decoration-none">
            <div class="category-item-header">
                <span class="category-name">
                    <i class="fas fa-chevron-right"></i>
                    <i class="fas fa-network-wired"></i>
                    Cisco Catos Switch
                </span>
                <span class="category-counts">
                    <span class="count-inuse">24</span>
                    <span class="count-instore">7</span>
                    <span class="count-inrepair">0</span>
                    <span class="text-muted">0</span>
                </span>
            </div>
        </a>
    </li>
    
    <!-- Cisco Router -->
    <li class="category-item">
        <a href="{{ route('admin.actifs.index') }}?type=reseau&brand=cisco&type_device=router" class="text-decoration-none">
            <div class="category-item-header">
                <span class="category-name">
                    <i class="fas fa-chevron-right"></i>
                    <i class="fas fa-router"></i>
                    Cisco Router
                </span>
                <span class="category-counts">
                    <span class="count-inuse">17</span>
                    <span class="count-instore">15</span>
                    <span class="count-inrepair">2</span>
                    <span class="text-muted">0</span>
                </span>
            </div>
        </a>
    </li>
    
    <!-- Cisco Switch -->
    <li class="category-item">
        <a href="{{ route('admin.actifs.index') }}?type=reseau&brand=cisco&type_device=switch" class="text-decoration-none">
            <div class="category-item-header">
                <span class="category-name">
                    <i class="fas fa-chevron-right"></i>
                    <i class="fas fa-network-wired"></i>
                    Cisco Switch
                </span>
                <span class="category-counts">
                    <span class="count-inuse">9</span>
                    <span class="count-instore">8</span>
                    <span class="count-inrepair">1</span>
                    <span class="text-muted">0</span>
                </span>
            </div>
        </a>
    </li>
    
    <!-- Computer -->
    <li class="category-item">
        <div class="category-item-header" onclick="toggleCategory(this)">
            <span class="category-name">
                <i class="fas fa-chevron-right"></i>
                <i class="fas fa-desktop"></i>
                Computer
            </span>
            <span class="category-counts">
                <span class="count-inuse">32</span>
                <span class="count-instore">27</span>
                <span class="count-inrepair">5</span>
                <span class="text-muted">0</span>
            </span>
        </div>
        <ul class="category-subtree">
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=pc&form_factor=desktop" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-desktop ms-4"></i>
                            Desktop
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">18</span>
                            <span class="count-instore">12</span>
                            <span class="count-inrepair">3</span>
                            <span class="text-muted">0</span>
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=pc&form_factor=laptop" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-laptop ms-4"></i>
                            Laptop
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">14</span>
                            <span class="count-instore">15</span>
                            <span class="count-inrepair">2</span>
                            <span class="text-muted">0</span>
                        </span>
                    </div>
                </a>
            </li>
        </ul>
    </li>
    
    <!-- Encrypted Phones -->
    <li class="category-item">
        <a href="{{ route('admin.actifs.index') }}?type=mobile&encrypted=1" class="text-decoration-none">
            <div class="category-item-header">
                <span class="category-name">
                    <i class="fas fa-chevron-right"></i>
                    <i class="fas fa-phone"></i>
                    Encrypted Phones
                </span>
                <span class="category-counts">
                    <span class="count-inuse">14</span>
                    <span class="count-instore">13</span>
                    <span class="count-inrepair">0</span>
                    <span class="text-muted">0</span>
                </span>
            </div>
        </a>
    </li>
    
    <!-- Firewall -->
    <li class="category-item">
        <a href="{{ route('admin.actifs.index') }}?type=reseau&category=firewall" class="text-decoration-none">
            <div class="category-item-header">
                <span class="category-name">
                    <i class="fas fa-chevron-right"></i>
                    <i class="fas fa-shield-halved"></i>
                    Firewall
                </span>
                <span class="category-counts">
                    <span class="count-inuse">5</span>
                    <span class="count-instore">5</span>
                    <span class="count-inrepair">0</span>
                    <span class="text-muted">0</span>
                </span>
            </div>
        </a>
    </li>
    
    <!-- Mobile -->
    <li class="category-item">
        <a href="{{ route('admin.actifs.index') }}?type=mobile" class="text-decoration-none">
            <div class="category-item-header">
                <span class="category-name">
                    <i class="fas fa-chevron-right"></i>
                    <i class="fas fa-mobile-alt"></i>
                    Mobile
                </span>
                <span class="category-counts">
                    <span class="count-inuse">0</span>
                    <span class="count-instore">0</span>
                    <span class="count-inrepair">0</span>
                    <span class="text-muted">0</span>
                </span>
            </div>
        </a>
    </li>
    
    <!-- Network Services -->
    <li class="category-item">
        <a href="{{ route('admin.actifs.index') }}?type=reseau&category=services" class="text-decoration-none">
            <div class="category-item-header">
                <span class="category-name">
                    <i class="fas fa-chevron-right"></i>
                    <i class="fas fa-cloud"></i>
                    Network Services
                </span>
                <span class="category-counts">
                    <span class="count-inuse">1</span>
                    <span class="count-instore">1</span>
                    <span class="count-inrepair">0</span>
                    <span class="text-muted">0</span>
                </span>
            </div>
        </a>
    </li>
    
    <!-- Printer -->
    <li class="category-item">
        <div class="category-item-header" onclick="toggleCategory(this)">
            <span class="category-name">
                <i class="fas fa-chevron-right"></i>
                <i class="fas fa-print"></i>
                Printer
            </span>
            <span class="category-counts">
                <span class="count-inuse">9</span>
                <span class="count-instore">9</span>
                <span class="count-inrepair">0</span>
                <span class="text-muted">0</span>
            </span>
        </div>
        <ul class="category-subtree">
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=imprimante&brand=hp" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-print ms-4"></i>
                            HP
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">4</span>
                            <span class="count-instore">3</span>
                            <span class="count-inrepair">0</span>
                            <span class="text-muted">0</span>
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=imprimante&brand=epson" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-print ms-4"></i>
                            Epson
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">3</span>
                            <span class="count-instore">4</span>
                            <span class="count-inrepair">0</span>
                            <span class="text-muted">0</span>
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=imprimante&brand=brother" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-print ms-4"></i>
                            Brother
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">2</span>
                            <span class="count-instore">2</span>
                            <span class="count-inrepair">0</span>
                            <span class="text-muted">0</span>
                        </span>
                    </div>
                </a>
            </li>
        </ul>
    </li>
    
    <!-- Rack -->
    <li class="category-item">
        <a href="{{ route('admin.actifs.index') }}?type=rack" class="text-decoration-none">
            <div class="category-item-header">
                <span class="category-name">
                    <i class="fas fa-chevron-right"></i>
                    <i class="fas fa-server"></i>
                    Rack
                </span>
                <span class="category-counts">
                    <span class="count-inuse">1</span>
                    <span class="count-instore">1</span>
                    <span class="count-inrepair">0</span>
                    <span class="text-muted">0</span>
                </span>
            </div>
        </a>
    </li>
    
    <!-- Router -->
    <li class="category-item">
        <div class="category-item-header" onclick="toggleCategory(this)">
            <span class="category-name">
                <i class="fas fa-chevron-right"></i>
                <i class="fas fa-router"></i>
                Router
            </span>
            <span class="category-counts">
                <span class="count-inuse">15</span>
                <span class="count-instore">14</span>
                <span class="count-inrepair">0</span>
                <span class="text-muted">0</span>
            </span>
        </div>
        <ul class="category-subtree">
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=reseau&brand=cisco&category=router" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-router ms-4"></i>
                            Cisco
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">8</span>
                            <span class="count-instore">7</span>
                            <span class="count-inrepair">0</span>
                            <span class="text-muted">0</span>
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=reseau&brand=juniper&category=router" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-router ms-4"></i>
                            Juniper
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">4</span>
                            <span class="count-instore">4</span>
                            <span class="count-inrepair">0</span>
                            <span class="text-muted">0</span>
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=reseau&brand=mikrotik&category=router" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-router ms-4"></i>
                            MikroTik
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">3</span>
                            <span class="count-instore">3</span>
                            <span class="count-inrepair">0</span>
                            <span class="text-muted">0</span>
                        </span>
                    </div>
                </a>
            </li>
        </ul>
    </li>
    
    <!-- Server -->
    <li class="category-item">
        <div class="category-item-header" onclick="toggleCategory(this)">
            <span class="category-name">
                <i class="fas fa-chevron-right"></i>
                <i class="fas fa-server"></i>
                Server
            </span>
            <span class="category-counts">
                <span class="count-inuse">29</span>
                <span class="count-instore">29</span>
                <span class="count-inrepair">0</span>
                <span class="text-muted">0</span>
            </span>
        </div>
        <ul class="category-subtree">
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=serveur&brand=dell" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-server ms-4"></i>
                            Dell
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">12</span>
                            <span class="count-instore">12</span>
                            <span class="count-inrepair">0</span>
                            <span class="text-muted">0</span>
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=serveur&brand=hp" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-server ms-4"></i>
                            HP
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">10</span>
                            <span class="count-instore">10</span>
                            <span class="count-inrepair">0</span>
                            <span class="text-muted">0</span>
                        </span>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.actifs.index') }}?type=serveur&brand=ibm" class="text-decoration-none">
                    <div class="category-item-header">
                        <span class="category-name">
                            <i class="fas fa-server ms-4"></i>
                            IBM
                        </span>
                        <span class="category-counts">
                            <span class="count-inuse">7</span>
                            <span class="count-instore">7</span>
                            <span class="count-inrepair">0</span>
                            <span class="text-muted">0</span>
                        </span>
                    </div>
                </a>
            </li>
        </ul>
    </li>
</ul>


