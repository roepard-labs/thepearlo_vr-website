<div align="center">
  <img src="https://img.shields.io/badge/Homelab%20Roepard-VR%20Project-brown?style=for-the-badge" alt="Homelab Roepard" />
  <img src="https://img.shields.io/github/license/thisfeeling/roepard-homelab?style=for-the-badge" alt="License" />
  <img src="https://img.shields.io/badge/AR.js-Enabled-green?style=for-the-badge" alt="AR.js" />
  <img src="https://img.shields.io/badge/WebVR-Supported-blue?style=for-the-badge" alt="WebVR" />
</div>

<h1 align="center">🏠 Homelab Roepard – VR Experience</h1>

<p align="center">
  An immersive VR/AR platform for managing virtual homelab services with interactive 3D environments.
</p>

## 📋 Table of Contents

- [Overview](#-overview)
- [Features](#-features)
- [VR/AR Capabilities](#-vrar-capabilities)
- [Tech Stack](#-tech-stack)
- [Screenshots](#-screenshots)
- [Installation](#-installation)
- [Usage](#-usage)
- [Documentation](#-documentation)
- [Contributing](#-contributing)
- [License](#-license)

## 🌟 Overview

Homelab Roepard is a comprehensive VR project that combines user management, statistics tracking, and immersive virtual reality experiences. Built on modern web technologies, it allows users to deploy and manage virtual homelab services in a 3D environment with full AR support.

Developed and tested with **Dokploy** infrastructure for optimal performance and security.

## ✨ Features

### Core System

- 🔐 **User Authentication** - Secure login and registration system
- 👥 **User Management** - Complete admin interface for user control
- 👤 **Individual User Profiles** - Personalized user experience
- 📊 **Statistics & Trends** - Real-time data visualization
- 📝 **Change Logging** - Comprehensive activity tracking

### VR/AR Experience

- 🎮 **Immersive VR Interface** - Meta Quest-inspired experience
- 🔍 **AR.js Integration** - Place virtual objects in real environments
- 🎨 **3D Model Editor** - Built-in WebVR modeling capabilities
- 🌄 **Dynamic Backgrounds** - Multiple environment options including:
  - Sky panorama over monument valley
  - Helipad sky panorama
  - Fantasy sky backgrounds
- 🎵 **Background Music Player** - Support for custom MP3 tracks
- 🎨 **Theme Customization** - Dark, light, and auto theme options with color palettes

## 🥽 VR/AR Capabilities

- **A-Frame Integration** - Official A-frame editor and A-frame-watcher
- **Surface Detection** - Automatic recognition of real-world surfaces
- **Accelerometer Navigation** - Motion-based control system
- **Interactive Pointer** - Color-changing center point for different interactions:
  - Green for three-second wait interactions
  - Red for six-second wait interactions
- **Camera Controls** - Toggle camera on/off for different experiences
- **VRBox Setup** - Optimized for Android mobile hardware and sensors

## 🛠️ Tech Stack

### Frontend (thepearlo_vr-website)

| Category            | Technologies                                                                                                                                                                                                                                                                                                                                                                                                                             |
| ------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| **Core**            | ![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white) ![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white) ![JavaScript ES6+](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black) ![PHP](https://img.shields.io/badge/PHP_8.4-777BB4?style=flat-square&logo=php&logoColor=white)                       |
| **Framework CSS**   | ![Bootstrap 5.3+](https://img.shields.io/badge/Bootstrap_5.3-7952B3?style=flat-square&logo=bootstrap&logoColor=white)                                                                                                                                                                                                                                                                                                                    |
| **HTTP Client**     | ![Axios](https://img.shields.io/badge/Axios-5A29E4?style=flat-square&logo=axios&logoColor=white)                                                                                                                                                                                                                                                                                                                                         |
| **Legacy**          | ![jQuery 3.7+](https://img.shields.io/badge/jQuery_3.7-0769AD?style=flat-square&logo=jquery&logoColor=white) (solo DataTables/Bootstrap)                                                                                                                                                                                                                                                                                                 |
| **VR/AR**           | ![A-Frame 1.7.1](https://img.shields.io/badge/A--Frame_1.7.1-EF2D5E?style=flat-square&logo=a-frame&logoColor=white) ![AR.js](https://img.shields.io/badge/AR.js-0080FF?style=flat-square&logo=ar&logoColor=white) ![Three.js 0.181](https://img.shields.io/badge/Three.js_0.181-000000?style=flat-square&logo=three.js&logoColor=white) ![WebXR](https://img.shields.io/badge/WebXR-000000?style=flat-square&logo=webxr&logoColor=white) |
| **UI Components**   | ![SweetAlert2](https://img.shields.io/badge/SweetAlert2-3085D6?style=flat-square) ![Notyf](https://img.shields.io/badge/Notyf-00C851?style=flat-square) ![DataTables](https://img.shields.io/badge/DataTables-1D365D?style=flat-square) ![Chart.js](https://img.shields.io/badge/Chart.js-FF6384?style=flat-square&logo=chart.js&logoColor=white)                                                                                        |
| **Animations**      | ![AOS](https://img.shields.io/badge/AOS-00D8FF?style=flat-square) ![Animate.css](https://img.shields.io/badge/Animate.css-DBFC3C?style=flat-square) ![Anime.js](https://img.shields.io/badge/Anime.js-FF0080?style=flat-square)                                                                                                                                                                                                          |
| **Package Manager** | ![NPM](https://img.shields.io/badge/NPM-CB3837?style=flat-square&logo=npm&logoColor=white)                                                                                                                                                                                                                                                                                                                                               |

### Backend (thepearlo_vr-backend - Separado)

| Category         | Technologies                                                                                                |
| ---------------- | ----------------------------------------------------------------------------------------------------------- |
| **API**          | ![PHP 8.4](https://img.shields.io/badge/PHP_8.4-777BB4?style=flat-square&logo=php&logoColor=white) REST API |
| **Database**     | ![MySQL 10.6](https://img.shields.io/badge/MySQL_10.6-4479A1?style=flat-square&logo=mysql&logoColor=white)  |
| **Architecture** | MVC Pattern (Models, Controllers, Services)                                                                 |
| **Endpoints**    | `localhost:3000` (dev) / `api.roepard.online` (prod)                                                        |

### Infrastructure

| Category       | Technologies                                                                                                    |
| -------------- | --------------------------------------------------------------------------------------------------------------- |
| **Container**  | ![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat-square&logo=docker&logoColor=white)             |
| **Web Server** | ![Nginx](https://img.shields.io/badge/Nginx-009639?style=flat-square&logo=nginx&logoColor=white)                |
| **OS**         | ![Ubuntu 22.04](https://img.shields.io/badge/Ubuntu_22.04-E95420?style=flat-square&logo=ubuntu&logoColor=white) |
| **Deployment** | ![Dokploy](https://img.shields.io/badge/Dokploy-4A5568?style=flat-square)                                       |

## 📸 Screenshots

<div align="center">
  <p><i>Screenshots coming soon...</i></p>
</div>

## 🚀 Installation

### Frontend Setup (thepearlo_vr-website)

```bash
# Clone repository
git clone https://github.com/roepard-labs/thepearlo_vr-website.git
cd thepearlo_vr-website

# Install NPM dependencies
npm install

# Generate configuration from .env
npm run build:config

# Copy environment configuration
cp .env.example .env

# Configure your environment variables
nano .env
```

**Environment Variables (.env):**

```env
# Backend API URLs
API_URL=http://localhost:3000
BACKEND_URL=http://localhost:3000

# Production
# API_URL=https://api.roepard.online
# BACKEND_URL=https://api.roepard.online
```

### Backend Setup (thepearlo_vr-backend - Separate Repository)

```bash
# Clone backend repository
git clone https://github.com/roepard-labs/thepearlo_vr-backend.git
cd thepearlo_vr-backend

# Configure database
cp .env.example .env
nano .env

# Run on port 3000
php -S localhost:3000
```

### 🔒 Production Deployment with HTTPS (Required for WebXR)

```bash
# Configure Nginx with SSL
sudo nano /etc/nginx/sites-available/homelab

# Enable the site
sudo ln -s /etc/nginx/sites-available/homelab /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

**Important:** WebXR requires HTTPS to function. Development can use `localhost` but production must have a valid SSL certificate.

## 🎮 Usage

### Development Mode

```bash
# Start backend API (port 3000)
cd thepearlo_vr-backend
php -S localhost:3000

# Start frontend (port 9000)
cd thepearlo_vr-website
php -S localhost:9000
```

### Accessing the Application

1. **Access the platform** at https://homelab.roepard.online or http://localhost:9000
2. **Login or register** - Authentication handled by backend API
3. **Navigate** to the VR experience from the dashboard
4. **Allow camera permissions** for AR functionality
5. **Explore the virtual environment** using accelerometer or touch controls
6. **Deploy virtual homelab components** by selecting them from the menu

### API Communication

The frontend communicates with the backend API using **Axios**:

```javascript
// Example API call using router.js
import { apiClient } from "../composables/router.js";

// GET request
const response = await apiClient.get("/user/check_session.php");

// POST request
const loginData = await apiClient.post("/user/auth_user.php", {
  username: "user@example.com",
  password: "password123",
});
```

## � NPM Dependencies Architecture

### Dynamic Module Loading System

The project uses a **dynamic NPM loading system** that allows reusable loading of dependencies:

```
composables/
├── npm-loader.js     # Dynamic path generator for node_modules
├── config.js         # Auto-generated config from .env (API URLs)
└── router.js         # Axios HTTP client for API communication
```

**Key Features:**

- ✅ All dependencies managed via NPM (no manual downloads)
- ✅ Dynamic loading with `npm-loader.js`
- ✅ Reusable across any HTML/PHP view
- ✅ Auto-generated configuration from `.env`
- ✅ Axios for modern HTTP requests
- ✅ jQuery as legacy dependency (DataTables/Bootstrap only)

### CSS Architecture

**3 Core CSS Files** (100% Bootstrap 5 compatible):

```
css/
├── variables.css   # Global CSS variables (colors, spacing, fonts)
├── base.css        # CSS reset and base styles
└── main.css        # Main utilities and custom components
```

**Features:**

- ✅ Reusable across all views
- ✅ Dark/Light theme support
- ✅ Bootstrap 5 integration
- ✅ CSS custom properties

### Component System

**Reusable UI Components:**

```
ui/
├── header.ui.php    # Dynamic header with auth status
├── footer.ui.php    # Footer component
├── navbar.ui.php    # Navigation bar
└── sidebar.ui.php   # Admin sidebar

sections/
└── about.section.php  # Reusable page sections

modals/
├── authModal.php      # Authentication modal
└── confirmModal.php   # Confirmation modal
```

**Layout System:**

```
layout/
└── AppLayout.php      # Base layout (includes header, footer, scripts)

layouts/
├── AdminLayout.php    # Admin layout (role_id = 2)
└── UserLayout.php     # User layout (authenticated users)
```

## �📚 Documentation & Demo

| Resource                  | Link                                                                                 |
| ------------------------- | ------------------------------------------------------------------------------------ |
| 🌐 **Live Demo**          | [https://homelab.roepard.online](https://homelab.roepard.online)                     |
| 📖 **Documentation**      | [https://homelab.roepard.online/docs](https://homelab.roepard.online/docs)           |
| 📊 **API Reference**      | [https://homelab.roepard.online/docs/api](https://homelab.roepard.online/docs/#/api) |
| 🔧 **Backend Repository** | [thepearlo_vr-backend](https://github.com/roepard-labs/thepearlo_vr-backend)         |

For comprehensive documentation of all components and APIs, please refer to our [detailed documentation](https://homelab.roepard.online/docs).

## 📖 Quick Start Guide

### Creating a New View

```php
<?php
// views/my-view.php
require_once __DIR__ . '/../layout/AppLayout.php';

ob_start();
?>
<section class="container py-5">
    <h1>My Custom View</h1>
    <button onclick="loadData()" class="btn btn-primary">Load Data</button>
    <div id="data-container"></div>
</section>

<script>
// Use AppRouter for API calls
async function loadData() {
    try {
        const data = await AppRouter.get('/routes/user/check_session.php');
        document.getElementById('data-container').innerHTML = JSON.stringify(data, null, 2);
    } catch (error) {
        console.error('Error:', error);
    }
}
</script>
<?php
$content = ob_get_clean();

AppLayout::render([
    'title' => 'My Custom View',
    'content' => $content,
    'scripts' => ['../js/custom.js'], // Optional custom scripts
    'styles' => ['../css/custom.css']  // Optional custom styles
]);
?>
```

### Making API Calls

```javascript
// GET request
const session = await AppRouter.get("/routes/user/check_session.php");

// POST login
const login = await AppRouter.post("/routes/user/auth_user.php", {
  username: "user@example.com",
  password: "password",
});

// Upload file
const formData = new FormData();
formData.append("file", fileInput.files[0]);
const upload = await AppRouter.upload("/routes/admin/upload.php", formData);
```

### Loading NPM Dependencies

```html
<!-- In your view -->
<script>
  // Dependencies are auto-loaded via AppLayout
  // Access them directly:

  // SweetAlert2
  Swal.fire("Success!", "Operation completed", "success");

  // Notyf
  const notyf = new Notyf();
  notyf.success("Data saved successfully");

  // Chart.js
  const ctx = document.getElementById("myChart");
  new Chart(ctx, {
    /* config */
  });
</script>
```

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request or open an Issue.

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

Please read our [Contributing Guidelines](CONTRIBUTING.md) for more details.

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

<p align="center">
  Built with ❤️ using <a href="https://aframe.io">A-Frame</a> and <a href="https://ar-js-org.github.io/AR.js-Docs/">AR.js</a>
</p>
