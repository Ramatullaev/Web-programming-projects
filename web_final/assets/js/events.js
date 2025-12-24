// events.js - Event handlers and interactions

// Initialize all event listeners when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    initializeEvents();
    loadInitialContent();
});

// Initialize all event handlers
function initializeEvents() {
    // Theme toggle button (click event)
    const themeToggle = document.getElementById('themeToggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', handleThemeToggle);
    }
    
    // Portfolio filter buttons (click events)
    const filterButtons = document.querySelectorAll('.filter-btn[data-category]');
    filterButtons.forEach(btn => {
        btn.addEventListener('click', handleFilterClick);
    });
    
    // Sort select (change event)
    const sortSelect = document.getElementById('sortSelect');
    if (sortSelect) {
        sortSelect.addEventListener('change', handleSortChange);
    }
    
    // Booking form submission (submit event)
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', handleFormSubmit);
    }
    
    // Form input validation (keydown events)
    const formInputs = document.querySelectorAll('#bookingForm input, #bookingForm textarea');
    formInputs.forEach(input => {
        input.addEventListener('keydown', handleInputKeydown);
        input.addEventListener('blur', handleInputBlur);
    });
    
    // Portfolio item hover effects (mouseover events)
    setupPortfolioHoverEffects();
}

// Load initial content
async function loadInitialContent() {
    // Load featured portfolio items on index page
    if (document.getElementById('featuredGrid')) {
        await loadFeaturedPortfolio();
    }
    
    // Load all portfolio items on portfolio page
    if (document.getElementById('portfolioGrid')) {
        await loadPortfolio();
    }
    
    // Load services on index page
    if (document.getElementById('servicesContainer')) {
        loadServices();
    }
    
    // Load team members on about page
    if (document.getElementById('teamContainer')) {
        loadTeamMembers();
    }
    
    // Load features on about page
    if (document.getElementById('featuresList')) {
        loadFeatures();
    }
}

// Theme toggle handler
function handleThemeToggle(event) {
    event.preventDefault();
    const newTheme = toggleTheme();
    
    // Save theme preference via cookie using fetch
    fetch('api/theme.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ theme: newTheme })
    }).catch(err => console.error('Error saving theme:', err));
}

// Filter click handler
function handleFilterClick(event) {
    const category = event.target.getAttribute('data-category');
    
    // Update active button
    document.querySelectorAll('.filter-btn[data-category]').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    // Filter portfolio items
    filterPortfolio(category);
}

// Sort change handler
function handleSortChange(event) {
    const sortBy = event.target.value;
    sortPortfolio(sortBy);
}

// Form submit handler (AJAX submission - no page reload)
async function handleFormSubmit(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const formMessages = document.getElementById('formMessages');
    
    // Clear previous messages
    formMessages.innerHTML = '';
    
    // Validate form
    if (!validateForm(form)) {
        const errorMsg = createMessage('Please fill in all required fields correctly.', 'error');
        formMessages.appendChild(errorMsg);
        return;
    }
    
    // Convert FormData to object
    const bookingData = {
        client_name: formData.get('client_name'),
        client_email: formData.get('client_email'),
        client_phone: formData.get('client_phone'),
        service_type: formData.get('service_type'),
        event_date: formData.get('event_date'),
        event_time: formData.get('event_time'),
        message: formData.get('message')
    };
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.textContent = 'Submitting...';
    submitBtn.disabled = true;
    
    try {
        // Submit via AJAX (Web Service v2)
        const result = await submitBooking(bookingData);
        
        if (result.success) {
            const successMsg = createMessage(result.message || 'Booking submitted successfully! We will contact you soon.', 'success');
            formMessages.appendChild(successMsg);
            form.reset();
        } else {
            const errorMsg = createMessage(result.message || 'Failed to submit booking. Please try again.', 'error');
            formMessages.appendChild(errorMsg);
        }
    } catch (error) {
        const errorMsg = createMessage('An error occurred. Please try again later.', 'error');
        formMessages.appendChild(errorMsg);
    } finally {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    }
}

// Input keydown handler
function handleInputKeydown(event) {
    // Add visual feedback on keydown
    if (event.target.value.length > 0) {
        event.target.style.borderColor = 'currentColor';
    }
}

