# gui/batch_rename_tab.py
from PyQt5.QtWidgets import (
    QWidget, QVBoxLayout, QLabel, QPushButton, QHBoxLayout, QFileDialog,
    QMessageBox, QLineEdit, QSpinBox, QFormLayout
)
from threads.batch_rename_thread import BatchRenameThread
from utils.email_utils import send_email
from plyer import notification
import logging

class BatchRenameTab(QWidget):
    def __init__(self):
        super().__init__()
        self.layout = QVBoxLayout()

        lbl = QLabel("Batch Rename Files")
        lbl.setStyleSheet("font-size: 18px; font-weight: bold;")
        self.layout.addWidget(lbl)

        form_layout = QFormLayout()

        # Select Directory
        self.select_dir_btn = QPushButton("📂 Select Directory")
        self.select_dir_btn.setToolTip("Choose the directory containing files to rename.")
        self.select_dir_btn.clicked.connect(self.select_directory)
        form_layout.addRow("Directory:", self.select_dir_btn)

        self.directory_label = QLabel("No directory selected.")
        self.directory_label.setStyleSheet("color: #555555;")
        form_layout.addRow("", self.directory_label)

        # Renaming Pattern
        self.pattern_input = QLineEdit()
        self.pattern_input.setPlaceholderText("e.g., File_{index}{extension}")
        self.pattern_input.setToolTip("Use placeholders like {index}, {original_name}, and {extension} to define the renaming pattern.")
        form_layout.addRow("Renaming Pattern:", self.pattern_input)

        # Starting Index
        self.start_index = QSpinBox()
        self.start_index.setRange(1, 1000000)
        self.start_index.setValue(1)
        self.start_index.setToolTip("Define the starting number for indexing.")
        form_layout.addRow("Starting Index:", self.start_index)

        self.layout.addLayout(form_layout)

        # Rename Button
        self.rename_btn = QPushButton("🔧 Rename Files")
        self.rename_btn.setToolTip("Start renaming the selected files based on the defined pattern.")
        self.rename_btn.clicked.connect(self.rename_files)
        self.rename_btn.setEnabled(False)
        self.layout.addWidget(self.rename_btn)

        self.setLayout(self.layout)
        self.selected_directory = None

    def select_directory(self):
        directory = QFileDialog.getExistingDirectory(self, "Select Directory for Renaming")
        if directory:
            self.directory_label.setText(directory)
            self.selected_directory = directory
            if self.pattern_input.text():
                self.rename_btn.setEnabled(True)

    def rename_files(self):
        pattern = self.pattern_input.text()
        if not pattern:
            QMessageBox.warning(self, "Input Error", "Renaming pattern cannot be empty.")
            return
        if not self.selected_directory:
            QMessageBox.warning(self, "Input Error", "Please select a directory.")
            return
        start_index = self.start_index.value()
        self.rename_btn.setEnabled(False)
        self.thread = BatchRenameThread(self.selected_directory, pattern, start_index)
        self.thread.finished.connect(self.rename_completed)
        self.thread.start()

    def rename_completed(self):
        self.rename_btn.setEnabled(True)
        QMessageBox.information(self, "Renaming Completed", "All selected files have been renamed.")
        send_email("Batch Renaming Completed", "All selected files have been renamed.")
        notification.notify(
            title="Batch Renaming Completed",
            message="All selected files have been renamed.",
            timeout=5
        )
