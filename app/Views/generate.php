<div class="col-md-10 offset-md-2">
    <div class="container mt-5">
        <h2>Generate Password</h2>

        <!-- Flash Message -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form action="/home/generatePassword" method="post">
            <!-- Hanya Admin dapat melihat dropdown untuk semua user -->
            <?php if ($currentUser['id_level'] === '1'): ?>
                <div class="mb-3">
                    <label for="user_id" class="form-label">Pilih User</label>
                    <select class="form-select" id="user_id" name="user_id" required>
                        <option value="">-- Pilih User --</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id_user'] ?>"><?= $user['username'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php else: ?>
                <!-- Jika bukan Admin, otomatis pilih user saat ini -->
                <input type="hidden" name="user_id" value="<?= $currentUser['id_user'] ?>">
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Generate Random Password</button>
            <!-- Tombol untuk membuka modal custom password -->
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal"
                data-bs-target="#customPasswordModal">
                Generate Custom Password
            </button>
        </form>

        <?php if ($currentUser['id_level'] === '1'): ?>
            <form action="/home/deleteAllPasswords" method="post"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua password?');">
                <button type="submit" class="btn btn-danger mb-3">Delete All Generated Passwords</button>
            </form>
        <?php endif; ?>

        <!-- Modal Custom Password -->
        <div class="modal fade" id="customPasswordModal" tabindex="-1" aria-labelledby="customPasswordModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/home/customGeneratePassword" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="customPasswordModalLabel">Custom Generate Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- User ID (tersembunyi jika bukan admin) -->
                            <?php if ($currentUser['id_level'] === '1'): ?>
                                <div class="mb-3">
                                    <label for="user_id_modal" class="form-label">Pilih User</label>
                                    <select class="form-select" id="user_id_modal" name="user_id" required>
                                        <option value="">-- Pilih User --</option>
                                        <?php foreach ($users as $user): ?>
                                            <option value="<?= $user['id_user'] ?>"><?= $user['username'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            <?php else: ?>
                                <input type="hidden" name="user_id" value="<?= $currentUser['id_user'] ?>">
                            <?php endif; ?>

                            <!-- Opsi panjang password -->
                            <div class="mb-3">
                                <label for="length" class="form-label">Panjang Password (4-64)</label>
                                <input type="number" class="form-control" id="length" name="length" min="4" max="64"
                                    required>
                            </div>
                            <!-- Opsi apakah termasuk simbol -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="include_symbols"
                                    name="include_symbols">
                                <label class="form-check-label" for="include_symbols">Sertakan Simbol</label>
                            </div>
                            <!-- Opsi apakah termasuk teks -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="include_letters"
                                    name="include_letters" checked>
                                <label class="form-check-label" for="include_letters">Sertakan Huruf</label>
                            </div>
                            <!-- Opsi apakah termasuk angka -->
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="include_numbers"
                                    name="include_numbers" checked>
                                <label class="form-check-label" for="include_numbers">Sertakan Angka</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Generate Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <h3 class="mt-4">Generated Passwords</h3>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Password</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($passwords as $index => $password): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= $password['username'] ?></td>
                        <td>
                            <!-- Input dengan Toggle Privasi dan Copy Clipboard -->
                            <div class="input-group">
                                <input type="password" class="form-control" id="passwordField<?= $password['user_id'] ?>"
                                    value="<?= $password['password'] ?>" readonly>
                                <button class="btn btn-outline-secondary toggle-visibility" type="button"
                                    data-id="<?= $password['user_id'] ?>">
                                    <i class="bi bi-eye"></i>
                                </button>
                                <button class="btn btn-outline-secondary copy-to-clipboard" type="button"
                                    data-clipboard-target="#passwordField<?= $password['user_id'] ?>">
                                    <i class="bi bi-clipboard"></i>
                                </button>
                            </div>
                        </td>
                        <td><?= $password['created_at'] ?></td>
                        <td>
                            <!-- Tombol untuk membuka modal -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                data-bs-target="#changePasswordModal<?= $password['user_id'] ?>">
                                Change Password
                            </button>
                        </td>
                    </tr>

                    <!-- Modal untuk mengganti password -->
                    <div class="modal fade" id="changePasswordModal<?= $password['user_id'] ?>" tabindex="-1"
                        aria-labelledby="changePasswordModalLabel<?= $password['user_id'] ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changePasswordModalLabel<?= $password['user_id'] ?>">
                                        Change Password for <?= $password['username'] ?>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="/home/changeToGeneratedPassword" method="post">
                                    <div class="modal-body">
                                        <input type="hidden" name="user_id" value="<?= $password['user_id'] ?>">
                                        <input type="hidden" name="generated_password" value="<?= $password['password'] ?>">
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">Current Password</label>
                                            <input type="password" class="form-control" id="current_password"
                                                name="current_password" required>
                                        </div>
                                        <div class="alert alert-warning" role="alert">
                                            Please enter your current password to apply the generated password.
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<script>

    document.addEventListener('DOMContentLoaded', () => {
        // Handle toggle visibility
        document.querySelectorAll('.toggle-visibility').forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-id');
                const passwordField = document.getElementById(`passwordField${targetId}`);
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    button.innerHTML = '<i class="bi bi-eye-slash"></i>';
                } else {
                    passwordField.type = 'password';
                    button.innerHTML = '<i class="bi bi-eye"></i>';
                }
            });
        });

        // Handle copy to clipboard
        document.querySelectorAll('.copy-to-clipboard').forEach(button => {
            button.addEventListener('click', () => {
                const target = button.getAttribute('data-clipboard-target');
                const input = document.querySelector(target);
                if (input) {
                    input.select();
                    document.execCommand('copy');
                    // Show a temporary tooltip or notification
                    button.innerHTML = '<i class="bi bi-clipboard-check"></i>';
                    setTimeout(() => {
                        button.innerHTML = '<i class="bi bi-clipboard"></i>';
                    }, 1500);
                }
            });
        });
    });

</script>