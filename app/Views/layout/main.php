<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - Invoice App</title>
    <!-- FontAwesome for Premium Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <?= $this->renderSection('styles') ?>
</head>
<body>

<div class="app-container">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon" style="background: transparent; box-shadow: none; padding: 0; overflow: hidden;">
                <img src="<?= base_url('image/logo.webp') ?>" alt="Bhinneka Transport" style="width: 44px; height: 44px; object-fit: contain; display: block;">
            </div>
            <div class="logo-text">Bhinneka<span>Transport</span></div>
        </div>
        
        <nav class="sidebar-menu">
            <?php 
                $uri = service('uri');
                $segment = $uri->getSegment(1);
            ?>
            <a href="<?= base_url('dashboard') ?>" class="menu-item <?= ($segment == 'dashboard' || $segment == '') ? 'active' : '' ?>">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </a>
            <a href="<?= base_url('invoices') ?>" class="menu-item <?= ($segment == 'invoices') ? 'active' : '' ?>">
                <i class="fa-solid fa-file-invoice-dollar"></i> Transaksi Invoice
            </a>
            <a href="<?= base_url('customers') ?>" class="menu-item <?= ($segment == 'customers') ? 'active' : '' ?>">
                <i class="fa-solid fa-users"></i> Pelanggan (Customers)
            </a>
            <a href="<?= base_url('products') ?>" class="menu-item <?= ($segment == 'products') ? 'active' : '' ?>">
                <i class="fa-solid fa-box"></i> Barang (Products)
            </a>
            <a href="<?= base_url('users') ?>" class="menu-item <?= ($segment == 'users') ? 'active' : '' ?>">
                <i class="fa-solid fa-user-gear"></i> Pengguna (Users)
            </a>
            <a href="<?= base_url('settings') ?>" class="menu-item <?= ($segment == 'settings') ? 'active' : '' ?>">
                <i class="fa-solid fa-building"></i> Profil Perusahaan
            </a>
        </nav>
        
        <div class="sidebar-footer">
            <div class="user-badge">
                <div class="avatar">
                    <?= strtoupper(substr(session()->get('name') ?? 'U', 0, 1)) ?>
                </div>
                <div class="user-info">
                    <span class="user-name"><?= session()->get('name') ?? 'User' ?></span>
                    <span class="user-role"><?= session()->get('role') ?? 'Role' ?></span>
                </div>
                <a href="<?= base_url('logout') ?>" style="margin-left: auto; color: var(--danger);" title="Keluar">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </a>
            </div>
        </div>
    </aside>

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <!-- Main Content Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="header">
            <div style="display: flex; align-items: center; gap: 16px;">
                <button class="menu-toggle" id="menu-toggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h1 class="page-title"><?= $this->renderSection('page_title') ?></h1>
            </div>
            <div class="header-actions">
                <span style="color: var(--text-muted); font-size: 0.85rem;">
                    <i class="fa-regular fa-calendar"></i> <?= date('d M Y') ?>
                </span>
            </div>
        </header>

        <!-- Main Content -->
        <main class="content">
            <!-- Toast Notification Container -->
            <div class="toast-container">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="toast toast-success">
                        <i class="fa-solid fa-circle-check"></i>
                        <div class="toast-message"><?= session()->getFlashdata('success') ?></div>
                        <button class="toast-close" onclick="this.parentElement.remove();">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="toast toast-danger">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <div class="toast-message"><?= session()->getFlashdata('error') ?></div>
                        <button class="toast-close" onclick="this.parentElement.remove();">&times;</button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- View Content Injection -->
            <?= $this->renderSection('content') ?>
        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Toggle Sidebar on mobile
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (menuToggle && sidebar && overlay) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('active');
            });

            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            });
        }

        // Setup PJAX for seamless dynamic content loading
        const baseUrl = '<?= base_url() ?>';

        function loadPage(url) {
            // Close mobile menu if open
            if (sidebar && overlay) {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            }

            fetch(url)
                .then(response => {
                    if (!response.ok) throw new Error('Response error');
                    return response.text();
                })
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // 1. Update Title
                    document.title = doc.title;

                    // 2. Update Page Header Title
                    const newPageTitle = doc.querySelector('.page-title');
                    const currentPageTitle = document.querySelector('.page-title');
                    if (newPageTitle && currentPageTitle) {
                        currentPageTitle.innerHTML = newPageTitle.innerHTML;
                    }

                    // 3. Update Main Content
                    const newContent = doc.querySelector('.content');
                    const currentContent = document.querySelector('.content');
                    if (newContent && currentContent) {
                        currentContent.innerHTML = newContent.innerHTML;
                        // Execute injected scripts
                        executeScripts(currentContent);
                        // Initialize newly injected toasts
                        initToasts();
                    }

                    // 4. Update History URL State
                    history.pushState({ url: url }, doc.title, url);

                    // 5. Update Active Menu Marker
                    updateActiveMenu(url);

                    window.scrollTo({ top: 0, behavior: 'smooth' });
                })
                .catch(error => {
                    console.error('PJAX Error:', error);
                    window.location.href = url; // fallback to browser navigation
                });
        }

        function executeScripts(container) {
            const scripts = container.querySelectorAll('script');
            scripts.forEach(oldScript => {
                const newScript = document.createElement('script');
                Array.from(oldScript.attributes).forEach(attr => newScript.setAttribute(attr.name, attr.value));
                newScript.appendChild(document.createTextNode(oldScript.innerHTML));
                oldScript.parentNode.replaceChild(newScript, oldScript);
            });
        }

        function updateActiveMenu(url) {
            const path = new URL(url).pathname;
            const menuItems = document.querySelectorAll('.sidebar-menu .menu-item');
            menuItems.forEach(item => {
                const itemUrl = item.getAttribute('href');
                if (itemUrl) {
                    const itemPath = new URL(itemUrl).pathname;
                    if (path === itemPath || (path === '/' && itemPath === '/dashboard') || (path.includes('invoices') && itemPath.includes('invoices'))) {
                        item.classList.add('active');
                    } else {
                        item.classList.remove('active');
                    }
                }
            });
        }

        // Intercept standard local links clicks
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a');
            if (link && link.href && link.href.startsWith(baseUrl)) {
                const targetAttr = link.getAttribute('target');
                if (targetAttr !== '_blank' && !link.href.includes('print') && !link.href.includes('logout') && !link.href.includes('#')) {
                    e.preventDefault();
                    loadPage(link.href);
                }
            }
        });

        // Handle history popstate events
        window.addEventListener('popstate', (e) => {
            if (e.state && e.state.url) {
                loadPage(e.state.url);
            } else {
                window.location.reload();
            }
        });

        // Initialize Toast notifications fadeout
        initToasts();
    });

    function initToasts() {
        const toasts = document.querySelectorAll('.toast');
        toasts.forEach(toast => {
            setTimeout(() => {
                toast.style.animation = 'toastFadeOut 0.4s ease forwards';
                setTimeout(() => {
                    toast.remove();
                }, 400);
            }, 3000);
        });
    }
</script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
