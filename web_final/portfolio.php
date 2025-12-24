<?php
$pageTitle = 'Portfolio - Kazakh Cuisine & Booking';
require_once 'includes/header.php';
?>

<section id="portfolio">
    <h2 class="section-title">Our Portfolio</h2>
    
    <div class="filter-controls" id="filterControls">
        <button class="filter-btn active" data-category="all">All</button>
        <button class="filter-btn" data-category="Kazakh Dishes">Kazakh Dishes</button>
        <button class="filter-btn" data-category="Meat Products">Meat Products</button>
        <button class="filter-btn" data-category="Bread Products">Bread Products</button>
        <button class="filter-btn" data-category="Dairy Products">Dairy Products</button>
        <button class="filter-btn" data-category="Meat Dishes">Meat Dishes</button>
        <button class="filter-btn" data-category="Desserts">Desserts</button>
        <button class="filter-btn" data-category="Soups">Soups</button>
    </div>
    
    <div class="sort-controls" id="sortControls">
        <label for="sortSelect">Sort by:</label>
        <select id="sortSelect" class="filter-btn">
            <option value="newest">Newest First</option>
            <option value="oldest">Oldest First</option>
            <option value="title">Title A-Z</option>
            <option value="category">Category</option>
        </select>
    </div>
    
    <div class="portfolio-grid" id="portfolioGrid">
        <!-- Portfolio items will be dynamically loaded via JavaScript -->
        <div class="loader"></div>
    </div>
</section>

<section id="booking">
    <h2 class="section-title">Book Your Service</h2>
    <div class="booking-form-container">
        <form id="bookingForm" method="POST" action="">
            <div id="formMessages"></div>
            
            <div class="form-group">
                <label for="client_name">Full Name *</label>
                <input type="text" id="client_name" name="client_name" required>
            </div>
            
            <div class="form-group">
                <label for="client_email">Email Address *</label>
                <input type="email" id="client_email" name="client_email" required>
            </div>
            
            <div class="form-group">
                <label for="client_phone">Phone Number</label>
                <input type="tel" id="client_phone" name="client_phone" placeholder="+7 (XXX) XXX-XX-XX">
            </div>
            
            <div class="form-group">
                <label for="service_type">Dish Type *</label>
                <select id="service_type" name="service_type" required>
                    <option value="">Select a dish</option>
                    <option value="Beshbarmak">Beshbarmak</option>
                    <option value="Kazy">Kazy</option>
                    <option value="Baursak">Baursak</option>
                    <option value="Manty">Manty</option>
                    <option value="Plov">Plov</option>
                    <option value="Shashlik">Shashlik</option>
                    <option value="Kurt">Kurt</option>
                    <option value="Kazakh Melon">Kazakh Melon</option>
                    <option value="Other Kazakh Dish">Other Kazakh Dish</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="event_date">Event Date *</label>
                <input type="date" id="event_date" name="event_date" required>
            </div>
            
            <div class="form-group">
                <label for="event_time">Event Time</label>
                <input type="time" id="event_time" name="event_time">
            </div>
            
            <div class="form-group">
                <label for="message">Additional Message</label>
                <textarea id="message" name="message" rows="4" placeholder="Special requests, quantity, dietary requirements..."></textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Submit Booking</button>
        </form>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

