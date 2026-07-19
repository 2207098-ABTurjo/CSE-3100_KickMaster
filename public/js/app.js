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

    // ---------- Navbar Live Search (AJAX) ----------
    // Ei code search box e type korle page refresh chara result dekhay
    const searchInput = document.getElementById('navSearchInput');
    const searchResults = document.getElementById('navSearchResults');
    let searchTimer;

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimer);
            const keyword = this.value.trim();

            if (keyword.length < 2) {
                searchResults.classList.remove('show');
                searchResults.innerHTML = '';
                return;
            }

            // Typing thamar por 400ms wait kore tarpor request pathano hoy (debounce)
            searchTimer = setTimeout(function () {
                fetch(`/search?q=${encodeURIComponent(keyword)}`, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                })
                    .then(res => res.json())
                    .then(data => renderSearchResults(data))
                    .catch(() => {
                        searchResults.innerHTML = '<span class="p-2 text-muted d-block">There was a problem searching</span>';
                    });
            }, 400);
        });

        // Search box er baire click korle dropdown close hoye jabe
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.classList.remove('show');
            }
        });
    }

    // Search result gula HTML banaye dropdown e boshano hoy
    function renderSearchResults(data) {
        let html = '';

        (data.teams || []).forEach(team => {
            html += `<a href="/teams/${team.id}"><i class="bi bi-shield"></i> ${team.name} <small class="text-muted">(Team)</small></a>`;
        });

        (data.players || []).forEach(player => {
            html += `<a href="/players/${player.id}"><i class="bi bi-person"></i> ${player.name} <small class="text-muted">(Player)</small></a>`;
        });

        (data.matches || []).forEach(match => {
            const label = `${match.home_team ? match.home_team.name : ''} vs ${match.away_team ? match.away_team.name : ''}`;
            html += `<a href="/matches/${match.id}"><i class="bi bi-broadcast"></i> ${label} <small class="text-muted">(Match)</small></a>`;
        });

        if (!html) {
            html = '<span class="p-2 text-muted d-block">No results found</span>';
        }

        searchResults.innerHTML = html;
        searchResults.classList.add('show');
    }

    // ---------- Auto-hide alert messages after 4 seconds ----------
    document.querySelectorAll('.alert').forEach(function (alertBox) {
        setTimeout(function () {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alertBox);
            bsAlert.close();
        }, 4000);
    });
});