// data.js - Data management and API interactions

// Kazakh cuisine services (English descriptions)
const services = [
    { id: 1, name: 'Beshbarmak', description: 'Traditional Kazakh dish - meat with noodles and broth', price: 'Starting at 5,000 ₸' },
    { id: 2, name: 'Kazy', description: 'Traditional Kazakh kazy - specially prepared horse meat sausage', price: 'Starting at 6,000 ₸' },
    { id: 3, name: 'Baursak', description: 'Golden Kazakh baursaks - delicious crispy fried bread', price: 'Starting at 3,000 ₸' },
    { id: 4, name: 'Manty', description: 'Steamed manty - traditional Kazakh dumplings with meat', price: 'Starting at 4,000 ₸' },
    { id: 5, name: 'Plov', description: 'Traditional Kazakh plov - aromatic rice with meat', price: 'Starting at 4,500 ₸' },
    { id: 6, name: 'Shashlik', description: 'Delicious Kazakh shashlik - marinated grilled meat', price: 'Starting at 5,500 ₸' }
];

const teamMembers = [
    { name: 'Aigul Nurlandykyzy', role: 'Head Chef', bio: '10+ years of experience in traditional Kazakh cuisine' },
    { name: 'Erlan Qasymuly', role: 'Master Cook', bio: 'Expert in preparing authentic Kazakh dishes' },
    { name: 'Quralay Amangeldikyzy', role: 'Service Manager', bio: 'Dedicated to providing excellent customer service' }
];

const features = [
    'Premium Quality Ingredients',
    'Custom Design Options',
    'Professional Photography',
    'On-Time Delivery',
    '24/7 Customer Support'
];

// API Base URL
const API_BASE = 'api';

// Fetch portfolio items from Web Service v1 (GET)
async function fetchPortfolioItems() {
    try {
        const response = await fetch(`${API_BASE}/portfolio.php`);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const result = await response.json();
        console.log('API Response:', result); // Debug log
        
        // Extract data array from API response
        if (result.success && result.data && Array.isArray(result.data)) {
            console.log(`Loaded ${result.data.length} items from API`);
            return result.data;
        } else {
            console.warn('API returned unexpected format:', result);
            return [];
        }
    } catch (error) {
        console.error('Error fetching portfolio:', error);
        console.error('API URL attempted:', `${API_BASE}/portfolio.php`);
        return [];
    }
}

// Submit booking via Web Service v2 (POST)
async function submitBooking(bookingData) {
    try {
        const response = await fetch(`${API_BASE}/booking.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(bookingData)
        });
        
        if (!response.ok) {
            throw new Error('Failed to submit booking');
        }
        
        const result = await response.json();
        return result;
    } catch (error) {
        console.error('Error submitting booking:', error);
        throw error;
    }
}

// Filter portfolio items by category
function filterPortfolioItems(items, category) {
    if (category === 'all') {
        return items;
    }
    return items.filter(item => item.category === category);
}

// Sort portfolio items
function sortPortfolioItems(items, sortBy) {
    const sortedItems = [...items];
    
    switch (sortBy) {
        case 'newest':
            return sortedItems.sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
        case 'oldest':
            return sortedItems.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
        case 'title':
            return sortedItems.sort((a, b) => a.title.localeCompare(b.title));
        case 'category':
            return sortedItems.sort((a, b) => a.category.localeCompare(b.category));
        default:
            return sortedItems;
    }
}

// Process portfolio data using map, filter, reduce
function processPortfolioData(items) {
    // Map: Transform items to include display properties
    const mappedItems = items.map(item => ({
        ...item,
        displayTitle: item.title.toUpperCase(),
        shortDescription: item.description ? item.description.substring(0, 100) + '...' : ''
    }));
    
    // Filter: Get only featured items (handle different data types from MySQL)
    const featuredItems = mappedItems.filter(item => {
        const featured = item.featured;
        // Handle boolean true, number 1, string "1", string "TRUE", etc.
        return featured === true || 
               featured === 1 || 
               featured === '1' || 
               featured === 'TRUE' || 
               featured === 'true' ||
               featured === 'True';
    });
    
    // Reduce: Count items by category
    const categoryCounts = mappedItems.reduce((acc, item) => {
        acc[item.category] = (acc[item.category] || 0) + 1;
        return acc;
    }, {});
    
    return {
        all: mappedItems,
        featured: featuredItems,
        categoryCounts: categoryCounts
    };
}

// Export functions for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        services,
        teamMembers,
        features,
        fetchPortfolioItems,
        submitBooking,
        filterPortfolioItems,
        sortPortfolioItems,
        processPortfolioData
    };
}
