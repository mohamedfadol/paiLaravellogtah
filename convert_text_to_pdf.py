import install
install.install('fpdf')
from fpdf import FPDF

import os

class PDF(FPDF):
    def __init__(self, font_path):
        super().__init__()
        self.set_auto_page_break(auto=True, margin=15)
        self.add_page()
        # Use the provided font path here
        self.add_font('DejaVu', '', font_path, uni=True)
        self.set_font('DejaVu', '', 12)
    
    def add_text(self, text):
        self.multi_cell(0, 10, text)

def convert_text_to_pdf(text_file_path, pdf_file_path, font_file_path):
    pdf = PDF(font_file_path)
    with open(text_file_path, 'r', encoding='utf-8') as file:
        for line in file:
            pdf.add_text(line)
    pdf.output(pdf_file_path)

# Get the directory of the current script
script_dir = os.path.dirname(os.path.realpath(__file__))

# Construct the path to the font file
font_file_path = os.path.join(script_dir, 'C:\\python_project/DejaVuSansCondensed.ttf')

# Adjust these paths as necessary
text_file_path = os.path.join(script_dir, 'C:\\python_project/extracted_text_combined.txt')  # Update with your text file name
pdf_file_path = os.path.join(script_dir, 'C:\\python_project/output_pdf_file.pdf')

convert_text_to_pdf(text_file_path, pdf_file_path, font_file_path)
 
