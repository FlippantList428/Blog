/**
 * Blog o Linuxie - Main JavaScript
 *
 * Ten plik zarządza prostym interfejsem klienta:
 * - menu hamburgerowym (mobilne)
 * - podstawową walidacją formularzy (rejestracja)
 * - mock dodawania komentarzy (dynamicznie do DOM)
 * - przełącznikiem motywu (localStorage)
 * - filtrowaniem listy dystrybucji
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Logika menu hamburgerowego (dla mniejszych ekranów)
    //    Przełącza klasy `active` na przycisku i elemencie nav, co powoduje
    //    pokazanie/ukrycie menu przez CSS.
    const hamburger = document.getElementById('hamburger');
    const navMenu = document.getElementById('nav-menu');

    if (hamburger && navMenu) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Zamknij menu po kliknięciu w link nawigacyjny (użyteczne na urządzeniach mobilnych)
        document.querySelectorAll('#nav-menu .btn').forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    }

    // 2. Walidacja formularzy prostego typu (jeśli formularze występują na stronie)
    //    Tutaj sprawdzamy jedynie zgodność haseł podczas rejestracji.
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            if (form.id === 'registerForm') {
                const password = document.getElementById('password');
                const confirmPassword = document.getElementById('confirm-password');

                // Jeśli pola istnieją i hasła się różnią — zablokuj wysłanie i pokaż alert.
                if (password && confirmPassword && password.value !== confirmPassword.value) {
                    e.preventDefault();
                    alert('Hasła nie są identyczne!');
                }
            }
        });
    });
});

/**
 * Dodaje komentarz do listy komentarzy (funkcja mock, działa tylko po stronie klienta).
 * Tworzy element <li> z nagłówkiem i treścią i dopina go do listy komentarzy.
 * @param {number} articleId - identyfikator wpisu (służy do zbudowania id elementów w DOM)
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
    // Uwaga: użycie innerHTML wstawia nieprzetworzony HTML — istnieje ryzyko XSS
    // jeśli treść komentarza pochodzi od użytkownika. W bezpiecznej implementacji
    // warto stosować `textContent` lub sanitize'ować wartość przed wstawieniem.
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
 * Przełącznik motywu (jasny/ciemny).
 * - Sprawdza lokalne ustawienie w localStorage i ustawia klasę `dark-mode` na <body>.
 * - Po kliknięciu zapisuje preferencję w localStorage, aby zachować wybór użytkownika.
 */
document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;

    // Odczyt preferencji użytkownika z localStorage (jeśli istnieje)
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        body.classList.add('dark-mode');
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');

            // Zapis preferencji do localStorage
            if (body.classList.contains('dark-mode')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
        });
    }
});

/**
 * Filtrowanie dystrybucji na stronie głównej.
 * - Przyciski posiadają `data-filter`, a każdy wpis `data-tags`.
 * - Kliknięcie przycisku ustawia stan aktywności i pokazuje/ukrywa wpisy.
 */
document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const posts = document.querySelectorAll('.wpis');

    if (filterButtons.length > 0 && posts.length > 0) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const filter = btn.getAttribute('data-filter');

                // Zaktualizuj stan aktywności przycisków
                filterButtons.forEach(b => b.classList.remove('active'));
                btn.classList.add('active');

                // Pokaż lub ukryj posty w zależności od filtra
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

// Drobna uwaga architektoniczna:
// Możliwe są trzy oddzielne nasłuchy `DOMContentLoaded` — to bezpieczne, ale
// dla większych projektów warto spiąć inicjalizację w jedną funkcję aby łatwiej
// zarządzać zależnościami i kolejnością uruchamiania modułów.
