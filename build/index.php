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
        'description' => 'Beautiful sunset from the Eiffel Tower'
    ],
    [
        'id' => 2,
        'title' => 'Street Art in Berlin',
        'author' => 'artist2',
        'likes' => 67,
        'comments' => 12,
        'image' => 'streetart.jpg',
        'description' => 'Colorful urban art in the streets of Berlin'
    ],
    [
        'id' => 3,
        'title' => 'Wild Nature',
        'author' => 'nature_lover',
        'likes' => 89,
        'comments' => 15,
        'image' => 'nature.jpg',
        'description' => 'Mysterious forest at dawn'
    ],
    [
        'id' => 4,
        'title' => 'Modern Architecture',
        'author' => 'architect',
        'likes' => 34,
        'comments' => 6,
        'image' => 'architecture.jpg',
        'description' => 'Contemporary design in the city center'
    ],
    [
        'id' => 5,
        'title' => 'Urban Portrait',
        'author' => 'portrait_master',
        'likes' => 156,
        'comments' => 23,
        'image' => 'portrait.jpg',
        'description' => 'Black and white portrait in the street'
    ],
    [
        'id' => 6,
        'title' => 'Creative Cuisine',
        'author' => 'food_artist',
        'likes' => 78,
        'comments' => 9,
        'image' => 'food.jpg',
        'description' => 'Gourmet dish prepared with love'
    ]
];

// Combine uploaded photos with default photos
$allPhotos = array_merge($photos, $defaultPhotos);

// Take the first 6 photos for the homepage
$featuredPhotos = array_slice($allPhotos, 0, 6);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoShare - Share your moments</title>
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
    <nav class="glass border-b border-gray-700 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-2xl font-bold text-primary">📸 PhotoShare</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="index.php" class="text-primary px-3 py-2 rounded-md text-sm font-medium">Home</a>
                    <a href="gallery.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Gallery</a>
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

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-bold text-white sm:text-5xl md:text-6xl">
                            <span class="block font-bold">Share your</span>
                            <span class="block text-primary font-bold">moments</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-300 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Discover and share your most beautiful photos with the PhotoShare community. Capture the moment, share the emotion.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="upload.php" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-md text-white bg-primary hover:bg-secondary md:py-4 md:text-lg md:px-10">
                                    📤 Share a photo
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Featured Photos -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 class="text-3xl font-bold text-center mb-8 font-bold">Popular Photos</h2>
        <div class="photo-grid">
            <?php foreach ($featuredPhotos as $photo): ?>
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
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="glass border-t border-gray-700 mt-12">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="text-center text-gray-400">
                <p>&copy; 2024 PhotoShare. Share your moments with the world.</p>
            </div>
        </div>
    </footer>
</body>
</html>
