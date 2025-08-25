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
                searchOverlay.addClass('active');
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
                searchOverlay.removeClass('active');
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
                mobileOverlay.addClass('active');
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
                mobileOverlay.removeClass('active');
                $('body').removeClass('mobile-menu-open');
                menuToggle.attr('aria-expanded', 'false');
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
            $('a[href*="#"]:not([href="#"])').on('click', function(e) {
                const target = $(this.hash);
                if (target.length) {
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
                const imageObserver = new IntersectionObserver(function(entries, observer) {
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
        
        // Form Enhancements
        function initFormEnhancements() {
            // Add loading state to forms
            $('form').on('submit', function() {
                const submitBtn = $(this).find('button[type="submit"], input[type="submit"]');
                const originalText = submitBtn.text();
                
                submitBtn.prop('disabled', true);
                if (submitBtn.is('button')) {
                    submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Processing...');
                } else {
                    submitBtn.val('Processing...');
                }
                
                // Re-enable after 3 seconds (fallback)
                setTimeout(function() {
                    submitBtn.prop('disabled', false);
                    if (submitBtn.is('button')) {
                        submitBtn.text(originalText);
                    } else {
                        submitBtn.val(originalText);
                    }
                }, 3000);
            });
            
            // Floating labels for forms
            $('.form-control').on('focus blur', function(e) {
                const $this = $(this);
                const label = $this.prev('label');
                
                if (e.type === 'focus' || this.value.length > 0) {
                    label.addClass('floating');
                } else {
                    label.removeClass('floating');
                }
            }).trigger('blur');
        }
        
        // Notification System
        window.showNotification = function(message, type = 'info', duration = 5000) {
            const container = $('#notifications');
            if (!container.length) return;
            
            const notification = $(`
                <div class="notification notification-${type}">
                    <div class="notification-content">
                        <span class="notification-message">${message}</span>
                        <button class="notification-close">&times;</button>
                    </div>
                </div>
            `);
            
            container.append(notification);
            
            // Show notification
            setTimeout(() => notification.addClass('show'), 100);
            
            // Auto-hide notification
            setTimeout(() => {
                notification.removeClass('show');
                setTimeout(() => notification.remove(), 300);
            }, duration);
            
            // Manual close
            notification.find('.notification-close').on('click', function() {
                notification.removeClass('show');
                setTimeout(() => notification.remove(), 300);
            });
        };
        
        // AJAX Comment Loading
        function initAjaxComments() {
            $(document).on('submit', '#commentform', function(e) {
                e.preventDefault();
                
                const form = $(this);
                const submitBtn = form.find('#submit');
                const originalText = submitBtn.val();
                
                submitBtn.val('Posting...').prop('disabled', true);
                
                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        // Handle successful comment submission
                        showNotification('Comment posted successfully!', 'success');
                        form[0].reset();
                    },
                    error: function() {
                        showNotification('Error posting comment. Please try again.', 'error');
                    },
                    complete: function() {
                        submitBtn.val(originalText).prop('disabled', false);
                    }
                });
            });
        }
        
        // Initialize all functions
        initSearchOverlay();
        initMobileMenu();
        initMiniCart();
        initBackToTop();
        initStickyHeader();
        initSmoothScrolling();
        initLazyLoading();
        initFormEnhancements();
        initAjaxComments();
        
        // Window resize handler
        $(window).on('resize', function() {
            // Close mobile menu on resize
            if ($(window).width() > 991) {
                $('.mobile-menu-overlay').removeClass('active');
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