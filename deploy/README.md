# PhotoShare Web Shell Upload Lab

A deliberately vulnerable PHP web application demonstrating file upload bypass techniques and content-type restriction evasion.

## Quick Start

```bash
docker pull cyberctf/photoshare-web-shell:latest
docker run -p 3206:80 cyberctf/photoshare-web-shell:latest
```

Access the application at: `http://localhost:3206`

## Demo Credentials

- Username: `TheBestPhoto`
- Password: `password123`

## Challenge

**Objective**: Retrieve the content of the `/etc/passwd` file from the server.

This lab focuses on exploiting file upload vulnerabilities by bypassing content-type restrictions. The application validates file uploads but contains intentional flaws that allow attackers to upload malicious files disguised as images.

**Your mission**: Find a way to upload a web shell and execute it to read sensitive system files.

## About

This lab demonstrates how improper file upload validation in a PHP application can allow attackers to bypass content-type restrictions and upload malicious web shells to gain server access.

## Features

- Realistic photo sharing portal interface
- File upload with intentional vulnerabilities
- Content-type restriction bypass techniques
- Multiple exploitation vectors
- Modern glassmorphism UI design

## Educational Purpose

This application is designed solely for educational purposes to teach web security concepts and file upload bypass techniques.

## Issues

Report issues at: `https://github.com/CyberCTF/photoshare-web-shell/issues`

---

This is a deliberately vulnerable lab designed solely for educational purposes.
