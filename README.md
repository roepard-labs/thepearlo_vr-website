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

| Category | Technologies |
|----------|-------------|
| **Backend** | ![PHP](https://img.shields.io/badge/PHP_8.4.7-777BB4?style=flat-square&logo=php&logoColor=white) ![MySQL](https://img.shields.io/badge/MySQL_10.6-4479A1?style=flat-square&logo=mysql&logoColor=white) |
| **Frontend** | ![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=flat-square&logo=html5&logoColor=white) ![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=flat-square&logo=css3&logoColor=white) ![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=flat-square&logo=javascript&logoColor=black) |
| **Libraries** | ![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=flat-square&logo=bootstrap&logoColor=white) ![jQuery](https://img.shields.io/badge/jQuery-0769AD?style=flat-square&logo=jquery&logoColor=white) ![FontAwesome](https://img.shields.io/badge/Font_Awesome-528DD7?style=flat-square&logo=font-awesome&logoColor=white) |
| **VR/AR** | ![A-Frame](https://img.shields.io/badge/A--Frame-EF2D5E?style=flat-square&logo=a-frame&logoColor=white) ![AR.js](https://img.shields.io/badge/AR.js-0080FF?style=flat-square&logo=ar&logoColor=white) ![WebXR](https://img.shields.io/badge/WebXR-000000?style=flat-square&logo=webxr&logoColor=white) |
| **Infrastructure** | ![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat-square&logo=docker&logoColor=white) ![Ubuntu](https://img.shields.io/badge/Ubuntu_22.04-E95420?style=flat-square&logo=ubuntu&logoColor=white) ![Nginx](https://img.shields.io/badge/Nginx-009639?style=flat-square&logo=nginx&logoColor=white) |

## 📸 Screenshots

<div align="center">
  <p><i>Screenshots coming soon...</i></p>
</div>

## 🚀 Installation

```bash
# Clone repository
git clone https://github.com/thisfeeling/roepard-homelab.git
cd roepard-homelab

# Copy environment configuration
cp .env.example .env

# Configure your environment variables
nano .env
```

For production deployment with Nginx and HTTPS (required for WebXR):

```bash
# Configure Nginx with SSL
sudo nano /etc/nginx/sites-available/homelab

# Enable the site
sudo ln -s /etc/nginx/sites-available/homelab /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 🔒 HTTPS Enforcement

La API incluye un middleware para forzar HTTPS antes de despachar rutas.

Variables de entorno relevantes:

```
FORCE_HTTPS=true                # Redirección 301 automática a https
HTTPS_EXEMPT_HOSTS=localhost,127.0.0.1  # Hosts sin redirección (desarrollo)
```

Si accedes vía `http://` en un host no exento, recibirás una redirección inmediata a la URL `https://` equivalente.


## 🎮 Usage

1. **Access the platform** at https://your-domain.com or https://localhost
2. **Login or register** a new account
3. **Navigate** to the VR experience from the dashboard
4. **Allow camera permissions** for AR functionality
5. **Explore the virtual environment** using accelerometer or touch controls
6. **Deploy virtual homelab components** by selecting them from the menu

## 📚 Documentation & Demo

| Resource | Link |
|----------|------|
| 🌐 **Live Demo** | [https://homelab.roepard.online](https://homelab.roepard.online) |
| 📖 **Documentation** | [https://homelab.roepard.online/docs](https://homelab.roepard.online/docs) |
| 📊 **API Reference** | [https://homelab.roepard.online/docs/api](https://homelab.roepard.online/docs/#/api) |

For comprehensive documentation of all components and APIs, please refer to our [detailed documentation](https://homelab.roepard.online/docs).

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