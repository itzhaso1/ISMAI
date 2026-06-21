import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const root = document.documentElement;
const savedTheme = localStorage.getItem('theme') || 'light';
root.dataset.theme = savedTheme;

document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const nextTheme = root.dataset.theme === 'dark' ? 'light' : 'dark';
        root.dataset.theme = nextTheme;
        localStorage.setItem('theme', nextTheme);
    });
});

const navToggle = document.querySelector('[data-nav-toggle]');
const primaryNav = document.querySelector('[data-primary-nav]');
if (navToggle && primaryNav) {
    navToggle.addEventListener('click', () => {
        const isOpen = primaryNav.classList.toggle('open');
        navToggle.setAttribute('aria-expanded', String(isOpen));
    });
}

const debounce = (callback, delay = 220) => {
    let timeout;
    return (...args) => {
        clearTimeout(timeout);
        timeout = setTimeout(() => callback(...args), delay);
    };
};

document.querySelectorAll('[data-live-search]').forEach((form) => {
    const input = form.querySelector('[data-search-input]');
    const results = form.querySelector('[data-search-results]');
    if (!input || !results) return;

    const renderEmpty = () => {
        results.innerHTML = `<div class="empty-state">${document.documentElement.lang === 'ar' ? 'لا توجد منتجات مطابقة.' : 'No matching products found.'}</div>`;
        results.classList.add('active');
    };

    const search = debounce(async () => {
        const query = input.value.trim();
        if (query.length < 2) {
            results.classList.remove('active');
            results.innerHTML = '';
            return;
        }

        try {
            const { data } = await axios.get('/search/suggestions', { params: { q: query } });
            if (!data.length) {
                renderEmpty();
                return;
            }
            results.innerHTML = data.map((item) => `
                <a class="search-result-item" href="${item.url}">
                    <img src="${item.image}" alt="${item.name}" loading="lazy">
                    <span><strong>${item.name}</strong><small>${item.category || ''}</small></span>
                    <b>${item.price}</b>
                </a>
            `).join('');
            results.classList.add('active');
        } catch (error) {
            results.classList.remove('active');
        }
    });

    input.addEventListener('input', search);
    document.addEventListener('click', (event) => {
        if (!form.contains(event.target)) results.classList.remove('active');
    });
});

document.querySelectorAll('[data-hero-slider]').forEach((slider) => {
    const slides = [...slider.querySelectorAll('.hero-slide')];
    const dots = slider.querySelector('[data-hero-dots]');
    if (!slides.length || !dots) return;

    let activeIndex = 0;
    const activate = (index) => {
        slides[activeIndex].classList.remove('active');
        dots.children[activeIndex]?.classList.remove('active');
        activeIndex = index;
        slides[activeIndex].classList.add('active');
        dots.children[activeIndex]?.classList.add('active');
    };

    slides.forEach((_, index) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = index === 0 ? 'active' : '';
        button.addEventListener('click', () => activate(index));
        dots.appendChild(button);
    });

    setInterval(() => activate((activeIndex + 1) % slides.length), 5500);
});
