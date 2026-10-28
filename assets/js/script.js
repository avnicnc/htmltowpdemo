/* ===== header ===== */
/* =========================================================
   HEADER JAVASCRIPT
   Interactions: Megamenu, Mobile Navigation Drawer, Language Toggle
   ========================================================= */

(function () {
    "use strict";

    var header = document.querySelector(".header-section");
    if (!header) return;

    /* ---------------------------------------------------------
       1. Megamenu (Desktop)
       --------------------------------------------------------- */
    var megamenuToggle = header.querySelector("[data-megamenu-toggle]");
    var megamenuPanel = header.querySelector("[data-megamenu-panel]");
    var megamenuItem = header.querySelector("[data-megamenu-item]");
    var closeTimeout = null;

    function openMegamenu() {
        if (closeTimeout) {
            clearTimeout(closeTimeout);
            closeTimeout = null;
        }
        if (megamenuPanel && megamenuItem) {
            megamenuPanel.classList.add("is-open");
            megamenuItem.classList.add("is-active");
            if (megamenuToggle) {
                megamenuToggle.setAttribute("aria-expanded", "true");
            }
        }
    }

    function closeMegamenu() {
        if (closeTimeout) clearTimeout(closeTimeout);
        closeTimeout = setTimeout(function () {
            if (megamenuPanel && megamenuItem) {
                megamenuPanel.classList.remove("is-open");
                megamenuItem.classList.remove("is-active");
                if (megamenuToggle) {
                    megamenuToggle.setAttribute("aria-expanded", "false");
                }
            }
        }, 150);
    }

    if (megamenuToggle && megamenuPanel && megamenuItem) {
        // Hover handling
        megamenuItem.addEventListener("mouseenter", openMegamenu);
        megamenuItem.addEventListener("mouseleave", closeMegamenu);
        megamenuPanel.addEventListener("mouseenter", openMegamenu);
        megamenuPanel.addEventListener("mouseleave", closeMegamenu);

        // Click handling for touch/laptop
        megamenuToggle.addEventListener("click", function (e) {
            e.preventDefault();
            var isOpen = megamenuPanel.classList.contains("is-open");
            if (isOpen) {
                closeMegamenu();
            } else {
                openMegamenu();
            }
        });
    }

    /* ---------------------------------------------------------
       2. Language Switcher Toggle
       --------------------------------------------------------- */
    var langToggle = header.querySelector("[data-lang-toggle]");
    var langWrapper = header.querySelector("[data-lang-wrapper]");

    var mobileLanguage = header.querySelector("[data-mobile-language]");
    if (langWrapper && mobileLanguage) {
        var languageHome = document.createComment("Language selector desktop position");
        langWrapper.before(languageHome);
        var mobileLanguageQuery = window.matchMedia("(max-width: 767px)");
        function placeLanguageSelector() {
            langWrapper.classList.remove("is-open");
            if (langToggle) langToggle.setAttribute("aria-expanded", "false");
            if (mobileLanguageQuery.matches) mobileLanguage.appendChild(langWrapper);
            else languageHome.after(langWrapper);
        }
        mobileLanguageQuery.addEventListener("change", placeLanguageSelector);
        placeLanguageSelector();
    }

    if (langToggle && langWrapper) {
        var langItems = langWrapper.querySelectorAll(".header-section-topbar-lang-item");
        var langLabel = langToggle.querySelector("[data-lang-label]");
        var langFlag = langToggle.querySelector(".header-section-topbar-flag img");

        function selectLanguage(item) {
            var label = item.querySelector("span:last-child").textContent.trim();
            var flag = item.querySelector("img");
            if (langLabel) langLabel.textContent = label;
            if (langFlag && flag) {
                langFlag.src = flag.getAttribute("src");
                langFlag.alt = flag.alt;
            }
            langItems.forEach(function (option) {
                var selected = option === item;
                option.classList.toggle("is-active", selected);
                if (selected) option.setAttribute("aria-current", "true");
                else option.removeAttribute("aria-current");
            });
            langWrapper.classList.remove("is-open");
            langToggle.setAttribute("aria-expanded", "false");
        }

        var savedLanguage;
        try { savedLanguage = localStorage.getItem("gia-premix-language"); } catch (e) { /* Storage may be unavailable. */ }
        langItems.forEach(function (item) {
            if (item.getAttribute("href") === savedLanguage || (!savedLanguage && item.classList.contains("is-active"))) {
                selectLanguage(item);
            }
            item.addEventListener("click", function (e) {
                e.preventDefault();
                selectLanguage(item);
                try { localStorage.setItem("gia-premix-language", item.getAttribute("href")); } catch (error) { /* Selection still works without storage. */ }
                langToggle.focus();
            });
        });

        langToggle.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();
            var isOpen = langWrapper.classList.contains("is-open");
            langWrapper.classList.toggle("is-open", !isOpen);
            langToggle.setAttribute("aria-expanded", String(!isOpen));
        });

        document.addEventListener("click", function (e) {
            if (!langWrapper.contains(e.target)) {
                langWrapper.classList.remove("is-open");
                langToggle.setAttribute("aria-expanded", "false");
            }
        });
    }

    /* ---------------------------------------------------------
       3. Mobile Navigation Drawer
       --------------------------------------------------------- */
    var mobileToggle = header.querySelector("[data-mobile-toggle]");
    var mobileDrawer = header.querySelector("[data-mobile-drawer]");
    var mobileBackdrop = header.querySelector("[data-mobile-backdrop]");
    var mobileClose = header.querySelector("[data-mobile-close]");

    function openMobileDrawer() {
        if (mobileDrawer && mobileBackdrop && mobileToggle) {
            mobileDrawer.classList.add("is-open");
            mobileBackdrop.classList.add("is-open");
            mobileToggle.classList.add("is-active");
            mobileToggle.setAttribute("aria-expanded", "true");
            document.body.style.overflow = "hidden";
        }
    }

    function closeMobileDrawer() {
        if (mobileDrawer && mobileBackdrop && mobileToggle) {
            mobileDrawer.classList.remove("is-open");
            mobileBackdrop.classList.remove("is-open");
            mobileToggle.classList.remove("is-active");
            mobileToggle.setAttribute("aria-expanded", "false");
            document.body.style.overflow = "";
        }
    }

    if (mobileToggle) {
        mobileToggle.addEventListener("click", function () {
            var isOpen = mobileDrawer && mobileDrawer.classList.contains("is-open");
            if (isOpen) {
                closeMobileDrawer();
            } else {
                openMobileDrawer();
            }
        });
    }

    if (mobileClose) {
        mobileClose.addEventListener("click", closeMobileDrawer);
    }

    if (mobileBackdrop) {
        mobileBackdrop.addEventListener("click", closeMobileDrawer);
    }

    /* ---------------------------------------------------------
       4. Mobile Accordion for Products Submenu
       --------------------------------------------------------- */
    var accordionBtns = header.querySelectorAll("[data-mobile-accordion-btn]");
    accordionBtns.forEach(function (btn) {
        btn.addEventListener("click", function () {
            var parent = btn.closest(".header-section-mobile-accordion-item");
            if (parent) {
                var isOpen = parent.classList.contains("is-open");
                parent.classList.toggle("is-open", !isOpen);
                btn.setAttribute("aria-expanded", String(!isOpen));
            }
        });
    });

    /* ---------------------------------------------------------
       5. AJAX Live Search Auto-Suggestion
       --------------------------------------------------------- */
    var searchInputs = header.querySelectorAll("#desktop-search, #mobile-search");

    searchInputs.forEach(function (input) {
        var form = input.closest("form");
        if (!form) return;

        // Create dropdown container
        var dropdown = document.createElement("div");
        dropdown.className = "live-search-dropdown";
        dropdown.setAttribute("role", "listbox");
        dropdown.setAttribute("aria-label", "Suggestions de recherche");
        form.appendChild(dropdown);

        var debounceTimer = null;
        var currentController = null;

        function closeDropdown() {
            dropdown.classList.remove("is-open");
            dropdown.innerHTML = "";
        }

        input.addEventListener("input", function () {
            var term = input.value.trim();
            if (debounceTimer) clearTimeout(debounceTimer);

            if (term.length < 2) {
                closeDropdown();
                return;
            }

            dropdown.innerHTML = '<div class="live-search-loading">' + ((window.giapremix_ajax && window.giapremix_ajax.searching_text) || 'Recherche en cours...') + '</div>';
            dropdown.classList.add("is-open");

            debounceTimer = setTimeout(function () {
                if (!window.giapremix_ajax || !window.giapremix_ajax.ajax_url) return;

                if (currentController) {
                    currentController.abort();
                }
                currentController = new AbortController();

                var ajaxUrl = window.giapremix_ajax.ajax_url + 
                    '?action=giapremix_live_search' + 
                    '&term=' + encodeURIComponent(term) + 
                    '&nonce=' + encodeURIComponent(window.giapremix_ajax.nonce || '');

                fetch(ajaxUrl, { signal: currentController.signal })
                    .then(function (res) { return res.json(); })
                    .then(function (res) {
                        if (!res || !res.success || !res.data) {
                            dropdown.innerHTML = '<div class="live-search-empty">' + ((window.giapremix_ajax && window.giapremix_ajax.no_results_text) || 'Aucun résultat trouvé.') + '</div>';
                            return;
                        }

                        var results = res.data.results || [];
                        if (results.length === 0) {
                            dropdown.innerHTML = '<div class="live-search-empty">' + ((window.giapremix_ajax && window.giapremix_ajax.no_results_text) || 'Aucun résultat trouvé.') + '</div>';
                            return;
                        }

                        var html = '<ul class="live-search-list" role="list">';
                        results.forEach(function (item) {
                            html += '<li class="live-search-item" role="option">';
                            html += '<a href="' + item.url + '" class="live-search-link">';
                            if (item.thumbnail) {
                                html += '<img src="' + item.thumbnail + '" class="live-search-thumb" alt="" />';
                            }
                            html += '<div class="live-search-info">';
                            html += '<div class="live-search-item-title">' + item.title + '</div>';
                            if (item.badge) {
                                html += '<span class="live-search-item-badge">' + item.badge + '</span>';
                            }
                            html += '</div>';
                            html += '</a>';
                            html += '</li>';
                        });
                        html += '</ul>';

                        var allResultsUrl = (window.giapremix_ajax && window.giapremix_ajax.home_url || '/') + '?s=' + encodeURIComponent(term);
                        html += '<div class="live-search-footer"><a href="' + allResultsUrl + '" class="live-search-view-all">Voir tous les résultats (' + res.data.total + ') &rarr;</a></div>';

                        dropdown.innerHTML = html;
                    })
                    .catch(function (err) {
                        if (err.name !== 'AbortError') {
                            dropdown.innerHTML = '<div class="live-search-empty">Une erreur est survenue.</div>';
                        }
                    });
            }, 250);
        });

        // Close on escape or outside click
        document.addEventListener("click", function (e) {
            if (!form.contains(e.target)) {
                closeDropdown();
            }
        });

        input.addEventListener("keydown", function (e) {
            if (e.key === "Escape") {
                closeDropdown();
            }
        });
    });

    /* ---------------------------------------------------------
       6. Global Keyboard & Click Outside Handlers
       --------------------------------------------------------- */
    document.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            closeMegamenu();
            closeMobileDrawer();
            if (langWrapper) {
                langWrapper.classList.remove("is-open");
                if (langToggle) langToggle.setAttribute("aria-expanded", "false");
            }
        }
    });

    document.addEventListener("click", function (e) {
        if (megamenuItem && !megamenuItem.contains(e.target) && megamenuPanel && !megamenuPanel.contains(e.target)) {
            if (closeTimeout) clearTimeout(closeTimeout);
            if (megamenuPanel && megamenuItem) {
                megamenuPanel.classList.remove("is-open");
                megamenuItem.classList.remove("is-active");
                if (megamenuToggle) megamenuToggle.setAttribute("aria-expanded", "false");
            }
        }
    });

}());

