const opening = document.getElementById('opening');
const openButton = document.getElementById('openInvitation');

openButton?.addEventListener('click', () => {
    opening.classList.add('hidden');
    document.body.classList.remove('locked');
    window.setTimeout(() => opening.remove(), 900);
});

const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
            revealObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.12 });

document.querySelectorAll('.reveal').forEach((element) => revealObserver.observe(element));

const countdown = document.querySelector('.countdown');
if (countdown) {
    const target = new Date(countdown.dataset.date.replace(' ', 'T') + '+07:00').getTime();
    const renderCountdown = () => {
        const distance = Math.max(0, target - Date.now());
        const values = {
            days: Math.floor(distance / 86400000),
            hours: Math.floor((distance % 86400000) / 3600000),
            minutes: Math.floor((distance % 3600000) / 60000),
            seconds: Math.floor((distance % 60000) / 1000),
        };
        Object.entries(values).forEach(([id, value]) => {
            const node = document.getElementById(id);
            if (node) node.textContent = String(value).padStart(2, '0');
        });
    };
    renderCountdown();
    window.setInterval(renderCountdown, 1000);
}

const musicButton = document.getElementById('musicButton');
musicButton?.addEventListener('click', () => {
    musicButton.classList.toggle('playing');
    musicButton.textContent = musicButton.classList.contains('playing') ? '♪' : '♫';
});
