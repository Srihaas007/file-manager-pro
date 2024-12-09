# logging_setup.py
import logging

def setup_logging():
    logging.basicConfig(
        filename='file_manager.log',
        filemode='a',
        format='%(asctime)s - %(levelname)s - %(message)s',
        level=logging.INFO
    )

setup_logging()
