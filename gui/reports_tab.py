# gui/reports_tab.py

from PyQt5.QtWidgets import (
    QWidget, QVBoxLayout, QLabel, QPushButton, QHBoxLayout, QFileDialog,
    QMessageBox, QLineEdit
)
from threads.report_thread import DirectorySizeReportThread, LogSummaryThread
from utils.email_utils import send_email
from plyer import notification
import logging

class ReportsTab(QWidget):
    def __init__(self):
        super().__init__()
        self.layout = QVBoxLayout()

        lbl = QLabel("Generate Reports")
        lbl.setStyleSheet("font-size: 18px; font-weight: bold;")
        self.layout.addWidget(lbl)

        # Directory Size Report Section
        dsr_section = QWidget()
        dsr_layout = QVBoxLayout()
        dsr_label = QLabel("📊 Directory Size Report")
        dsr_label.setStyleSheet("font-size: 16px; font-weight: bold;")
        dsr_layout.addWidget(dsr_label)

        # Select Directory
        dsr_dir_layout = QHBoxLayout()
        self.select_dsr_dir_btn = QPushButton("📂 Select Directory")
        self.select_dsr_dir_btn.setToolTip("Choose the directory to analyze for size reporting.")
        self.select_dsr_dir_btn.clicked.connect(self.select_dsr_directory)
        dsr_dir_layout.addWidget(self.select_dsr_dir_btn)

        self.dsr_dir_label = QLabel("No directory selected.")
        self.dsr_dir_label.setStyleSheet("color: #555555;")
        dsr_dir_layout.addWidget(self.dsr_dir_label)

        dsr_layout.addLayout(dsr_dir_layout)

        # Report Path
        dsr_path_layout = QHBoxLayout()
        self.dsr_report_path = QLineEdit()
        self.dsr_report_path.setPlaceholderText("Enter report file path (e.g., report.txt)")
        self.dsr_report_path.setToolTip("Specify where the directory size report will be saved.")
        dsr_path_layout.addWidget(self.dsr_report_path)
        dsr_layout.addLayout(dsr_path_layout)

        # Generate Report Button
        self.generate_dsr_btn = QPushButton("📈 Generate Report")
        self.generate_dsr_btn.setToolTip("Create the directory size report based on the selected directory.")
        self.generate_dsr_btn.clicked.connect(self.generate_dsr)
        self.generate_dsr_btn.setEnabled(False)
        dsr_layout.addWidget(self.generate_dsr_btn)

        dsr_section.setLayout(dsr_layout)
        self.layout.addWidget(dsr_section)

        # Log Summary Report Section
        lsr_section = QWidget()
        lsr_layout = QVBoxLayout()
        lsr_label = QLabel("📝 Log Summary Report")
        lsr_label.setStyleSheet("font-size: 16px; font-weight: bold;")
        lsr_layout.addWidget(lsr_label)

        # Log Path
        lsr_log_layout = QHBoxLayout()
        self.lsr_log_path = QLineEdit()
        self.lsr_log_path.setPlaceholderText("Enter log file path (default 'file_manager.log')")
        self.lsr_log_path.setToolTip("Specify the path to the log file for generating the summary.")
        lsr_log_layout.addWidget(self.lsr_log_path)
        lsr_layout.addLayout(lsr_log_layout)

        # Summary Path
        lsr_summary_layout = QHBoxLayout()
        self.lsr_summary_path = QLineEdit()
        self.lsr_summary_path.setPlaceholderText("Enter summary file path (e.g., summary.txt)")
        self.lsr_summary_path.setToolTip("Specify where the log summary will be saved.")
        lsr_summary_layout.addWidget(self.lsr_summary_path)
        lsr_layout.addLayout(lsr_summary_layout)

        # Generate Summary Button
        self.generate_lsr_btn = QPushButton("📝 Generate Summary")
        self.generate_lsr_btn.setToolTip("Create a summary of the log file.")
        self.generate_lsr_btn.clicked.connect(self.generate_lsr)
        self.generate_lsr_btn.setEnabled(True)
        lsr_layout.addWidget(self.generate_lsr_btn)

        lsr_section.setLayout(lsr_layout)
        self.layout.addWidget(lsr_section)

        self.setLayout(self.layout)
        self.selected_dsr_directory = None

    def select_dsr_directory(self):
        directory = QFileDialog.getExistingDirectory(self, "Select Directory for Size Report")
        if directory:
            self.dsr_dir_label.setText(directory)
            self.selected_dsr_directory = directory
            if self.dsr_report_path.text():
                self.generate_dsr_btn.setEnabled(True)

    def generate_dsr(self):
        directory = self.selected_dsr_directory
        report_path = self.dsr_report_path.text() if self.dsr_report_path.text() else "directory_size_report.txt"
        if not directory:
            QMessageBox.warning(self, "Input Error", "Please select a directory.")
            return
        self.generate_dsr_btn.setEnabled(False)
        self.dsr_thread = DirectorySizeReportThread(directory, report_path)
        self.dsr_thread.finished.connect(self.dsr_completed)
        self.dsr_thread.start()

    def dsr_completed(self):
        self.generate_dsr_btn.setEnabled(True)
        QMessageBox.information(self, "Report Generated", f"Directory size report generated at {self.dsr_report_path.text() or 'directory_size_report.txt'}.")
        send_email("Directory Size Report Generated", f"The directory size report has been generated at {self.dsr_report_path.text() or 'directory_size_report.txt'}.")
        notification.notify(
            title="Report Generated",
            message=f"Directory size report generated at {self.dsr_report_path.text() or 'directory_size_report.txt'}.",
            timeout=5
        )

    def generate_lsr(self):
        log_path = self.lsr_log_path.text() if self.lsr_log_path.text() else 'file_manager.log'
        summary_path = self.lsr_summary_path.text() if self.lsr_summary_path.text() else 'log_summary.txt'
        self.generate_lsr_btn.setEnabled(False)
        self.lsr_thread = LogSummaryThread(log_path, summary_path)
        self.lsr_thread.finished.connect(self.lsr_completed)
        self.lsr_thread.start()

    def lsr_completed(self):
        self.generate_lsr_btn.setEnabled(True)
        QMessageBox.information(self, "Log Summary Generated", f"Log summary generated at {self.lsr_summary_path.text() or 'log_summary.txt'}.")
        send_email("Log Summary Generated", f"The log summary has been generated at {self.lsr_summary_path.text() or 'log_summary.txt'}.")
        notification.notify(
            title="Log Summary Generated",
            message=f"Log summary generated at {self.lsr_summary_path.text() or 'log_summary.txt'}.",
            timeout=5
        )
