<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use App\Models\GeneratedPasswordModel;

class Home extends BaseController
{
	public function login()
	{
		// Cek apakah sudah login, jika iya redirect ke halaman dashboard
		if (session()->has('user')) {
			return redirect()->to('home/dashboard');
		}

		// Jika belum login, tampilkan form login
		return view('login');  // Pastikan Anda sudah punya file view login.php
	}

	public function loginAction()
	{
		$userModel = new UserModel();

		// Ambil input
		$username = $this->request->getPost('username');
		$password = $this->request->getPost('password');

		// Cek apakah data valid
		$user = $userModel->where('username', $username)->first();

		if ($user && password_verify($password, $user['password'])) { // Bandingkan password menggunakan bcrypt
			// Jika valid, simpan data user ke session
			session()->set('user', $user);
			return redirect()->to('home/dashboard');  // Redirect ke dashboard atau halaman yang diinginkan
		} else {
			// Jika login gagal, tampilkan pesan error
			session()->setFlashdata('error', 'Username atau password salah.');
			return redirect()->to('/home/login');
		}
	}

	public function logout()
	{
		// Hapus data user dari session
		session()->remove('user');
		return redirect()->to('/home/login');  // Redirect ke halaman login
	}

	public function user()
	{
		$userModel = new UserModel();
		$levelModel = new LevelModel();

		$data = [
			'users' => $userModel->findAll(),
			'levels' => $levelModel->findAll()
		];

		echo view('head');
		echo view('menu');
		echo view('user', $data);
		echo view('foot');
	}

	public function addLevel()
	{
		// Periksa apakah ini adalah permintaan POST
		if ($this->request->getMethod() === 'post') {
			$levelModel = new LevelModel();

			// Ambil data dari form
			$namaLevel = $this->request->getPost('nama_level');

			// Validasi data
			if (empty($namaLevel)) {
				return redirect()->back()->with('error', 'Nama level tidak boleh kosong!');
			}

			// Simpan ke database
			$levelModel->save([
				'nama_level' => $namaLevel,
			]);

			// Redirect kembali dengan pesan sukses
			return redirect()->to('/home/user')->with('success', 'Level berhasil ditambahkan!');
		}

		// Jika bukan POST, kembalikan ke halaman utama
		return redirect()->to('/home/user');
	}

	public function deleteLevel($id)
	{
		$levelModel = new LevelModel();

		// Cari data level berdasarkan ID
		$level = $levelModel->find($id);
		if (!$level) {
			return redirect()->to('/home/user')->with('error', 'Level tidak ditemukan!');
		}

		// Hapus data level
		$levelModel->delete($id);

		// Redirect kembali dengan pesan sukses
		return redirect()->to('/home/user')->with('success', 'Level berhasil dihapus!');
	}

	public function addUser()
	{
		if ($this->request->getMethod() === 'post') {
			$userModel = new UserModel();

			// Ambil data dari form
			$data = [
				'username' => $this->request->getPost('username'),
				'email' => $this->request->getPost('email'),
				'id_level' => $this->request->getPost('id_level'),
				'password' => password_hash('defaultPassword123', PASSWORD_DEFAULT), // Set password default
			];

			// Simpan data ke database
			$userModel->save($data);

			// Redirect ke halaman utama dengan pesan sukses
			return redirect()->to('/home/user')->with('success', 'User berhasil ditambahkan!');
		}

		return redirect()->to('/home/user')->with('error', 'Gagal menambahkan user.');
	}

	public function editUser($id)
	{
		if ($this->request->getMethod() === 'post') {
			$userModel = new UserModel();

			// Cari user berdasarkan ID
			$user = $userModel->find($id);
			if (!$user) {
				return redirect()->to('/home/user')->with('error', 'User tidak ditemukan!');
			}

			// Ambil data dari form
			$data = [
				'id_user' => $id,
				'username' => $this->request->getPost('username'),
				'email' => $this->request->getPost('email'),
				'id_level' => $this->request->getPost('id_level'),
				'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT), // Hash password
			];

			// Cek apakah password diubah
			$password = $this->request->getPost('password');
			if (!empty($password)) {
				$data['password'] = password_hash($password, PASSWORD_DEFAULT); // Hash password baru
			}

			// Update data user
			$userModel->save($data);

			// Redirect ke halaman utama dengan pesan sukses
			return redirect()->to('/home/user')->with('success', 'User berhasil diubah!');
		}

		return redirect()->to('/home/user')->with('error', 'Gagal mengubah user.');
	}

