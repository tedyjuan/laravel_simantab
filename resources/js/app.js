// resources/js/app.js

import 'flyonui/flyonui';
import Swal from 'sweetalert2';
document.addEventListener('DOMContentLoaded', initAdminUI);
document.addEventListener('livewire:navigated', initAdminUI);

function initAdminUI() {
    // Profile Dropdown Toggle Logic
    const profileBtn = document.getElementById('profileBtn');
    const profileDropdown = document.getElementById('profileDropdown');
    const profileChevron = document.getElementById('profileChevron');

    if (profileBtn && profileDropdown && !profileBtn.dataset.bound) {
        profileBtn.dataset.bound = 'true';
        profileBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            profileDropdown.classList.toggle('hidden');
            if (profileChevron) profileChevron.classList.toggle('rotate-180');
        });

        document.addEventListener('click', (e) => {
            if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
                profileDropdown.classList.add('hidden');
                if (profileChevron) profileChevron.classList.remove('rotate-180');
            }
        });
    }

    // Mobile and Desktop Sidebar Toggle Logic
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');
    const mobileOverlay = document.getElementById('mobileOverlay');

    if (toggleBtn && sidebar && !toggleBtn.dataset.bound) {
        toggleBtn.dataset.bound = 'true';
        toggleBtn.addEventListener('click', function () {
            if (window.innerWidth >= 1024) {
                sidebar.classList.toggle('sidebar-collapsed');
            } else {
                sidebar.classList.toggle('-translate-x-full');
                mobileOverlay.classList.toggle('hidden');
                setTimeout(() => mobileOverlay.classList.toggle('opacity-0'), 10);
            }
        });
    }

    if (mobileOverlay && !mobileOverlay.dataset.bound) {
        mobileOverlay.dataset.bound = 'true';
        mobileOverlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            mobileOverlay.classList.add('opacity-0');
            setTimeout(() => mobileOverlay.classList.add('hidden'), 300);
        });
    }
}

// =========================
// LOGOUT CONFIRMATION
// =========================
window.handleLogout = async function () {

    const result = await Swal.fire({
        icon: 'warning',
        title: 'Konfirmasi Keluar',
        text: 'Apakah Anda yakin ingin keluar dari aplikasi?',
        showCancelButton: true,
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#1555d4ff'
    });


    if (result.isConfirmed) {
        document.getElementById('logoutForm').submit();
    }

};