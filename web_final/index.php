<?php
$pageTitle = 'Home - Kazakh Cuisine & Booking';
require_once 'includes/header.php';
?>

<section class="hero">
    <h2>Welcome to Kazakh Cuisine</h2>
    <p>Experience authentic traditional Kazakh dishes and culinary excellence</p>
    <a href="portfolio.php" class="btn btn-primary">View Our Dishes</a>
</section>

<section id="featured">
    <h2 class="section-title">Featured Kazakh Dishes</h2>
    <div class="portfolio-grid" id="featuredGrid">
        <!-- Dynamically loaded via JavaScript -->
        <div class="loader"></div>
    </div>
</section>

<section id="gallery-preview">
    <h2 class="section-title">Gallery Preview</h2>
    <div class="gallery-grid" id="galleryPreview">
        <!-- Additional gallery images -->
        <div class="gallery-item">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSkcEtV0wsGgZhdHVSRPdsNaIHRXyy_DmET5w&s" alt="Creative Design 1">
            <div class="gallery-overlay">
                <h3>Elegant Design</h3>
            </div>
        </div>
        <div class="gallery-item">
            <img src="https://www.advantour.com/img/kazakhstan/kazakh-dishes.jpg" alt="Creative Design 2">
            <div class="gallery-overlay">
                <h3>Modern Style</h3>
            </div>
        </div>
        <div class="gallery-item">
            <img src="https://timesca.com/wp-content/uploads/2024/11/iStock-2160966904.jpg" alt="Creative Design 3">
            <div class="gallery-overlay">
                <h3>Artistic Touch</h3>
            </div>
        </div>
        <div class="gallery-item">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTVJB3O8HDYytDNU6FzbINa5CmEqmkHbUVpqA&s" alt="Creative Design 4">
            <div class="gallery-overlay">
                <h3>Premium Quality</h3>
            </div>
        </div>
        <div class="gallery-item">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSSsGK7JLTmpE0wYx4kHGhdhUngak_q5_JAoA&s" alt="Creative Design 5">
            <div class="gallery-overlay">
                <h3>Unique Flavor</h3>
            </div>
        </div>
        <div class="gallery-item">
            <img src="https://indyguide-web-development.s3.us-east-2.amazonaws.com/articles/Traditional-Kazakh-Cuisine-1609607543473.jpg" alt="Creative Design 6">
            <div class="gallery-overlay">
                <h3>Exquisite Taste</h3>
            </div>
        </div>
    </div>
</section>

<section id="services">
    <h2 class="section-title">Our Services</h2>
    <div class="services-grid" id="servicesContainer">
        <!-- Services will be dynamically created via JavaScript -->
    </div>
</section>

<section id="testimonials">
    <h2 class="section-title">What Our Clients Say</h2>
    <div class="testimonials-grid">
        <div class="testimonial-card">
            <div class="testimonial-image">
                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150" alt="Client 1">
            </div>
            <p class="testimonial-text">"Exceptional quality and authentic taste! The beshbarmak reminded me of my grandmother's cooking. Highly recommended!"</p>
            <p class="testimonial-author">- Aigul Nurlandykyzy</p>
        </div>
        <div class="testimonial-card">
            <div class="testimonial-image">
                <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150" alt="Client 2">
            </div>
            <p class="testimonial-text">"Amazing experience from start to finish! The kazy and baursak were perfect. Will definitely order again for our family gatherings!"</p>
            <p class="testimonial-author">- Erlan Qasymuly</p>
        </div>
        <div class="testimonial-card">
            <div class="testimonial-image">
                <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150" alt="Client 3">
            </div>
            <p class="testimonial-text">"Professional service and absolutely delicious traditional dishes! The manty and plov exceeded all expectations. Thank you!"</p>
            <p class="testimonial-author">- Quralay Amangeldikyzy</p>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

