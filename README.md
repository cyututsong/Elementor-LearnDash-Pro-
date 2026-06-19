# ElemLearnPro — LearnDash + Elementor Integration Plugin

**ElemLearnPro** is a custom WordPress plugin that bridges the powerful page-building capabilities of **Elementor** with the robust online course management of **LearnDash LMS** . This integration allows course creators to design visually stunning, conversion-focused course pages without writing a single line of code — giving you full control over the look and feel of your learning content .

---

## 📦 What This Plugin Does

With ElemLearnPro, you can:

- **Replace default LearnDash templates** with custom-designed pages built using Elementor’s drag-and-drop interface 
- **Display custom course pages** specifically for non-enrolled students (conversion-optimized sales pages) 
- **Use Elementor’s design widgets** alongside LearnDash-specific course elements seamlessly 
- **Create a consistent brand experience** across your entire WordPress site without design compromise 

---

## ⚙️ Requirements

Before installing ElemLearnPro, ensure your WordPress environment meets these prerequisites :

| Requirement | Notes |
|-------------|-------|
| **WordPress** | Latest stable version recommended |
| **LearnDash LMS** | Active licensed version |
| **Elementor** | Free version works; Pro recommended for advanced features |
| **Elementor Pro** | Required for Theme Builder features (optional) |

---

## 🚀 Installation

### Method 1: Manual Upload

1. Download the plugin ZIP file from this repository
2. Go to **WordPress Admin → Plugins → Add New → Upload Plugin**
3. Select the ZIP file and click **Install Now**
4. Click **Activate**

### Method 2: Direct Upload

1. Upload the `elemlearnpro` folder to `/wp-content/plugins/` directory via FTP
2. Activate the plugin through the **Plugins** menu in WordPress

---

## 🛠️ How It Works

After activation, ElemLearnPro adds a new menu item under **LearnDash LMS** where you can:

1. **Create Custom Templates** — Design pages using Elementor’s builder
2. **Assign Templates to Courses** — Select your custom template for individual courses
3. **Automatic Display** — The plugin automatically replaces the default LearnDash course template for non-enrolled students 

> **Pro Tip:** This plugin works best with **Astra Theme** and other Elementor-compatible themes .

---

## 📁 Folder Structure

```
elemlearnpro/
├── assets/          # CSS, JS, and image files
├── includes/        # Core PHP classes and functions
├── templates/       # Default template overrides
├── admin/           # Admin panel and settings pages
├── public/          # Frontend-facing code
├── languages/       # Translation files
├── index.php        # Security entry point
├── elemlearnpro.php # Main plugin bootstrap file
└── readme.txt       # WordPress plugin readme
```

---

## 🔧 Configuration

1. Navigate to **LearnDash LMS → ElemLearnPro Settings**
2. Select which course templates you want to override
3. Assign custom templates to individual courses from the course edit screen
4. Use **Elementor** to design your template pages from **Templates → Add New**

---

## 🤝 Contributing

We welcome contributions! Here’s how you can help:

1. Fork this repository
2. Create a new branch (`git checkout -b feature/your-feature`)
3. Commit your changes (`git commit -m "Add your feature"`)
4. Push to your branch (`git push origin feature/your-feature`)
5. Open a Pull Request

Please ensure your code follows WordPress coding standards and includes appropriate documentation.

---

## 📄 License

This plugin is licensed under the **GPLv2 or later** — same as WordPress itself. You are free to copy, modify, and distribute this software under the terms of the GPL license .

---

## 🐛 Reporting Issues

Found a bug? Please [open an issue](https://github.com/YOUR_USERNAME/elemlearnpro/issues) with:

- WordPress version
- LearnDash version
- Elementor version
- PHP version
- Steps to reproduce the problem
- Any error messages from the debug log

---

## 📞 Support & Contact

For questions, suggestions, or support:

- **GitHub Issues:** Use the issue tracker above
- **Email:** [your-email@example.com]
- **Documentation:** [link to docs if available]

---

## 🙏 Acknowledgments

- Built on top of the excellent **LearnDash** and **Elementor** ecosystems
- Inspired by the [Custom Template for LearnDash](https://github.com/brainstormforce/custom-template-learndash) plugin by brainstormforce 

---

## 🗺️ Roadmap

- [ ] Support for Elementor Pro Theme Builder integration
- [ ] Additional course-specific widgets
- [ ] Performance optimizations for large course catalogs
- [ ] Multilingual support (WPML compatibility)

---

*Made for course creators who want beautiful, branded learning experiences without compromise.*
