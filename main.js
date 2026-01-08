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

/**
 * Theme Toggle Functionality
 */
document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;

    // Check for saved theme preference
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        body.classList.add('dark-mode');
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');

            // Save preference
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        });
    }
});

/**
 * Filter distributions on the home page
 */
document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const posts = document.querySelectorAll('.wpis');

    if (filterButtons.length > 0 && posts.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.getAttribute('data-filter');

                // Update active state
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                // Filter posts
                posts.forEach(post => {
                    if (filter === 'all') {
                        post.classList.remove('hidden');
                    } else {
                        const tags = post.getAttribute('data-tags');
                        if (tags && tags.includes(filter)) {
                            post.classList.remove('hidden');
                        } else {
                            post.classList.add('hidden');
                        }
                    }
                });
            });
        });
    }
});
