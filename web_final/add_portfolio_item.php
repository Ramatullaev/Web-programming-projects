<?php
// Script for adding new portfolio items
require_once 'includes/config.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? sanitizeInput($_POST['title']) : '';
    $category = isset($_POST['category']) ? sanitizeInput($_POST['category']) : '';
    $description = isset($_POST['description']) ? sanitizeInput($_POST['description']) : '';
    $image_url = isset($_POST['image_url']) ? sanitizeInput($_POST['image_url']) : '';
    $featured = isset($_POST['featured']) ? 1 : 0;
    
    if (empty($title) || empty($category)) {
        $message = 'Title and category are required!';
        $messageType = 'error';
    } else {
        try {
            $conn = getDBConnection();
            $stmt = $conn->prepare("INSERT INTO portfolio_items (title, category, description, image_url, featured) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssi", $title, $category, $description, $image_url, $featured);
            
            if ($stmt->execute()) {
                $message = 'Dish successfully added!';
                $messageType = 'success';
            } else {
                $message = 'Error: ' . $stmt->error;
                $messageType = 'error';
            }
            
            $stmt->close();
            $conn->close();
        } catch (Exception $e) {
            $message = 'Error: ' . $e->getMessage();
            $messageType = 'error';
        }
    }
}

$pageTitle = 'Add Portfolio Item - Kazakh Cuisine';
require_once 'includes/header.php';
?>

<section>
    <h2 class="section-title">Add New Dish</h2>
    
    <?php if ($message): ?>
        <div class="message <?php echo $messageType; ?>" style="max-width: 600px; margin: 0 auto 2rem;">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>
    
    <div class="booking-form-container">
        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Title *</label>
                <input type="text" id="title" name="title" required>
            </div>
            
            <div class="form-group">
                <label for="category">Category *</label>
                <select id="category" name="category" required>
                    <option value="">Select a category</option>
                    <option value="Kazakh Dishes">Kazakh Dishes</option>
                    <option value="Meat Products">Meat Products</option>
                    <option value="Bread Products">Bread Products</option>
                    <option value="Dairy Products">Dairy Products</option>
                    <option value="Meat Dishes">Meat Dishes</option>
                    <option value="Desserts">Desserts</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>
            
            <div class="form-group">
                <label for="image_url">Image URL *</label>
                <input type="text" id="image_url" name="image_url" required 
                       placeholder="https://example.com/image.jpg or assets/images/photo.jpg">
                <small style="display: block; margin-top: 0.5rem; opacity: 0.7;">
                    You can use an internet URL or local path (e.g., assets/images/photo.jpg)
                </small>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="featured" value="1"> 
                    Show in "Featured Dishes" section on homepage
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary">Add Dish</button>
        </form>
    </div>
    
    <div style="max-width: 600px; margin: 2rem auto; padding: 1.5rem; border-radius: 8px; border: 2px solid currentColor;">
        <h3 style="margin-bottom: 1rem;">Image Upload Instructions:</h3>
        <ol style="line-height: 2; padding-left: 1.5rem;">
            <li><strong>Local Images:</strong>
                <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
                    <li>Place images in the <code>assets/images/</code> folder</li>
                    <li>Use path: <code>assets/images/filename.jpg</code></li>
                    <li>Supported formats: JPG, PNG, GIF, WebP</li>
                </ul>
            </li>
            <li><strong>Internet Images:</strong>
                <ul style="margin-top: 0.5rem; padding-left: 1.5rem;">
                    <li>Use full URL: <code>https://example.com/image.jpg</code></li>
                    <li>You can use Unsplash, Pexels and other free sources</li>
                </ul>
            </li>
            <li><strong>URL Examples:</strong>
                <ul style="margin-top: 0.5rem; padding-left: 1.5rem; font-family: monospace; font-size: 0.9rem;">
                    <li>Local: <code>assets/images/dish1.jpg</code></li>
                    <li>Internet: <code>https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=800</code></li>
                </ul>
            </li>
        </ol>
    </div>
    
    <div style="text-align: center; margin-top: 2rem;">
        <a href="portfolio.php" class="btn">Back to Portfolio</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>

