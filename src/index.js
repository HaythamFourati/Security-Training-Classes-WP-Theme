import Person from "./scripts/Person"
import ExampleReactComponent from "./scripts/ExampleReactComponent"
import React from "react"
import ReactDOM from "react-dom/client"

const person1 = new Person("Brad")
if (document.querySelector("#render-react-example-here")) {
  const root = ReactDOM.createRoot(document.querySelector("#render-react-example-here"))
  root.render(<ExampleReactComponent />)
}

// AJAX Loading for GHL Calendar and Classes
document.addEventListener('DOMContentLoaded', function () {
    // Load classes via AJAX
    const classesContainer = document.getElementById('classes-ajax-container');
    if (classesContainer && typeof ghlAjax !== 'undefined') {
        fetch(ghlAjax.ajaxUrl + '?action=load_upcoming_classes', {
            method: 'GET',
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                classesContainer.innerHTML = data.data.html;
                // Re-initialize class filtering after AJAX load
                initClassFiltering();
            } else {
                classesContainer.innerHTML = '<p class="text-center text-white">Failed to load classes. Please refresh the page.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading classes:', error);
            classesContainer.innerHTML = '<p class="text-center text-white">Failed to load classes. Please refresh the page.</p>';
        });
    }

    // Load calendar via AJAX
    const calendarContainer = document.getElementById('calendar-ajax-container');
    if (calendarContainer && typeof ghlAjax !== 'undefined') {
        fetch(ghlAjax.ajaxUrl + '?action=load_ghl_calendar', {
            method: 'GET',
            credentials: 'same-origin'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                calendarContainer.innerHTML = data.data.html;
                // Re-initialize calendar JS after AJAX load
                initCalendarJS();
            } else {
                calendarContainer.innerHTML = '<p class="text-center text-red-500">Failed to load calendar. Please refresh the page.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading calendar:', error);
            calendarContainer.innerHTML = '<p class="text-center text-red-500">Failed to load calendar. Please refresh the page.</p>';
        });
    }
});

// Initialize class filtering (called after AJAX load)
function initClassFiltering() {
    const filterContainer = document.getElementById('class-filters');
    const classGrid = document.getElementById('class-grid');
    const paginationContainer = document.getElementById('class-pagination');

    if (filterContainer && classGrid) {
        const allItems = Array.from(classGrid.querySelectorAll('.class-item'));
        let currentPage = 1;
        const itemsPerPage = 12;
        let currentFilter = 'all';

        function updateClasses() {
            const filteredItems = allItems.filter(item => {
                if (currentFilter === 'all') return true;
                const categories = item.dataset.category || '';
                return categories.split(' ').includes(currentFilter);
            });

            allItems.forEach(item => item.style.display = 'none');

            const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
            if (currentPage > totalPages) currentPage = 1;
            if (filteredItems.length === 0) currentPage = 1;

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const itemsToShow = filteredItems.slice(startIndex, endIndex);

            itemsToShow.forEach(item => item.style.display = 'flex');

            if (paginationContainer) {
                paginationContainer.innerHTML = '';
                if (totalPages > 1) {
                    const prevButton = document.createElement('button');
                    prevButton.innerText = 'Previous';
                    prevButton.disabled = currentPage === 1;
                    prevButton.className = 'px-4 py-2 rounded font-semibold text-navy border border-gray-300 bg-white hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed';
                    prevButton.onclick = () => { currentPage--; updateClasses(); };
                    paginationContainer.appendChild(prevButton);

                    const pageIndicator = document.createElement('span');
                    pageIndicator.innerText = `Page ${currentPage} of ${totalPages}`;
                    pageIndicator.className = 'px-4 py-2 text-steel-gray';
                    paginationContainer.appendChild(pageIndicator);

                    const nextButton = document.createElement('button');
                    nextButton.innerText = 'Next';
                    nextButton.disabled = currentPage === totalPages;
                    nextButton.className = 'px-4 py-2 rounded font-semibold text-navy border border-gray-300 bg-white hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed';
                    nextButton.onclick = () => { currentPage++; updateClasses(); };
                    paginationContainer.appendChild(nextButton);
                }
            }
        }

        filterContainer.addEventListener('click', (e) => {
            const button = e.target.closest('button');
            if (button && button.dataset.filter) {
                currentFilter = button.dataset.filter;
                currentPage = 1;

                filterContainer.querySelectorAll('button').forEach(btn => {
                    btn.classList.remove('bg-safety-orange', 'text-white');
                    btn.classList.add('bg-white', 'text-navy', 'border-4', 'border-navy');
                });
                button.classList.add('bg-safety-orange', 'text-white');
                button.classList.remove('bg-white', 'text-navy', 'border-4', 'border-navy');

                updateClasses();
            }
        });

        updateClasses();
    }
}

