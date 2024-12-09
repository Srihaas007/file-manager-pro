# utils/report_utils.py

import os
from pathlib import Path
import logging
import json
import time  # Added import for time
from utils.email_utils import send_email
from config import config

def generate_report(duplicates):
    """
    Generates a report of duplicate files and saves it to a report file.

    Args:
        duplicates (dict): A dictionary where keys are hashes and values are lists of duplicate file paths.
    """
    try:
        report_dir = Path("Reports")
        report_dir.mkdir(exist_ok=True)
        report_path = report_dir / f"duplicate_report_{int(time.time())}.txt"
        with report_path.open('w') as report_file:
            for hash_val, paths in duplicates.items():
                report_file.write(f"Hash: {hash_val}\n")
                for path in paths:
                    report_file.write(f"    {path}\n")
                report_file.write("\n")
        logging.info(f"Duplicate report generated at {report_path}")
        send_email("Duplicate Report Generated", f"Duplicate report has been generated at {report_path}.")
    except Exception as e:
        logging.error(f"Failed to generate duplicate report: {e}")

def directory_size_report(directory, report_path):
    """
    Generates a report of directory sizes and saves it to the specified path.

    Args:
        directory (str or Path): The directory to analyze.
        report_path (str or Path): The file path where the report will be saved.
    """
    try:
        directory = Path(directory)
        report_path = Path(report_path)
        with report_path.open('w') as report_file:
            total_size = 0
            for dirpath, dirnames, filenames in os.walk(directory):
                dir_size = 0
                for filename in filenames:
                    file_path = Path(dirpath) / filename
                    if file_path.is_symlink():
                        continue
                    try:
                        dir_size += file_path.stat().st_size
                    except Exception as e:
                        logging.error(f"Error accessing file {file_path}: {e}")
                total_size += dir_size
                report_file.write(f"Directory: {dirpath}\n")
                report_file.write(f"Size: {dir_size / (1024 * 1024):.2f} MB\n\n")
            report_file.write(f"Total Size of {directory}: {total_size / (1024 * 1024):.2f} MB\n")
        logging.info(f"Directory size report generated at {report_path}")
        send_email("Directory Size Report Generated", f"The directory size report has been generated at {report_path}.")
    except Exception as e:
        logging.error(f"Failed to generate directory size report: {e}")

def generate_log_summary(log_path, summary_path):
    """
    Generates a summary of the log file and saves it to the specified path.

    Args:
        log_path (str or Path): The path to the log file.
        summary_path (str or Path): The file path where the summary will be saved.
    """
    try:
        log_path = Path(log_path)
        summary_path = Path(summary_path)
        if not log_path.exists():
            logging.error(f"Log file {log_path} does not exist.")
            return
        summary = {}
        with log_path.open('r') as log_file:
            for line in log_file:
                if "ERROR" in line:
                    summary.setdefault("Errors", []).append(line.strip())
                elif "INFO" in line:
                    summary.setdefault("Info", []).append(line.strip())
                elif "WARNING" in line:
                    summary.setdefault("Warnings", []).append(line.strip())
        with summary_path.open('w') as summary_file:
            for key, messages in summary.items():
                summary_file.write(f"--- {key} ---\n")
                for msg in messages:
                    summary_file.write(f"{msg}\n")
                summary_file.write("\n")
        logging.info(f"Log summary generated at {summary_path}")
        send_email("Log Summary Generated", f"The log summary has been generated at {summary_path}.")
    except Exception as e:
        logging.error(f"Failed to generate log summary: {e}")
