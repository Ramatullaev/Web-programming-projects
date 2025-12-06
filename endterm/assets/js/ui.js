// ui.js - DOM manipulation functions

// Create a new element dynamically
const createElement = (tag, className = '', text = '') => {
  const element = document.createElement(tag);
  if (className) element.className = className;
  if (text) element.textContent = text;
  return element;
};

// Create a card element for events
const createEventCard = (event) => {
  const card = createElement('div', 'card');
  const content = createElement('div', 'content');
  
  const title = createElement('h3', '', event.title);
  const date = createElement('p', 'meta', `Date: ${event.date}`);
  const location = createElement('p', 'meta', `Location: ${event.location}`);
  
  content.appendChild(title);
  content.appendChild(date);
  content.appendChild(location);
  card.appendChild(content);
  
  return card;
};

// Create a message element (for notifications)
const createMessage = (text, type = 'info') => {
  const message = createElement('div', `message message-${type}`);
  message.textContent = text;
  message.style.padding = '12px';
  message.style.marginBottom = '16px';
  message.style.borderRadius = '8px';
  
  if (type === 'success') {
    message.style.background = '#1f2937';
    message.style.color = '#22d3ee';
    message.style.border = '1px solid #22d3ee';
  } else if (type === 'error') {
    message.style.background = '#1f2937';
    message.style.color = '#ef4444';
    message.style.border = '1px solid #ef4444';
  }
  
  return message;
};

// Dynamically modify CSS styles
const setStyle = (element, styles) => {
  Object.assign(element.style, styles);
};

// Add fade in effect
const fadeIn = (element, duration = 500) => {
  element.style.opacity = '0';
  element.style.transition = `opacity ${duration}ms`;
  
  setTimeout(() => {
    element.style.opacity = '1';
  }, 10);
};

// Add slide down effect
const slideDown = (element, duration = 500) => {
  const height = element.scrollHeight;
  element.style.height = '0px';
  element.style.overflow = 'hidden';
  element.style.transition = `height ${duration}ms`;
  
  setTimeout(() => {
    element.style.height = height + 'px';
  }, 10);
  
  setTimeout(() => {
    element.style.height = 'auto';
  }, duration);
};

// Remove element with fade out
const removeElement = (element) => {
  element.style.transition = 'opacity 300ms';
  element.style.opacity = '0';
  setTimeout(() => {
    element.remove();
  }, 300);
};

// Pulsate effect (grows and shrinks)
const pulsate = (element, duration = 1000, iterations = 3) => {
  let count = 0;
  const interval = setInterval(() => {
    element.style.transform = 'scale(1.1)';
    element.style.transition = 'transform 0.3s';
    
    setTimeout(() => {
      element.style.transform = 'scale(1)';
      count++;
      if (count >= iterations) {
        clearInterval(interval);
        element.style.transform = '';
      }
    }, duration / (iterations * 2));
  }, duration / iterations);
};

// Appear effect (slide up and fade in)
const appear = (element, duration = 500) => {
  element.style.opacity = '0';
  element.style.transform = 'translateY(20px)';
  element.style.transition = `opacity ${duration}ms, transform ${duration}ms`;
  
  setTimeout(() => {
    element.style.opacity = '1';
    element.style.transform = 'translateY(0)';
  }, 10);
};

// Append message to container and auto-remove after delay
const showMessage = (container, text, type = 'info', delay = 3000) => {
  const message = createMessage(text, type);
  container.appendChild(message);
  fadeIn(message);
  
  setTimeout(() => {
    removeElement(message);
  }, delay);
};
