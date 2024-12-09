# threads/file_sorter_thread.py
from PyQt5.QtCore import QThread, pyqtSignal
from utils.file_utils import sort_files

class FileSorterThread(QThread):
    progress = pyqtSignal(int)
    finished = pyqtSignal()

    def __init__(self, directory, sort_by, target_directory):
        super().__init__()
        self.directory = directory
        self.sort_by = sort_by
        self.target_directory = target_directory

    def run(self):
        sort_files(self.directory, sort_by=self.sort_by, target_directory=self.target_directory)
        self.finished.emit()
