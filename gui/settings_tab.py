# gui/settings_tab.py
from PyQt5.QtWidgets import (
    QWidget, QVBoxLayout, QLabel, QPushButton, QHBoxLayout, QLineEdit,
    QCheckBox, QSpinBox, QMessageBox, QFileDialog, QFormLayout
)
from config import config, save_config
from utils.email_utils import send_email
from plyer import notification
import logging

class SettingsTab(QWidget):
    def __init__(self):
        super().__init__()
        self.layout = QVBoxLayout()

        lbl = QLabel("Settings")
        lbl.setStyleSheet("font-size: 18px; font-weight: bold;")
        self.layout.addWidget(lbl)

        form_layout = QFormLayout()

        # Backup Directory
        self.backup_dir_btn = QPushButton("📁 Select Backup Directory")
        self.backup_dir_btn.setToolTip("Choose where backups of deleted or moved files will be stored.")
        self.backup_dir_btn.clicked.connect(self.select_backup_directory)
        form_layout.addRow("Backup Directory:", self.backup_dir_btn)

        self.backup_dir_label = QLabel(config.get("backup_directory", "Backup"))
        self.backup_dir_label.setStyleSheet("color: #555555;")
        form_layout.addRow("", self.backup_dir_label)

        # Email Notifications
        self.email_enabled = QCheckBox("Enable Email Notifications")
        self.email_enabled.setChecked(config.get("email_notifications", {}).get("enabled", False))
        self.email_enabled.setToolTip("Enable or disable email notifications for various operations.")
        form_layout.addRow(self.email_enabled)

        self.smtp_server = QLineEdit(config.get("email_notifications", {}).get("smtp_server", ""))
        self.smtp_server.setToolTip("Enter the SMTP server address (e.g., smtp.gmail.com).")
        form_layout.addRow("SMTP Server:", self.smtp_server)

        self.smtp_port = QSpinBox()
        self.smtp_port.setRange(1, 65535)
        self.smtp_port.setValue(config.get("email_notifications", {}).get("smtp_port", 587))
        self.smtp_port.setToolTip("Enter the SMTP server port (e.g., 587 for TLS).")
        form_layout.addRow("SMTP Port:", self.smtp_port)

        self.sender_email = QLineEdit(config.get("email_notifications", {}).get("sender_email", ""))
        self.sender_email.setToolTip("Enter the sender's email address.")
        form_layout.addRow("Sender Email:", self.sender_email)

        self.sender_password = QLineEdit()
        self.sender_password.setEchoMode(QLineEdit.Password)
        self.sender_password.setToolTip("Enter the sender's email password.")
        form_layout.addRow("Sender Password:", self.sender_password)

        self.receiver_email = QLineEdit(config.get("email_notifications", {}).get("receiver_email", ""))
        self.receiver_email.setToolTip("Enter the receiver's email address.")
        form_layout.addRow("Receiver Email:", self.receiver_email)

        self.layout.addLayout(form_layout)

        # Save Settings Button
        self.save_btn = QPushButton("💾 Save Settings")
        self.save_btn.setToolTip("Save all the configured settings.")
        self.save_btn.clicked.connect(self.save_settings)
        self.layout.addWidget(self.save_btn)

        self.setLayout(self.layout)

    def select_backup_directory(self):
        directory = QFileDialog.getExistingDirectory(self, "Select Backup Directory")
        if directory:
            self.backup_dir_label.setText(directory)
            config['backup_directory'] = directory

    def save_settings(self):
        config['email_notifications']['enabled'] = self.email_enabled.isChecked()
        config['email_notifications']['smtp_server'] = self.smtp_server.text()
        config['email_notifications']['smtp_port'] = self.smtp_port.value()
        config['email_notifications']['sender_email'] = self.sender_email.text()
        config['email_notifications']['sender_password'] = self.sender_password.text()
        config['email_notifications']['receiver_email'] = self.receiver_email.text()
        save_config(config)
        QMessageBox.information(self, "Settings Saved", "Settings have been saved successfully.")
        logging.info("Settings updated and saved.")
        send_email("Settings Updated", "All settings have been updated successfully.")
        notification.notify(
            title="Settings Saved",
            message="All settings have been saved successfully.",
            timeout=5
        )
