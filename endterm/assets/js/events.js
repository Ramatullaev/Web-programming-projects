// events.js - Event handlers and interactive components

// Initialize all event handlers when DOM is ready
const initEventHandlers = () => {
  // Bigger Pimpin' Button - grows 5% on each click
  const biggerButton = document.getElementById('bigger-button');
  if (biggerButton) {
    let scale = 1;
    biggerButton.addEventListener('click', () => {
      scale += 0.05;
      biggerButton.style.transform = `scale(${scale})`;
      biggerButton.style.transition = 'transform 0.3s';
    });
  }
  
  // Snoopy Bling Checkbox - toggles colorful styling
  const blingCheckbox = document.getElementById('snoopy-bling');
  if (blingCheckbox) {
    blingCheckbox.addEventListener('change', (e) => {
      const body = document.body;
      if (e.target.checked) {
        body.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
        body.style.transition = 'background 0.5s';
      } else {
        body.style.background = '';
      }
    });
  }
  
  // Live search filter
  const searchInput = document.getElementById('live-search');
  if (searchInput) {
    searchInput.addEventListener('keydown', (e) => {
      // Allow typing
    });
    
    searchInput.addEventListener('input', (e) => {
      const searchTerm = e.target.value.toLowerCase();
      const cards = document.querySelectorAll('.card');
      
      cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        if (text.includes(searchTerm)) {
          card.style.display = '';
          fadeIn(card);
        } else {
          card.style.opacity = '0.3';
          card.style.transform = 'scale(0.95)';
          card.style.transition = 'all 0.3s';
        }
      });
    });
  }
  
  // Mouseover effects on cards
  const cards = document.querySelectorAll('.card');
  cards.forEach(card => {
    card.addEventListener('mouseover', () => {
      card.style.transform = 'translateY(-5px)';
      card.style.transition = 'transform 0.3s';
      card.style.boxShadow = '0 10px 30px rgba(96,165,250,0.3)';
    });
    
    card.addEventListener('mouseout', () => {
      card.style.transform = '';
      card.style.boxShadow = '';
    });
  });
  
  // Keydown handler for keyboard shortcuts
  document.addEventListener('keydown', (e) => {
    // Press 'S' to focus search
    if (e.key === 's' && !e.ctrlKey && !e.metaKey && document.activeElement.tagName !== 'INPUT') {
      const searchInput = document.getElementById('live-search');
      if (searchInput) {
        e.preventDefault();
        searchInput.focus();
      }
    }
  });
};

// Wait for DOM to load before initializing
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initEventHandlers);
} else {
  initEventHandlers();
}
