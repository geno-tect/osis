(() => {
    const navLinks = Array.from(document.querySelectorAll("[data-nav-id]"));
    const navSections = Array.from(document.querySelectorAll("[data-nav-match]"));

    if (document.body.dataset.page === "beranda" && navLinks.length && navSections.length) {
        let ticking = false;

        const setActiveNav = (id) => {
            navLinks.forEach((link) => {
                const isActive = link.dataset.navId === id;
                link.classList.toggle("is-active", isActive);

                if (isActive) {
                    link.setAttribute("aria-current", "location");
                } else {
                    link.removeAttribute("aria-current");
                }
            });
        };

        const updateActiveNav = () => {
            const marker = window.scrollY + 140;
            let activeId = navSections[0].dataset.navMatch;

            navSections.forEach((section) => {
                const top = section.getBoundingClientRect().top + window.scrollY;

                if (top <= marker) {
                    activeId = section.dataset.navMatch;
                }
            });

            const nearBottom = window.innerHeight + window.scrollY >= document.documentElement.scrollHeight - 4;

            if (nearBottom) {
                activeId = "aspirasi";
            }

            setActiveNav(activeId);
            ticking = false;
        };

        window.addEventListener("scroll", () => {
            if (!ticking) {
                window.requestAnimationFrame(updateActiveNav);
                ticking = true;
            }
        }, { passive: true });

        window.addEventListener("resize", () => {
            if (!ticking) {
                window.requestAnimationFrame(updateActiveNav);
                ticking = true;
            }
        }, { passive: true });

        updateActiveNav();
    }

    const aspirationForm = document.querySelector("[data-aspiration-form]");

    if (aspirationForm) {
        const submitButton = aspirationForm.querySelector("[data-submit-button]");
        const submitLabel = aspirationForm.querySelector("[data-submit-label]");

        aspirationForm.addEventListener("submit", () => {
            if (!aspirationForm.checkValidity()) {
                return;
            }

            if (submitButton) {
                submitButton.disabled = true;
                submitButton.classList.add("is-loading");
                submitButton.setAttribute("aria-busy", "true");
            }

            if (submitLabel) {
                submitLabel.textContent = "Mengirim...";
            }
        });

        window.addEventListener("pageshow", () => {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.classList.remove("is-loading");
                submitButton.removeAttribute("aria-busy");
            }

            if (submitLabel) {
                submitLabel.textContent = "Kirim aspirasi";
            }
        });
    }

    const successCard = document.querySelector("[data-success]");
    const errorSummary = document.querySelector("[data-error-summary]");

    if (successCard) {
        successCard.focus();
    }

    if (errorSummary) {
        errorSummary.focus();
    }
})();
