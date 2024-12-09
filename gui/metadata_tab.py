# gui/metadata_tab.py
from PyQt5.QtWidgets import (
    QWidget, QVBoxLayout, QLabel, QPushButton, QHBoxLayout, QFileDialog,
    QMessageBox, QFormLayout, QTextEdit, QComboBox
)
from threads.metadata_thread import MetadataThread
from utils.email_utils import send_email
from plyer import notification
import logging

class MetadataTab(QWidget):
    def __init__(self):
        super().__init__()
        self.layout = QVBoxLayout()

        lbl = QLabel("Handle Image Metadata")
        lbl.setStyleSheet("font-size: 18px; font-weight: bold;")
        self.layout.addWidget(lbl)

        form_layout = QFormLayout()

        # Action Selection
        self.action_combo = QComboBox()
        self.action_combo.addItems(["Display Metadata", "Remove Metadata"])
        self.action_combo.setToolTip("Choose whether to display or remove metadata from an image.")
        form_layout.addRow("Action:", self.action_combo)

        # Select Image
        self.select_image_btn = QPushButton("📂 Select Image")
        self.select_image_btn.setToolTip("Choose the image file to work with.")
        self.select_image_btn.clicked.connect(self.select_image)
        form_layout.addRow("Image:", self.select_image_btn)

        self.image_label = QLabel("No image selected.")
        self.image_label.setStyleSheet("color: #555555;")
        form_layout.addRow("", self.image_label)

        # Select Output Path (For Removal)
        self.select_output_btn = QPushButton("📁 Select Output Path (For Removal)")
        self.select_output_btn.setToolTip("Choose where the cleaned image will be saved.")
        self.select_output_btn.clicked.connect(self.select_output_path)
        form_layout.addRow("Output Path:", self.select_output_btn)

        self.output_label = QLabel("No output path selected.")
        self.output_label.setStyleSheet("color: #555555;")
        form_layout.addRow("", self.output_label)

        self.layout.addLayout(form_layout)

        # Action Selection Changed
        self.action_combo.currentTextChanged.connect(self.action_changed)

        # Start Button
        self.start_btn = QPushButton("🔧 Start")
        self.start_btn.setToolTip("Start displaying or removing metadata.")
        self.start_btn.clicked.connect(self.start_process)
        self.start_btn.setEnabled(False)
        self.layout.addWidget(self.start_btn)

        # Result Display
        self.result_display = QTextEdit()
        self.result_display.setReadOnly(True)
        self.result_display.setPlaceholderText("Metadata will be displayed here.")
        self.layout.addWidget(self.result_display)

        self.setLayout(self.layout)
        self.selected_image = None
        self.output_path = None

    def select_image(self):
        file, _ = QFileDialog.getOpenFileName(self, "Select Image", filter="Images (*.png *.jpg *.jpeg *.bmp *.tiff)")
        if file:
            self.image_label.setText(file)
            self.selected_image = file
            self.check_ready()

    def select_output_path(self):
        file, _ = QFileDialog.getSaveFileName(self, "Select Output Path for Metadata Removal", filter="Images (*.png *.jpg *.jpeg *.bmp *.tiff)")
        if file:
            self.output_label.setText(file)
            self.output_path = file
            self.check_ready()

    def check_ready(self):
        action = self.action_combo.currentText()
        if action == "Display Metadata":
            if self.selected_image:
                self.start_btn.setEnabled(True)
        elif action == "Remove Metadata":
            if self.selected_image and self.output_path:
                self.start_btn.setEnabled(True)

    def action_changed(self, text):
        if text == "Display Metadata":
            self.select_output_btn.setEnabled(False)
            self.output_label.setText("Not required.")
            self.output_path = None
            self.check_ready()
        elif text == "Remove Metadata":
            self.select_output_btn.setEnabled(True)
            self.check_ready()

    def start_process(self):
        action = self.action_combo.currentText().split()[0].lower()
        image_path = self.selected_image
        output_path = self.output_path if action == "remove" else None
        if not image_path:
            QMessageBox.warning(self, "Input Error", "Please select an image file.")
            return
        if action == "remove" and not output_path:
            QMessageBox.warning(self, "Input Error", "Please select an output path for the cleaned image.")
            return
        self.start_btn.setEnabled(False)
        self.result_display.clear()
        self.thread = MetadataThread(action, image_path, output_path)
        self.thread.finished.connect(self.process_completed)
        self.thread.start()

    def process_completed(self, message):
        self.start_btn.setEnabled(True)
        if self.action_combo.currentText() == "Display Metadata":
            self.result_display.setText(message)
        else:
            self.result_display.setText(message)
        send_email(f"{message}", f"The image metadata has been {message.lower()}.")
        notification.notify(
            title=message,
            message=f"The image metadata has been {message.lower()}.",
            timeout=5
        )