;
/* ===== hero ===== */
/* =========================================================
   HERO BANNER JAVASCRIPT
   Interactions: Carousel / Slider, Autoplay, Indicator Dots
   ========================================================= */

(function () {
    "use strict";

    var hero = document.querySelector(".hero-section");
    if (!hero) return;

    var slides = hero.querySelectorAll("[data-hero-slide]");
    var dots = hero.querySelectorAll("[data-hero-dot]");
    if (!slides.length) return;

    var currentIndex = 0;
    var totalSlides = slides.length;
    var autoplayTimer = null;
    /* Faster animation cycle per user request (3500ms) */
    var intervalDuration = 3500;

    function goToSlide(index) {
        if (index < 0) {
            index = totalSlides - 1;
        } else if (index >= totalSlides) {
            index = 0;
        }

        slides.forEach(function (slide, i) {
            var isActive = (i === index);
            slide.classList.toggle("is-active", isActive);
            slide.setAttribute("aria-hidden", String(!isActive));
        });

        dots.forEach(function (dot, i) {
            var isActive = (i === index);
            dot.classList.toggle("is-active", isActive);
            dot.setAttribute("aria-selected", String(isActive));
        });

        // Toggle dark state on root if current slide is dark variant
        var currentSlide = slides[index];
        if (currentSlide && currentSlide.classList.contains("hero-section-slide-dark")) {
            hero.classList.add("is-dark-active");
        } else {
            hero.classList.remove("is-dark-active");
        }

        currentIndex = index;
    }

    function startAutoplay() {
        stopAutoplay();
        autoplayTimer = setInterval(function () {
            goToSlide(currentIndex + 1);
        }, intervalDuration);
    }

    function stopAutoplay() {
        if (autoplayTimer) {
            clearInterval(autoplayTimer);
            autoplayTimer = null;
        }
    }

    // Dot indicators click
    dots.forEach(function (dot, i) {
        dot.addEventListener("click", function () {
            goToSlide(i);
            startAutoplay();
        });
    });

    // Pause autoplay on mouse enter, resume on leave
    hero.addEventListener("mouseenter", stopAutoplay);
    hero.addEventListener("mouseleave", startAutoplay);

    // Keyboard navigation
    hero.addEventListener("keydown", function (e) {
        if (e.key === "ArrowLeft") {
            goToSlide(currentIndex - 1);
            startAutoplay();
        } else if (e.key === "ArrowRight") {
            goToSlide(currentIndex + 1);
            startAutoplay();
        }
    });

    // Start carousel
    startAutoplay();

}());

