import 'flyonui/flyonui';
import Swal from 'sweetalert2';
window.togglePassword = function () {
    const input = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    icon.innerHTML = isHidden
        ? `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.774 3.162 10.066 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.243L9.88 9.88"/>`
        : `<path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
};

// button login 
window.handleLogin = async function (e) {
    e.preventDefault();
    const form = document.getElementById('loginForm');
    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const usernameError = document.getElementById('usernameError');
    const passwordError = document.getElementById('passwordError');
    const btn = document.getElementById('loginBtn');
    const spinner = document.getElementById('loginSpinner');
    const text = document.getElementById('loginBtnText');
    // Reset error
    usernameError.textContent = '';
    usernameError.classList.add('hidden');
    passwordError.textContent = '';
    passwordError.classList.add('hidden');
    let isValid = true;
    // =========================
    // VALIDASI USERNAME
    // =========================
    if (username.value.trim() === '') {
        usernameError.textContent = 'Username wajib diisi.';
        usernameError.classList.remove('hidden');
        username.focus();
        isValid = false;
    }
    // =========================
    // VALIDASI PASSWORD
    // =========================
    if (password.value.trim() === '') {
        passwordError.textContent = 'Password wajib diisi.';
        passwordError.classList.remove('hidden');
        if (isValid) {
            password.focus();
        }
        isValid = false;
    }
    if (!isValid) {
        return false;
    }
    spinner.classList.remove('hidden');
    text.textContent = 'Memproses...';
    btn.disabled = true;
    btn.classList.add(
        'opacity-90',
        'cursor-not-allowed'
    );
    // =========================
    // KIRIM KE LARAVEL
    // =========================
    const formData = new FormData(form);
    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });
        const result = await response.json();
        // =========================
        // LOGIN BERHASIL
        // =========================
        if (response.ok && result.success) {
            window.location.href = result.redirect;
            return;
        }
        // =========================
        // LOGIN GAGAL
        // =========================
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: result.message ?? 'Username atau password salah.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    } catch (error) {
        console.error(error);
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Terjadi kesalahan.',
            text: 'Silakan coba lagi.',
            showConfirmButton: false,
            timer: 3000
        });
    } finally {
        spinner.classList.add('hidden');
        text.textContent = 'Masuk';
        btn.disabled = false;
        btn.classList.remove(
            'opacity-90',
            'cursor-not-allowed'
        );
    }
    return false;
};
