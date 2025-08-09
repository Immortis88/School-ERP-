function showToast(message, redirectUrl = null) {
    const toastBody = document.getElementById('toast-alert-message');
    const toastElement = document.getElementById('liveToast');
    toastBody.textContent = message;
    const toast = new bootstrap.Toast(toastElement, {
        animation: true,
        autohide: true,
    });
    toast.show();
    if (redirectUrl) {
        setTimeout(() => {
            window.location.href = redirectUrl;
        }, 800);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const role = urlParams.get('role');
    const error = urlParams.get('error');

    if (success === 'true' && role) {
        let redirectUrl;
        switch (role) {
            case 'admin':
                redirectUrl = 'admin_panel/ad_dashboard.php';
                break;
            case 'teacher':
                redirectUrl = 'teacher_panel/st_dashboard.php';
                break;
            case 'student':
                redirectUrl = 'student_panel/th_dashboard.php';
                break;
            default:
                showToast('Unknown role.', null);
                return;
        }
        showToast('Login Successful!', redirectUrl);
    } else if (error === 'invalid_password') {
        showToast('Invalid password.', null);
    } else if (error === 'user_not_found') {
        showToast('User not found.', null);
    }
});