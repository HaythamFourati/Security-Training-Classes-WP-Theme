import Person from "./scripts/Person"
import ExampleReactComponent from "./scripts/ExampleReactComponent"
import React from "react"
import ReactDOM from "react-dom/client"

const person1 = new Person("Brad")
if (document.querySelector("#render-react-example-here")) {
  const root = ReactDOM.createRoot(document.querySelector("#render-react-example-here"))
  root.render(<ExampleReactComponent />)
}

// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function () {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // Class Filtering, Pagination, and Modal Logic
    const filterContainer = document.getElementById('class-filters');
    const classGrid = document.getElementById('class-grid');
    const paginationContainer = document.getElementById('class-pagination');

    if (filterContainer && classGrid) {
        const allItems = Array.from(classGrid.querySelectorAll('.class-item'));
        let currentPage = 1;
        const itemsPerPage = 6;
        let currentFilter = 'all';

        function updateClasses() {
            // 1. Filter items
            const filteredItems = allItems.filter(item => 
                currentFilter === 'all' || item.dataset.category === currentFilter
            );

            // 2. Hide all items initially
            allItems.forEach(item => item.style.display = 'none');

            // 3. Calculate pagination for filtered items
            const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
            if (currentPage > totalPages) currentPage = 1;
            if (filteredItems.length === 0) currentPage = 1;

            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const itemsToShow = filteredItems.slice(startIndex, endIndex);

            // 4. Show only the items for the current page
            itemsToShow.forEach(item => item.style.display = 'flex');

            // 5. Render pagination controls
            paginationContainer.innerHTML = '';
            if (totalPages > 1) {
                const prevButton = document.createElement('button');
                prevButton.innerText = 'Previous';
                prevButton.disabled = currentPage === 1;
                prevButton.className = 'px-4 py-2 rounded font-semibold text-navy border border-gray-300 disabled:opacity-50 disabled:cursor-not-allowed';
                prevButton.onclick = () => { currentPage--; updateClasses(); };
                paginationContainer.appendChild(prevButton);

                const pageIndicator = document.createElement('span');
                pageIndicator.innerText = `Page ${currentPage} of ${totalPages}`;
                pageIndicator.className = 'px-4 py-2 text-steel-gray';
                paginationContainer.appendChild(pageIndicator);

                const nextButton = document.createElement('button');
                nextButton.innerText = 'Next';
                nextButton.disabled = currentPage === totalPages;
                nextButton.className = 'px-4 py-2 rounded font-semibold text-navy border border-gray-300 disabled:opacity-50 disabled:cursor-not-allowed';
                nextButton.onclick = () => { currentPage++; updateClasses(); };
                paginationContainer.appendChild(nextButton);
            }
        }

        // Event listener for filter buttons
        filterContainer.addEventListener('click', (e) => {
            if (e.target.tagName === 'BUTTON') {
                currentFilter = e.target.dataset.filter;
                currentPage = 1;

                // Update active button styles
                filterContainer.querySelectorAll('button').forEach(button => {
                    button.classList.remove('bg-navy', 'text-white');
                    button.classList.add('bg-white', 'text-navy', 'border', 'border-gray-300');
                });
                e.target.classList.add('bg-navy', 'text-white');
                e.target.classList.remove('bg-white', 'text-navy', 'border', 'border-gray-300');

                updateClasses();
            }
        });

        // Modal handling with event delegation
        document.body.addEventListener('click', function(e) {
            const openButton = e.target.closest('[data-modal-target]');
            if (openButton) {
                const modal = document.querySelector(openButton.dataset.modalTarget);
                if (modal) modal.classList.replace('hidden', 'flex');
            }

            const closeButton = e.target.closest('[data-modal-close]');
            if (closeButton) {
                const modal = document.querySelector(closeButton.dataset.modalClose);
                if (modal) modal.classList.replace('flex', 'hidden');
            }

            if (e.target.classList.contains('class-modal')) {
                e.target.classList.replace('flex', 'hidden');
            }
        });

        // Initial load
        updateClasses();
    }
});
