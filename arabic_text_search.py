import sys
import json
import requests
import re
import unicodedata
from pdfminer.high_level import extract_text
from tempfile import NamedTemporaryFile
from bidi.algorithm import get_display
def normalize_arabic(text):
    text = unicodedata.normalize('NFKD', text)
    text = re.sub(r'[\u064B-\u065F\u06D6-\u06DC\u06DF-\u06E8\u06EA-\u06ED]', '', text)
    text = re.sub(r'[\u0621-\u0625]', '\u0627', text)
    text = re.sub(r'\s+', ' ', text)  # Replace multiple spaces with a single space
    return text.lower().strip()

def download_pdf(url):
    try:
        response = requests.get(url)
        response.raise_for_status()
        with NamedTemporaryFile(delete=False, suffix='.pdf') as tmp_file:
            tmp_file.write(response.content)
            return tmp_file.name
    except Exception as err:
        print(f'An error occurred downloading the PDF: {err}', file=sys.stderr)
        return None

def search_text_in_pdf(pdf_file_path, search_text):
    try:
        with open(pdf_file_path, 'rb') as file:
            text = extract_text(file)
            print(f"Extracted Text Sample: {text[:500]}")  # Sample of extracted text

            normalized_text = normalize_arabic(text)
            normalized_search_text = normalize_arabic(search_text) 
            print(f"normalized_search_text normalized_search_text {normalized_search_text}")
            # Check if the search text is in the normalized text
            if normalized_search_text in normalized_text:
                print("Search text found in document.")
            else:
                print("Search text not found in document.")
            
            search_pattern = re.compile(re.escape(normalized_search_text))
            matches = list(search_pattern.finditer(normalized_text))
            found_texts = [normalized_text[max(0, match.start() - 30):match.end() + 30] for match in matches]
            
            return {"count": len(matches), "texts": found_texts}
    except Exception as e:
        print(f"Error reading PDF file {pdf_file_path}: {e}", file=sys.stderr)
        return {"count": 0, "texts": []}

if __name__ == "__main__":
    if len(sys.argv) < 3:
        sys.exit(json.dumps({"error": "Usage: script.py search_text pdf_url1 [pdf_url2 ...]"}, ensure_ascii=False))

    search_text = sys.argv[1]
    pdf_urls = sys.argv[2:]
    results = []

    for url in pdf_urls:
        pdf_path = download_pdf(url)
        if pdf_path:
            result = search_text_in_pdf(pdf_path, search_text)
            result.update({"url": url})
            results.append(result)

    print(json.dumps(results, ensure_ascii=False))  # Ensuring Arabic text is correctly displayed
