# gui/monitor_tab.py
from PyQt5.QtWidgets import (
    QWidget, QVBoxLayout, QLabel, QPushButton, QHBoxLayout, QFileDialog,
    QMessageBox
)
from threads.monitor_thread import MonitorThread
from utils.email_utils import send_email
from plyer import notification
import logging

class MonitorTab(QWidget):
    def __init__(self):
        super().__init__()
        self.layout = QVBoxLayout()

        lbl = QLabel("Real-Time Directory Monitoring")
        lbl.setStyleSheet("font-size: 18px; font-weight: bold;")
        self.layout.addWidget(lbl)

        # Select Directory Button and Label
        dir_layout = QHBoxLayout()
        self.select_dir_btn = QPushButton("📂 Select Directory to Monitor")
        self.select_dir_btn.setToolTip("Choose the directory to monitor for new files.")
        self.select_dir_btn.clicked.connect(self.select_directory)
        dir_layout.addWidget(self.select_dir_btn)

        self.dir_label = QLabel("No directory selected.")
        self.dir_label.setStyleSheet("color: #555555;")
        dir_layout.addWidget(self.dir_label)

        self.layout.addLayout(dir_layout)

        # Start Monitoring Button
        self.start_btn = QPushButton("🚀 Start Monitoring")
        self.start_btn.setToolTip("Begin real-time monitoring of the selected directory.")
        self.start_btn.clicked.connect(self.start_monitoring)
        self.start_btn.setEnabled(False)
        self.layout.addWidget(self.start_btn)

        self.setLayout(self.layout)
        self.selected_directory = None
        self.monitor_thread = None

    def select_directory(self):
        directory = QFileDialog.getExistingDirectory(self, "Select Directory to Monitor")
        if directory:
            self.dir_label.setText(directory)
            self.selected_directory = directory
            self.start_btn.setEnabled(True)

    def start_monitoring(self):
        if not self.selected_directory:
            QMessageBox.warning(self, "Input Error", "Please select a directory to monitor.")
            return
        self.start_btn.setEnabled(False)
        self.thread = MonitorThread(self.selected_directory)
        self.thread.finished.connect(self.monitoring_stopped)
        self.thread.start()
        QMessageBox.information(self, "Monitoring Started", f"Real-time monitoring started on {self.selected_directory}. Press Ctrl+C to stop.")
        notification.notify(
            title="Monitoring Started",
            message=f"Real-time monitoring started on {self.selected_directory}.",
            timeout=5
        )

    def monitoring_stopped(self):
        self.start_btn.setEnabled(True)
        QMessageBox.information(self, "Monitoring Stopped", "Real-time monitoring has been stopped.")
        notification.notify(
            title="Monitoring Stopped",
            message="Real-time monitoring has been stopped.",
            timeout=5
        )
