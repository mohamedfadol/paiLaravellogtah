import install
install.install('pdf2image')
import fitz  # PyMuPDF
import pytesseract
from pdf2image import convert_from_path
import pytesseract
from PIL import Image
import os

# Convert PDF to a list of images
pdf_path = 'C:\\python_project/3.pdf'
# images = convert_from_path(pdf_path, 500, poppler_path=r'C:\\poppler\Library\bin')

# # Ensure pytesseract is pointing to the correct installation path of Tesseract
# # On some systems, you might need to specify the path to the tesseract executable if it's not in the PATH
# # For example, on Windows:
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'
# # For this environment, we'll assume Tesseract is correctly set up and accessible

# # Perform OCR on each image and collect text
# extracted_texts = []
# for i, image in enumerate(images):
#     text = pytesseract.image_to_string(image)
#     extracted_texts.append(text)

# # Join all extracted text into a single string
# all_extracted_text = "\n".join(extracted_texts)

# # Since the output might be large, we'll save it to a file instead of printing it directly
# output_text_file_path = 'C:\\python_project/extracted_text_from_pdf.txt'
# with open(output_text_file_path, 'w', encoding='utf-8') as file:
#     file.write(all_extracted_text)

# output_text_file_path


extracted_text = ''

# Attempt to extract selectable text directly from the PDF
doc = fitz.open(pdf_path)
for page in doc:
    extracted_text += page.get_text()

# If the direct extraction found text, it might not be necessary to use OCR
if not extracted_text.strip():
    # No direct text found, use OCR on the PDF's images
    images = convert_from_path(pdf_path, 500, poppler_path=r'C:\\poppler\Library\bin')
    for image in images:
        extracted_text += pytesseract.image_to_string(image)

# Save the extracted text to a file
output_text_file_path = 'C:\\python_project\\extracted_text_combined.txt'
with open(output_text_file_path, 'w', encoding='utf-8') as file:
    file.write(extracted_text)

print('Extraction complete. Text saved to:', output_text_file_path)