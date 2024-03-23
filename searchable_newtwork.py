 

# import unicodedata
# import re

# def normalize_arabic(text):
#     text = unicodedata.normalize('NFKD', text)
#     text = re.sub(r'[\u064B-\u065F\u06D6-\u06DC\u06DF-\u06E8\u06EA-\u06ED]', '', text)  # Remove diacritics
#     text = re.sub(r'[\u0621-\u0625]', '\u0627', text)  # Normalize forms of Alef
#     return text.lower()

# search_text = 'ملاحظة'  # Example search text in Arabic
# normalized_search_text = normalize_arabic(search_text)
# print(normalized_search_text)  # Debug: Print normalized search text

 

import sys
import json
import requests
import re
import unicodedata
from pdfminer.high_level import extract_text
from tempfile import NamedTemporaryFile

def normalize_arabic(text):
    text = unicodedata.normalize('NFKD', text)
    text = re.sub(r'[\u064B-\u065F\u06D6-\u06DC\u06DF-\u06E8\u06EA-\u06ED]', '', text)
    text = re.sub(r'[\u0621-\u0625]', '\u0627', text)
    return text.lower()

def download_pdf(url):
    try:
        response = requests.get(url)
        response.raise_for_status()
        with NamedTemporaryFile(delete=False, suffix='.pdf') as tmp_file:
            tmp_file.write(response.content)
            return tmp_file.name
    except Exception as err:
        print(f'An error occurred: {err}', file=sys.stderr)
        return None

def search_text_in_pdf(pdf_file_path, search_text):
    try:
        with open(pdf_file_path, 'rb') as file:
            text = extract_text(file)
            normalized_text = normalize_arabic(text)
            normalized_search_text = normalize_arabic(search_text)
            text_count = normalized_text.count(normalized_search_text)
            return text_count
    except Exception as e:
        print(f"Error reading PDF file {pdf_file_path}: {e}", file=sys.stderr)
        return 0

# Process the PDFs and search text
if __name__ == "__main__":
    if len(sys.argv) < 3:
        sys.exit(json.dumps({"error": "Usage: python script.py [search_text] [pdf_url1] [pdf_url2] ..."}))

    search_text = sys.argv[1]
    pdf_urls = sys.argv[2:]
    results = []

    for url in pdf_urls:
        pdf_path = download_pdf(url)
        if pdf_path:
            text_count = search_text_in_pdf(pdf_path, search_text)
            results.append({"url": url, "count": text_count})

    print(json.dumps(results))  # Output results as JSON



 