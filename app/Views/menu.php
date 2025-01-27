<div class="row">
    <div class="col-md-2 sidebar p-3 bg-dark">
        <h4 class="text-white text-center">Menu</h4>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link text-white <?= (uri_string() === 'home/dashboard') ? 'active' : '' ?>"
                    href="<?= base_url('home/dashboard') ?>">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= (uri_string() === 'home/user') ? 'active' : '' ?>"
                    href="<?= base_url('/home/user') ?>">
                    <i class="bi bi-people"></i> Users
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white <?= (uri_string() === 'home/generate') ? 'active' : '' ?>"
                    href="<?= base_url('/home/generate') ?>">
                    <i class="bi bi-key"></i> Generate Password
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="<?= base_url('home/logout') ?>">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>

<script>
    // JavaScript untuk mengelola highlight pada menu sidebar
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarMenu = document.getElementById('sidebarMenu');
        const links = sidebarMenu.querySelectorAll('.nav-link');

        links.forEach(link => {
            link.addEventListener('click', function () {
                // Hapus class 'active' dari semua link
                links.forEach(item => item.classList.remove('active'));
                // Tambahkan class 'active' ke link yang diklik
                this.classList.add('active');
            });
        });
    });
</script>