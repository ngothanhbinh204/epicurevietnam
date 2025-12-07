/**
 * Product Filter AJAX Handler
 * Smooth filtering without page reload
 */
(function($) {
    'use strict';
    
    // Cache DOM elements
    var $container = $('#product-grid-container');
    var $grid = $('#product-grid');
    var $pagination = $('#product-pagination');
    var $filters = $('#product-filters');
    var $loading = $container.find('.loading-overlay');
    
    // Filter state
    var filterState = {
        category: $('#current-category').val() || '',
        attributes: {},
        orderby: 'date',
        paged: 1
    };
    
    /**
     * Collect filter values from dropdowns
     */
    function collectFilters() {
        filterState.attributes = {};
        
        $filters.find('.filter-input').each(function() {
            var $input = $(this);
            var value = $input.val();
            var name = $input.attr('name');
            
            if (value && value !== '') {
                filterState.attributes[name] = value;
            }
        });
        
        filterState.orderby = $filters.find('.sort-input').val() || 'date';
    }
    
    /**
     * Show loading state
     */
    function showLoading() {
        $loading.fadeIn(200);
        $container.addClass('is-loading');
    }
    
    /**
     * Hide loading state
     */
    function hideLoading() {
        $loading.fadeOut(200);
        $container.removeClass('is-loading');
    }
    
    /**
     * Perform AJAX filter request
     */
    function doFilter() {
        collectFilters();
        showLoading();
        
        // Build attributes array
        var attributeValues = [];
        $.each(filterState.attributes, function(key, val) {
            if (val) {
                attributeValues.push(val);
            }
        });
        
        var data = {
            action: 'filter_products',
            nonce: productFilterAjax.nonce,
            category: filterState.category,
            attributes: attributeValues,
            orderby: filterState.orderby,
            paged: filterState.paged
        };
        
        $.ajax({
            url: productFilterAjax.ajaxurl,
            type: 'POST',
            data: data,
            success: function(response) {
                if (response.success) {
                    // Update products
                    if (response.data.products) {
                        $grid.html(response.data.products);
                    }
                    
                    // Update pagination
                    if (response.data.pagination) {
                        $pagination.html(response.data.pagination);
                    } else {
                        $pagination.html('');
                    }
                    
                    // Update hidden values
                    $('#max-pages').val(response.data.max_pages);
                    $('#current-page').val(response.data.current_page);
                    
                    // Scroll to top of grid (smooth)
                    $('html, body').animate({
                        scrollTop: $container.offset().top - 300
                    }, 300);
                    
                    // Update URL without reload
                    updateURL();
                }
                
                hideLoading();
            },
            error: function(xhr, status, error) {
                console.error('Filter error:', error);
                hideLoading();
            }
        });
    }
    
    /**
     * Update URL with filter parameters (for bookmarking/sharing)
     */
    function updateURL() {
        var url = new URL(window.location.href);
        var params = url.searchParams;
        
        // Clear old filter params
        var keysToRemove = [];
        params.forEach(function(value, key) {
            if (key.startsWith('attr_') || key === 'orderby' || key === 'paged') {
                keysToRemove.push(key);
            }
        });
        keysToRemove.forEach(function(key) {
            params.delete(key);
        });
        
        // Add current filters
        $.each(filterState.attributes, function(key, val) {
            if (val) {
                params.set(key, val);
            }
        });
        
        if (filterState.orderby !== 'date') {
            params.set('orderby', filterState.orderby);
        }
        
        // Handle Pagination with Pretty Permalinks (/page/2/)
        var baseUrl = url.origin + url.pathname;
        
        // Remove existing /page/X/ from path
        baseUrl = baseUrl.replace(/\/page\/\d+\/?/, '/');
        // Remove trailing slash to avoid double slashes
        baseUrl = baseUrl.replace(/\/$/, '');
        
        if (filterState.paged > 1) {
            baseUrl += '/page/' + filterState.paged;
        }
        
        // Construct final URL
        var finalUrl = baseUrl;
        var paramString = params.toString();
        if (paramString) {
            finalUrl += '?' + paramString;
        }
        
        // Update URL without reload
        window.history.replaceState({}, '', finalUrl);
    }
    
    /**
     * Handle filter change
     */
    function onFilterChange() {
        filterState.paged = 1; // Reset to page 1
        doFilter();
    }
    
    /**
     * Handle pagination click
     */
    function onPaginationClick(e) {
        var $link = $(e.target).closest('a');
        if ($link.length === 0) return;
        
        e.preventDefault();
        
        var href = $link.attr('href');
        var pageMatch = href.match(/[?&]paged=(\d+)|\/page\/(\d+)/);
        
        if (pageMatch) {
            filterState.paged = parseInt(pageMatch[1] || pageMatch[2]);
        } else if ($link.hasClass('next')) {
            filterState.paged++;
        } else if ($link.hasClass('prev')) {
            filterState.paged--;
        } else {
            // Try to get page number from link text
            var pageNum = parseInt($link.text());
            if (!isNaN(pageNum)) {
                filterState.paged = pageNum;
            }
        }
        
        doFilter();
    }
    
    /**
     * Initialize URL params to dropdowns
     */
    function initFromURL() {
        var url = new URL(window.location.href);
        var params = url.searchParams;
        
        params.forEach(function(value, key) {
            if (key.startsWith('attr_')) {
                var $dropdown = $filters.find('.custom-dropdown[data-name="' + key + '"]');
                if ($dropdown.length) {
                    $dropdown.find('.filter-input').val(value);
                    var text = $dropdown.find('.dropdown-item[data-value="' + value + '"]').text();
                    if (text) {
                        $dropdown.find('.selected-text').text(text);
                    }
                    filterState.attributes[key] = value;
                }
            } else if (key === 'orderby') {
                var $dropdown = $filters.find('.sort-dropdown');
                $dropdown.find('.sort-input').val(value);
                var text = $dropdown.find('.dropdown-item[data-value="' + value + '"]').text();
                if (text) {
                    $dropdown.find('.selected-text').text(text);
                }
                filterState.orderby = value;
            } else if (key === 'paged') {
                filterState.paged = parseInt(value);
            }
        });
    }
    
    /**
     * Initialize Custom Dropdowns
     */
    function initDropdowns() {
        // Toggle dropdown
        $(document).on('click', '.dropdown-toggle', function(e) {
            e.stopPropagation();
            var $parent = $(this).parent();
            
            // Close other dropdowns
            $('.custom-dropdown').not($parent).removeClass('active');
            
            // Toggle current
            $parent.toggleClass('active');
        });
        
        // Select item
        $(document).on('click', '.dropdown-item', function(e) {
            e.stopPropagation();
            var $item = $(this);
            var $dropdown = $item.closest('.custom-dropdown');
            var value = $item.data('value');
            var text = $item.text();
            
            // Update UI
            $dropdown.find('.selected-text').text(text);
            $dropdown.removeClass('active');
            
            // Update input
            var $input = $dropdown.find('input[type="hidden"]');
            var oldValue = $input.val();
            
            if (oldValue != value) {
                $input.val(value);
                
                // Add/remove has-value class for styling
                if (value && value !== '') {
                    $dropdown.addClass('has-value');
                } else {
                    $dropdown.removeClass('has-value');
                }
                
                onFilterChange();
            }
        });
        
        // Clear filter button click
        $(document).on('click', '.clear-filter-btn', function(e) {
            e.stopPropagation();
            e.preventDefault();
            
            var $dropdown = $(this).closest('.custom-dropdown');
            var defaultText = $dropdown.data('default-text') || '';
            
            // Reset to default
            $dropdown.find('.selected-text').text(defaultText);
            $dropdown.find('input[type="hidden"]').val('');
            $dropdown.removeClass('has-value active');
            
            onFilterChange();
        });
        
        // Close when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.custom-dropdown').length) {
                $('.custom-dropdown').removeClass('active');
            }
        });
    }
    
    /**
     * Update has-value class based on current values
     */
    function updateDropdownStates() {
        $filters.find('.custom-dropdown').each(function() {
            var $dropdown = $(this);
            var value = $dropdown.find('input[type="hidden"]').val();
            if (value && value !== '') {
                $dropdown.addClass('has-value');
            } else {
                $dropdown.removeClass('has-value');
            }
        });
    }
    
    /**
     * Initialize
     */
    function init() {
        // Init custom dropdowns
        initDropdowns();
        
        // Init from URL params
        initFromURL();
        
        // Update dropdown states after init
        updateDropdownStates();
        
        // Bind pagination clicks (using delegation for dynamic content)
        $container.on('click', '.product-pagination a', onPaginationClick);
        
        // Category links (if you want AJAX category switching)
        $('.product-cat-list a').on('click', function(e) {
            e.preventDefault();
            
            var href = $(this).attr('href');
            var url = new URL(href, window.location.origin);
            var newCategory = url.searchParams.get('product_category') || '';
            
            // Update active state
            $('.product-cat-list a').removeClass('active');
            $(this).addClass('active');
            
            // Update filter state
            filterState.category = newCategory;
            filterState.paged = 1;
            $('#current-category').val(newCategory);
            
            // Reset attribute filters when changing category
            $filters.find('.filter-input').val('');
            $filters.find('.custom-dropdown').each(function() {
                var defaultText = $(this).data('default-text') || '';
                $(this).find('.selected-text').text(defaultText);
                $(this).removeClass('has-value');
            });
            filterState.attributes = {};
            
            doFilter();
        });
        
        // Initialize category slider for mobile
        initCategorySlider();
    }
    
    /**
     * Initialize Category Horizontal Slider for Mobile
     */
    function initCategorySlider() {
        var $nav = $('.product-categories-nav');
        var $wrapper = $nav.find('.categories-list-wrapper');
        var $list = $nav.find('.categories-list');
        var $prevBtn = $nav.find('.cat-nav-prev');
        var $nextBtn = $nav.find('.cat-nav-next');
        var $items = $list.find('.category-item');
        
        if ($items.length === 0) return;
        
        var itemWidth = 0;
        var gap = 12;
        
        function calculateDimensions() {
            // Get item width including gap
            var $firstItem = $items.first();
            itemWidth = $firstItem.outerWidth(true);
            gap = parseInt($list.css('gap')) || 12;
        }
        
        function updateButtonStates() {
            var scrollLeft = $wrapper.scrollLeft();
            var maxScroll = $wrapper[0].scrollWidth - $wrapper[0].clientWidth;
            
            $prevBtn.prop('disabled', scrollLeft <= 0);
            $nextBtn.prop('disabled', scrollLeft >= maxScroll - 1);
        }
        
        function goToPrev() {
            var scrollLeft = $wrapper.scrollLeft();
            var newScroll = Math.max(0, scrollLeft - itemWidth);
            $wrapper.animate({ scrollLeft: newScroll }, 300);
        }
        
        function goToNext() {
            var scrollLeft = $wrapper.scrollLeft();
            var maxScroll = $wrapper[0].scrollWidth - $wrapper[0].clientWidth;
            var newScroll = Math.min(maxScroll, scrollLeft + itemWidth);
            $wrapper.animate({ scrollLeft: newScroll }, 300);
        }
        
        // Bind arrow button events
        $prevBtn.on('click', goToPrev);
        $nextBtn.on('click', goToNext);
        
        // Update button states on manual scroll (touch/swipe)
        $wrapper.on('scroll', function() {
            updateButtonStates();
        });
        
        // Recalculate on resize
        var resizeTimer;
        $(window).on('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                calculateDimensions();
                updateButtonStates();
            }, 100);
        });
        
        // Initial calculation
        setTimeout(function() {
            calculateDimensions();
            updateButtonStates();
        }, 100);
    }
    
    // Run on DOM ready
    $(document).ready(init);
    
})(jQuery);