	public function deleteUser($id)
	{
		$userModel = new UserModel();

		// Cari user berdasarkan ID
		$user = $userModel->find($id);
		if (!$user) {
			return redirect()->to('/home/user')->with('error', 'User tidak ditemukan!');
		}

		// Hapus user dari database
		$userModel->delete($id);

		// Redirect ke halaman utama dengan pesan sukses
		return redirect()->to('/home/user')->with('success', 'User berhasil dihapus!');
	}

	public function generate()
	{
		$userModel = new UserModel();
		$generatedPasswordModel = new GeneratedPasswordModel();

		// Dapatkan data pengguna yang login
		$currentUser = session()->get('user');

		if (!$currentUser) {
			// Jika session tidak ada, redirect ke login
			session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
			return redirect()->to('/home/login');
		}

		// Validasi apakah pengguna adalah admin
		$isAdmin = (int) $currentUser['id_level'] === 1; // Pastikan tipe datanya cocok
		log_message('debug', 'Is Admin: ' . ($isAdmin ? 'Yes' : 'No'));

		// Ambil data berdasarkan level pengguna
		if ($isAdmin) {
			// Jika Admin, dapatkan semua data
			$passwords = $generatedPasswordModel
				->select('generated_passwords.*, user.username')
				->join('user', 'user.id_user = generated_passwords.user_id')
				->orderBy('generated_passwords.created_at', 'DESC')
				->findAll();
		} else {
			// Jika bukan Admin, hanya data milik sendiri
			$passwords = $generatedPasswordModel
				->select('generated_passwords.*, user.username')
				->join('user', 'user.id_user = generated_passwords.user_id')
				->where('generated_passwords.user_id', $currentUser['id_user'])
				->orderBy('generated_passwords.created_at', 'DESC')
				->findAll();
		}

		// Debug hasil query
		log_message('debug', 'Generated Passwords: ' . json_encode($passwords));

		echo view('head');
		echo view('menu');
		echo view('generate', [
			'passwords' => $passwords,
			'users' => $userModel->findAll(), // Data pengguna untuk dropdown
			'currentUser' => $currentUser, // Data pengguna saat ini
		]);
		echo view('foot');
	}

	public function generatePassword()
	{
		$generatedPasswordModel = new GeneratedPasswordModel();

		// Generate password random (contoh: 10 karakter alfanumerik)
		$password = bin2hex(random_bytes(5));

		// Ambil ID user dari form
		$userId = $this->request->getPost('user_id');

		// Cek apakah user sudah memiliki password
		$existingPassword = $generatedPasswordModel->where('user_id', $userId)->first();

		// Data yang akan disimpan/diupdate
		$data = [
			'password' => $password,
			'created_at' => date('Y-m-d H:i:s'),
		];

		if ($existingPassword) {
			// Jika sudah ada, update data
			$generatedPasswordModel->update($existingPassword['id'], $data);
		} else {
			// Jika belum ada, tambahkan user_id dan simpan data baru
			$data['id_user'] = $userId;
			$generatedPasswordModel->save($data);
		}

		// Redirect ke halaman generate password dengan flash message
		return redirect()->to('/home/generate')->with('success', "Password berhasil dibuat");
	}

