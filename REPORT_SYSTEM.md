# 📋 Fitur Report System - Dokumentasi Lengkap

## 📌 Ringkasan Fitur

Fitur Report System memungkinkan pembeli untuk melaporkan seller bermasalah langsung dari halaman detail produk. Admin dapat mengelola laporan, melihat response dari seller, dan melakukan blacklist/suspend terhadap seller yang bermasalah. Seller juga mendapatkan notifikasi tentang laporan dan dapat merespons untuk membela diri.

---

## 🏗️ Arsitektur Sistem

### Database Schema

**Tabel: `reports`**
```
- id: BIGINT (Primary Key)
- user_id: BIGINT (Foreign Key → users.id) - Pembeli yang melaporkan
- seller_id: BIGINT (Foreign Key → users.id) - Seller yang dilaporkan
- product_id: BIGINT (Foreign Key → products.id) - Produk yang dilaporkan
- reason: VARCHAR(100) - poor_quality, fake_product, unsafe, inappropriate, other
- description: LONGTEXT - Deskripsi detail laporan
- seller_response: LONGTEXT - Response/penjelasan dari seller (nullable)
- admin_notes: LONGTEXT - Catatan admin (nullable)
- status: VARCHAR(50) - pending, responded, resolved, dismissed (default: pending)
- action_taken: VARCHAR(100) - none, warning, suspended, blacklisted (nullable)
- created_at: TIMESTAMP
- updated_at: TIMESTAMP
- Indexes: seller_id, user_id, status, created_at, composite(seller_id, status)
```

**Kolom Tambahan di Tabel `users`**
```
- is_blacklisted: BOOLEAN (default: FALSE)
- suspended_reason: LONGTEXT (nullable)
- suspended_at: TIMESTAMP (nullable)
```

---

## 📂 File Structure

### Models
- **`app/Models/Report.php`** - Report model dengan relationships dan scopes
  - Relationships: reporter(), seller(), product()
  - Scopes: pending(), responded(), resolved(), byStatus(), forSeller()

### Controllers

**Admin Report Management**
- **`app/Http/Controllers/Admin/ReportController.php`** (198 lines)
  - `index()` - List sellers dengan laporan terbanyak
  - `detail($sellerId)` - View semua laporan untuk seller tertentu
  - `view($reportId)` - View detail single report
  - `dismiss($reportId)` - Reject report
  - `blacklist($sellerId)` - Blacklist seller
  - `removeBlacklist($sellerId)` - Restore seller dari blacklist
  - `export()` - Export reports ke CSV

**Seller Report Management**
- **`app/Http/Controllers/SellerReportController.php`** (52 lines)
  - `index()` - List semua laporan tentang seller tersebut
  - `show($reportId)` - View detail laporan
  - `respond(Request $request, $reportId)` - Submit response to report

**Product Report Submission**
- **`app/Http/Controllers/ProductReportController.php`** (72 lines)
  - `store(Request $request)` - Submit report untuk produk
  - `check($productId)` - Check apakah user sudah report produk ini

### Views

**Admin Pages**
- **`resources/views/admin/reports/index.blade.php`** (417 lines)
  - Dashboard dengan 4 stat cards (Total Reports, Pending, Responded, Blacklisted Sellers)
  - Tabel sellers dengan laporan terbanyak, diurutkan dari ranking tertinggi
  - Status indicator untuk active/blacklist
  - Risk level indicator (Sangat Tinggi, Tinggi, Sedang, Rendah)
  - Export CSV button
  - Dark theme styling

- **`resources/views/admin/reports/detail.blade.php`** (485 lines)
  - Header dengan info seller (photo, name, email)
  - Status alert (Active/Blacklisted)
  - 3 stat cards (Total Reports, Pending, Responded)
  - Tabel laporan untuk seller dengan columns: Pembeli, Produk, Alasan, Status, Tanggal, Aksi
  - Detail modal untuk setiap laporan
  - Blacklist/Remove Blacklist modals dengan form
  - Dark theme styling

**Seller Pages**
- **`resources/views/seller/reports/index.blade.php`** (486 lines)
  - Header: "Laporan tentang Saya"
  - 3 stat cards (Total Reports, Menunggu, Sudah Direspons)
  - Tabel laporan dengan columns: Pembeli, Produk, Alasan, Status, Tanggal, Aksi
  - Detail modal untuk setiap laporan
  - Response modal dengan textarea untuk respons
  - Dark theme styling
  - Seller hanya bisa lihat laporan tentang mereka sendiri

**Product Page**
- Modified **`resources/views/products/show.blade.php`**
  - Added "Report Product" button next to "Add to Cart"
  - Report modal dengan form (reason dropdown + description textarea)
  - Validation: min 10 char, max 500 char untuk description
  - Warning message tentang laporan palsu

---

## 🔄 Alur Sistem Report

