<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$error = '';

// Create uploads directory if it doesn't exist
if (!is_dir('uploads')) {
    mkdir('uploads', 0755, true);
}

// Create JSON file to store photo information
$photosFile = 'photos_data.json';
if (!file_exists($photosFile)) {
    file_put_contents($photosFile, json_encode([]));
}

// File upload processing
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['photo'])) {
    $file = $_FILES['photo'];
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? '';
    
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = $file['name'];
        $fileType = $file['type'];
        $fileTmpName = $file['tmp_name'];
        
        // VULNERABILITY: Client-sent Content-Type verification
        // This verification can be bypassed by modifying the Content-Type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        if (in_array($fileType, $allowedTypes)) {
            // Generate unique filename
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $newFileName = uniqid() . '.' . $extension;
            $uploadPath = 'uploads/' . $newFileName;
            
            if (move_uploaded_file($fileTmpName, $uploadPath)) {
                // Read existing photos
                $photosData = json_decode(file_get_contents($photosFile), true) ?: [];
                
                // Add new photo
                $newPhoto = [
                    'id' => count($photosData) + 1,
                    'title' => $title,
                    'author' => $_SESSION['user']['username'],
                    'likes' => 0,
                    'comments' => 0,
                    'image' => $newFileName,
                    'description' => $description,
                    'category' => $category,
                    'upload_date' => date('Y-m-d H:i:s')
                ];
                
                $photosData[] = $newPhoto;
                
                // Save data
                file_put_contents($photosFile, json_encode($photosData));
                
                $_SESSION['user']['last_upload'] = $newFileName;
                
                // Redirect to gallery with success message
                header('Location: gallery.php?success=1');
                exit;
            } else {
                $error = 'Error uploading file.';
            }
        } else {
            $error = 'File type not allowed. Only JPEG, PNG and GIF files are accepted.';
        }
    } else {
        $error = 'Error uploading file.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload - PhotoShare</title>
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
                    <a href="gallery.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Gallery</a>
                                         <a href="upload.php" class="text-primary px-3 py-2 rounded-md text-sm font-medium">Upload</a>
                     <a href="logout.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Upload Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="glass rounded-lg p-8">
            <h1 class="text-3xl font-bold mb-8 font-bold">📤 Share a photo</h1>
            
            <?php if ($error): ?>
                <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-200 px-4 py-3 rounded mb-6">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Photo upload -->
                    <div>
                        <h2 class="text-xl font-bold mb-4">📷 Select a photo</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-300 mb-2">
                                    Choose a photo
                                </label>
                                <input type="file" id="photo" name="photo" accept="image/*" required
                                       class="block w-full text-sm text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-primary file:text-white hover:file:bg-secondary">
                            </div>
                            
                            <div class="p-4 bg-gray-800 rounded-lg">
                                <h3 class="text-sm font-medium text-gray-300 mb-2">Accepted file types:</h3>
                                <ul class="text-sm text-gray-400 space-y-1">
                                    <li>• JPEG (.jpg, .jpeg)</li>
                                    <li>• PNG (.png)</li>
                                    <li>• GIF (.gif)</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Photo information -->
                    <div>
                        <h2 class="text-xl font-bold mb-4">📝 Information</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-300">
                                    Photo title
                                </label>
                                <input type="text" id="title" name="title" required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white placeholder-gray-400 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                                       placeholder="Ex: Sunset in Paris">
                            </div>
                            
                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-300">
                                    Description
                                </label>
                                <textarea id="description" name="description" rows="3" required
                                          class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white placeholder-gray-400 rounded-md focus:outline-none focus:ring-primary focus:border-primary"
                                          placeholder="Describe your photo..."></textarea>
                            </div>
                            
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-300">
                                    Category
                                </label>
                                <select id="category" name="category" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white rounded-md focus:outline-none focus:ring-primary focus:border-primary">
                                    <option value="">Select a category</option>
                                    <option value="Landscape">Landscape</option>
                                    <option value="Art">Art</option>
                                    <option value="Nature">Nature</option>
                                    <option value="Architecture">Architecture</option>
                                    <option value="Portrait">Portrait</option>
                                    <option value="Cuisine">Cuisine</option>
                                    <option value="Travel">Travel</option>
                                    <option value="Fashion">Fashion</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-center">
                    <button type="submit" 
                            class="bg-primary hover:bg-secondary text-white px-8 py-3 rounded-md text-lg font-bold">
                        📤 Share the photo
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
