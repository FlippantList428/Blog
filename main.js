/**
 * Blog o Linuxie - Main JavaScript
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Hamburger Menu Logic
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');

    if (hamburger && navMenu) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Close menu when clicking on links
        document.querySelectorAll('#nav-menu .btn').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    }

    // 2. Form validation for Login & Register (if present)
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            if (form.id === 'registerForm') {
                const password = document.getElementById('password');
                const confirmPassword = document.getElementById('confirm-password');

                if (password && confirmPassword && password.value !== confirmPassword.value) {
                    e.preventDefault();
                    alert('Hasła nie są identyczne!');
                }
            }
        });
    });
});

/**
 * Adds a comment to a list (mock functionality)
 * @param {number} articleId 
 */
function addComment(articleId) {
    const input = document.getElementById(`comment-input-${articleId}`);
    const list = document.getElementById(`comments-${articleId}`);

    if (!input || !list) return;

    if (input.value.trim() === '') {
        alert('Proszę wpisać treść komentarza.');
        return;
    }

    const now = new Date();
    const dateStr = now.toISOString().split('T')[0];

    const li = document.createElement('li');
    li.className = 'comment-item animate-fade';
    li.innerHTML = `
        <div class="comment-header">
            <span class="comment-author">Gość</span>
            <span class="comment-date">${dateStr}</span>
        </div>
        <div class="comment-body">${input.value.trim()}</div>
    `;

    list.appendChild(li);
    input.value = '';
}
