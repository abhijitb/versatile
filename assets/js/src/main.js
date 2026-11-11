import './archive-view-toggle';
import './author-filter';
import './single-post';
import './cart-sync';

/**
 * Main JavaScript file for Versatile theme
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Search Overlay Functions
        function initSearchOverlay() {
            const searchToggle = $('.search-toggle');
            const searchOverlay = $('.search-overlay');
            const searchClose = $('.search-close');
            const searchField = $('.search-overlay .search-field');
            
            // Open search overlay
            searchToggle.on('click', function(e) {
                e.preventDefault();
                searchOverlay.addClass('active').attr('aria-hidden', 'false');
                searchToggle.attr('aria-expanded', 'true');
                $('body').addClass('search-open');
                
                // Focus on search field after animation
                setTimeout(function() {
                    searchField.focus();
                }, 300);
            });
            
            // Close search overlay
            searchClose.on('click', function(e) {
                e.preventDefault();
                closeSearchOverlay();
            });
            
            // Close on overlay click
            searchOverlay.on('click', function(e) {
                if (e.target === this) {
                    closeSearchOverlay();
                }
            });
            
            // Close on escape key
            $(document).on('keyup', function(e) {
                if (e.keyCode === 27 && searchOverlay.hasClass('active')) {
                    closeSearchOverlay();
                }
            });
            
            function closeSearchOverlay() {
                searchOverlay.removeClass('active').attr('aria-hidden', 'true');
                searchToggle.attr('aria-expanded', 'false').focus();
                $('body').removeClass('search-open');
                searchField.val('');
            }
        }
        
        // Mobile Menu Functions
        function initMobileMenu() {
            const menuToggle = $('.menu-toggle');
            const mobileOverlay = $('.mobile-menu-overlay');
            const mobileClose = $('.mobile-menu-close');
            
            // Open mobile menu
            menuToggle.on('click', function(e) {
                e.preventDefault();
                mobileOverlay.addClass('active').attr('aria-hidden', 'false');
                $('body').addClass('mobile-menu-open');
                $(this).attr('aria-expanded', 'true');
            });
            
            // Close mobile menu
            mobileClose.on('click', function(e) {
                e.preventDefault();
                closeMobileMenu();
            });
            
            // Close on overlay click
            mobileOverlay.on('click', function(e) {
                if (e.target === this) {
                    closeMobileMenu();
                }
            });
            
            // Close on escape key
            $(document).on('keyup', function(e) {
                if (e.keyCode === 27 && mobileOverlay.hasClass('active')) {
                    closeMobileMenu();
                }
            });
            
            function closeMobileMenu() {
                mobileOverlay.removeClass('active').attr('aria-hidden', 'true');
                $('body').removeClass('mobile-menu-open');
                menuToggle.attr('aria-expanded', 'false').focus();
            }
        }
        
        // Mini Cart Functions (WooCommerce)
        function initMiniCart() {
            const cartContents = $('.cart-contents');
            const miniCartWrapper = $('.mini-cart-wrapper');
            
            if (cartContents.length && miniCartWrapper.length) {
                cartContents.on('mouseenter', function() {
                    miniCartWrapper.addClass('visible');
                });
                
                $('.header-cart').on('mouseleave', function() {
                    miniCartWrapper.removeClass('visible');
                });
                
                // Mobile cart toggle
                cartContents.on('click', function(e) {
                    if ($(window).width() <= 768) {
                        e.preventDefault();
                        miniCartWrapper.toggleClass('visible');
                    }
                });
            }
        }
        
        // Back to Top Button
        function initBackToTop() {
            const backToTop = $('#back-to-top');
            
            if (backToTop.length) {
                $(window).on('scroll', function() {
                    if ($(window).scrollTop() > 300) {
                        backToTop.addClass('visible');
                    } else {
                        backToTop.removeClass('visible');
                    }
                });
                
                backToTop.on('click', function(e) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: 0
                    }, 600);
                });
            }
        }
        
        // Sticky Header
        function initStickyHeader() {
            const header = $('.site-header');
            const headerHeight = header.outerHeight();
            let lastScrollTop = 0;
            
            $(window).on('scroll', function() {
                const scrollTop = $(window).scrollTop();
                
                if (scrollTop > headerHeight) {
                    header.addClass('sticky');
                    
                    // Hide/show header on scroll
                    if (scrollTop > lastScrollTop && scrollTop > headerHeight * 2) {
                        header.addClass('hidden');
                    } else {
                        header.removeClass('hidden');
                    }
                } else {
                    header.removeClass('sticky hidden');
                }
                
                lastScrollTop = scrollTop;
            });
        }
        
        // Smooth Scrolling for Anchor Links
        function initSmoothScrolling() {
            // Skip UI controls that use #hash links for their own behaviour
            // (WooCommerce product tabs, review link, comment reply, etc.).
            const skip = [
                '.wc-tabs a',
                '.woocommerce-tabs a',
                '[role="tab"]',
                '[data-toggle]',
                '.woocommerce-review-link',
                '.comment-reply-link',
                '#cancel-comment-reply-link',
                '.skip-link',
                '.screen-reader-text'
            ].join(',');

            $('a[href*="#"]:not([href="#"])').not(skip).on('click', function(e) {
                // Only same-page anchors.
                if (this.pathname !== window.location.pathname || this.host !== window.location.host) {
                    return;
                }
                let target;
                try {
                    target = $(this.hash);
                } catch (err) {
                    return; // Hash is not a valid selector (e.g. "#/route").
                }
                if (target.length && target.is(':visible')) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top - 80
                    }, 600);
                }
            });
        }
        
        // Image Lazy Loading (simple implementation)
        function initLazyLoading() {
            const images = $('img[data-src]');
            
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('lazy');
                            imageObserver.unobserve(img);
                        }
                    });
                });
                
                images.each(function() {
                    imageObserver.observe(this);
                });
            } else {
                // Fallback for older browsers
                images.each(function() {
                    this.src = this.dataset.src;
                });
            }
        }
        
        // Initialize all functions
        initSearchOverlay();
        initMobileMenu();
        initMiniCart();
        initBackToTop();
        initStickyHeader();
        initSmoothScrolling();
        initLazyLoading();

        // Window resize handler
        $(window).on('resize', function() {
            // Close mobile menu on resize
            if ($(window).width() > 991) {
                $('.mobile-menu-overlay').removeClass('active').attr('aria-hidden', 'true');
                $('body').removeClass('mobile-menu-open');
                $('.menu-toggle').attr('aria-expanded', 'false');
            }
        });
        
        // Accessibility enhancements
        $(document).on('keydown', function(e) {
            // Tab navigation enhancements
            if (e.keyCode === 9) { // Tab key
                $('body').addClass('user-is-tabbing');
            }
        });
        
        $(document).on('mousedown', function() {
            $('body').removeClass('user-is-tabbing');
        });
        
    });

})(jQuery);