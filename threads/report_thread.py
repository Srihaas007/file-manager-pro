# threads/report_thread.py

from PyQt5.QtCore import QThread, pyqtSignal
from utils.report_utils import directory_size_report, generate_log_summary
import logging

class DirectorySizeReportThread(QThread):
    finished = pyqtSignal()

    def __init__(self, directory, report_path):
        super().__init__()
        self.directory = directory
        self.report_path = report_path

    def run(self):
        try:
            directory_size_report(self.directory, self.report_path)
        except Exception as e:
            logging.error(f"Error in DirectorySizeReportThread: {e}")
        finally:
            self.finished.emit()

class LogSummaryThread(QThread):
    finished = pyqtSignal()

    def __init__(self, log_path, summary_path):
        super().__init__()
        self.log_path = log_path
        self.summary_path = summary_path

    def run(self):
        try:
            generate_log_summary(self.log_path, self.summary_path)
        except Exception as e:
            logging.error(f"Error in LogSummaryThread: {e}")
        finally:
            self.finished.emit()
