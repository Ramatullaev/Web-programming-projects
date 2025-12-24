// ui.js - UI manipulation and DOM creation

// Dynamically create DOM elements
function createPortfolioCard(item) {
    const card = document.createElement('div');
    card.className = 'portfolio-item';
    card.setAttribute('data-category', item.category);
    
    const img = document.createElement('img');
    img.src = item.image_url || 'https://via.placeholder.com/400x300';
    img.alt = item.title;
    img.loading = 'lazy';
    
    const content = document.createElement('div');
    content.className = 'portfolio-item-content';
    
    const title = document.createElement('h3');
    title.textContent = item.title;
    
    const category = document.createElement('span');
    category.className = 'category';
    category.textContent = item.category;
    
    const description = document.createElement('p');
    description.className = 'description';
    description.textContent = item.description || '';
    
    content.appendChild(title);
    content.appendChild(category);
    content.appendChild(description);
    
    card.appendChild(img);
    card.appendChild(content);
    
    return card;
}

function createServiceCard(service) {
    const card = document.createElement('div');
    card.className = 'service-card';
    card.style.cssText = 'padding: 1.5rem; border-radius: 8px; border: 2px solid currentColor; margin-bottom: 1rem;';
    
    const title = document.createElement('h3');
    title.textContent = service.name;
    title.style.cssText = 'margin-bottom: 0.5rem;';
    
    const description = document.createElement('p');
    description.textContent = service.description;
    description.style.cssText = 'margin-bottom: 0.5rem; opacity: 0.8;';
    
    const price = document.createElement('p');
    price.textContent = service.price;
    price.style.cssText = 'font-weight: 600;';
    
    card.appendChild(title);
    card.appendChild(description);
    card.appendChild(price);
    
    return card;
}

function createTeamMemberCard(member) {
    const card = document.createElement('div');
    card.className = 'team-member-card';
    card.style.cssText = 'padding: 1.5rem; border-radius: 8px; border: 2px solid currentColor; text-align: center;';
    
    const name = document.createElement('h3');
    name.textContent = member.name;
    name.style.cssText = 'margin-bottom: 0.5rem;';
    
    const role = document.createElement('p');
    role.textContent = member.role;
    role.style.cssText = 'font-weight: 600; margin-bottom: 0.5rem; opacity: 0.8;';
    
    const bio = document.createElement('p');
    bio.textContent = member.bio;
    bio.style.cssText = 'opacity: 0.7; font-size: 0.9rem;';
    
    card.appendChild(name);
    card.appendChild(role);
    card.appendChild(bio);
    
    return card;
}

function createFeatureItem(feature) {
    const li = document.createElement('li');
    li.textContent = feature;
    li.style.cssText = 'padding: 0.5rem 0; list-style: disc; margin-left: 1.5rem;';
    return li;
}

function createMessage(message, type = 'success') {
    const messageDiv = document.createElement('div');
    messageDiv.className = `message ${type}`;
    messageDiv.textContent = message;
    messageDiv.style.cssText = 'padding: 1rem; border-radius: 8px; margin-bottom: 1rem;';
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (messageDiv.parentNode) {
            messageDiv.remove();
        }
    }, 5000);
    
    return messageDiv;
}

// Display portfolio items
function displayPortfolioItems(items, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    // Clear existing content
    container.innerHTML = '';
    
    if (items.length === 0) {
        container.innerHTML = '<p style="text-align: center; padding: 2rem;">No items found.</p>';
        return;
    }
    
    items.forEach(item => {
        const card = createPortfolioCard(item);
        container.appendChild(card);
    });
}

// Display services
function displayServices(services, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    container.innerHTML = '';
    
    services.forEach(service => {
        const card = createServiceCard(service);
        container.appendChild(card);
    });
}

// Display team members
function displayTeamMembers(members, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    container.innerHTML = '';
    container.style.cssText = 'display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem;';
    
    members.forEach(member => {
        const card = createTeamMemberCard(member);
        container.appendChild(card);
    });
}

// Display features
function displayFeatures(features, containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;
    
    features.forEach(feature => {
        const li = createFeatureItem(feature);
        container.appendChild(li);
    });
}

// Show loading state
function showLoader(containerId) {
    const container = document.getElementById(containerId);
    if (container) {
        container.innerHTML = '<div class="loader"></div>';
    }
}

// Hide loader
function hideLoader(containerId) {
    const container = document.getElementById(containerId);
    const loader = container?.querySelector('.loader');
    if (loader) {
        loader.remove();
    }
}

// Modify styles dynamically
function toggleTheme(theme) {
    const body = document.body;
    const currentTheme = body.classList.contains('theme-dark') ? 'dark' : 'light';
    const newTheme = theme || (currentTheme === 'dark' ? 'light' : 'dark');
    
    body.classList.remove('theme-dark', 'theme-light');
    body.classList.add(`theme-${newTheme}`);
    
    // Update theme icon
    const themeIcon = document.getElementById('themeIcon');
    if (themeIcon) {
        themeIcon.textContent = newTheme === 'dark' ? '🌙' : '☀️';
    }
    
    return newTheme;
}

// Add/remove elements dynamically
function addElement(parentId, elementType, className, content) {
    const parent = document.getElementById(parentId);
    if (!parent) return null;
    
    const element = document.createElement(elementType);
    if (className) element.className = className;
    if (content) element.textContent = content;
    
    parent.appendChild(element);
    return element;
}

function removeElement(elementId) {
    const element = document.getElementById(elementId);
    if (element && element.parentNode) {
        element.parentNode.removeChild(element);
    }
}

// Export functions
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        createPortfolioCard,
        createServiceCard,
        createTeamMemberCard,
        createFeatureItem,
        createMessage,
        displayPortfolioItems,
        displayServices,
        displayTeamMembers,
        displayFeatures,
        showLoader,
        hideLoader,
        toggleTheme,
        addElement,
        removeElement
    };
}
