<div class="col-md-10 offset-md-2">
    <div class="row mt-3">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Users Table -->
        <div class="col-md-6">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h3 class="text-center">Users</h3>
                <!-- Button to trigger Add User modal -->
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="bi bi-person-plus"></i> Add User
                </button>
            </div>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id_user'] ?></td>
                            <td><?= $user['username'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['id_level'] ?></td>
                            <td>
                                <!-- Edit button -->
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editUserModal<?= $user['id_user'] ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <!-- Delete button -->
                                <form action="/home/deleteUser/<?= $user['id_user'] ?>" method="post" class="d-inline"
                                    onsubmit="return confirmDeleteUser();">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit User Modal -->
                        <div class="modal fade" id="editUserModal<?= $user['id_user'] ?>" tabindex="-1"
                            aria-labelledby="editUserLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="/home/editUser/<?= $user['id_user'] ?>" method="post">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editUserLabel">Edit User</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="username<?= $user['id_user'] ?>"
                                                    class="form-label">Username</label>
                                                <input type="text" class="form-control" id="username<?= $user['id_user'] ?>"
                                                    name="username" value="<?= $user['username'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="password<?= $user['id_user'] ?>" class="form-label">Password
                                                    (Kosongkan jika tidak ingin mengubah)</label>
                                                <input type="password" class="form-control"
                                                    id="password<?= $user['id_user'] ?>" name="password">
                                            </div>
                                            <div class="mb-3">
                                                <label for="email<?= $user['id_user'] ?>" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email<?= $user['id_user'] ?>"
                                                    name="email" value="<?= $user['email'] ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="level<?= $user['id_user'] ?>" class="form-label">Level</label>
                                                <select class="form-select" id="level<?= $user['id_user'] ?>"
                                                    name="id_level" required>
                                                    <?php foreach ($levels as $level): ?>
                                                        <option value="<?= $level['id_level'] ?>"
                                                            <?= $level['id_level'] == $user['id_level'] ? 'selected' : '' ?>>
                                                            <?= $level['nama_level'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Add User Modal -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/home/addUser" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addUserLabel">Add User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_level" class="form-label">Level</label>
                                <select class="form-select" id="id_level" name="id_level" required>
                                    <option value="" disabled selected>Select a level</option>
                                    <?php foreach ($levels as $level): ?>
                                        <option value="<?= $level['id_level'] ?>"><?= $level['nama_level'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Levels Table -->
        <div class="col-md-6">
            <div class="mb-3">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addLevelModal">
                    <i class="bi bi-plus-circle"></i> Tambah Level
                </button>
            </div>
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Level Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($levels as $level): ?>
                        <tr>
                            <td><?= $level['id_level'] ?></td>
                            <td><?= $level['nama_level'] ?></td>
                            <td>
                                <form action="/home/deleteLevel/<?= $level['id_level'] ?>" method="post" class="d-inline"
                                    onsubmit="return confirmDelete();">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah Level -->
        <div class="modal fade" id="addLevelModal" tabindex="-1" aria-labelledby="addLevelLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/home/addLevel" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addLevelLabel">Tambah Level</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_level" class="form-label">Nama Level</label>
                                <input type="text" class="form-control" id="nama_level" name="nama_level" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Fungsi untuk menampilkan konfirmasi sebelum penghapusan
    function confirmDelete() {
        return confirm("Apakah Anda yakin ingin menghapus level ini?");
    }
    function confirmDeleteUser() {
        return confirm("Are you sure you want to delete this user?");
    }
</script>