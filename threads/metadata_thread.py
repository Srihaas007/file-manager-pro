# threads/metadata_thread.py
from PyQt5.QtCore import QThread, pyqtSignal
from utils.file_utils import display_image_metadata, remove_image_metadata

class MetadataThread(QThread):
    progress = pyqtSignal(int)
    finished = pyqtSignal(str)

    def __init__(self, action, image_path, output_path=None):
        super().__init__()
        self.action = action
        self.image_path = image_path
        self.output_path = output_path

    def run(self):
        if self.action == 'display':
            metadata = display_image_metadata(self.image_path)
            self.finished.emit(metadata)
        elif self.action == 'remove':
            remove_image_metadata(self.image_path, self.output_path)
            self.finished.emit("Metadata Removal Completed")
