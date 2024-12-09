# threads/batch_rename_thread.py
from PyQt5.QtCore import QThread, pyqtSignal
import os
import shutil
from pathlib import Path
import logging
from utils.file_utils import send_email

class BatchRenameThread(QThread):
    progress = pyqtSignal(int)
    finished = pyqtSignal()

    def __init__(self, directory, pattern, start_index=1):
        super().__init__()
        self.directory = directory
        self.pattern = pattern
        self.start_index = start_index

    def run(self):
        try:
            files = sorted([f for f in Path(self.directory).iterdir() if f.is_file()])
            for i, file in enumerate(files, start=self.start_index):
                new_name = self.pattern.format(index=i, original_name=file.stem, extension=file.suffix)
                new_path = file.parent / new_name
                shutil.move(str(file), new_path)
                logging.info(f"Renamed {file} to {new_path}")
                print(f"Renamed: {file} -> {new_path}")
            print("Batch renaming completed.")
            logging.info("Batch renaming completed.")
            send_email("Batch Renaming Completed", "All selected files have been renamed.")
        except Exception as e:
            logging.error(f"Failed to batch rename files in {self.directory}: {e}")