### 1️⃣ Pembeli Melaporkan Produk
```
User lihat detail produk
  ↓
Klik "Report Product" button
  ↓
Form modal: pilih alasan + tulis deskripsi
  ↓
Submit → POST /product/{product}/report
  ↓
Validasi (tidak boleh report produk yang sama 2x secara aktif)
  ↓
Create report dengan status "pending"
  ↓
Notifikasi ke Seller: "Laporan Produk Baru"
```

### 2️⃣ Seller Menerima & Merespons Laporan
```
Seller dapat notifikasi
  ↓
Kunjungi Menu "Laporan Saya"
  ↓
Lihat daftar laporan (menunggu respons)
  ↓
Klik detail laporan
  ↓
Klik "Respons" button
  ↓
Submit respons/penjelasan
  ↓
Status laporan berubah: pending → responded
```

### 3️⃣ Admin Meninjau & Mengambil Tindakan
```
Admin kunjungi Menu "Laporan"
  ↓
Lihat sellers dengan laporan terbanyak (ranked)
  ↓
Klik seller untuk lihat detail laporan
  ↓
Option A: "Tolak Laporan" (dismiss single report)
  ↓ Option B: "Blacklist Seller" (blacklist semua)
  ↓
Jika dismiss → Notifikasi ke seller "Laporan Ditolak"
  ↓
Jika blacklist → Notifikasi ke seller "Akun Dinonaktifkan"
  ↓
Seller status: is_blacklisted = TRUE
  ↓
Seller tidak bisa berjualan lagi
```

### 4️⃣ Admin Menghapus Blacklist
```
Admin klik "Hapus Blacklist"
  ↓
Confirm dialog
  ↓
Seller status: is_blacklisted = FALSE
  ↓
Seller dapat berjualan kembali
  ↓
Notifikasi ke seller: "Akun Diaktifkan Kembali"
```

---

## 📊 Routes

### Public Report Routes (Auth Required)
```
POST   /product/{product}/report           → ProductReportController@store
GET    /product/{product}/report-check     → ProductReportController@check
```

### Admin Report Routes (Middleware: auth, admin)
```
GET    /admin/reports                      → Admin\ReportController@index
GET    /admin/reports/seller/{seller}      → Admin\ReportController@detail
GET    /admin/reports/{report}             → Admin\ReportController@view
POST   /admin/reports/{report}/dismiss     → Admin\ReportController@dismiss
POST   /admin/reports/seller/{seller}/blacklist          → Admin\ReportController@blacklist
POST   /admin/reports/seller/{seller}/remove-blacklist   → Admin\ReportController@removeBlacklist
GET    /admin/reports/export               → Admin\ReportController@export
```

### Seller Report Routes (Middleware: auth, seller)
```
GET    /seller/reports                     → SellerReportController@index
GET    /seller/reports/{report}            → SellerReportController@show
POST   /seller/reports/{report}/respond    → SellerReportController@respond
```

---

## 🎨 UI/UX Features

### Admin Report Dashboard
- **Stat Cards**: Total Reports, Pending, Responded, Blacklisted Sellers (color-coded)
- **Risk Level Indicators**: 
  - Sangat Tinggi (≥10 reports) - Red
  - Tinggi (≥5 reports) - Orange
  - Sedang (≥3 reports) - Cyan
  - Rendah (<3 reports) - Green
- **Table Sorting**: Sellers diurutkan dari yang paling bermasalah
- **Status Badges**: Active/Blacklist dengan icons
- **Action Buttons**: View seller reports
- **Export**: CSV download untuk semua reports

### Seller Report View
- **Status Stats**: Menunggu, Direspons, Total
- **Report List**: Dengan pagination
- **Detail Modal**: Lihat lengkap laporan pembeli
- **Response Modal**: Form untuk respond ke laporan
- **Visual Indicators**: Pending/Responded/Resolved badges

### Product Page Report
- **Report Button**: Next to "Add to Cart"
- **Report Modal**: 
  - Reason dropdown (5 options)
  - Description textarea (10-500 chars)
  - Validation message
  - Warning tentang laporan palsu
- **Disabled for Sellers**: Seller tidak bisa report produk sendiri

### Sidebar Menu
- **Admin**: Menu "Laporan" dengan icon exclamation-circle
- **Seller**: Menu "Laporan Saya" dengan icon bell
- Active state indicator untuk current page

---

## 🔐 Security & Validation

### Input Validation
- Product Report:
  - reason: required, in (poor_quality, fake_product, unsafe, inappropriate, other)
  - description: required, string, min:10, max:500
- Seller Response:
  - response: required, string, min:10, max:1000
- Admin Blacklist:
  - reason: optional text field
  
### Authorization
- User hanya bisa report produk seller lain (tidak seller sendiri)
- User tidak boleh report produk yang sama 2x secara aktif
- Seller hanya bisa lihat laporan tentang mereka sendiri
- Admin middleware untuk semua admin routes
- Seller middleware untuk semua seller routes

### Preventing Abuse
- Warning message di report modal
- One active report per user per product (checked via DB query)
- Description field min length requirement
- Admin dapat dismiss laporan yang tidak valid

