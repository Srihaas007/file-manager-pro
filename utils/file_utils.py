# utils/file_utils.py

import os
import hashlib
from pathlib import Path
import shutil
import logging
from concurrent.futures import ThreadPoolExecutor, as_completed
from tqdm import tqdm
from utils.email_utils import send_email
from config import config
import send2trash
import time
from difflib import SequenceMatcher
from PIL import Image, ExifTags

def backup_file(file_path, backup_dir):
    """
    Backs up a file to the specified backup directory, preserving the relative path.
    
    Args:
        file_path (str or Path): The path of the file to backup.
        backup_dir (str or Path): The directory where the backup will be stored.
    """
    try:
        backup_dir = Path(backup_dir)
        backup_dir.mkdir(parents=True, exist_ok=True)
        relative_path = Path(file_path).relative_to(Path(file_path).parents[1])
        destination = backup_dir / relative_path
        destination.parent.mkdir(parents=True, exist_ok=True)
        shutil.copy2(file_path, destination)
        logging.info(f"Backed up {file_path} to {destination}")
    except Exception as e:
        logging.error(f"Failed to backup {file_path}: {e}")

def calculate_sha256(file_path, block_size=65536):
    """
    Calculates the SHA-256 hash of a file.

    Args:
        file_path (str or Path): The path of the file to hash.
        block_size (int, optional): The size of each read block. Defaults to 65536.

    Returns:
        str: The SHA-256 hash in hexadecimal format, or None if an error occurs.
    """
    sha256 = hashlib.sha256()
    path = Path(file_path)
    try:
        if os.name == 'nt':
            # Handle long paths on Windows
            path = Path(r'\\?\{}'.format(path))
        with path.open('rb') as f:
            for block in iter(lambda: f.read(block_size), b''):
                sha256.update(block)
    except Exception as e:
        logging.error(f"Couldn't process file {file_path} due to {e}")
        return None
    return sha256.hexdigest()

def group_files_by_size(directory):
    """
    Groups files in a directory by their size.

    Args:
        directory (str or Path): The directory to scan.

    Returns:
        list: A list of lists, where each sublist contains files of the same size.
    """
    files_by_size = {}
    directory = Path(directory)
    for dirpath, _, filenames in os.walk(directory):
        for filename in filenames:
            file_path = Path(dirpath) / filename
            try:
                if file_path.is_symlink():
                    continue
                file_size = file_path.stat().st_size
                files_by_size.setdefault(file_size, []).append(file_path)
            except Exception as e:
                logging.error(f"Error processing file {file_path}. Error: {e}")
    # Filter out sizes that have only one file
    potential_duplicates = [files for files in files_by_size.values() if len(files) > 1]
    return potential_duplicates

def group_files_by_hash(potential_duplicates):
    """
    Groups potential duplicate files by their SHA-256 hash.

    Args:
        potential_duplicates (list): A list of lists containing potential duplicate files.

    Returns:
        dict: A dictionary where keys are hashes and values are lists of file paths.
    """
    duplicates = {}
    with ThreadPoolExecutor(max_workers=os.cpu_count()) as executor:
        future_to_file = {
            executor.submit(calculate_sha256, file_path): file_path
            for group in potential_duplicates for file_path in group
        }
        for future in tqdm(as_completed(future_to_file), total=len(future_to_file), desc="Hashing files", unit="file"):
            file_path = future_to_file[future]
            try:
                file_hash = future.result()
                if file_hash:
                    duplicates.setdefault(file_hash, []).append(file_path)
            except Exception as e:
                logging.error(f"Error hashing file {file_path}: {e}")
    # Filter out hashes that have only one file
    duplicates = {hash_val: paths for hash_val, paths in duplicates.items() if len(paths) > 1}
    return duplicates

def find_duplicate_files(directory):
    """
    Finds duplicate files in a directory by size and SHA-256 hash.

    Args:
        directory (str or Path): The directory to scan.

    Returns:
        dict: A dictionary where keys are hashes and values are lists of duplicate file paths.
    """
    logging.info(f"Starting duplicate search in: {directory}")
    potential_duplicates = group_files_by_size(directory)
    if not potential_duplicates:
        logging.info("No potential duplicates found based on file size.")
        return {}
    duplicates = group_files_by_hash(potential_duplicates)
    logging.info(f"Duplicate search completed. {len(duplicates)} sets of duplicates found.")
    return duplicates

def delete_files_permanently(duplicates, backup=True):
    """
    Permanently deletes duplicate files, optionally backing them up first.

    Args:
        duplicates (dict): A dictionary of duplicate files.
        backup (bool, optional): Whether to backup files before deletion. Defaults to True.
    """
    logging.info("Starting permanent deletion of duplicates.")
    for file_hash, file_paths in duplicates.items():
        for file in file_paths[1:]:  # Keep the first file, delete the rest
            try:
                if backup:
                    backup_file(file, config.get("backup_directory", "Backup"))
                os.remove(file)
                logging.info(f"Permanently deleted: {file}")
                print(f"Deleted: {file}")
            except Exception as e:
                logging.error(f"Error deleting file {file}: {e}")
    print("Permanent deletion completed.")
    logging.info("Permanent deletion completed.")
    send_email("Duplicate Deletion Completed", "All duplicate files have been permanently deleted.")

