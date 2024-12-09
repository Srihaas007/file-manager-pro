# utils/image_utils.py
import os
from PIL import Image
import logging
from utils.email_utils import send_email

def compress_images(input_folder, output_folder, quality=85):
    if not os.path.exists(output_folder):
        os.makedirs(output_folder)
    
    for root, _, files in os.walk(input_folder):
        for file in files:
            if file.lower().endswith(('jpg', 'jpeg', 'png', 'webp')):
                input_path = os.path.join(root, file)
                output_path = os.path.join(output_folder, file)
                try:
                    with Image.open(input_path) as img:
                        if img.mode in ("RGBA", "P"):
                            img = img.convert("RGB")
                        img.save(output_path, optimize=True, quality=quality)
                        print(f"Compressed: {input_path} -> {output_path}")
                        logging.info(f"Compressed: {input_path} -> {output_path}")
                except Exception as e:
                    logging.error(f"Failed to compress {input_path}: {e}")

def convert_images(input_folder, output_folder, target_format):
    target_format = target_format.lower()
    if not os.path.exists(output_folder):
        os.makedirs(output_folder)
    supported_formats = ('jpg', 'jpeg', 'png', 'webp')
    for root, _, files in os.walk(input_folder):
        for file in files:
            if file.lower().endswith(supported_formats):
                input_path = os.path.join(root, file)
                output_filename = os.path.splitext(file)[0] + f".{target_format}"
                output_path = os.path.join(output_folder, output_filename)
                try:
                    with Image.open(input_path) as img:
                        if target_format in ("jpg", "jpeg") and img.mode in ("RGBA", "P"):
                            img = img.convert("RGB")
                        img.save(output_path, format=target_format.upper())
                        print(f"Converted: {input_path} -> {output_path}")
                        logging.info(f"Converted: {input_path} -> {output_path}")
                except Exception as e:
                    logging.error(f"Failed to convert {input_path}: {e}")
