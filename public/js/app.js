// ================================
// KickMaster Custom JavaScript
// ================================

document.addEventListener('DOMContentLoaded', function () {

    // ---------- Delete Confirmation ----------
    // Ei code shob delete form e confirmation dialog dekhay, jate accidental delete na hoy
    document.querySelectorAll('.delete-form').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const confirmed = confirm('Are you sure you want to delete this? This action cannot be undone.');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    });

    // ---------- Auto-hide alert messages after 4 seconds ----------
    document.querySelectorAll('.alert').forEach(function (alertBox) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alertBox);
            bsAlert.close();
        }, 4000);
    });
});