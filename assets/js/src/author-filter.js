/**
 * Author Page Filter Functionality
 * Versatile WordPress Theme
 */

document.addEventListener('DOMContentLoaded', function() {
    // Filter author posts by category
    window.filterAuthorPosts = function(category) {
        const posts = document.querySelectorAll('.author-post-item');
        
        posts.forEach(post => {
            const postCategories = post.getAttribute('data-categories');
            if (!postCategories) return;
            
            const categoriesArray = postCategories.split(',');
            
            if (category === 'all' || categoriesArray.includes(category)) {
                post.style.display = 'block';
                post.style.animation = 'fadeIn 0.3s ease';
            } else {
                post.style.display = 'none';
            }
        });
        
        // Update active filter visual state
        const filterSelect = document.getElementById('author-post-filter');
        if (filterSelect) {
            filterSelect.value = category;
        }
    };
    
    // Add smooth animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .author-post-item {
            transition: all 0.3s ease;
        }
    `;
    document.head.appendChild(style);
});