<?php
// Core helpers for JSON-based data storage

function data_path($relative)
{
    return dirname(__DIR__) . '/data/' . $relative;
}

function load_json($filename)
{
    $path = data_path($filename);
    if (!file_exists($path)) {
        return [];
    }
    $content = file_get_contents($path);
    $decoded = json_decode($content, true);
    return is_array($decoded) ? $decoded : [];
}

function save_json($filename, $data)
{
    $path = data_path($filename);
    file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

// Events (JSON-only)
function load_events()
{
    $events = load_json('events.json');
    // Sort by date
    usort($events, function($a, $b) {
        return strcmp($a['date'] ?? '', $b['date'] ?? '');
    });
    return $events;
}

function get_event_by_id($id)
{
    $events = load_json('events.json');
    foreach ($events as $event) {
        if ((int)$event['id'] === (int)$id) {
            return $event;
        }
    }
    return null;
}

function add_event($event)
{
    $events = load_json('events.json');
    $max = 0;
    foreach ($events as $e) {
        $max = max($max, (int)$e['id']);
    }
    $event['id'] = $max + 1;
    $events[] = $event;
    save_json('events.json', $events);
    return $event['id'];
}

function delete_event($id)
{
    $events = load_json('events.json');
    $filtered = array_values(array_filter($events, function ($e) use ($id) {
        return (int)$e['id'] !== (int)$id;
    }));
    save_json('events.json', $filtered);
}

// Registrations (JSON-only)
function load_registrations()
{
    return load_json('registrations.json');
}

function add_registration($registration)
{
    $registrations = load_json('registrations.json');
    $registration['date'] = date('Y-m-d H:i:s');
    $registrations[] = $registration;
    save_json('registrations.json', $registrations);
}

function h($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

// Asset helpers
function photos_path()
{
    return dirname(__DIR__) . '/assets/photos';
}

function list_partner_photos()
{
    $dir = photos_path();
    if (!is_dir($dir)) return [];
    $files = scandir($dir);
    $out = [];
    foreach ($files as $f) {
        if ($f === '.' || $f === '..' || $f === '.gitkeep') continue;
        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
        if (in_array($ext, ['png','jpg','jpeg','webp','svg'])) {
            $out[] = '/assets/photos/' . $f;
        }
    }
    return $out;
}

// Named assets: photo1..photoN, sponsor1..sponsorN
function resolve_named_assets($prefix, $maxCount = 15)
{
    $dir = photos_path();
    if (!is_dir($dir)) return [];
    $extensions = ['jpg','jpeg','png','webp','svg'];
    $results = [];
    for ($i = 1; $i <= $maxCount; $i++) {
        $found = null;
        foreach ($extensions as $ext) {
            $candidate = $dir . '/' . $prefix . $i . '.' . $ext;
            if (file_exists($candidate)) { $found = '/assets/photos/' . $prefix . $i . '.' . $ext; break; }
        }
        if ($found) $results[] = $found;
    }
    return $results;
}

function list_gallery_photos($maxCount = 15)
{
    return resolve_named_assets('photo', $maxCount);
}

function list_sponsor_logos($maxCount = 20)
{
    return resolve_named_assets('sponsor', $maxCount);
}

// Get city-based marathon photo
function get_city_marathon_photo($city)
{
    $city = strtolower($city);
    $extensions = ['jpg','jpeg','png','webp','svg','avif'];
    $dir = photos_path();
    
    if (!is_dir($dir)) return 'https://images.unsplash.com/photo-1544915319-6ae69f0940f6?q=80&w=600&auto=format&fit=crop';
    
    foreach ($extensions as $ext) {
        $file = $dir . '/' . $city . '.' . $ext;
        if (file_exists($file)) {
            return '/assets/photos/' . $city . '.' . $ext;
        }
    }
    
    // Fallback to Unsplash
    return 'https://images.unsplash.com/photo-1544915319-6ae69f0940f6?q=80&w=600&auto=format&fit=crop';
}

// Authentication functions (JSON-based)
function start_session()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function is_logged_in()
{
    start_session();
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function get_logged_in_user()
{
    if (!is_logged_in()) return null;
    
    $users = load_json('users.json');
    foreach ($users as $user) {
        if ((int)$user['id'] === (int)$_SESSION['user_id']) {
            return $user;
        }
    }
    return null;
}

function register_user($name, $email, $password, $phone = null)
{
    $users = load_json('users.json');
    
    // Check if email already exists
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            return ['success' => false, 'error' => 'Email already exists'];
        }
    }
    
    // Generate new user ID
    $maxId = 0;
    foreach ($users as $user) {
        $maxId = max($maxId, (int)$user['id']);
    }
    $newId = $maxId + 1;
    
    // Create new user
    $newUser = [
        'id' => $newId,
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'phone' => $phone,
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $users[] = $newUser;
    save_json('users.json', $users);
    
    return ['success' => true, 'user_id' => $newId];
}

function login_user($email, $password)
{
    $users = load_json('users.json');
    
    foreach ($users as $user) {
        if ($user['email'] === $email && password_verify($password, $user['password'])) {
            start_session();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            return ['success' => true, 'user' => $user];
        }
    }
    
    return ['success' => false, 'error' => 'Invalid email or password'];
}

function logout_user()
{
    start_session();
    session_destroy();
}

function generate_bib_number()
{
    // Generate a 4-digit bib number (1000-9999)
    return rand(1000, 9999);
}


function get_start_time($event_date, $distance)
{
    // Different start times for different distances
    $start_times = [
        '10 км' => '08:00',
        '21 км' => '07:30', 
        '42 км' => '07:00'
    ];
    
    return $event_date . ' ' . ($start_times[$distance] ?? '08:00');
}

function register_user_for_event($event_id, $distance)
{
    if (!is_logged_in()) {
        return ['success' => false, 'error' => 'Must be logged in'];
    }
    
    $user = get_logged_in_user();
    $registrations = load_json('registrations.json');
    $events = load_json('events.json');
    
    // Find the event
    $event = null;
    foreach ($events as $e) {
        if ($e['id'] == $event_id) {
            $event = $e;
            break;
        }
    }
    
    if (!$event) {
        return ['success' => false, 'error' => 'Event not found'];
    }
    
    // Check if already registered
    foreach ($registrations as $reg) {
        if ($reg['user_id'] == $user['id'] && $reg['event_id'] == $event_id) {
            return ['success' => false, 'error' => 'Already registered for this event'];
        }
    }
    
    // Generate new registration ID
    $maxId = 0;
    foreach ($registrations as $reg) {
        $maxId = max($maxId, (int)$reg['id']);
    }
    $newId = $maxId + 1;
    
    // Generate marathon details
    $bib_number = generate_bib_number();
    $start_time = get_start_time($event['date'], $distance);
    
    // Create new registration
    $newRegistration = [
        'id' => $newId,
        'event_id' => (int)$event_id,
        'user_id' => (int)$user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'phone' => $user['phone'] ?? '',
        'distance' => $distance,
        'bib_number' => $bib_number,
        'start_time' => $start_time,
        'status' => 'registered', // registered, completed, dnf (did not finish)
        'created_at' => date('Y-m-d H:i:s')
    ];
    
    $registrations[] = $newRegistration;
    save_json('registrations.json', $registrations);
    
    return ['success' => true, 'bib_number' => $bib_number];
}

function get_user_registrations($user_id = null)
{
    if (!$user_id) {
        $user = get_logged_in_user();
        if (!$user) return [];
        $user_id = $user['id'];
    }
    
    $registrations = load_json('registrations.json');
    $events = load_json('events.json');
    
    $userRegistrations = [];
    foreach ($registrations as $reg) {
        if ($reg['user_id'] == $user_id) {
            // Find the event details
            foreach ($events as $event) {
                if ($event['id'] == $reg['event_id']) {
                    $reg['title'] = $event['title'];
                    $reg['date'] = $event['date'];
                    $reg['location'] = $event['location'];
                    $reg['event_distance'] = $event['distance'];
                    $reg['category'] = $event['category'] ?? '';
                    $reg['image'] = $event['image'] ?? '';
                    $userRegistrations[] = $reg;
                    break;
                }
            }
        }
    }
    
    // Sort by date
    usort($userRegistrations, function($a, $b) {
        return strcmp($a['date'], $b['date']);
    });
    
    return $userRegistrations;
}

function cancel_user_registration($registration_id)
{
    if (!is_logged_in()) {
        return ['success' => false, 'error' => 'Must be logged in'];
    }
    
    $user = get_logged_in_user();
    $registrations = load_json('registrations.json');
    
    // Find and remove the registration
    $found = false;
    foreach ($registrations as $key => $reg) {
        if ($reg['id'] == $registration_id && $reg['user_id'] == $user['id']) {
            unset($registrations[$key]);
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        return ['success' => false, 'error' => 'Registration not found or not authorized'];
    }
    
    // Re-index array and save
    $registrations = array_values($registrations);
    save_json('registrations.json', $registrations);
    
    return ['success' => true];
}