;
/* ===== products-slider ===== */
/**
 * Products Slider Section Module
 * Section 02 — "Solutions de sécurité industrielle pour environnements dangereux"
 * Features: Arrow navigation, dynamic progress bar, drag-to-scroll, and accessibility
 */

(function () {
    'use strict';

    function initProductsSlider() {
        const section = document.querySelector('.products-section');
        if (!section) return;

        const wrapper = section.querySelector('.products-section-slider-wrapper');
        const track = section.querySelector('.products-section-track');
        const progressThumb = section.querySelector('.products-section-progress-thumb');
        const prevBtn = section.querySelector('[data-products-prev]');
        const nextBtn = section.querySelector('[data-products-next]');

        if (!track || !progressThumb) return;

        function updateSliderState() {
            const scrollLeft = track.scrollLeft;
            const maxScroll = track.scrollWidth - track.clientWidth;

            if (maxScroll <= 0) {
                progressThumb.style.width = '100%';
                progressThumb.style.transform = 'translateX(0)';
                if (prevBtn) prevBtn.disabled = true;
                if (nextBtn) nextBtn.disabled = true;
                if (wrapper) wrapper.classList.remove('has-scroll-right');
                return;
            }

            // Ratio of viewport to total scroll width
            const visibleRatio = Math.min(1, Math.max(0.18, track.clientWidth / track.scrollWidth));
            const thumbWidthPercent = visibleRatio * 100;
            const progressRatio = Math.min(1, Math.max(0, scrollLeft / maxScroll));
            const maxTranslatePercent = (100 - thumbWidthPercent) / visibleRatio;

            progressThumb.style.width = `${thumbWidthPercent}%`;
            progressThumb.style.transform = `translateX(${progressRatio * maxTranslatePercent}%)`;

            // Update arrow button states
            if (prevBtn) prevBtn.disabled = scrollLeft <= 4;
            if (nextBtn) nextBtn.disabled = scrollLeft >= maxScroll - 4;

            // Toggle fade gradient on the right
            if (wrapper) {
                if (scrollLeft < maxScroll - 10) {
                    wrapper.classList.add('has-scroll-right');
                } else {
                    wrapper.classList.remove('has-scroll-right');
                }
            }
        }

        function getScrollStep() {
            const firstCard = track.querySelector('.products-section-card');
            if (firstCard) {
                const cardWidth = firstCard.getBoundingClientRect().width;
                const gap = 20;
                return cardWidth + gap;
            }
            return 385;
        }

        // Prev & Next Button Clicks
        if (prevBtn) {
            prevBtn.addEventListener('click', function () {
                const step = getScrollStep();
                track.scrollBy({ left: -step, behavior: 'smooth' });
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', function () {
                const step = getScrollStep();
                track.scrollBy({ left: step, behavior: 'smooth' });
            });
        }

        // Scroll listener with requestAnimationFrame throttling
        let isTicking = false;
        track.addEventListener('scroll', function () {
            if (!isTicking) {
                window.requestAnimationFrame(function () {
                    updateSliderState();
                    isTicking = false;
                });
                isTicking = true;
            }
        }, { passive: true });

        // Drag to scroll functionality
        let isDown = false;
        let startX = 0;
        let initialScrollLeft = 0;
        let hasMoved = false;

        track.addEventListener('mousedown', function (e) {
            // Don't trigger drag on button or link clicks
            if (e.target.closest('button')) return;
            isDown = true;
            hasMoved = false;
            startX = e.pageX - track.offsetLeft;
            initialScrollLeft = track.scrollLeft;
            track.classList.add('is-dragging');
        });

        window.addEventListener('mouseup', function () {
            if (!isDown) return;
            isDown = false;
            track.classList.remove('is-dragging');
        });

        track.addEventListener('mousemove', function (e) {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - track.offsetLeft;
            const walk = (x - startX) * 1.5;
            if (Math.abs(walk) > 5) {
                hasMoved = true;
            }
            track.scrollLeft = initialScrollLeft - walk;
        });

        // Prevent unintentional clicks when dragging
        track.addEventListener('click', function (e) {
            if (hasMoved) {
                e.preventDefault();
                e.stopPropagation();
            }
        }, true);

        // ---------------------------------------------------------
        // Quick View Modal Functionality (Figma: Node 330:786)
        // ---------------------------------------------------------
        const modal = document.getElementById('product-quickview-modal');
        const modalImg = document.getElementById('products-modal-image');
        const modalTitle = document.getElementById('products-modal-title');
        let lastFocusedElement = null;

        function openModal(imgSrc, titleText, triggerBtn) {
            if (!modal) return;
            lastFocusedElement = triggerBtn || document.activeElement;

            if (modalImg && imgSrc) {
                modalImg.src = imgSrc;
                modalImg.alt = titleText || 'Aperçu du produit';
            }
            if (modalTitle && titleText) {
                modalTitle.textContent = titleText;
            }

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';

            const closeBtn = modal.querySelector('.products-modal-close');
            if (closeBtn) closeBtn.focus();
        }

        function closeModal() {
            if (!modal || !modal.classList.contains('is-open')) return;
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';

            if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
                lastFocusedElement.focus();
            }
        }

        // Open modal when clicking eye buttons
        section.addEventListener('click', function (e) {
            const openBtn = e.target.closest('[data-modal-open]');
            if (!openBtn) return;
            e.preventDefault();
            e.stopPropagation();

            const imgSrc = openBtn.dataset.productImg || '';
            const titleText = openBtn.dataset.productTitle || '';
            openModal(imgSrc, titleText, openBtn);
        });

        // Close modal when clicking close button or backdrop
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target.closest('[data-modal-close]')) {
                    e.preventDefault();
                    closeModal();
                }
            });

            // Close on Escape key
            window.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && modal.classList.contains('is-open')) {
                    closeModal();
                }
            });
        }

        // Dynamically align wrapper's left edge with .container content edge and extend right to full screen
        function updateTrackAlignment() {
            const container = section.querySelector('.container');
            if (!container || !wrapper) return;
            const containerRect = container.getBoundingClientRect();
            const computedStyle = window.getComputedStyle(container);
            const paddingLeft = parseFloat(computedStyle.paddingLeft) || 24;
            const exactLeft = Math.max(24, Math.round(containerRect.left + paddingLeft));
            wrapper.style.marginLeft = `${exactLeft}px`;
            wrapper.style.width = `calc(100% - ${exactLeft}px)`;
            if (track) track.style.paddingLeft = '0px';
        }

        // Window resize observer
        window.addEventListener('resize', function () {
            updateTrackAlignment();
            updateSliderState();
        }, { passive: true });

        // Initial setup
        updateTrackAlignment();
        updateSliderState();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProductsSlider);
    } else {
        initProductsSlider();
    }
})();

