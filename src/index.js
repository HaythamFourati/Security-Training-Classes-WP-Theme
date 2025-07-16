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

    // Class Filtering Logic
    const filters = document.getElementById('class-filters');
    const classItems = document.querySelectorAll('.class-item');

    if (filters && classItems.length > 0) {
        filters.addEventListener('click', function (e) {
            if (e.target.tagName === 'BUTTON') {
                // Manage active button state
                const buttons = filters.querySelectorAll('button');
                buttons.forEach(button => {
                    button.classList.remove('bg-navy', 'text-white');
                    button.classList.add('bg-white', 'text-navy', 'border', 'border-gray-300');
                });
                e.target.classList.add('bg-navy', 'text-white');
                e.target.classList.remove('bg-white', 'text-navy', 'border', 'border-gray-300');

                const filter = e.target.getAttribute('data-filter');

                // Filter class items
                classItems.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
            }
        });
    }
});
