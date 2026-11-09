/**
 * Single post: reading progress bar, copy-link and native share buttons.
 */

document.addEventListener('DOMContentLoaded', function () {
    const bar = document.querySelector('.reading-progress__bar');
    const article = document.querySelector('.single-post-article .entry-content');

    if (bar && article) {
        let ticking = false;
        const update = function () {
            const rect = article.getBoundingClientRect();
            const total = rect.height - window.innerHeight;
            const read = Math.min(Math.max(-rect.top, 0), Math.max(total, 1));
            bar.style.transform = 'scaleX(' + (total > 0 ? read / total : 1) + ')';
            ticking = false;
        };
        window.addEventListener('scroll', function () {
            if (!ticking) {
                window.requestAnimationFrame(update);
                ticking = true;
            }
        }, { passive: true });
        update();
    }

    const status = document.querySelector('.entry-share__status');
    const announce = function (text) {
        if (!status) {
            return;
        }
        status.textContent = text;
        window.setTimeout(function () {
            status.textContent = '';
        }, 2000);
    };

    document.querySelectorAll('.js-copy-link').forEach(function (button) {
        button.addEventListener('click', function () {
            if (!navigator.clipboard) {
                return;
            }
            navigator.clipboard.writeText(button.dataset.url).then(function () {
                announce('Link copied');
            });
        });
    });

    document.querySelectorAll('.js-share').forEach(function (button) {
        if (!navigator.share) {
            return;
        }
        button.hidden = false;
        button.addEventListener('click', function () {
            navigator.share({ title: button.dataset.title, url: button.dataset.url }).catch(function () {});
        });
    });
});