// Input blur handler (validation feedback)
function handleInputBlur(event) {
    const input = event.target;
    if (input.hasAttribute('required') && !input.value.trim()) {
        input.style.borderColor = 'rgba(244, 67, 54, 0.5)';
    } else {
        input.style.borderColor = '';
    }
}

// Portfolio hover effects
function setupPortfolioHoverEffects() {
    // Use event delegation for dynamically created items
    document.addEventListener('mouseover', (event) => {
        const portfolioItem = event.target.closest('.portfolio-item');
        if (portfolioItem) {
            portfolioItem.style.transform = 'translateY(-5px)';
            portfolioItem.style.transition = 'transform 0.3s ease';
        }
    });
    
    document.addEventListener('mouseout', (event) => {
        const portfolioItem = event.target.closest('.portfolio-item');
        if (portfolioItem) {
            portfolioItem.style.transform = 'translateY(0)';
        }
    });
}

// Load featured portfolio items
async function loadFeaturedPortfolio() {
    showLoader('featuredGrid');
    
    try {
        const items = await fetchPortfolioItems();
        console.log('Fetched items:', items); // Debug log
        
        if (!items || items.length === 0) {
            document.getElementById('featuredGrid').innerHTML = '<p style="text-align: center; padding: 2rem;">No dishes found. Please make sure the database is set up correctly.</p>';
            return;
        }
        
        const processed = processPortfolioData(items);
        console.log('Processed featured items:', processed.featured); // Debug log
        
        if (processed.featured.length === 0) {
            document.getElementById('featuredGrid').innerHTML = '<p style="text-align: center; padding: 2rem;">No featured dishes found. Please mark some dishes as featured in the database.</p>';
            return;
        }
        
        displayPortfolioItems(processed.featured, 'featuredGrid');
    } catch (error) {
        console.error('Error loading featured portfolio:', error);
        document.getElementById('featuredGrid').innerHTML = '<p style="text-align: center; padding: 2rem;">Failed to load portfolio items. Please check the console for details.</p>';
    }
}

// Load all portfolio items
async function loadPortfolio() {
    showLoader('portfolioGrid');
    
    try {
        const items = await fetchPortfolioItems();
        window.portfolioItems = items; // Store for filtering/sorting
        const processed = processPortfolioData(items);
        displayPortfolioItems(processed.all, 'portfolioGrid');
    } catch (error) {
        console.error('Error loading portfolio:', error);
        document.getElementById('portfolioGrid').innerHTML = '<p>Failed to load portfolio items.</p>';
    }
}

// Filter portfolio items
function filterPortfolio(category) {
    if (!window.portfolioItems) return;
    
    const filtered = filterPortfolioItems(window.portfolioItems, category);
    displayPortfolioItems(filtered, 'portfolioGrid');
}

// Sort portfolio items
function sortPortfolio(sortBy) {
    if (!window.portfolioItems) return;
    
    const sorted = sortPortfolioItems(window.portfolioItems, sortBy);
    displayPortfolioItems(sorted, 'portfolioGrid');
}

// Load services
function loadServices() {
    displayServices(services, 'servicesContainer');
}

// Load team members
function loadTeamMembers() {
    displayTeamMembers(teamMembers, 'teamContainer');
}

// Load features
function loadFeatures() {
    displayFeatures(features, 'featuresList');
}

// Form validation
function validateForm(form) {
    const requiredFields = form.querySelectorAll('[required]');
    let isValid = true;
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            isValid = false;
            field.style.borderColor = 'rgba(244, 67, 54, 0.5)';
        } else {
            field.style.borderColor = '';
        }
        
        // Email validation
        if (field.type === 'email' && field.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(field.value)) {
                isValid = false;
                field.style.borderColor = 'rgba(244, 67, 54, 0.5)';
            }
        }
    });
    
    return isValid;
}

// Helper function to toggle theme (from ui.js)
function toggleTheme(theme) {
    const body = document.body;
    const currentTheme = body.classList.contains('theme-dark') ? 'dark' : 'light';
    const newTheme = theme || (currentTheme === 'dark' ? 'light' : 'dark');
    
    body.classList.remove('theme-dark', 'theme-light');
    body.classList.add(`theme-${newTheme}`);
    
    const themeIcon = document.getElementById('themeIcon');
    if (themeIcon) {
        themeIcon.textContent = newTheme === 'dark' ? '🌙' : '☀️';
    }
    
    return newTheme;
}