---

## 🔔 Notification System

### Report Submitted
- **Recipient**: Seller
- **Title**: "Laporan Produk Baru"
- **Message**: "Produk "[nama]" anda telah dilaporkan oleh pembeli. Silakan cek akun anda."
- **Type**: report_received

### Report Dismissed
- **Recipient**: Seller
- **Title**: "Laporan Ditolak"
- **Message**: "Laporan tentang produk anda dari [pembeli] telah ditinjau dan ditolak oleh admin."
- **Type**: report_dismissed

### Seller Blacklisted
- **Recipient**: Seller
- **Title**: "Akun Dinonaktifkan"
- **Message**: "Akun seller anda telah dinonaktifkan karena banyaknya laporan dari pembeli. Alasan: [reason]"
- **Type**: account_suspended

### Blacklist Removed
- **Recipient**: Seller
- **Title**: "Akun Diaktifkan Kembali"
- **Message**: "Akun seller anda telah diaktifkan kembali oleh admin. Anda dapat berjualan kembali."
- **Type**: account_activated

---

## 🎯 Admin Workflow

### Melihat Dashboard Reports
1. Sidebar → Laporan
2. Lihat 4 stat cards dengan overview
3. Tabel sellers diurutkan dari paling banyak reports
4. Risk level indicator menunjukkan severity

### Membuka Detail Seller
1. Klik tombol "Lihat" di row seller
2. Lihat semua laporan untuk seller tersebut
3. Setiap laporan dalam collapsible cards

### Membaca Laporan
1. Klik detail laporan
2. Modal menampilkan:
   - Pembeli info
   - Produk
   - Alasan
   - Deskripsi
   - Respons seller (jika ada)
3. Options: "Tolak Laporan" atau close

### Blacklist Seller
1. Klik "Blacklist Seller"
2. Modal confirmation dengan field alasan
3. Confirm → Seller diblacklist
4. Status berubah ke "Blacklist"

### Remove Blacklist
1. Klik "Hapus Blacklist"
2. Modal confirmation
3. Confirm → Seller diaktifkan kembali
4. Status kembali ke "Aktif"

### Export Reports
1. Klik tombol "Export CSV"
2. Optional filters (seller_id, status)
3. Download CSV dengan columns: Report ID, Reporter, Seller, Product, Reason, Status, Action, Date

---

## 🛠️ Implementation Checklist

- ✅ Database table `reports` created dengan semua fields
- ✅ Kolom `is_blacklisted`, `suspended_reason`, `suspended_at` ditambah ke users
- ✅ Report model dengan relationships dan scopes
- ✅ User model updated dengan report relationships
- ✅ Admin ReportController (6 methods)
- ✅ SellerReportController (3 methods)
- ✅ ProductReportController (2 methods)
- ✅ Admin report views (index + detail) dengan dark theme
- ✅ Seller report views dengan response functionality
- ✅ Product detail page updated dengan report button
- ✅ Report modal dengan validation
- ✅ Routes configured (3 group: public, admin, seller)
- ✅ Sidebar updated (admin + seller menu links)
- ✅ Notification system integrated
- ✅ Validation & authorization implemented
- ✅ CSV export functionality

---

## 📝 Testing Checklist

- [ ] User dapat submit report dari product detail page
- [ ] Validation works (description min 10 chars, max 500)
- [ ] User tidak bisa report produk seller sendiri
- [ ] User tidak bisa report same product 2x
- [ ] Seller dapat lihat laporan di "Laporan Saya"
- [ ] Seller dapat submit response ke laporan
- [ ] Admin dapat lihat report dashboard
- [ ] Admin dapat view detail seller reports
- [ ] Admin dapat dismiss single report
- [ ] Admin dapat blacklist seller
- [ ] Admin dapat remove blacklist
- [ ] Notifications terkirim dengan benar
- [ ] CSV export works
- [ ] Dark theme render correctly di semua pages
- [ ] Responsive design di mobile/tablet

---

## 🚀 Future Enhancements

- [ ] Appeal system: Seller bisa appeal blacklist dengan form
- [ ] Report categories statistics: Chart untuk reason breakdown
- [ ] Automated blacklist: Auto-blacklist setelah N reports
- [ ] Report evidence: Upload file/screenshot sebagai bukti
- [ ] Response deadline: Seller harus respond dalam X days
- [ ] Rating impact: Reports affect seller rating score
- [ ] Warning system: Warning sebelum blacklist
- [ ] Report reason templates: Canned responses untuk efficiency
- [ ] Batch actions: Admin bisa dismiss multiple reports
- [ ] Report history: Lihat historical reports even after resolved

---

## 📞 Support Notes

- Pastikan JavaScript (Bootstrap modals) enabled di browser
- Report system menggunakan soft delete untuk audit trail
- All timestamps dalam timezone server
- CSV export tidak include soft-deleted records
- Notifications menggunakan database notifications (dapat dilihat di notification bell)

