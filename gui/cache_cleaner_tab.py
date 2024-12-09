# gui/cache_cleaner_tab.py
from PyQt5.QtWidgets import (
    QWidget, QVBoxLayout, QLabel, QPushButton, QHBoxLayout, QListWidget,
    QListWidgetItem, QMessageBox, QProgressBar
)
from PyQt5.QtCore import Qt  # Added import for Qt
from threads.cache_cleaner_thread import CacheCleanerThread
from config import config
from utils.email_utils import send_email
from plyer import notification
import logging
import sys
import os

class CacheCleanerTab(QWidget):
    def __init__(self):
        super().__init__()
        self.layout = QVBoxLayout()

        lbl = QLabel("Cache and Temporary Files Cleaner")
        lbl.setStyleSheet("font-size: 18px; font-weight: bold;")
        self.layout.addWidget(lbl)

        info_lbl = QLabel("Clean cache and temporary files to free up space and enhance system performance.")
        info_lbl.setWordWrap(True)
        self.layout.addWidget(info_lbl)

        # Platform-Specific Cache Directories
        cache_dirs = self.get_cache_directories()
        self.cache_list_widget = QListWidget()
        for dir_path in cache_dirs:
            item = QListWidgetItem(dir_path)
            item.setCheckState(Qt.Unchecked)
            self.cache_list_widget.addItem(item)
        self.cache_list_widget.setToolTip("Select the cache directories you want to clean.")
        self.layout.addWidget(self.cache_list_widget)

        # Select All and Deselect All Buttons
        select_buttons_layout = QHBoxLayout()
        self.select_all_btn = QPushButton("✅ Select All")
        self.select_all_btn.setToolTip("Select all cache directories.")
        self.select_all_btn.clicked.connect(self.select_all_caches)
        select_buttons_layout.addWidget(self.select_all_btn)

        self.deselect_all_btn = QPushButton("❌ Deselect All")
        self.deselect_all_btn.setToolTip("Deselect all cache directories.")
        self.deselect_all_btn.clicked.connect(self.deselect_all_caches)
        select_buttons_layout.addWidget(self.deselect_all_btn)

        self.layout.addLayout(select_buttons_layout)

        # Clean Button
        self.clean_btn = QPushButton("🧹 Clean Selected Directories")
        self.clean_btn.setToolTip("Start cleaning the selected cache directories.")
        self.clean_btn.clicked.connect(self.clean_selected_dirs)
        self.clean_btn.setEnabled(False)
        self.layout.addWidget(self.clean_btn)

        # Progress Bar
        self.progress = QProgressBar()
        self.layout.addWidget(self.progress)

        # Connect selection changes to enable/disable clean button
        self.cache_list_widget.itemChanged.connect(self.update_clean_button)

        self.setLayout(self.layout)

    def get_cache_directories(self):
        dirs = []
        if sys.platform.startswith('win'):
            # Windows Cache Directories
            dirs.extend([
                os.getenv('LOCALAPPDATA', '') + '\\Temp',
                os.getenv('TEMP', ''),
                os.path.join(os.getenv('LOCALAPPDATA', ''), 'Google', 'Chrome', 'User Data', 'Default', 'Cache'),
                os.path.join(os.getenv('LOCALAPPDATA', ''), 'Mozilla', 'Firefox', 'Profiles')
            ])
        elif sys.platform.startswith('darwin'):
            # macOS Cache Directories
            dirs.extend([
                os.path.expanduser('~/Library/Caches'),
                '/private/var/tmp',
                '/private/tmp'
            ])
        else:
            # Linux Cache Directories
            dirs.extend([
                os.path.expanduser('~/.cache'),
                '/tmp',
                '/var/tmp'
            ])
        # Remove any empty paths and ensure directories exist
        dirs = [d for d in dirs if d and os.path.exists(d)]
        return dirs

    def select_all_caches(self):
        for index in range(self.cache_list_widget.count()):
            item = self.cache_list_widget.item(index)
            item.setCheckState(Qt.Checked)

    def deselect_all_caches(self):
        for index in range(self.cache_list_widget.count()):
            item = self.cache_list_widget.item(index)
            item.setCheckState(Qt.Unchecked)

    def update_clean_button(self, item):
        any_checked = any(
            self.cache_list_widget.item(i).checkState() == Qt.Checked
            for i in range(self.cache_list_widget.count())
        )
        self.clean_btn.setEnabled(any_checked)

    def clean_selected_dirs(self):
        selected_dirs = [
            self.cache_list_widget.item(i).text()
            for i in range(self.cache_list_widget.count())
            if self.cache_list_widget.item(i).checkState() == Qt.Checked
        ]
        if not selected_dirs:
            QMessageBox.warning(self, "No Directories Selected", "Please select at least one directory to clean.")
            return
        confirm = QMessageBox.question(self, "Confirm Cleaning",
                                       "Are you sure you want to delete all files in the selected directories?\nThis action cannot be undone.",
                                       QMessageBox.Yes | QMessageBox.No, QMessageBox.No)
        if confirm != QMessageBox.Yes:
            return
        self.clean_btn.setEnabled(False)
        self.progress.setValue(0)
        self.thread = CacheCleanerThread(selected_dirs)
        self.thread.progress.connect(self.progress.setValue)
        self.thread.finished.connect(self.cleaning_completed)
        self.thread.start()

    def cleaning_completed(self):
        self.clean_btn.setEnabled(True)
        self.progress.setValue(100)
        QMessageBox.information(self, "Cleaning Completed", "Selected cache directories have been cleaned.")
        send_email("Cache Cleaning Completed", "Selected cache directories have been cleaned.")
        notification.notify(
            title="Cache Cleaning Completed",
            message="Selected cache directories have been cleaned.",
            timeout=5
        )
