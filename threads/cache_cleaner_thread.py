# threads/cache_cleaner_thread.py
from PyQt5.QtCore import QThread, pyqtSignal
import os
from pathlib import Path
import logging
from utils.email_utils import send_email
from config import config

class CacheCleanerThread(QThread):
    progress = pyqtSignal(int)
    finished = pyqtSignal()

    def __init__(self, directories):
        super().__init__()
        self.directories = directories

    def run(self):
        try:
            total_dirs = len(self.directories)
            for idx, directory in enumerate(self.directories, 1):
                self.progress.emit(int((idx / total_dirs) * 100))
                self.clean_directory(directory)
            self.finished.emit()
        except Exception as e:
            logging.error(f"Error during cache cleaning: {e}")

    def clean_directory(self, directory):
        if not os.path.exists(directory):
            logging.warning(f"Directory does not exist: {directory}")
            return
        for root, dirs, files in os.walk(directory):
            for file in files:
                file_path = Path(root) / file
                try:
                    if file_path.is_file():
                        file_path.unlink()
                        logging.info(f"Deleted cache file: {file_path}")
                except Exception as e:
                    logging.error(f"Failed to delete {file_path}: {e}")
