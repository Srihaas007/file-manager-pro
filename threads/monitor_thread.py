# threads/monitor_thread.py
from PyQt5.QtCore import QThread, pyqtSignal
from watchdog.observers import Observer
from watchdog.events import FileSystemEventHandler
import time
import logging
from utils.email_utils import send_email

class Handler(FileSystemEventHandler):
    @staticmethod
    def on_created(event):
        if event.is_directory:
            return
        logging.info(f"Detected new file: {event.src_path}")
        print(f"New file detected: {event.src_path}")
        send_email("New File Detected", f"A new file has been created: {event.src_path}")

class MonitorThread(QThread):
    progress = pyqtSignal(int)
    finished = pyqtSignal()

    def __init__(self, directory_to_watch):
        super().__init__()
        self.DIRECTORY_TO_WATCH = directory_to_watch
        self.observer = Observer()

    def run(self):
        event_handler = Handler()
        self.observer.schedule(event_handler, self.DIRECTORY_TO_WATCH, recursive=True)
        self.observer.start()
        logging.info(f"Started real-time monitoring on {self.DIRECTORY_TO_WATCH}")
        print(f"Real-time monitoring started on {self.DIRECTORY_TO_WATCH}. Press Ctrl+C to stop.")
        try:
            while True:
                time.sleep(5)
        except KeyboardInterrupt:
            self.observer.stop()
            logging.info("Stopped real-time monitoring.")
            print("\nReal-time monitoring stopped.")
        self.observer.join()
        self.finished.emit()
