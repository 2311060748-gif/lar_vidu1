import os
import sys
import docx

if hasattr(sys.stdout, 'reconfigure'):
    sys.stdout.reconfigure(encoding='utf-8', errors='replace')

from report_styles import setup_document
from chapter_prelim import (
    create_cover_page, add_acknowledgements, 
    add_table_of_contents, add_acronyms_tables_figures, add_introduction
)
from chapter_1 import build_chapter_1
from chapter_2 import build_chapter_2
from chapter_3 import build_chapter_3
from chapter_4 import build_chapter_4
from chapter_5 import build_chapter_5
from chapter_concl import build_conclusion_and_references

def main():
    print("=== BẮT ĐẦU TẠO BÁO CÁO BÀI TẬP LỚN: HỆ THỐNG CỬA HÀNG PHỤ TÙNG XE MÁY ===")
    
    doc = setup_document()
    
    print("1. Tạo Trang bìa chính...")
    create_cover_page(doc, is_sub=False)
    
    print("2. Tạo Trang bìa phụ...")
    create_cover_page(doc, is_sub=True)
    
    print("3. Tạo Lời cảm ơn...")
    add_acknowledgements(doc)
    
    print("4. Tạo Mục lục chi tiết...")
    add_table_of_contents(doc)
    
    print("5. Tạo Danh mục từ viết tắt, Bảng biểu, Hình ảnh...")
    add_acronyms_tables_figures(doc)
    
    print("6. Tạo Phần Mở đầu...")
    add_introduction(doc)
    
    print("7. Tạo Chương 1: Tổng quan về Kiến trúc và Thiết kế phần mềm...")
    build_chapter_1(doc)
    
    print("8. Tạo Chương 2: Phân tích yêu cầu và Thiết kế mô hình...")
    build_chapter_2(doc)
    
    print("9. Tạo Chương 3: Thiết kế kiến trúc...")
    build_chapter_3(doc)
    
    print("10. Tạo Chương 4: Thiết kế dữ liệu và lớp...")
    build_chapter_4(doc)
    
    print("11. Tạo Chương 5: Thiết kế giao diện và thành phần...")
    build_chapter_5(doc)
    
    print("12. Tạo Kết luận, Hướng phát triển và Tài liệu tham khảo...")
    build_conclusion_and_references(doc)
    
    # Save target 1: dedicated descriptive name
    primary_filename = "Bao_Cao_Bai_Tap_Lon_Kien_Truc_Phan_Mem_Cua_Hang_Phu_Tung_Xe_May.docx"
    primary_path = os.path.join(os.path.dirname(os.path.abspath(__file__)), primary_filename)
    doc.save(primary_path)
    file_size_kb = os.path.getsize(primary_path) / 1024
    print(f"=== XUẤT FILE THÀNH CÔNG: {primary_filename} ({file_size_kb:.2f} KB) ===")

    # Save target 2: original filename if unlocked
    secondary_filename = "Bao_Cao_Bai_Tap_Lon_Kien_Truc_Thiet_Ke_Phan_Mem.docx"
    secondary_path = os.path.join(os.path.dirname(os.path.abspath(__file__)), secondary_filename)
    try:
        doc.save(secondary_path)
        print(f"=== ĐÃ ĐỒNG BỘ CẢ FILE: {secondary_filename} ===")
    except PermissionError:
        print(f"Lưu ý: Tệp {secondary_filename} đang được mở trong Word, bản cập nhật hoàn chỉnh đã được lưu vào {primary_filename}.")

if __name__ == "__main__":
    main()
