# gui/duplicate_finder_tab.py

from PyQt5.QtCore import QThread, pyqtSignal
from PyQt5.QtWidgets import (
    QWidget, QVBoxLayout, QLabel, QPushButton, QHBoxLayout, QTextEdit,
    QMessageBox, QProgressBar
)
from threads.duplicate_finder_thread import DuplicateFinderThread
from utils.file_utils import delete_files_permanently, send_duplicates_to_trash
from utils.report_utils import generate_report  # Corrected Import
import logging
from utils.email_utils import send_email
from plyer import notification

class DuplicateFinderTab(QWidget):
    def __init__(self):
        super().__init__()
        self.layout = QVBoxLayout()

        lbl = QLabel("Find and Handle Duplicate Files")
        lbl.setStyleSheet("font-size: 18px; font-weight: bold;")
        self.layout.addWidget(lbl)

        # Select Directory Button and Label
        dir_layout = QHBoxLayout()
        self.select_dir_btn = QPushButton("📂 Select Directory")
        self.select_dir_btn.setToolTip("Choose the directory to scan for duplicate files.")
        self.select_dir_btn.clicked.connect(self.select_directory)
        dir_layout.addWidget(self.select_dir_btn)

        self.directory_label = QLabel("No directory selected.")
        self.directory_label.setStyleSheet("color: #555555;")
        dir_layout.addWidget(self.directory_label)

        self.layout.addLayout(dir_layout)

        # Find Duplicates Button
        self.find_btn = QPushButton("🔍 Find Duplicates")
        self.find_btn.setToolTip("Start scanning the selected directory for duplicate files.")
        self.find_btn.clicked.connect(self.find_duplicates)
        self.find_btn.setEnabled(False)
        self.layout.addWidget(self.find_btn)

        # Progress Bar
        self.progress = QProgressBar()
        self.layout.addWidget(self.progress)

        # Results Display
        self.results = QTextEdit()
        self.results.setReadOnly(True)
        self.results.setPlaceholderText("Duplicate files will be listed here.")
        self.layout.addWidget(self.results)

        # Handle Duplicates Buttons
        handle_layout = QHBoxLayout()
        self.delete_btn = QPushButton("🗑️ Permanently Delete Duplicates")
        self.delete_btn.setToolTip("Delete all duplicate files permanently.")
        self.delete_btn.clicked.connect(self.delete_duplicates)
        self.delete_btn.setEnabled(False)
        handle_layout.addWidget(self.delete_btn)

        self.trash_btn = QPushButton("🗄️ Move Duplicates to Trash")
        self.trash_btn.setToolTip("Move all duplicate files to the system trash.")
        self.trash_btn.clicked.connect(self.trash_duplicates)
        self.trash_btn.setEnabled(False)
        handle_layout.addWidget(self.trash_btn)

        self.layout.addLayout(handle_layout)

        self.setLayout(self.layout)
        self.current_duplicates = {}

    def select_directory(self):
        from PyQt5.QtWidgets import QFileDialog
        directory = QFileDialog.getExistingDirectory(self, "Select Directory")
        if directory:
            self.directory_label.setText(directory)
            self.find_btn.setEnabled(True)
            self.selected_directory = directory

    def find_duplicates(self):
        self.results.clear()
        self.find_btn.setEnabled(False)
        self.delete_btn.setEnabled(False)
        self.trash_btn.setEnabled(False)
        self.progress.setValue(0)
        self.thread = DuplicateFinderThread(self.selected_directory)
        self.thread.finished.connect(self.display_duplicates)
        self.thread.start()

    def display_duplicates(self, duplicates):
        if not duplicates:
            self.results.setText("No duplicates found.")
            self.delete_btn.setEnabled(False)
            self.trash_btn.setEnabled(False)
            self.progress.setValue(100)
            return
        report = f"Found {len(duplicates)} sets of duplicates:\n\n"
        for idx, (hash_val, paths) in enumerate(duplicates.items(), 1):
            report += f"Set {idx} - Hash: {hash_val}\n"
            for path in paths:
                report += f"    {path}\n"
            report += "\n"
        self.results.setText(report)
        self.current_duplicates = duplicates
        self.delete_btn.setEnabled(True)
        self.trash_btn.setEnabled(True)
        self.progress.setValue(100)
        generate_report(duplicates)  # Corrected Function Call
        send_email("Duplicate Report Generated", f"Duplicate search completed. Report saved.")
        notification.notify(
            title="Duplicate Search Completed",
            message="Duplicate search completed and report generated.",
            timeout=5
        )

    def delete_duplicates(self):
        confirm = QMessageBox.question(self, "Confirm Deletion",
                                       "Are you sure you want to permanently delete the duplicates?\nThis action cannot be undone.",
                                       QMessageBox.Yes | QMessageBox.No, QMessageBox.No)
        if confirm == QMessageBox.Yes:
            delete_files_permanently(self.current_duplicates)
            self.results.append("\nDuplicates have been permanently deleted.")
            self.delete_btn.setEnabled(False)
            self.trash_btn.setEnabled(False)

    def trash_duplicates(self):
        confirm = QMessageBox.question(self, "Confirm Trash",
                                       "Are you sure you want to move the duplicates to trash?",
                                       QMessageBox.Yes | QMessageBox.No, QMessageBox.No)
        if confirm == QMessageBox.Yes:
            send_duplicates_to_trash(self.current_duplicates)
            self.results.append("\nDuplicates have been moved to trash.")
            self.delete_btn.setEnabled(False)
            self.trash_btn.setEnabled(False)
