/**
 * Bookeo API Plugin JavaScript
 * Handles class display, filtering, and pagination
 */

(function($) {
    'use strict';

    class BookeoClassesWidget {
        constructor(container) {
            this.container = $(container);
            this.containerId = container.id;
            this.limit = parseInt(this.container.data('limit')) || 12;
            this.category = this.container.data('category') || '';
            this.showFilters = this.container.data('show-filters') === 'true';
            this.showPagination = this.container.data('show-pagination') === 'true';
            this.columns = parseInt(this.container.data('columns')) || 3;
            this.currentPage = 1;
            this.currentFilter = this.category || 'all';
            this.classes = [];
            this.totalPages = 1;
            
            this.init();
        }
        
        init() {
            this.setupGrid();
            this.bindEvents();
            this.loadClasses();
        }
        
        setupGrid() {
            const grid = this.container.find('.bookeo-classes-grid');
            grid.addClass(`columns-${this.columns}`);
        }
        
        bindEvents() {
            // Filter buttons
            this.container.on('click', '.bookeo-filter-btn', (e) => {
                e.preventDefault();
                const filter = $(e.target).data('filter');
                this.setFilter(filter);
            });
            
            // Pagination
            this.container.on('click', '.bookeo-pagination button', (e) => {
                e.preventDefault();
                const page = $(e.target).data('page');
                if (page && page !== this.currentPage) {
                    this.setPage(page);
                }
            });
        }
        
        setFilter(filter) {
            if (filter === this.currentFilter) return;
            
            this.currentFilter = filter;
            this.currentPage = 1;
            
            // Update active filter button
            this.container.find('.bookeo-filter-btn').removeClass('active');
            this.container.find(`[data-filter="${filter}"]`).addClass('active');
            
            this.loadClasses();
        }
        
        setPage(page) {
            this.currentPage = page;
            this.loadClasses();
            
            // Scroll to top of widget
            $('html, body').animate({
                scrollTop: this.container.offset().top - 100
            }, 500);
        }
        
        loadClasses() {
            this.showLoading();
            
            $.ajax({
                url: bookeo_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'bookeo_get_classes',
                    nonce: bookeo_ajax.nonce,
                    page: this.currentPage,
                    limit: this.limit,
                    category: this.currentFilter
                },
                success: (response) => {
                    if (response.success) {
                        this.classes = response.data.classes;
                        this.totalPages = response.data.pages;
                        this.renderClasses();
                        this.renderPagination();
                        this.hideLoading();
                    } else {
                        this.showError(response.data.message || 'Failed to load classes');
                    }
                },
                error: () => {
                    this.showError('Network error occurred while loading classes');
                }
            });
        }
        
        renderClasses() {
            const grid = this.container.find('.bookeo-classes-grid');
            grid.empty();
            
            if (this.classes.length === 0) {
                this.showEmpty();
                return;
            }
            
            this.classes.forEach((classItem, index) => {
                const card = this.createClassCard(classItem, index);
                grid.append(card);
            });
            
            grid.show();
        }
        
        createClassCard(classItem, index) {
            const category = this.getClassCategory(classItem);
            const categoryLabel = this.getCategoryLabel(category);
            const description = this.truncateDescription(classItem.description || '', 150);
            const price = this.formatPrice(classItem.price);
            const bookingUrl = this.getBookingUrl(classItem);
            
            return $(`
                <div class="bookeo-class-card" style="animation-delay: ${index * 0.1}s">
                    <div class="bookeo-class-header">
                        <h3 class="bookeo-class-title">${this.escapeHtml(classItem.name)}</h3>
                        <span class="bookeo-class-category">${categoryLabel}</span>
                    </div>
                    <div class="bookeo-class-body">
                        ${description ? `<div class="bookeo-class-description">${description}</div>` : ''}
                        <div class="bookeo-class-meta">
                            ${price ? `<div class="bookeo-class-price">${price}</div>` : ''}
                            <a href="${bookingUrl}" target="_blank" class="bookeo-class-btn">
                                Book Now
                            </a>
                        </div>
                    </div>
                </div>
            `);
        }
        
        renderPagination() {
            if (!this.showPagination || this.totalPages <= 1) {
                this.container.find('.bookeo-pagination').hide();
                return;
            }
            
            const pagination = this.container.find('.bookeo-pagination');
            pagination.empty();
            
            // Previous button
            const prevBtn = $(`<button data-page="${this.currentPage - 1}" ${this.currentPage === 1 ? 'disabled' : ''}>Previous</button>`);
            pagination.append(prevBtn);
            
            // Page numbers
            const startPage = Math.max(1, this.currentPage - 2);
            const endPage = Math.min(this.totalPages, this.currentPage + 2);
            
            if (startPage > 1) {
                pagination.append(`<button data-page="1">1</button>`);
                if (startPage > 2) {
                    pagination.append(`<span class="page-info">...</span>`);
                }
            }
            
            for (let i = startPage; i <= endPage; i++) {
                const pageBtn = $(`<button data-page="${i}" ${i === this.currentPage ? 'class="active"' : ''}>${i}</button>`);
                pagination.append(pageBtn);
            }
            
            if (endPage < this.totalPages) {
                if (endPage < this.totalPages - 1) {
                    pagination.append(`<span class="page-info">...</span>`);
                }
                pagination.append(`<button data-page="${this.totalPages}">${this.totalPages}</button>`);
            }
            
            // Next button
            const nextBtn = $(`<button data-page="${this.currentPage + 1}" ${this.currentPage === this.totalPages ? 'disabled' : ''}>Next</button>`);
            pagination.append(nextBtn);
            
            // Page info
            const pageInfo = $(`<span class="page-info">Page ${this.currentPage} of ${this.totalPages}</span>`);
            pagination.append(pageInfo);
            
            pagination.show();
        }
        
        getClassCategory(classItem) {
            const name = (classItem.name || '').toLowerCase();
            
            if (name.includes('security guard') || name.includes('guard')) {
                return 'security-guard';
            } else if (name.includes('firearm') || name.includes('gun') || name.includes('pistol')) {
                return 'firearms';
            } else if (name.includes('special police') || name.includes('spo')) {
                return 'spo';
            } else if (name.includes('nra')) {
                return 'nra';
            } else if (name.includes('uscca')) {
                return 'uscca';
            } else if (name.includes('cpr') || name.includes('acls') || name.includes('pals')) {
                return 'life-saving';
            }
            
            return 'other';
        }
        
        getCategoryLabel(category) {
            const labels = {
                'security-guard': 'Security Guard',
                'firearms': 'Firearms',
                'spo': 'Special Police',
                'nra': 'NRA Classes',
                'uscca': 'USCCA Classes',
                'life-saving': 'Life Saving',
                'other': 'Training'
            };
            
            return labels[category] || 'Training';
        }
        
        truncateDescription(text, maxLength) {
            if (!text) return '';
            
            text = this.stripHtml(text);
            if (text.length <= maxLength) return text;
            
            return text.substring(0, maxLength).trim() + '...';
        }
        
        formatPrice(price) {
            if (!price) return '';
            
            // Handle different price formats
            if (typeof price === 'number') {
                return `$${price.toFixed(2)}`;
            }
            
            if (typeof price === 'string') {
                // If already formatted, return as is
                if (price.includes('$')) return price;
                
                // Try to parse as number
                const numPrice = parseFloat(price);
                if (!isNaN(numPrice)) {
                    return `$${numPrice.toFixed(2)}`;
                }
            }
            
            return price;
        }
        
        getBookingUrl(classItem) {
            // Default booking URL - could be customized based on class
            return 'https://bookeo.com/securitytrainingacademy';
        }
        
        showLoading() {
            this.container.find('.bookeo-loading').show();
            this.container.find('.bookeo-classes-grid').hide();
            this.container.find('.bookeo-pagination').hide();
            this.container.find('.bookeo-error').hide();
        }
        
        hideLoading() {
            this.container.find('.bookeo-loading').hide();
        }
        
        showError(message) {
            this.hideLoading();
            this.container.find('.bookeo-classes-grid').hide();
            this.container.find('.bookeo-pagination').hide();
            
            const errorDiv = this.container.find('.bookeo-error');
            errorDiv.find('p').text(message);
            errorDiv.show();
        }
        
        showEmpty() {
            const grid = this.container.find('.bookeo-classes-grid');
            grid.html(`
                <div class="bookeo-empty">
                    <h3>No Classes Found</h3>
                    <p>There are no upcoming classes matching your criteria.</p>
                </div>
            `);
            grid.show();
        }
        
        escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
        
        stripHtml(html) {
            const div = document.createElement('div');
            div.innerHTML = html;
            return div.textContent || div.innerText || '';
        }
    }
    
    // Initialize all Bookeo Classes widgets when DOM is ready
    $(document).ready(function() {
        $('.bookeo-classes-container').each(function() {
            new BookeoClassesWidget(this);
        });
    });
    
    // Re-initialize if new widgets are added dynamically
    $(document).on('bookeo:reinit', function() {
        $('.bookeo-classes-container').each(function() {
            if (!$(this).data('bookeo-initialized')) {
                new BookeoClassesWidget(this);
                $(this).data('bookeo-initialized', true);
            }
        });
    });

})(jQuery);
