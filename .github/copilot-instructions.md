## ⚙️ Nguyên tắc chung (Cấp cao)

### 🚫 QUY TẮC VÀNG: KHÔNG BAO GIỜ ĐOÁN DATABASE SCHEMA

**LUÔN LUÔN** kiểm tra database thực tế trước khi viết bất kỳ SQL/Query nào:

```bash
# BẮT BUỘC chạy trước khi code
php artisan db:table [table_name]    # Kiểm tra cấu trúc bảng
php artisan db:show                  # Xem tất cả bảng trong DB
```

### 📋 QUY TRÌNH KIỂM TRA DATABASE BẮT BUỘC

1. **TRƯỚC KHI VIẾT Query/SQL:**
   ```bash
   # Bước 1: Kiểm tra bảng tồn tại
   php artisan db:show
   
   # Bước 2: Kiểm tra cấu trúc cột thực tế  
   php artisan db:table users
   php artisan db:table orders
   php artisan db:table [table_name]
   
   # Bước 3: Kiểm tra data mẫu (nếu cần)
   php artisan tinker --execute="DB::table('table_name')->limit(3)->get()"
   ```


2. **WORKFLOW BẮT BUỘC:**
   ```
   Yêu cầu → Kiểm tra DB → Viết Query → Test → Deploy
            ↑ KHÔNG ĐƯỢC BỎ QUA BƯỚC NÀY
   ```

### 🔍 CHECKLIST TRƯỚC KHI CODE

**Database Verification:**
- [ ] Đã chạy `php artisan db:table [table]` cho TẤT CẢ bảng liên quan
- [ ] Đã xác minh tên cột CHÍNH XÁC (không đoán)
- [ ] Đã kiểm tra foreign key relationships
- [ ] Đã xác minh bảng nào có data, bảng nào rỗng

**Query Construction:**  
- [ ] Sử dụng đúng tên bảng từ database thực tế
- [ ] Sử dụng đúng tên cột từ schema check
- [ ] Join đúng bảng có data (tránh join bảng rỗng)
- [ ] Test query trước khi integrate vào controller

**Error Prevention:**
- [ ] Không assume tên cột dựa trên convention
- [ ] Không copy-paste query từ bảng khác mà không verify
- [ ] Luôn check schema khi gặp "Column not found" error

2. **WORKFLOW BẮT BUỘC:**
- Size chữ chỉ được từ 13px trở lên, không được quá lớn
- Bắt buộc phải dùng svg icons, không được dùng emoji