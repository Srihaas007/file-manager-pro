# threads/duplicate_finder_thread.py
from PyQt5.QtCore import QThread, pyqtSignal
from utils.file_utils import find_duplicate_files

class DuplicateFinderThread(QThread):
    progress = pyqtSignal(int)
    finished = pyqtSignal(dict)

    def __init__(self, directory):
        super().__init__()
        self.directory = directory

    def run(self):
        duplicates = find_duplicate_files(self.directory)
        self.finished.emit(duplicates)
