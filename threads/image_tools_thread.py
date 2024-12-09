# threads/image_tools_thread.py
from PyQt5.QtCore import QThread, pyqtSignal
from utils.image_utils import compress_images, convert_images

class CompressImagesThread(QThread):
    progress = pyqtSignal(int)
    finished = pyqtSignal()

    def __init__(self, input_folder, output_folder, quality):
        super().__init__()
        self.input_folder = input_folder
        self.output_folder = output_folder
        self.quality = quality

    def run(self):
        compress_images(self.input_folder, self.output_folder, self.quality)
        self.finished.emit()

class ConvertImagesThread(QThread):
    progress = pyqtSignal(int)
    finished = pyqtSignal()

    def __init__(self, input_folder, output_folder, target_format):
        super().__init__()
        self.input_folder = input_folder
        self.output_folder = output_folder
        self.target_format = target_format

    def run(self):
        convert_images(self.input_folder, self.output_folder, self.target_format)
        self.finished.emit()
