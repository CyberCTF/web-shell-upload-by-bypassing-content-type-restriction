# PhotoShare - Web Shell Upload Lab

## Description

PhotoShare is a modern web application for photo sharing. This application contains a file upload vulnerability that allows bypassing content type restrictions.

## Lab Objective

The main objective of this lab is to **retrieve the content of the `/etc/passwd` file** from the server. This vulnerability allows bypassing content type restrictions during file uploads, which can lead to malicious code execution on the server.

## Features

- Photo sharing with the community
- Photo gallery with category filters
- User profile system
- Photo upload with validation
- Modern interface with glassmorphism design

## Installation

### With Docker (Recommended)

```bash
# Clone the repository
git clone <repository-url>
cd photoshare-lab

# Start the application
cd deploy
docker-compose up -d

# The application will be accessible at http://localhost:3206
```

### Manual Installation

```bash
# Install dependencies
npm install

# Start the application
npm start
```

## Access

- **Main URL**: http://localhost:3206
- **Test account**: `TheBestPhoto:password123`

## Project Structure

```
├── .github/workflows/        # GitHub Actions configuration
├── build/                    # PHP application files
│   ├── index.php
│   ├── login.php
│   ├── profile.php
│   ├── gallery.php
│   ├── upload.php
│   └── logout.php
├── deploy/                   # Docker configuration
│   ├── docker-compose.yml
│   ├── Dockerfile
│   
├── docs/                     # Documentation
│   ├── WRITEUP.md
│   └── done.md
├── test/                     # Test scripts
│   └── test_exploit.py
└── README.md
```

## Bug Reporting

If you encounter any issues, please open an issue on GitHub.

---

*This lab is deliberately vulnerable and designed for educational purposes only.*