// Initialize calendar JS (called after AJAX load)
function initCalendarJS() {
    const monthSelector = document.getElementById("month-selector");
    const prevBtn = document.getElementById("prev-month");
    const nextBtn = document.getElementById("next-month");
    const monthContainers = document.querySelectorAll(".month-container");

    if (monthSelector && prevBtn && nextBtn) {
        function showMonth(monthStr) {
            monthContainers.forEach(container => {
                if (container.dataset.month === monthStr) {
                    container.classList.remove("hidden");
                } else {
                    container.classList.add("hidden");
                }
            });
        }

        monthSelector.addEventListener("change", function() {
            showMonth(this.value);
        });

        prevBtn.addEventListener("click", function() {
            const currentIndex = monthSelector.selectedIndex;
            if (currentIndex > 0) {
                monthSelector.selectedIndex = currentIndex - 1;
                monthSelector.dispatchEvent(new Event("change"));
            }
        });

        nextBtn.addEventListener("click", function() {
            const currentIndex = monthSelector.selectedIndex;
            if (currentIndex < monthSelector.options.length - 1) {
                monthSelector.selectedIndex = currentIndex + 1;
                monthSelector.dispatchEvent(new Event("change"));
            }
        });
    }

    // Tooltip functionality
    document.querySelectorAll(".event-tooltip-trigger").forEach(trigger => {
        const tooltip = trigger.querySelector(".event-tooltip");
        if (tooltip) {
            trigger.addEventListener("mouseenter", function() {
                tooltip.style.display = "block";
            });
            trigger.addEventListener("mouseleave", function() {
                tooltip.style.display = "none";
            });
        }
    });
}

// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function () {
    // Floating header behavior
    const header = document.getElementById('main-header');
    
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }
    
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuClose = document.getElementById('mobile-menu-close');
    const mobileMenuOverlay = document.getElementById('mobile-menu-overlay');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function () {
            mobileMenu.classList.remove('hidden');
        });
    }

    // Close mobile menu
    if (mobileMenuClose && mobileMenu) {
        mobileMenuClose.addEventListener('click', function () {
            mobileMenu.classList.add('hidden');
        });
    }

    // Close mobile menu when clicking overlay
    if (mobileMenuOverlay && mobileMenu) {
        mobileMenuOverlay.addEventListener('click', function () {
            mobileMenu.classList.add('hidden');
        });
    }

    // Close mobile menu when clicking nav links
    const mobileNavLinks = mobileMenu?.querySelectorAll('a');
    if (mobileNavLinks) {
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
            });
        });
    }

    // Mobile Classes Sub-menu Toggle
    const mobileClassesToggle = document.getElementById('mobile-classes-toggle');
    const mobileClassesSubmenu = document.getElementById('mobile-classes-submenu');

    if (mobileClassesToggle && mobileClassesSubmenu) {
        mobileClassesToggle.addEventListener('click', function() {
            mobileClassesSubmenu.classList.toggle('hidden');
            const icon = mobileClassesToggle.querySelector('svg');
            icon.classList.toggle('rotate-180');
        });
    }

    // Mobile Services Sub-menu Toggle
    const mobileServicesToggle = document.getElementById('mobile-services-toggle');
    const mobileServicesSubmenu = document.getElementById('mobile-services-submenu');

    if (mobileServicesToggle && mobileServicesSubmenu) {
        mobileServicesToggle.addEventListener('click', function() {
            mobileServicesSubmenu.classList.toggle('hidden');
            const icon = mobileServicesToggle.querySelector('svg');
            icon.classList.toggle('rotate-180');
        });
    }

    // FAQ Accordion
    const accordion = document.getElementById('faq-accordion');
    if (accordion) {
        accordion.addEventListener('click', function (event) {
            const button = event.target.closest('button');
            if (!button) return;

            const content = button.nextElementSibling;
            const icon = button.querySelector('svg');

            // Toggle the content visibility
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
                content.classList.add('hidden');
                content.classList.remove('p-6', 'pt-0');
            } else {
                content.classList.remove('hidden');
                content.classList.add('p-6', 'pt-0');
                content.style.maxHeight = content.scrollHeight + "px";
            }

            // Rotate the icon
            icon.classList.toggle('rotate-180');
        });
    }

    // Modal handling with event delegation (works for AJAX-loaded content)
    document.body.addEventListener('click', function(e) {
        const openButton = e.target.closest('[data-modal-target]');
        if (openButton) {
            const modal = document.querySelector(openButton.dataset.modalTarget);
            if (modal) {
                modal.classList.replace('hidden', 'flex');
                document.body.classList.add('overflow-hidden');
            }
        }

        const closeButton = e.target.closest('[data-modal-close]');
        if (closeButton) {
            const modal = document.querySelector(closeButton.dataset.modalClose);
            if (modal) {
                modal.classList.replace('flex', 'hidden');
                document.body.classList.remove('overflow-hidden');
            }
        }

        // Also close modal if clicking on the overlay
        if (e.target.classList.contains('class-modal')) {
            e.target.classList.replace('flex', 'hidden');
            document.body.classList.remove('overflow-hidden');
        }
    });
});
