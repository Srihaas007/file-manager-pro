# gui/encryption_tab.py

from PyQt5.QtWidgets import (
    QWidget, QVBoxLayout, QLabel, QPushButton, QHBoxLayout, QFileDialog,
    QMessageBox, QFormLayout, QLineEdit, QComboBox  # Added QComboBox
)
from threads.encryption_thread import EncryptionThread
from utils.email_utils import send_email
from plyer import notification
import logging

class EncryptionTab(QWidget):
    def __init__(self):
        super().__init__()
        self.layout = QVBoxLayout()

        lbl = QLabel("Encrypt and Decrypt Files")
        lbl.setStyleSheet("font-size: 18px; font-weight: bold;")
        self.layout.addWidget(lbl)

        form_layout = QFormLayout()

        # Action Selection
        self.action_combo = QComboBox()
        self.action_combo.addItems(["Encrypt", "Decrypt"])
        self.action_combo.setToolTip("Choose whether to encrypt or decrypt a file.")
        form_layout.addRow("Action:", self.action_combo)

        # Select File
        self.select_file_btn = QPushButton("📂 Select File")
        self.select_file_btn.setToolTip("Choose the file to encrypt or decrypt.")
        self.select_file_btn.clicked.connect(self.select_file)
        form_layout.addRow("File:", self.select_file_btn)

        self.file_label = QLabel("No file selected.")
        self.file_label.setStyleSheet("color: #555555;")
        form_layout.addRow("", self.file_label)

        # Select Output Path
        self.select_output_btn = QPushButton("📁 Select Output Path")
        self.select_output_btn.setToolTip("Choose where the encrypted/decrypted file will be saved.")
        self.select_output_btn.clicked.connect(self.select_output_path)
        form_layout.addRow("Output Path:", self.select_output_btn)

        self.output_label = QLabel("No output path selected.")
        self.output_label.setStyleSheet("color: #555555;")
        form_layout.addRow("", self.output_label)

        self.layout.addLayout(form_layout)

        # Start Button
        self.start_btn = QPushButton("🔒 Start")
        self.start_btn.setToolTip("Start the encryption or decryption process.")
        self.start_btn.clicked.connect(self.start_process)
        self.start_btn.setEnabled(False)
        self.layout.addWidget(self.start_btn)

        self.setLayout(self.layout)
        self.selected_file = None
        self.output_path = None

    def select_file(self):
        file, _ = QFileDialog.getOpenFileName(self, "Select File")
        if file:
            self.file_label.setText(file)
            self.selected_file = file
            self.check_ready()

    def select_output_path(self):
        if self.action_combo.currentText() == "Encrypt":
            file, _ = QFileDialog.getSaveFileName(self, "Select Output Path for Encryption")
        else:
            file, _ = QFileDialog.getSaveFileName(self, "Select Output Path for Decryption")
        if file:
            self.output_label.setText(file)
            self.output_path = file
            self.check_ready()

    def check_ready(self):
        if self.selected_file and self.output_path:
            self.start_btn.setEnabled(True)

    def start_process(self):
        action = self.action_combo.currentText().lower()
        if not self.selected_file or not self.output_path:
            QMessageBox.warning(self, "Input Error", "Please select both file and output path.")
            return
        self.start_btn.setEnabled(False)
        self.thread = EncryptionThread(action, self.selected_file, self.output_path)
        self.thread.finished.connect(self.process_completed)
        self.thread.start()

    def process_completed(self, message):
        self.start_btn.setEnabled(True)
        QMessageBox.information(self, "Process Completed", message)
        send_email(f"{message}", f"The file has been {message.lower()}.")
        notification.notify(
            title=message,
            message=f"The file has been {message.lower()}.",
            timeout=5
        )
