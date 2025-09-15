/**
 * Archive View Toggle Functionality
 * Versatile WordPress Theme
 */

document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-btn');
    const postsGrid = document.getElementById('archive-posts');
    
    if (!viewButtons.length || !postsGrid) {
        return;
    }
    
    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            viewButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            // Toggle view class on posts grid
            const viewType = this.getAttribute('data-view');
            if (viewType) {
                postsGrid.className = 'archive-posts-' + viewType;
            }
        });
    });
});