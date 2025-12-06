// data.js - Functions for fetching data from API endpoints

// Fetch events data from API
const fetchEvents = async () => {
  try {
    const response = await fetch('/public/api/getData.php?type=events');
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error fetching events:', error);
    return [];
  }
};

// Fetch registrations data from API
const fetchRegistrations = async () => {
  try {
    const response = await fetch('/public/api/getData.php?type=registrations');
    const data = await response.json();
    return data;
  } catch (error) {
    console.error('Error fetching registrations:', error);
    return [];
  }
};

// Post registration data to API
const postRegistration = async (registrationData) => {
  try {
    const response = await fetch('/public/api/postData.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(registrationData)
    });
    const result = await response.json();
    return result;
  } catch (error) {
    console.error('Error posting registration:', error);
    return { success: false, error: 'Network error' };
  }
};

// Post comment/feedback data to API
const postComment = async (commentData) => {
  try {
    const response = await fetch('/public/api/postData.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify(commentData)
    });
    const result = await response.json();
    return result;
  } catch (error) {
    console.error('Error posting comment:', error);
    return { success: false, error: 'Network error' };
  }
};

// Export functions for use in other modules
if (typeof module !== 'undefined' && module.exports) {
  module.exports = { fetchEvents, fetchRegistrations, postRegistration, postComment };
}
