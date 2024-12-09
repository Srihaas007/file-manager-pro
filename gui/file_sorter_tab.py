# gui/file_sorter_tab.py
from PyQt5.QtWidgets import (
    QWidget, QVBoxLayout, QLabel, QPushButton, QHBoxLayout, QComboBox,
    QFileDialog, QMessageBox, QProgressBar
)
from threads.file_sorter_thread import FileSorterThread
from utils.email_utils import send_email
from plyer import notification

class FileSorterTab(QWidget):
    def __init__(self):
        super().__init__()
        self.layout = QVBoxLayout()

        lbl = QLabel("Sort Files by Type or Date")
        lbl.setStyleSheet("font-size: 18px; font-weight: bold;")
        self.layout.addWidget(lbl)

        # Select Directory Button and Label
        dir_layout = QHBoxLayout()
        self.select_dir_btn = QPushButton("📂 Select Directory to Sort")
        self.select_dir_btn.setToolTip("Choose the directory containing files to sort.")
        self.select_dir_btn.clicked.connect(self.select_sort_directory)
        dir_layout.addWidget(self.select_dir_btn)

        self.directory_label = QLabel("No directory selected.")
        self.directory_label.setStyleSheet("color: #555555;")
        dir_layout.addWidget(self.directory_label)

        self.layout.addLayout(dir_layout)

        # Sort By Dropdown
        sort_layout = QHBoxLayout()
        sort_label = QLabel("Sort By:")
        sort_layout.addWidget(sort_label)

        self.sort_by = QComboBox()
        self.sort_by.addItems(["Type", "Date"])
        self.sort_by.setToolTip("Choose whether to sort files by their type or creation date.")
        sort_layout.addWidget(self.sort_by)

        self.layout.addLayout(sort_layout)

        # Select Target Directory Button and Label
        target_layout = QHBoxLayout()
        self.select_target_btn = QPushButton("📁 Select Target Directory (Optional)")
        self.select_target_btn.setToolTip("Choose where sorted files will be moved. If not selected, a 'Sorted_Files' folder will be created.")
        self.select_target_btn.clicked.connect(self.select_target_directory)
        target_layout.addWidget(self.select_target_btn)

        self.target_label = QLabel("No target directory selected.")
        self.target_label.setStyleSheet("color: #555555;")
        target_layout.addWidget(self.target_label)

        self.layout.addLayout(target_layout)

        # Sort Files Button
        self.sort_btn = QPushButton("📑 Sort Files")
        self.sort_btn.setToolTip("Start sorting the selected files based on the chosen criteria.")
        self.sort_btn.clicked.connect(self.sort_files_action)
        self.sort_btn.setEnabled(False)
        self.layout.addWidget(self.sort_btn)

        # Progress Bar
        self.progress = QProgressBar()
        self.layout.addWidget(self.progress)

        self.setLayout(self.layout)
        self.selected_sort_directory = None
        self.selected_target_directory = None

    def select_sort_directory(self):
        directory = QFileDialog.getExistingDirectory(self, "Select Directory to Sort")
        if directory:
            self.directory_label.setText(directory)
            self.selected_sort_directory = directory
            self.check_sort_ready()

    def select_target_directory(self):
        directory = QFileDialog.getExistingDirectory(self, "Select Target Directory")
        if directory:
            self.target_label.setText(directory)
            self.selected_target_directory = directory
            self.check_sort_ready()

    def check_sort_ready(self):
        if self.selected_sort_directory:
            self.sort_btn.setEnabled(True)

    def sort_files_action(self):
        sort_by = self.sort_by.currentText().lower()
        target_directory = self.selected_target_directory if hasattr(self, 'selected_target_directory') else None
        self.sort_btn.setEnabled(False)
        self.progress.setValue(0)
        self.thread = FileSorterThread(self.selected_sort_directory, sort_by=sort_by, target_directory=target_directory)
        self.thread.finished.connect(self.sort_completed)
        self.thread.start()

    def sort_completed(self):
        self.sort_btn.setEnabled(True)
        self.progress.setValue(100)
        send_email("File Sorting Completed", f"Files in {self.selected_sort_directory} have been sorted by {self.sort_by.currentText()}.")
        notification.notify(
            title="File Sorting Completed",
            message=f"Files in {self.selected_sort_directory} have been sorted by {self.sort_by.currentText()}.",
            timeout=5
        )
