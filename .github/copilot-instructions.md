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

### ⚠️ CẢNH BÁO NGUY HIỂM: MIGRATION COMMANDS

**🚨 TUYỆT ĐỐI KHÔNG BAO GIỜ CHẠY:**

```bash
# ❌ CẤM TUYỆT ĐỐI - XÓA TOÀN BỘ DATABASE
php artisan migrate:fresh
php artisan migrate:refresh
php artisan db:wipe

# ❌ CẤM - Rollback tất cả migrations
php artisan migrate:reset
```

**✅ CHỈ ĐƯỢC DÙNG:**

```bash
# ✅ AN TOÀN - Chạy migrations mới
php artisan migrate

# ✅ AN TOÀN - Rollback batch cuối cùng (nếu cần)
php artisan migrate:rollback --step=1

# ✅ Kiểm tra status
php artisan migrate:status
```

**📋 QUY TRÌNH XỬ LÝ MIGRATION LỖI:**

1. **Khi gặp lỗi migration duplicate/conflict:**
   ```bash
   # Bước 1: Kiểm tra migrations đã chạy
   php artisan migrate:status
   
   # Bước 2: Xóa migration file TRÙNG (nếu có)
   # VÍ DỤ: Nếu có 2 file tạo cart_items, chỉ giữ 1 file
   rm database/migrations/2025_09_20_131312_create_cart_items_table.php
   
   # Bước 3: Chạy migrate bình thường
   php artisan migrate
   ```

2. **TUYỆT ĐỐI KHÔNG:**
   - ❌ Chạy `migrate:fresh` trên database có data thật
   - ❌ Xóa migration đã chạy thành công
   - ❌ Sửa migration file sau khi đã migrate
   
3. **NẾU CẦN RESET (chỉ trên dev):**
   ```bash
   # 1. Backup database TRƯỚC
   mysqldump -u root webbansach > backup_$(date +%Y%m%d_%H%M%S).sql
   
   # 2. Mới được chạy fresh
   php artisan migrate:fresh
   
   # 3. Restore data từ seeders
   php artisan db:seed
   ```

**🎯 NGUYÊN TẮC VÀNG MIGRATIONS:**
- Luôn backup database trước khi thao tác migrations
- Kiểm tra `migrate:status` trước khi làm gì
- Không bao giờ xóa/sửa migration đã deployed
- Test trên database dev riêng trước khi apply lên production

### 🎨 UI/UX GUIDELINES

**WORKFLOW BẮT BUỘC:**
- Size chữ chỉ được từ 13px trở lên, không được quá lớn
- Bắt buộc phải dùng svg icons, không được dùng emoji