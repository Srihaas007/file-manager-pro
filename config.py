# config.py
import os
import json
import logging

CONFIG_FILE = 'config.json'

def load_config():
    if not os.path.exists(CONFIG_FILE):
        default_config = {
            "file_categories": {
                "Images": [".jpg", ".jpeg", ".png", ".gif", ".bmp", ".tiff"],
                "Videos": [".mp4", ".avi", ".mkv", ".mov", ".wmv"],
                "Documents": [".doc", ".docx", ".pdf", ".txt", ".xls", ".xlsx", ".ppt", ".pptx"],
                "Audio": [".mp3", ".wav", ".aac", ".flac"],
                "Archives": [".zip", ".rar", ".7z", ".tar", ".gz"],
                "Others": []
            },
            "backup_directory": "Backup",
            "encryption_key_file": "secret.key",
            "email_notifications": {
                "enabled": False,
                "smtp_server": "",
                "smtp_port": 587,
                "sender_email": "",
                "sender_password": "",
                "receiver_email": ""
            }
        }
        with open(CONFIG_FILE, 'w') as f:
            json.dump(default_config, f, indent=4)
        logging.info(f"Created default config file at {CONFIG_FILE}")
        return default_config
    else:
        try:
            with open(CONFIG_FILE, 'r') as f:
                config_data = json.load(f)
            return config_data
        except json.JSONDecodeError:
            logging.error(f"Malformed config.json. Recreating default config.")
            default_config = {
                "file_categories": {
                    "Images": [".jpg", ".jpeg", ".png", ".gif", ".bmp", ".tiff"],
                    "Videos": [".mp4", ".avi", ".mkv", ".mov", ".wmv"],
                    "Documents": [".doc", ".docx", ".pdf", ".txt", ".xls", ".xlsx", ".ppt", ".pptx"],
                    "Audio": [".mp3", ".wav", ".aac", ".flac"],
                    "Archives": [".zip", ".rar", ".7z", ".tar", ".gz"],
                    "Others": []
                },
                "backup_directory": "Backup",
                "encryption_key_file": "secret.key",
                "email_notifications": {
                    "enabled": False,
                    "smtp_server": "",
                    "smtp_port": 587,
                    "sender_email": "",
                    "sender_password": "",
                    "receiver_email": ""
                }
            }
            with open(CONFIG_FILE, 'w') as f:
                json.dump(default_config, f, indent=4)
            logging.info(f"Recreated default config file at {CONFIG_FILE}")
            return default_config

def save_config(config):
    try:
        with open(CONFIG_FILE, 'w') as f:
            json.dump(config, f, indent=4)
        logging.info(f"Saved configuration to {CONFIG_FILE}")
    except Exception as e:
        logging.error(f"Failed to save config: {e}")

config = load_config()
