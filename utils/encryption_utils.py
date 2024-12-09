# utils/encryption_utils.py
from cryptography.fernet import Fernet
import os
import logging
from config import config

def generate_encryption_key():
    key = Fernet.generate_key()
    with open(config['encryption_key_file'], 'wb') as key_file:
        key_file.write(key)
    logging.info("Encryption key generated and saved.")
    return key

def load_encryption_key():
    key_file = config.get('encryption_key_file', 'secret.key')
    if not os.path.exists(key_file):
        return generate_encryption_key()
    with open(key_file, 'rb') as key_file:
        key = key_file.read()
    return key

ENCRYPTION_KEY = load_encryption_key()
fernet = Fernet(ENCRYPTION_KEY)

def encrypt_file(file_path, encrypted_path):
    try:
        with open(file_path, 'rb') as f:
            data = f.read()
        encrypted_data = fernet.encrypt(data)
        with open(encrypted_path, 'wb') as f:
            f.write(encrypted_data)
        logging.info(f"Encrypted {file_path} to {encrypted_path}")
        print(f"Encrypted: {file_path} -> {encrypted_path}")
    except Exception as e:
        logging.error(f"Failed to encrypt {file_path}: {e}")
        print(f"Failed to encrypt {file_path}: {e}")

def decrypt_file(encrypted_path, decrypted_path):
    try:
        with open(encrypted_path, 'rb') as f:
            data = f.read()
        decrypted_data = fernet.decrypt(data)
        with open(decrypted_path, 'wb') as f:
            f.write(decrypted_data)
        logging.info(f"Decrypted {encrypted_path} to {decrypted_path}")
        print(f"Decrypted: {encrypted_path} -> {decrypted_path}")
    except Exception as e:
        logging.error(f"Failed to decrypt {encrypted_path}: {e}")
        print(f"Failed to decrypt {encrypted_path}: {e}")
