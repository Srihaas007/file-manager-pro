# gui/image_tools_tab.py
from PyQt5.QtWidgets import (
    QWidget, QVBoxLayout, QLabel, QPushButton, QHBoxLayout, QLineEdit,
    QComboBox, QMessageBox, QSpinBox, QFileDialog, QProgressBar
)
from threads.image_tools_thread import CompressImagesThread, ConvertImagesThread
from utils.email_utils import send_email
from plyer import notification

class ImageToolsTab(QWidget):
    def __init__(self):
        super().__init__()
        self.layout = QVBoxLayout()

        lbl = QLabel("Image Compression and Conversion")
        lbl.setStyleSheet("font-size: 18px; font-weight: bold;")
        self.layout.addWidget(lbl)

        # Compression Section
        comp_section = QWidget()
        comp_layout = QVBoxLayout()
        comp_label = QLabel("📦 Compress Images")
        comp_label.setStyleSheet("font-size: 16px; font-weight: bold;")
        comp_layout.addWidget(comp_label)

        # Select Input Folder
        comp_input_layout = QHBoxLayout()
        self.compress_select_input_btn = QPushButton("📂 Select Input Folder")
        self.compress_select_input_btn.setToolTip("Choose the folder containing images to compress.")
        self.compress_select_input_btn.clicked.connect(self.select_compress_input_folder)
        comp_input_layout.addWidget(self.compress_select_input_btn)

        self.compress_input_label = QLabel("No input folder selected.")
        self.compress_input_label.setStyleSheet("color: #555555;")
        comp_input_layout.addWidget(self.compress_input_label)

        comp_layout.addLayout(comp_input_layout)

        # Select Output Folder
        comp_output_layout = QHBoxLayout()
        self.compress_select_output_btn = QPushButton("📁 Select Output Folder")
        self.compress_select_output_btn.setToolTip("Choose where compressed images will be saved.")
        self.compress_select_output_btn.clicked.connect(self.select_compress_output_folder)
        comp_output_layout.addWidget(self.compress_select_output_btn)

        self.compress_output_label = QLabel("No output folder selected.")
        self.compress_output_label.setStyleSheet("color: #555555;")
        comp_output_layout.addWidget(self.compress_output_label)

        comp_layout.addLayout(comp_output_layout)

        # Compression Quality
        quality_layout = QHBoxLayout()
        self.compress_quality = QSpinBox()
        self.compress_quality.setRange(1, 100)
        self.compress_quality.setValue(85)
        self.compress_quality.setToolTip("Set the compression quality (1-100). Higher values retain more quality.")
        quality_label = QLabel("Compression Quality:")
        quality_layout.addWidget(quality_label)
        quality_layout.addWidget(self.compress_quality)
        comp_layout.addLayout(quality_layout)

        # Compress Button
        self.compress_btn = QPushButton("🔧 Compress Images")
        self.compress_btn.setToolTip("Start compressing the selected images.")
        self.compress_btn.clicked.connect(self.compress_images_action)
        self.compress_btn.setEnabled(False)
        comp_layout.addWidget(self.compress_btn)

        # Add Compression Layout
        comp_section.setLayout(comp_layout)
        self.layout.addWidget(comp_section)

        # Conversion Section
        conv_section = QWidget()
        conv_layout = QVBoxLayout()
        conv_label = QLabel("🔄 Convert Images")
        conv_label.setStyleSheet("font-size: 16px; font-weight: bold;")
        conv_layout.addWidget(conv_label)

        # Select Input Folder
        conv_input_layout = QHBoxLayout()
        self.convert_select_input_btn = QPushButton("📂 Select Input Folder")
        self.convert_select_input_btn.setToolTip("Choose the folder containing images to convert.")
        self.convert_select_input_btn.clicked.connect(self.select_convert_input_folder)
        conv_input_layout.addWidget(self.convert_select_input_btn)

        self.convert_input_label = QLabel("No input folder selected.")
        self.convert_input_label.setStyleSheet("color: #555555;")
        conv_input_layout.addWidget(self.convert_input_label)

        conv_layout.addLayout(conv_input_layout)

        # Select Output Folder
        conv_output_layout = QHBoxLayout()
        self.convert_select_output_btn = QPushButton("📁 Select Output Folder")
        self.convert_select_output_btn.setToolTip("Choose where converted images will be saved.")
        self.convert_select_output_btn.clicked.connect(self.select_convert_output_folder)
        conv_output_layout.addWidget(self.convert_select_output_btn)

        self.convert_output_label = QLabel("No output folder selected.")
        self.convert_output_label.setStyleSheet("color: #555555;")
        conv_output_layout.addWidget(self.convert_output_label)

        conv_layout.addLayout(conv_output_layout)

        # Select Target Format
        format_layout = QHBoxLayout()
        self.convert_format = QComboBox()
        self.convert_format.addItems(["png", "jpg", "webp"])
        self.convert_format.setToolTip("Choose the desired format to convert images to.")
        format_label = QLabel("Target Format:")
        format_layout.addWidget(format_label)
        format_layout.addWidget(self.convert_format)
        conv_layout.addLayout(format_layout)

        # Convert Button
        self.convert_btn = QPushButton("🔧 Convert Images")
        self.convert_btn.setToolTip("Start converting the selected images.")
        self.convert_btn.clicked.connect(self.convert_images_action)
        self.convert_btn.setEnabled(False)
        conv_layout.addWidget(self.convert_btn)

        # Add Conversion Layout
        conv_section.setLayout(conv_layout)
        self.layout.addWidget(conv_section)

        # Progress Bar
        self.progress = QProgressBar()
        self.layout.addWidget(self.progress)

        self.setLayout(self.layout)
        self.selected_compress_input = None
        self.selected_compress_output = None
        self.selected_convert_input = None
        self.selected_convert_output = None

    def select_compress_input_folder(self):
        directory = QFileDialog.getExistingDirectory(self, "Select Input Folder for Compression")
        if directory:
            self.compress_input_label.setText(directory)
            self.selected_compress_input = directory
            self.check_compress_ready()

    def select_compress_output_folder(self):
        directory = QFileDialog.getExistingDirectory(self, "Select Output Folder for Compression")
        if directory:
            self.compress_output_label.setText(directory)
            self.selected_compress_output = directory
            self.check_compress_ready()

    def check_compress_ready(self):
        if self.selected_compress_input and self.selected_compress_output:
            self.compress_btn.setEnabled(True)

    def compress_images_action(self):
        quality = self.compress_quality.value()
        self.compress_btn.setEnabled(False)
        self.thread = CompressImagesThread(self.selected_compress_input, self.selected_compress_output, quality)
        self.thread.finished.connect(self.compress_completed)
        self.thread.start()

    def compress_completed(self):
        self.compress_btn.setEnabled(True)
        send_email("Image Compression Completed", f"Images in {self.selected_compress_input} have been compressed.")
        notification.notify(
            title="Image Compression Completed",
            message=f"Images have been compressed and saved to {self.selected_compress_output}.",
            timeout=5
        )

    def select_convert_input_folder(self):
        directory = QFileDialog.getExistingDirectory(self, "Select Input Folder for Conversion")
        if directory:
            self.convert_input_label.setText(directory)
            self.selected_convert_input = directory
            self.check_convert_ready()

    def select_convert_output_folder(self):
        directory = QFileDialog.getExistingDirectory(self, "Select Output Folder for Conversion")
        if directory:
            self.convert_output_label.setText(directory)
            self.selected_convert_output = directory
            self.check_convert_ready()

    def check_convert_ready(self):
        if self.selected_convert_input and self.selected_convert_output:
            self.convert_btn.setEnabled(True)

    def convert_images_action(self):
        target_format = self.convert_format.currentText()
        self.convert_btn.setEnabled(False)
        self.thread = ConvertImagesThread(self.selected_convert_input, self.selected_convert_output, target_format)
        self.thread.finished.connect(self.convert_completed)
        self.thread.start()

    def convert_completed(self):
        self.convert_btn.setEnabled(True)
        send_email("Image Conversion Completed", f"Images in {self.selected_convert_input} have been converted to {self.convert_format.currentText()}.")
        notification.notify(
            title="Image Conversion Completed",
            message=f"Images have been converted to {self.convert_format.currentText()} and saved to {self.selected_convert_output}.",
            timeout=5
        )
