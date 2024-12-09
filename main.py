# main.py
import sys
from PyQt5.QtWidgets import QApplication, QWidget, QTabWidget, QVBoxLayout
from gui.duplicate_finder_tab import DuplicateFinderTab
from gui.file_sorter_tab import FileSorterTab
# Import other tabs similarly
from gui.image_tools_tab import ImageToolsTab
from gui.encryption_tab import EncryptionTab
from gui.metadata_tab import MetadataTab
from gui.batch_rename_tab import BatchRenameTab
from gui.reports_tab import ReportsTab
from gui.monitor_tab import MonitorTab
from gui.cache_cleaner_tab import CacheCleanerTab
from gui.settings_tab import SettingsTab

class FileManagerGUI(QWidget):
    def __init__(self):
        super().__init__()
        self.setWindowTitle("File Manager Pro")
        self.setGeometry(100, 100, 1000, 800)
        # self.setWindowIcon(QIcon('icon.png'))  # Optional: Add an icon.png in the script directory
        self.layout = QVBoxLayout()
        self.tabs = QTabWidget()
        self.layout.addWidget(self.tabs)
        self.setLayout(self.layout)

        # Initialize all tabs
        self.tabs.addTab(DuplicateFinderTab(), "Duplicate Finder")
        self.tabs.addTab(FileSorterTab(), "File Sorter")
        self.tabs.addTab(ImageToolsTab(), "Image Tools")
        self.tabs.addTab(EncryptionTab(), "Encryption")
        self.tabs.addTab(MetadataTab(), "Metadata")
        self.tabs.addTab(BatchRenameTab(), "Batch Rename")
        self.tabs.addTab(ReportsTab(), "Reports")
        self.tabs.addTab(MonitorTab(), "Monitor")
        self.tabs.addTab(CacheCleanerTab(), "Cache Cleaner")
        self.tabs.addTab(SettingsTab(), "Settings")

        # Apply Stylesheet if needed
        self.apply_stylesheet()

    def apply_stylesheet(self):
        self.setStyleSheet("""
            QWidget {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                font-size: 14px;
            }
            QPushButton {
                background-color: #007ACC;
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                font-size: 14px;
            }
            QPushButton:hover {
                background-color: #005A9E;
            }
            QLineEdit, QTextEdit, QComboBox, QSpinBox, QListWidget {
                padding: 8px;
                border: 1px solid #ccc;
                border-radius: 4px;
                font-size: 14px;
            }
            QTabWidget::pane { /* The tab widget frame */
                border-top: 2px solid #C2C7CB;
            }
            QTabBar::tab {
                background: #f1f1f1;
                border: 1px solid #C4C4C3;
                padding: 12px;
                border-bottom: none;
                min-width: 120px;
                font-weight: bold;
            }
            QTabBar::tab:selected {
                background: #ffffff;
                border-bottom: 2px solid #007ACC;
            }
            QLabel {
                padding: 5px;
                font-size: 14px;
            }
            QProgressBar {
                border: 1px solid #ccc;
                border-radius: 5px;
                text-align: center;
            }
            QProgressBar::chunk {
                background-color: #007ACC;
                width: 20px;
            }
            QScrollArea {
                background: #ffffff;
            }
        """)

if __name__ == '__main__':
    from logging_setup import setup_logging  # Ensure logging is set up
    app = QApplication(sys.argv)
    gui = FileManagerGUI()
    gui.show()
    sys.exit(app.exec_())
