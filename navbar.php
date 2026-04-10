<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-lg custom-navbar fixed-top">
    <div class="container">

        <a class="navbar-brand mr-auto" href="<?= base_url(); ?>">A M O U R </a>
        <button class="navbar-toggler" type="button" id="sidebarToggle" aria-label="Toggle navigation">
            <span id="hamburgerIcon">
                <span style="display:block; width: 25px; height: 3px; background-color: #5a0a0a; margin: 4px 0; border-radius: 2px;"></span>
                <span style="display:block; width: 25px; height: 3px; background-color: #5a0a0a; margin: 4px 0; border-radius: 2px;"></span>
                <span style="display:block; width: 25px; height: 3px; background-color: #5a0a0a; margin: 4px 0; border-radius: 2px;"></span>
            </span>
            <span id="closeIcon" style="display:none; font-size: 28px; color: #5a0a0a; font-weight: bold; line-height: 1; user-select: none;">X</span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?= $menu == 'beranda' ? 'active' : ''; ?>">
                    <a class="nav-link" href="index.php">Beranda</a>
                </li>
                <li class="nav-item <?= $menu == 'status' ? 'active' : ''; ?>">
                    <a class="nav-link" href="status.php">Riwayat Pesanan</a>
                </li>
                <li class="nav-item <?= $menu == 'tentang' ? 'active' : ''; ?>">
                    <a class="nav-link" href="about.php">Tentang Kami</a>
                </li>
                <li class="nav-item search-container" style="position: relative;">
                    <a href="javascript:void(0);" class="nav-link search-icon" id="searchIcon"><i class="fa fa-search"></i></a>
                    <div class="search-box" id="searchBox" style="display:none; position:absolute; top:50px; right:0; background:#fff; border:1px solid #ccc; width:300px; z-index:1000; padding:10px; border-radius:5px;">
                        <input type="text" id="searchInput" placeholder="Search..." style="width:100%; padding:5px; border:1px solid #ccc; border-radius:3px;">
                        <div id="searchResults" style="margin-top:10px; max-height:300px; overflow-y:auto;"></div>
                    </div>
                </li>
                <style>
                    @media (max-width: 768px) {
                        .search-box {
                            width: 90vw !important;
                            left: 50% !important;
                            transform: translateX(-50%) !important;
                            top: 50px !important;
                            right: auto !important;
                        }
                    }
                </style>
                <li class="nav-item <?= $menu == 'keranjang' ? 'active' : ''; ?>">
                    <a class="nav-link" href="cart.php"><i class="fa fa-shopping-cart"></i></a>
                </li>
                <li class="nav-item <?= $menu == 'admin' ? 'active' : ''; ?>">
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'member'): ?>
                    <a class="nav-link" href="user_profile.php"><i class="fa fa-user"></i> Profil</a>
<?php else: ?>
                    <a class="nav-link" href="login.php"><i class="fa fa-user"></i></a>
<?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Sidebar menu -->
<div id="sidebarMenu" class="sidebar-menu">
    <div class="sidebar-header">
        <h3>Menu</h3>
        <button id="sidebarClose" aria-label="Close sidebar">&times;</button>
    </div>
    <ul class="sidebar-nav">
        <li><a href="index.php">Beranda</a></li>
        <li><a href="status.php">Riwayat Pesanan</a></li>
        <li><a href="about.php">Tentang Kami</a></li>
        <li>
            <a href="javascript:void(0);" id="sidebarSearchIcon"><i class="fa fa-search"></i> Search</a>
            <div class="sidebar-search-box" id="sidebarSearchBox" style="display:none; margin-top:10px;">
                <input type="text" id="sidebarSearchInput" placeholder="Search..." style="width:100%; padding:5px; border:1px solid #ccc; border-radius:3px;">
                <div id="sidebarSearchResults" style="margin-top:10px; max-height:200px; overflow-y:auto; background:#fff; color:#000; border:1px solid #ccc; border-radius:3px;"></div>
            </div>
        </li>
        <li><a href="cart.php"><i class="fa fa-shopping-cart"> Shopping</i></a></li>
        <li>
<?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'member'): ?>
            <a href="user_profile.php"><i class="fa fa-user"></i> Profil</a>
<?php else: ?>
            <a href="login.php"><i class="fa fa-user"></i> Login</a>
<?php endif; ?>
        </li>
    </ul>
</div>

<style>
/* Sidebar styles */
.sidebar-menu {
    position: fixed;
    top: 0;
    left: -280px;
    width: 280px;
    height: 100%;
    background-color: #DFADAE;
    color: #fff;
    z-index: 1050;
    padding: 20px;
    transition: left 0.3s ease;
    overflow-y: auto;
    box-shadow: 2px 0 5px rgba(0,0,0,0.5);
}

.sidebar-menu.active {
    left: 0;
}

.sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.sidebar-header h3 {
    margin: 0;
    font-weight: 700;
}

#sidebarClose {
    background: transparent;
    border: none;
    font-size: 28px;
    color: #fff;
    cursor: pointer;
    line-height: 1;
}

.sidebar-nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.sidebar-nav li {
    margin-bottom: 20px;
}

.sidebar-nav li a {
    color: #fff;
    text-decoration: none;
    font-weight: 500;
    font-size: 16px;
}

