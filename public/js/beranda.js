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

    const explorer = document.querySelector("[data-sekbid]");

    if (explorer) {
        const tabs = Array.from(explorer.querySelectorAll("[data-sekbid-tab]"));
        const panels = Array.from(explorer.querySelectorAll('[role="tabpanel"]'));

        if (tabs.length && panels.length) {
            const selectTab = (index, moveFocus = false) => {
                tabs.forEach((tab, tabIndex) => {
                    const selected = tabIndex === index;
                    tab.setAttribute("aria-selected", String(selected));
                    tab.tabIndex = selected ? 0 : -1;

                    if (selected) {
                        if (moveFocus) {
                            tab.focus();
                        }

                        tab.scrollIntoView({ block: "nearest", inline: "nearest" });
                    }
                });

                panels.forEach((panel, panelIndex) => {
                    panel.hidden = panelIndex !== index;
                });
            };

            tabs.forEach((tab, index) => {
                tab.addEventListener("click", () => selectTab(index));
            });

            explorer.addEventListener("keydown", (event) => {
                const currentIndex = tabs.indexOf(document.activeElement);

                if (currentIndex === -1) {
                    return;
                }

                let nextIndex = null;

                switch (event.key) {
                    case "ArrowRight":
                    case "ArrowDown":
                        nextIndex = (currentIndex + 1) % tabs.length;
                        break;
                    case "ArrowLeft":
                    case "ArrowUp":
                        nextIndex = (currentIndex - 1 + tabs.length) % tabs.length;
                        break;
                    case "Home":
                        nextIndex = 0;
                        break;
                    case "End":
                        nextIndex = tabs.length - 1;
                        break;
                    default:
                        return;
                }

                event.preventDefault();
                selectTab(nextIndex, true);
            });
        }
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
