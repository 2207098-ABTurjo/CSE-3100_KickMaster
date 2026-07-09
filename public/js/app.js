// ================================
// KickMaster Custom JavaScript
// ================================

document.addEventListener('DOMContentLoaded', function () {

    // ---------- Auto-hide alert messages after 4 seconds ----------
    document.querySelectorAll('.alert').forEach(function (alertBox) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alertBox);
            bsAlert.close();
        }, 4000);
    });
});