
# 🗂️ File Manager Pro

![File Manager Pro Logo](assets/logo.png)

**File Manager Pro** is a powerful and user-friendly desktop application designed to help you efficiently manage, organize, and optimize your files and system performance. Built with Python and PyQt5, this tool offers a comprehensive suite of functionalities to handle duplicate files, sort files by type or date, manage images, encrypt/decrypt sensitive data, clean cache and temporary files, generate detailed reports, and monitor system activities.

---

## 🚀 Features

- **🔍 Duplicate Finder:** Identify and handle duplicate files to free up storage space.
- **📁 File Sorter:** Organize files by type or creation date into designated folders.
- **🖼️ Image Tools:** View and manage image metadata, and remove sensitive information.
- **🔒 Encryption:** Encrypt and decrypt files to protect sensitive data.
- **📝 Batch Rename:** Rename multiple files efficiently using customizable patterns.
- **📊 Reports:** Generate detailed reports on file distributions and system logs.
- **🧹 Cache Cleaner:** Remove cache and temporary files to enhance system performance.
- **📈 System Monitor:** Monitor real-time system activities and resource usage.
- **⚙️ Settings:** Customize application preferences and configurations.

---

## 📋 Table of Contents

- [🚀 Features](#-features)
- [💻 Installation](#-installation)
  - [🔧 Prerequisites](#-prerequisites)
  - [🛠️ Setup](#️-setup)
- [🎮 Usage](#🎮-usage)
  - [🚀 Launching the Application](#🚀-launching-the-application)
  - [⚙️ Configuration](#⚙️-configuration)
- [📂 Project Structure](#📂-project-structure)
- [🤝 Contributing](#🤝-contributing)
- [📄 License](#📄-license)
- [👤 About the Author](#👤-about-the-author)
- [🙏 Acknowledgements](#🙏-acknowledgements)

---

## 💻 Installation

### 🔧 Prerequisites

- **Operating System:** Windows, macOS, or Linux
- **Python:** Version 3.6 or higher
- **Git:** (Optional) For cloning the repository

### 🛠️ Setup

1. **Clone the Repository:**

   ```bash
   git clone https://github.com/Srihaas007/file-manager-pro.git
   ```

   Alternatively, you can download the repository as a ZIP file and extract it.

2. **Navigate to the Project Directory:**

   ```bash
   cd file-manager-pro
   ```

3. **Create a Virtual Environment (Recommended):**

   ```bash
   python -m venv venv
   ```

4. **Activate the Virtual Environment:**

   - **Windows:**

     ```bash
     venv\Scripts\activate
     ```

   - **macOS/Linux:**

     ```bash
     source venv/bin/activate
     ```

5. **Install Dependencies:**

   Ensure you have `pip` installed. Then, install the required packages:

   ```bash
   pip install -r requirements.txt
   ```

   **Dependencies:**

   - PyQt5
   - send2trash
   - Pillow
   - tqdm
   - cryptography
   - watchdog
   - plyer

6. **Configure the Application:**

   - **Populate `config.json`:**

     Ensure that the `config.json` file is populated with the necessary configurations. If it's empty, refer to the [⚙️ Configuration](#⚙️-configuration) section below.

   - **Generate Encryption Key:**

     If encryption functionalities are to be used, generate an encryption key:

     ```bash
     python utils/encryption_utils.py generate_key
     ```

     This will create a `secret.key` file in the project directory.

---

## 🎮 Usage

### 🚀 Launching the Application

After completing the installation and configuration steps, launch the application using the following command:

```bash
python main.py
```

This will open the **File Manager Pro** GUI, where you can navigate through different tabs to access various functionalities.

### ⚙️ Configuration

The `config.json` file is central to configuring the application's behavior. Here's a sample configuration:

```json
{
    "file_categories": {
        "Images": [".jpg", ".jpeg", ".png", ".gif", ".bmp", ".tiff"],
        "Videos": [".mp4", ".avi", ".mkv", ".mov", ".wmv"],
        "Documents": [".doc", ".docx", ".pdf", ".txt", ".xls", ".xlsx", ".ppt", ".pptx"],
        "Audio": [".mp3", ".wav", ".aac", ".flac"],
        "Archives": [".zip", ".rar", ".7z", ".tar", ".gz"],
        "Others": []
    },
    "backup_directory": "Backup",
    "encryption_key_file": "secret.key",
    "email_notifications": {
        "enabled": false,
        "smtp_server": "",
        "smtp_port": 587,
        "sender_email": "",
        "sender_password": "",
        "receiver_email": ""
    }
}
```

**Configuration Options:**

- **`file_categories`:** Define file extensions for categorizing files.
- **`backup_directory`:** Specify the directory where backups will be stored.
- **`encryption_key_file`:** Path to the encryption key file.
- **`email_notifications`:** Configure email settings for notifications.

**Note:** Ensure that `config.json` contains valid JSON data. If it's empty, the application will attempt to recreate it with default settings upon launch.

---

## 📂 Project Structure

```
file-manager-pro/
├── main.py
├── config.py
├── logging_setup.py
├── requirements.txt
├── config.json
├── utils/
│   ├── __init__.py
│   ├── email_utils.py
│   ├── encryption_utils.py
│   ├── file_utils.py
│   ├── image_utils.py
│   ├── report_utils.py
│   └── ... (other utility modules)
├── threads/
│   ├── __init__.py
│   ├── duplicate_finder_thread.py
│   ├── file_sorter_thread.py
│   ├── image_tools_thread.py
│   ├── encryption_thread.py
│   ├── metadata_thread.py
│   ├── batch_rename_thread.py
│   ├── report_thread.py
│   ├── monitor_thread.py
│   └── cache_cleaner_thread.py
├── gui/
│   ├── __init__.py
│   ├── duplicate_finder_tab.py
│   ├── file_sorter_tab.py
│   ├── image_tools_tab.py
│   ├── encryption_tab.py
│   ├── metadata_tab.py
│   ├── batch_rename_tab.py
│   ├── reports_tab.py
│   ├── monitor_tab.py
│   ├── cache_cleaner_tab.py
│   └── settings_tab.py
├── assets/
│   ├── logo.png
│   ├── duplicate_finder.png
│   ├── file_sorter.png
│   ├── image_tools.png
│   └── ... (other assets)
└── README.md
```

---

## 🤝 Contributing

Contributions are welcome! To contribute to **File Manager Pro**, please follow these steps:

1. **Fork the Repository:**

   Click the "Fork" button at the top right of the repository page to create a personal copy.

2. **Clone Your Fork:**

   ```bash
   git clone https://github.com/Srihaas007/file-manager-pro.git
   cd file-manager-pro
   ```

3. **Create a New Branch:**

   ```bash
   git checkout -b feature/YourFeatureName
   ```

4. **Make Your Changes:**

   Implement your feature or bug fix. Ensure that your code adheres to the project's coding standards.

5. **Commit Your Changes:**

   ```bash
   git add .
   git commit -m "Add feature: YourFeatureName"
   ```

6. **Push to Your Fork:**

   ```bash
   git push origin feature/YourFeatureName
   ```

7. **Create a Pull Request:**

   Navigate to the original repository and create a pull request from your forked repository.

**Please ensure that your contributions follow the project's [Code of Conduct](CODE_OF_CONDUCT.md) and [Contribution Guidelines](CONTRIBUTING.md).**

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

---

## 👤 About the Author

### Srihaas Gorantla

📍 **Address:** 21 Swinford Road, B29 5SH, Birmingham  
🌐 **Portfolio:** [https://srihaas007.github.io/](https://srihaas007.github.io/)  
📞 **Phone:** +44 7788760133  
🔗 **LinkedIn:** [linkedin.com/in/srihaas](https://linkedin.com/in/srihaas)  
🐱 **GitHub:** [https://github.com/Srihaas007](https://github.com/Srihaas007)  

Feel free to reach out for collaborations, feedback, or any inquiries related to the project!

---

## 🙏 Acknowledgements

- **PyQt5:** For providing a robust framework for building cross-platform GUI applications.
- **Pillow:** For image processing capabilities.
- **Send2Trash:** For safely sending files to the trash/recycle bin.
- **Cryptography:** For encryption and decryption functionalities.
- **Plyer:** For providing cross-platform access to features like notifications.
- **All Open-Source Contributors:** Thank you for your invaluable contributions to the open-source community!

---


---

## ✨ Enhancements and Best Practices

To make your `README.md` even more engaging and informative, consider the following enhancements:

### 1. **Badges**

Add badges at the top of your README to showcase important information like build status, license, and GitHub stars. Here's how you can add some:


# 🗂️ File Manager Pro

![Build Status](https://img.shields.io/github/workflow/status/Srihaas007/file-manager-pro/CI)
![License](https://img.shields.io/github/license/Srihaas007/file-manager-pro)
![GitHub stars](https://img.shields.io/github/stars/Srihaas007/file-manager-pro?style=social)


**Example:**


# 🗂️ File Manager Pro

![Build Status](https://img.shields.io/github/workflow/status/Srihaas007/file-manager-pro/CI)
![License](https://img.shields.io/github/license/Srihaas007/file-manager-pro)
![GitHub stars](https://img.shields.io/github/stars/Srihaas007/file-manager-pro?style=social)

![File Manager Pro Logo](assets/logo.png)


**Note:** Replace the badge URLs with the actual endpoints relevant to your repository.

### 2. **Screenshots and GIFs**

Visual aids can significantly enhance the appeal of your README. Include screenshots or GIFs showcasing different features of your application.


## 📸 Screenshots

### Main Interface

![Main Interface](assets/screenshots/main_interface.png)

### Duplicate Finder

![Duplicate Finder](assets/screenshots/duplicate_finder.png)

### File Sorter

![File Sorter](assets/screenshots/file_sorter.png)


### 3. **Installation via Executable**

If you plan to distribute your application as an executable (e.g., using PyInstaller), include instructions for users who prefer not to install dependencies manually.


### 📦 Creating an Executable

To create a standalone executable for your platform, you can use [PyInstaller](https://www.pyinstaller.org/):

```bash
pip install pyinstaller
pyinstaller --onefile main.py
```

The executable will be generated in the `dist/` directory.


### 4. **Usage Examples**

Provide examples or step-by-step guides on how to use specific features.


### 🔍 Using the Duplicate Finder

1. Navigate to the **Duplicate Finder** tab.
2. Click on the "📂 Select Directory" button to choose the folder you want to scan.
3. Click on the "🔍 Find Duplicates" button.
4. Review the list of duplicate files and choose to delete or move them as desired.


### 5. **Contribution Guidelines and Code of Conduct**

For larger projects, maintaining separate `CONTRIBUTING.md` and `CODE_OF_CONDUCT.md` files is recommended. However, if you prefer to keep everything in the README, ensure that guidelines are clear and concise.


## 🤝 Contributing

Contributions are welcome! Please read our [Contributing Guidelines](CONTRIBUTING.md) and [Code of Conduct](CODE_OF_CONDUCT.md) before submitting pull requests.


### 6. **Contact Information**

While the "About the Author" section includes contact details, you can also add a dedicated "Contact" section.


## 📬 Contact

Feel free to reach out via [LinkedIn](https://linkedin.com/in/srihaas) or [GitHub](https://github.com/Srihaas007) for any questions, suggestions, or collaborations.

### 7. **License Details**

If you have a separate `LICENSE` file, ensure the README links to it correctly. Also, provide a brief overview of what the license entails.


## 📄 License

This project is licensed under the [MIT License](LICENSE). You are free to use, modify, and distribute this software as per the terms of the license.


### 8. **Table Formatting and Enhanced Markdown**

Use tables for better organization, especially in sections like "Features" or "Project Structure."


## 🚀 Features

| Feature            | Description                                                                 |
|--------------------|-----------------------------------------------------------------------------|
| **🔍 Duplicate Finder** | Identify and handle duplicate files to free up storage space.              |
| **📁 File Sorter**       | Organize files by type or creation date into designated folders.           |
| **🖼️ Image Tools**       | View and manage image metadata, and remove sensitive information.          |
| **🔒 Encryption**        | Encrypt and decrypt files to protect sensitive data.                       |
| **📝 Batch Rename**      | Rename multiple files efficiently using customizable patterns.             |
| **📊 Reports**           | Generate detailed reports on file distributions and system logs.          |
| **🧹 Cache Cleaner**     | Remove cache and temporary files to enhance system performance.           |
| **📈 System Monitor**    | Monitor real-time system activities and resource usage.                    |
| **⚙️ Settings**          | Customize application preferences and configurations.                      |

