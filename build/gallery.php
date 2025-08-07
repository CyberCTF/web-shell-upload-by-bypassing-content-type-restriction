<?php
session_start();

// Read photos from JSON file
$photosFile = 'photos_data.json';
$photos = [];

if (file_exists($photosFile)) {
    $photos = json_decode(file_get_contents($photosFile), true) ?: [];
}

// Default photo data if no photos are uploaded
$defaultPhotos = [
    [
        'id' => 1,
        'title' => 'Sunset in Paris',
        'author' => 'photographer1',
        'likes' => 42,
        'comments' => 8,
        'image' => 'sunset.jpg',
        'description' => 'Beautiful sunset from the Eiffel Tower',
        'category' => 'Landscape'
    ],
    [
        'id' => 2,
        'title' => 'Street Art in Berlin',
        'author' => 'artist2',
        'likes' => 67,
        'comments' => 12,
        'image' => 'streetart.jpg',
        'description' => 'Colorful urban art in the streets of Berlin',
        'category' => 'Art'
    ],
    [
        'id' => 3,
        'title' => 'Wild Nature',
        'author' => 'nature_lover',
        'likes' => 89,
        'comments' => 15,
        'image' => 'nature.jpg',
        'description' => 'Mysterious forest at dawn',
        'category' => 'Nature'
    ],
    [
        'id' => 4,
        'title' => 'Modern Architecture',
        'author' => 'architect',
        'likes' => 34,
        'comments' => 6,
        'image' => 'architecture.jpg',
        'description' => 'Contemporary design in the city center',
        'category' => 'Architecture'
    ],
    [
        'id' => 5,
        'title' => 'Urban Portrait',
        'author' => 'portrait_master',
        'likes' => 156,
        'comments' => 23,
        'image' => 'portrait.jpg',
        'description' => 'Black and white portrait in the street',
        'category' => 'Portrait'
    ],
    [
        'id' => 6,
        'title' => 'Creative Cuisine',
        'author' => 'food_artist',
        'likes' => 78,
        'comments' => 9,
        'image' => 'food.jpg',
        'description' => 'Gourmet dish prepared with love',
        'category' => 'Cuisine'
    ],
    [
        'id' => 7,
        'title' => 'Travel in Asia',
        'author' => 'traveler',
        'likes' => 234,
        'comments' => 31,
        'image' => 'asia.jpg',
        'description' => 'Traditional temple in Japan',
        'category' => 'Travel'
    ],
    [
        'id' => 8,
        'title' => 'Urban Fashion',
        'author' => 'fashion_photographer',
        'likes' => 98,
        'comments' => 14,
        'image' => 'fashion.jpg',
        'description' => 'Fashion shoot in the streets of Milan',
        'category' => 'Fashion'
    ]
];

// Combine uploaded photos with default photos
$allPhotos = array_merge($photos, $defaultPhotos);

$categories = ['All', 'Landscape', 'Art', 'Nature', 'Architecture', 'Portrait', 'Cuisine', 'Travel', 'Fashion'];
$selectedCategory = $_GET['category'] ?? 'All';
$filteredPhotos = $selectedCategory === 'All' ? $allPhotos : array_filter($allPhotos, function($photo) use ($selectedCategory) {
    return $photo['category'] === $selectedCategory;
});
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - PhotoShare</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: '#8b5cf6',
                        secondary: '#7c3aed'
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-purple-900 to-gray-900 min-h-screen text-white">
    <!-- Navigation -->
    <nav class="glass border-b border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="index.php" class="text-2xl font-bold text-primary">📸 PhotoShare</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="index.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="gallery.php" class="text-primary px-3 py-2 rounded-md text-sm font-medium">Gallery</a>
                                         <a href="upload.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Upload</a>
                     <?php if (isset($_SESSION['user'])): ?>
                         <a href="logout.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Logout</a>
                     <?php else: ?>
                         <a href="login.php" class="bg-primary hover:bg-secondary text-white px-4 py-2 rounded-md text-sm font-medium">Login</a>
                     <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Gallery Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-4 font-bold">PhotoShare Gallery</h1>
            <p class="text-gray-300 mb-6">Discover all photos shared by our community</p>
            
            <?php if (isset($_GET['success'])): ?>
                <div class="bg-green-500 bg-opacity-20 border border-green-500 text-green-200 px-4 py-3 rounded mb-6">
                    ✅ Photo uploaded successfully! It is now visible in the gallery.
                </div>
            <?php endif; ?>
            
            <!-- Filters -->
            <div class="flex flex-wrap gap-2 mb-8">
                <?php foreach ($categories as $category): ?>
                    <a href="?category=<?php echo urlencode($category); ?>" 
                       class="px-4 py-2 rounded-md text-sm font-medium <?php echo $selectedCategory === $category ? 'bg-primary text-white' : 'bg-gray-700 text-gray-300 hover:bg-gray-600'; ?>">
                        <?php echo htmlspecialchars($category); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Photo grid -->
        <div class="photo-grid">
            <?php foreach ($filteredPhotos as $photo): ?>
            <div class="glass rounded-lg overflow-hidden hover:shadow-lg transition duration-300">
                <?php if (isset($photo['image']) && file_exists('uploads/' . $photo['image'])): ?>
                    <!-- Display the real uploaded image -->
                    <div class="w-full h-64 bg-cover bg-center" style="background-image: url('uploads/<?php echo htmlspecialchars($photo['image']); ?>');">
                    </div>
                <?php else: ?>
                    <!-- Default image -->
                    <div class="w-full h-64 bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center">
                        <span class="text-6xl">📷</span>
                    </div>
                <?php endif; ?>
                <div class="p-6">
                    <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($photo['title']); ?></h3>
                    <p class="text-gray-300 mb-4"><?php echo htmlspecialchars($photo['description']); ?></p>
                    <div class="flex justify-between items-center text-sm text-gray-400">
                        <span>By @<?php echo htmlspecialchars($photo['author']); ?></span>
                        <div class="flex items-center space-x-4">
                            <span>❤️ <?php echo $photo['likes']; ?></span>
                            <span>💬 <?php echo $photo['comments']; ?></span>
                        </div>
                    </div>
                    <div class="mt-3">
                        <span class="inline-block bg-purple-600 text-white text-xs px-2 py-1 rounded">
                            <?php echo htmlspecialchars($photo['category']); ?>
                        </span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
