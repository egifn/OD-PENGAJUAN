// togglePassword.js

// Ambil referensi elemen input password
const passwordInput = document.getElementById('password');

// Ambil referensi elemen tombol mata
const toggleButton = document.getElementById('togglePassword');

// Tambahkan event listener untuk mengubah tipe input password
toggleButton.addEventListener('click', function () {
  const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
  passwordInput.setAttribute('type', type);
});