.sidebar-nav li a:hover {
    text-decoration: underline;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Existing search box toggle code
    const searchIcon = document.getElementById('searchIcon');
    const searchBox = document.getElementById('searchBox');
    const searchInput = document.getElementById('searchInput');
    const searchResults = document.getElementById('searchResults');

    searchIcon.addEventListener('click', function() {
        if (searchBox.style.display === 'none' || searchBox.style.display === '') {
            searchBox.style.display = 'block';
            searchInput.focus();
        } else {
            searchBox.style.display = 'none';
            searchResults.innerHTML = '';
            searchInput.value = '';
        }
    });

    function debounce(func, delay) {
        let debounceTimer;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func.apply(context, args), delay);
        }
    }

    function fetchSearchResults(query) {
        if (query.length === 0) {
            searchResults.innerHTML = '';
            return;
        }
        fetch('search_product.php?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                renderResults(data);
            })
            .catch(error => {
                console.error('Error fetching search results:', error);
            });
    }

    function renderResults(products) {
        if (products.length === 0) {
            searchResults.innerHTML = '<p style="padding: 10px; color: #666;">No products found.</p>';
            return;
        }
        let html = '';
        products.forEach(product => {
            html += `
                <div class="search-result-item" style="display: flex; align-items: center; padding: 5px; cursor: pointer; border-bottom: 1px solid #eee;">
                    <img src="${product.image}" alt="${product.name}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 3px; margin-right: 10px;">
                    <span>${product.name}</span>
                </div>
            `;
        });
        searchResults.innerHTML = html;

        document.querySelectorAll('.search-result-item').forEach(item => {
            item.addEventListener('click', function() {
                const productName = this.querySelector('span').textContent;
                const product = products.find(p => p.name === productName);
                if (product) {
                    window.location.href = 'detail_product.php?id_product=' + product.id;
                }
            });
        });
    }

    searchInput.addEventListener('input', debounce(function(e) {
        fetchSearchResults(e.target.value.trim());
    }, 300));

    // Sidebar toggle
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarMenu = document.getElementById('sidebarMenu');
    const sidebarClose = document.getElementById('sidebarClose');

    sidebarToggle.addEventListener('click', function() {
        if (sidebarMenu.classList.contains('active')) {
            sidebarMenu.classList.remove('active');
            hamburgerIcon.style.display = 'block';
            closeIcon.style.display = 'none';
        } else {
            sidebarMenu.classList.add('active');
            hamburgerIcon.style.display = 'none';
            closeIcon.style.display = 'block';
        }
    });

    sidebarClose.addEventListener('click', function() {
        sidebarMenu.classList.remove('active');
        hamburgerIcon.style.display = 'block';
        closeIcon.style.display = 'none';
    });

    // Optional: close sidebar when clicking outside
    document.addEventListener('click', function(event) {
        if (!sidebarMenu.contains(event.target) && !sidebarToggle.contains(event.target)) {
            sidebarMenu.classList.remove('active');
            hamburgerIcon.style.display = 'block';
            closeIcon.style.display = 'none';
        }
    });
    });

    // Sidebar search toggle and functionality
    const sidebarSearchIcon = document.getElementById('sidebarSearchIcon');
    const sidebarSearchBox = document.getElementById('sidebarSearchBox');
    const sidebarSearchInput = document.getElementById('sidebarSearchInput');
    const sidebarSearchResults = document.getElementById('sidebarSearchResults');

    sidebarSearchIcon.addEventListener('click', function() {
        if (sidebarSearchBox.style.display === 'none' || sidebarSearchBox.style.display === '') {
            sidebarSearchBox.style.display = 'block';
            sidebarSearchInput.focus();
        } else {
            sidebarSearchBox.style.display = 'none';
            sidebarSearchResults.innerHTML = '';
            sidebarSearchInput.value = '';
        }
    });

    function debounce(func, delay) {
        let debounceTimer;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => func.apply(context, args), delay);
        }
    }

    function fetchSidebarSearchResults(query) {
        if (query.length === 0) {
            sidebarSearchResults.innerHTML = '';
            return;
        }
        fetch('search_product.php?query=' + encodeURIComponent(query))
            .then(response => response.json())
            .then(data => {
                renderSidebarResults(data);
            })
            .catch(error => {
                console.error('Error fetching sidebar search results:', error);
            });
    }

    function renderSidebarResults(products) {
        if (products.length === 0) {
            sidebarSearchResults.innerHTML = '<p style="padding: 10px; color: #666;">No products found.</p>';
            return;
        }
        let html = '';
        products.forEach(product => {
            html += `
                <div class="sidebar-search-result-item" style="display: flex; align-items: center; padding: 5px; cursor: pointer; border-bottom: 1px solid #eee;">
                    <img src="${product.image}" alt="${product.name}" style="width: 40px; height: 40px; object-fit: cover; border-radius: 3px; margin-right: 10px;">
                    <span>${product.name}</span>
                </div>
            `;
        });
        sidebarSearchResults.innerHTML = html;

        document.querySelectorAll('.sidebar-search-result-item').forEach(item => {
            item.addEventListener('click', function() {
                const productName = this.querySelector('span').textContent;
                const product = products.find(p => p.name === productName);
                if (product) {
                    window.location.href = 'detail_product.php?id_product=' + product.id;
                }
            });
        });
    }

    sidebarSearchInput.addEventListener('input', debounce(function(e) {
        fetchSidebarSearchResults(e.target.value.trim());
    }, 300));
</script>
