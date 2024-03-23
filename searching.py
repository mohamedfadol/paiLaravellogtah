import sys
from pdfminer.high_level import extract_text
from pdfminer.pdfpage import PDFPage

def extract_info_from_pdf(pdf_file_paths, search_text):
    results = {}

    for pdf_file_path in pdf_file_paths:
        text_count = 0
        total_text = ""
        page_count = 0

        try:
            with open(pdf_file_path, 'rb') as file:
                for page in PDFPage.get_pages(file):
                    page_text = extract_text(file, page_numbers=[page_count])
                    total_text += page_text
                    page_count += 1

            text_count = total_text.lower().count(search_text.lower())

            if text_count > 0:
                results[pdf_file_path] = {
                    'page_count': page_count,
                    'text_count': text_count
                }
        except Exception as e:
            print(f"Error processing {pdf_file_path}: {str(e)}")

    return results

if __name__ == "__main__":
    if len(sys.argv) < 3:
        print("Usage: python extract_info_from_pdf.py [search_text] [pdf_file_path1] [pdf_file_path2] ...")
        sys.exit(1)

    search_text = sys.argv[1]
    pdf_paths = sys.argv[2:]
    results = extract_info_from_pdf(pdf_paths, search_text)

    for path, info in results.items():
        print(f"{path}: Page Count: {info['page_count']}, Occurrences of '{search_text}': {info['text_count']}")
