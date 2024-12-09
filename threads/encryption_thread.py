# threads/encryption_thread.py
from PyQt5.QtCore import QThread, pyqtSignal
from utils.encryption_utils import encrypt_file, decrypt_file

class EncryptionThread(QThread):
    progress = pyqtSignal(int)
    finished = pyqtSignal(str)

    def __init__(self, action, file_path, output_path):
        super().__init__()
        self.action = action
        self.file_path = file_path
        self.output_path = output_path

    def run(self):
        if self.action == 'encrypt':
            encrypt_file(self.file_path, self.output_path)
            self.finished.emit("Encryption Completed")
        elif self.action == 'decrypt':
            decrypt_file(self.file_path, self.output_path)
            self.finished.emit("Decryption Completed")