def send_duplicates_to_trash(duplicates, backup=True):
    """
    Sends duplicate files to the system trash, optionally backing them up first.

    Args:
        duplicates (dict): A dictionary of duplicate files.
        backup (bool, optional): Whether to backup files before sending to trash. Defaults to True.
    """
    logging.info("Sending duplicates to trash.")
    for file_hash, file_paths in duplicates.items():
        for file in file_paths[1:]:  # Keep the first file, send the rest to trash
            try:
                if backup:
                    backup_file(file, config.get("backup_directory", "Backup"))
                send2trash.send2trash(str(file))
                logging.info(f"Sent to trash: {file}")
                print(f"Sent to trash: {file}")
            except Exception as e:
                logging.error(f"Error sending file {file} to trash: {e}")
    print("Duplicates sent to trash.")
    logging.info("Duplicates sent to trash.")
    send_email("Duplicate Trash Completed", "All duplicate files have been moved to trash.")

def sort_files(directory, target_directory=None, sort_by='type'):
    """
    Sorts files in a directory by type or creation date into designated folders.

    Args:
        directory (str or Path): The directory containing files to sort.
        target_directory (str or Path, optional): The directory where sorted files will be placed.
            If None, a 'Sorted_Files' folder will be created within the source directory.
        sort_by (str, optional): Criteria to sort by ('type' or 'date'). Defaults to 'type'.
    """
    if target_directory is None:
        target_directory = Path(directory) / "Sorted_Files"
    target_directory = Path(target_directory)
    target_directory.mkdir(exist_ok=True)
    
    logging.info(f"Starting to sort files in: {directory} by {sort_by}")
    for dirpath, _, filenames in os.walk(directory):
        for filename in filenames:
            file_path = Path(dirpath) / filename
            try:
                if file_path.is_symlink():
                    continue
                if file_path.parent == target_directory:
                    continue  # Avoid sorting already sorted files
                if sort_by == 'type':
                    file_ext = file_path.suffix.lower()
                    category_found = False
                    for category, extensions in config["file_categories"].items():
                        if file_ext in extensions:
                            category_dir = target_directory / category
                            category_dir.mkdir(exist_ok=True)
                            shutil.move(str(file_path), category_dir / file_path.name)
                            logging.info(f"Moved {file_path} to {category_dir}")
                            category_found = True
                            break
                    if not category_found:
                        others_dir = target_directory / "Others"
                        others_dir.mkdir(exist_ok=True)
                        shutil.move(str(file_path), others_dir / file_path.name)
                        logging.info(f"Moved {file_path} to {others_dir}")
                elif sort_by == 'date':
                    creation_time = file_path.stat().st_ctime
                    date_folder = time.strftime('%Y-%m-%d', time.localtime(creation_time))
                    date_dir = target_directory / date_folder
                    date_dir.mkdir(exist_ok=True)
                    shutil.move(str(file_path), date_dir / file_path.name)
                    logging.info(f"Moved {file_path} to {date_dir}")
            except Exception as e:
                logging.error(f"Error sorting file {file_path}: {e}")
    print(f"Files have been sorted and moved to {target_directory}")
    logging.info(f"File sorting completed. Sorted files are in {target_directory}")
    send_email("File Sorting Completed", f"Files in {directory} have been sorted by {sort_by}.")

def is_similar(file1, file2, threshold=0.9):
    """
    Checks if two text files are similar based on a similarity threshold.

    Args:
        file1 (str or Path): Path to the first file.
        file2 (str or Path): Path to the second file.
        threshold (float, optional): Similarity threshold between 0 and 1. Defaults to 0.9.

    Returns:
        bool: True if similarity >= threshold, else False.
    """
    try:
        with open(file1, 'r', errors='ignore') as f1, open(file2, 'r', errors='ignore') as f2:
            text1 = f1.read()
            text2 = f2.read()
            similarity = SequenceMatcher(None, text1, text2).ratio()
            return similarity >= threshold
    except Exception as e:
        logging.error(f"Error comparing files {file1} and {file2}: {e}")
        return False

def fuzzy_duplicate_detection(duplicates):
    """
    Performs fuzzy duplicate detection. Placeholder for more advanced duplicate detection methods.

    Args:
        duplicates (dict): A dictionary of duplicate files.

    Returns:
        dict: The processed duplicates after fuzzy detection.
    """
    # Placeholder for fuzzy duplicate detection logic
    # For example, implementing perceptual hashing for images
    # Currently, it just returns the original duplicates
    return duplicates

def display_image_metadata(image_path):
    """
    Retrieves and returns metadata from an image file.

    Args:
        image_path (str or Path): The path to the image file.

    Returns:
        str: A formatted string of metadata, or an error message.
    """
    try:
        with Image.open(image_path) as img:
            info = img._getexif()
            if not info:
                logging.info(f"No metadata found for {image_path}")
                return "No metadata found."
            metadata = ""
            for tag, value in info.items():
                tag_name = ExifTags.TAGS.get(tag, tag)
                metadata += f"{tag_name}: {value}\n"
            logging.info(f"Displayed metadata for {image_path}")
            return metadata
    except Exception as e:
        logging.error(f"Failed to read metadata from {image_path}: {e}")
        print(f"Failed to read metadata from {image_path}: {e}")
        return f"Failed to read metadata from {image_path}: {e}"

def remove_image_metadata(image_path, output_path):
    """
    Removes metadata from an image and saves the cleaned image to a new path.

    Args:
        image_path (str or Path): The path to the original image.
        output_path (str or Path): The path where the cleaned image will be saved.
    """
    try:
        with Image.open(image_path) as img:
            data = list(img.getdata())
            img_without_exif = Image.new(img.mode, img.size)
            img_without_exif.putdata(data)
            img_without_exif.save(output_path)
        logging.info(f"Removed metadata from {image_path} and saved to {output_path}")
        print(f"Removed metadata: {image_path} -> {output_path}")
    except Exception as e:
        logging.error(f"Failed to remove metadata from {image_path}: {e}")
        print(f"Failed to remove metadata from {image_path}: {e}")