;
/* ===== latest-news ===== */
/**
 * Latest news carousel
 * Mirrors the product slider interaction: arrows, progress, drag and edge fade.
 */
(function () {
    'use strict';

    function initLatestNewsSlider() {
        const section = document.querySelector('.latest-news-section');
        if (!section) return;

        const wrapper = section.querySelector('.latest-news-section-slider-wrapper');
        const track = section.querySelector('.latest-news-section-track');
        const progressThumb = section.querySelector('.latest-news-section-progress-thumb');
        const prevButton = section.querySelector('[data-news-prev]');
        const nextButton = section.querySelector('[data-news-next]');

        if (!wrapper || !track || !progressThumb) return;

        function updateAlignment() {
            const container = section.querySelector('.container');
            if (!container) return;

            const rect = container.getBoundingClientRect();
            const style = window.getComputedStyle(container);
            const paddingLeft = parseFloat(style.paddingLeft) || 24;
            const left = Math.max(24, Math.round(rect.left + paddingLeft));

            wrapper.style.marginLeft = `${left}px`;
            wrapper.style.width = `calc(100% - ${left}px)`;
        }

        function updateState() {
            const maxScroll = Math.max(0, track.scrollWidth - track.clientWidth);
            const scrollLeft = Math.max(0, track.scrollLeft);

            if (maxScroll <= 1) {
                progressThumb.style.width = '100%';
                progressThumb.style.transform = 'translateX(0)';
                wrapper.classList.remove('has-scroll-right');
                if (prevButton) prevButton.disabled = true;
                if (nextButton) nextButton.disabled = true;
                return;
            }

            const visibleRatio = Math.min(1, Math.max(0.18, track.clientWidth / track.scrollWidth));
            const thumbWidth = visibleRatio * 100;
            const progress = Math.min(1, scrollLeft / maxScroll);
            const maxTranslate = (100 - thumbWidth) / visibleRatio;

            progressThumb.style.width = `${thumbWidth}%`;
            progressThumb.style.transform = `translateX(${progress * maxTranslate}%)`;
            wrapper.classList.toggle('has-scroll-right', scrollLeft < maxScroll - 10);

            if (prevButton) prevButton.disabled = scrollLeft <= 4;
            if (nextButton) nextButton.disabled = scrollLeft >= maxScroll - 4;
        }

        function getScrollStep() {
            const card = track.querySelector('.latest-news-section-card');
            return card ? card.getBoundingClientRect().width + 20 : 405;
        }

        if (prevButton) {
            prevButton.addEventListener('click', function () {
                track.scrollBy({ left: -getScrollStep(), behavior: 'smooth' });
            });
        }

        if (nextButton) {
            nextButton.addEventListener('click', function () {
                track.scrollBy({ left: getScrollStep(), behavior: 'smooth' });
            });
        }

        let ticking = false;
        track.addEventListener('scroll', function () {
            if (ticking) return;
            ticking = true;
            window.requestAnimationFrame(function () {
                updateState();
                ticking = false;
            });
        }, { passive: true });

        let dragging = false;
        let moved = false;
        let startX = 0;
        let startScrollLeft = 0;

        track.addEventListener('mousedown', function (event) {
            if (event.button !== 0) return;
            dragging = true;
            moved = false;
            startX = event.pageX - track.offsetLeft;
            startScrollLeft = track.scrollLeft;
            track.classList.add('is-dragging');
        });

        window.addEventListener('mouseup', function () {
            if (!dragging) return;
            dragging = false;
            track.classList.remove('is-dragging');
        });

        track.addEventListener('mousemove', function (event) {
            if (!dragging) return;
            event.preventDefault();
            const distance = (event.pageX - track.offsetLeft - startX) * 1.5;
            moved = moved || Math.abs(distance) > 5;
            track.scrollLeft = startScrollLeft - distance;
        });

        track.addEventListener('click', function (event) {
            if (!moved) return;
            event.preventDefault();
            event.stopPropagation();
            moved = false;
        }, true);

        track.addEventListener('keydown', function (event) {
            if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;
            event.preventDefault();
            track.scrollBy({
                left: event.key === 'ArrowLeft' ? -getScrollStep() : getScrollStep(),
                behavior: 'smooth'
            });
        });

        window.addEventListener('resize', function () {
            updateAlignment();
            updateState();
        }, { passive: true });

        updateAlignment();
        updateState();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initLatestNewsSlider);
    } else {
        initLatestNewsSlider();
    }
})();

;
/* ===== scroll-to-top ===== */
(function () {
    "use strict";
    var button = document.querySelector(".scroll-to-top");
    if (!button) return;

    function updateVisibility() {
        var visible = window.scrollY >= 400;
        button.classList.toggle("is-visible", visible);
        button.inert = !visible;
        button.setAttribute("aria-hidden", String(!visible));
    }

    button.hidden = false;
    window.addEventListener("scroll", updateVisibility, { passive: true });
    updateVisibility();
    button.addEventListener("click", function () {
        var reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
        window.scrollTo({ top: 0, behavior: reducedMotion ? "instant" : "smooth" });
    });
}());