	public function customGeneratePassword()
	{
		$generatedPasswordModel = new GeneratedPasswordModel();

		// Ambil opsi dari form
		$length = $this->request->getPost('length');
		$includeSymbols = $this->request->getPost('include_symbols') ? true : false;
		$includeLetters = $this->request->getPost('include_letters') ? true : false;
		$includeNumbers = $this->request->getPost('include_numbers') ? true : false;

		// Validasi panjang password
		if ($length < 4 || $length > 64) {
			return redirect()->to('/home/generate')->with('error', 'Panjang password harus antara 4 dan 64 karakter.');
		}

		// Generate password sesuai opsi
		$password = $this->generateCustomPassword($length, $includeSymbols, $includeLetters, $includeNumbers);

		// Ambil ID user dari form
		$userId = $this->request->getPost('user_id');

		// Cek apakah user sudah memiliki password
		$existingPassword = $generatedPasswordModel->where('user_id', $userId)->first();

		// Data yang akan disimpan/diupdate
		$data = [
			'password' => $password,
			'created_at' => date('Y-m-d H:i:s'),
		];

		if ($existingPassword) {
			// Jika sudah ada, update data
			$generatedPasswordModel->update($existingPassword['id'], $data);
		} else {
			// Jika belum ada, tambahkan user_id dan simpan data baru
			$data['user_id'] = $userId;
			$generatedPasswordModel->save($data);
		}

		// Redirect ke halaman generate password dengan flash message
		return redirect()->to('/home/generate')->with('success', "Password berhasil dibuat");
	}

	private function generateCustomPassword($length, $includeSymbols, $includeLetters, $includeNumbers)
	{
		$symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';
		$letters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$numbers = '0123456789';

		$characterPool = '';

		if ($includeSymbols) {
			$characterPool .= $symbols;
		}
		if ($includeLetters) {
			$characterPool .= $letters;
		}
		if ($includeNumbers) {
			$characterPool .= $numbers;
		}

		// Jika pool kosong, default ke semua jenis karakter
		if ($characterPool === '') {
			$characterPool = $symbols . $letters . $numbers;
		}

		// Acak karakter
		$password = '';
		$poolLength = strlen($characterPool);
		for ($i = 0; $i < $length; $i++) {
			$password .= $characterPool[random_int(0, $poolLength - 1)];
		}

		return $password;
	}


	public function deleteAllPasswords()
	{
		$generatedPasswordModel = new GeneratedPasswordModel();

		// Dapatkan data pengguna yang login
		$currentUser = session()->get('user');

		if (!$currentUser) {
			// Jika session tidak ada, redirect ke login
			session()->setFlashdata('error', 'Anda harus login terlebih dahulu.');
			return redirect()->to('/home/login');
		}

		// Validasi apakah pengguna adalah admin
		if ((int) $currentUser['id_level'] !== 1) {
			// Jika bukan admin, tolak akses
			session()->setFlashdata('error', 'Anda tidak memiliki izin untuk menghapus semua password.');
			return redirect()->to('/home/generate');
		}

		// Hapus semua password
		$generatedPasswordModel->truncate(); // Menghapus semua data di tabel

		// Redirect dengan flash message
		session()->setFlashdata('success', 'Semua password berhasil dihapus.');
		return redirect()->to('/home/generate');
	}

	public function changeToGeneratedPassword()
	{
		$userModel = new UserModel();

		// Ambil data input
		$userId = $this->request->getPost('user_id');
		$currentPassword = $this->request->getPost('current_password');
		$generatedPassword = $this->request->getPost('generated_password');

		// Validasi pengguna dan password saat ini
		$user = $userModel->find($userId);

		if (!$user || !password_verify($currentPassword, $user['password'])) {
			// Jika password saat ini salah
			session()->setFlashdata('error', 'Current password is incorrect.');
			return redirect()->to('/home/generate');
		}

		// Update password ke password yang di-generate
		$hashedPassword = password_hash($generatedPassword, PASSWORD_BCRYPT);
		$userModel->update($userId, ['password' => $hashedPassword]);

		// Redirect dengan pesan sukses
		session()->setFlashdata('success', 'Password successfully updated to the generated password.');
		return redirect()->to('/home/generate');
	}

	public function dashboard()
	{
		echo view('head');
		echo view('menu');
		echo view('dashboard');
		echo view('foot');
	}
}