<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Simple authentication (in production, use secure hashes)
    if ($username === 'TheBestPhoto' && $password === 'password123') {
        $_SESSION['user'] = [
            'username' => $username,
            'role' => 'photographer'
        ];
        header('Location: upload.php');
        exit;
    } else {
        $error = 'Incorrect credentials';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PhotoShare</title>
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
                    <a href="upload.php" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Upload</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Login Form -->
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="glass max-w-md w-full space-y-8 p-8 rounded-lg">
            <div>
                                 <h2 class="mt-6 text-center text-3xl font-bold text-white">
                     Login to PhotoShare
                 </h2>
                <p class="mt-2 text-center text-sm text-gray-400">
                    Access your personal space to share your photos
                </p>
            </div>
            
            <?php if ($error): ?>
                <div class="bg-red-500 bg-opacity-20 border border-red-500 text-red-200 px-4 py-3 rounded">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form class="mt-8 space-y-6" method="POST">
                <div class="space-y-4">
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-300">
                            Username
                        </label>
                        <input id="username" name="username" type="text" required 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white placeholder-gray-400 rounded-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm"
                               placeholder="Enter your username">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300">
                            Password
                        </label>
                        <input id="password" name="password" type="password" required 
                               class="mt-1 appearance-none relative block w-full px-3 py-2 border border-gray-600 bg-gray-700 text-white placeholder-gray-400 rounded-md focus:outline-none focus:ring-primary focus:border-primary focus:z-10 sm:text-sm"
                               placeholder="Enter your password">
                    </div>
                </div>

                <div>
                    <button type="submit" 
                                                         class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-bold rounded-md text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        Login
                    </button>
                </div>
            </form>
            
            <div class="text-center">
                <p class="text-sm text-gray-400">
                    Test account: <code class="bg-gray-700 px-2 py-1 rounded">TheBestPhoto:password123</code>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
