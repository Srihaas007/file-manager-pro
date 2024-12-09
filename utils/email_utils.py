# utils/email_utils.py
import smtplib
from email.mime.text import MIMEText
import logging
from config import config

def send_email(subject, body):
    email_config = config.get("email_notifications", {})
    if not email_config.get("enabled"):
        return
    try:
        msg = MIMEText(body)
        msg['Subject'] = subject
        msg['From'] = email_config['sender_email']
        msg['To'] = email_config['receiver_email']

        with smtplib.SMTP(email_config['smtp_server'], email_config['smtp_port']) as server:
            server.starttls()
            server.login(email_config['sender_email'], email_config['sender_password'])
            server.send_message(msg)
        logging.info("Email notification sent.")
    except Exception as e:
        logging.error(f"Failed to send email: {e}")
