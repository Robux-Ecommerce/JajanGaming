# JajanGaming - E-commerce Top Up Game Online

Sistem e-commerce untuk top up game online dengan fitur dompet internal dan payment gateway.

## Fitur Utama

### 🔐 Authentication
- **Register & Login** - Sistem registrasi dan login user
- **User Management** - Manajemen profil user dengan wallet balance

### 🛒 E-commerce Features
- **Product Catalog** - Katalog produk game top up dengan search dan filter
- **Shopping Cart** - Keranjang belanja dengan CRUD operations
- **Order Management** - Sistem pesanan dengan status tracking
- **Product Detail** - Halaman detail produk dengan informasi lengkap

### 💰 Payment System
- **DompetKu (Internal Wallet)** - Dompet internal untuk menyimpan saldo
- **Wallet Top Up** - Top up saldo melalui payment gateway
- **Dual Payment Options**:
  - Pembayaran menggunakan saldo dompet internal
  - Pembayaran langsung melalui payment gateway
- **Transaction History** - Riwayat transaksi lengkap

### 🎮 Game Support
- Mobile Legends (Diamond)
- Free Fire (Diamond)
- PUBG Mobile (UC)
- Genshin Impact (Genesis Crystal)

## Teknologi yang Digunakan

- **Backend**: Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Font Awesome
- **Authentication**: Laravel Auth
- **File Storage**: Laravel Storage

## Instalasi

### Prerequisites
- PHP 8.2+
- Composer
- MySQL
- Node.js & NPM

### Setup

1. **Clone Repository**
```bash
git clone <repository-url>
cd jajangaming
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Configuration**
Update `.env` file dengan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jajangaming
DB_USERNAME=root
DB_PASSWORD=
```

5. **Run Migrations & Seeders**
```bash
php artisan migrate
php artisan db:seed
```

6. **Create Storage Link**
```bash
php artisan storage:link
```

7. **Build Assets**
```bash
npm run build
```

8. **Start Server**
```bash
php artisan serve
```

## Default Accounts

### Admin Account
- **Email**: admin@jajangaming.com
- **Password**: admin123
- **Access**: Admin panel untuk manage products

### Test User
Buat akun baru melalui halaman register untuk testing fitur user.

## Struktur Database

### Tables
- `users` - Data user dengan wallet_balance
- `products` - Katalog produk game top up
- `carts` - Keranjang belanja user
- `orders` - Data pesanan
- `order_items` - Item dalam pesanan
- `wallets` - Data wallet user (optional, menggunakan wallet_balance di users)
- `transactions` - Riwayat transaksi

### Relationships
- User hasMany Carts, Orders, Transactions
- User hasOne Wallet
- Product hasMany Carts, OrderItems
- Order belongsTo User, hasMany OrderItems, Transactions
- Cart belongsTo User, Product
- Transaction belongsTo User, Order

## API Endpoints

### Public Routes
- `GET /` - Home page dengan product listing
- `GET /product/{product}` - Product detail
- `GET /register` - Registration form
- `POST /register` - User registration
- `GET /login` - Login form
- `POST /login` - User login

### Protected Routes (Auth Required)
- `GET /cart` - Shopping cart
- `POST /cart/add` - Add to cart
- `PUT /cart/{cart}` - Update cart item
- `DELETE /cart/{cart}` - Remove cart item
- `GET /orders` - Order history
- `GET /orders/{order}` - Order detail
- `POST /checkout` - Process checkout
- `GET /wallet` - Wallet management
- `POST /wallet/topup` - Wallet top up

### Payment Routes
- `GET /payment/process/{order}` - Payment processing
- `GET /payment/topup/{transaction}` - Wallet top up payment
- `POST /payment/success` - Simulate successful payment
- `POST /payment/failed` - Simulate failed payment
- `POST /payment/callback` - Payment gateway callback

### Admin Routes
- `GET /admin/products` - Product management
- `POST /admin/products` - Create product
- `PUT /admin/products/{product}` - Update product
- `DELETE /admin/products/{product}` - Delete product

## Payment Gateway Integration

Sistem ini menggunakan simulasi payment gateway untuk demo. Untuk implementasi real:

1. **Integrate dengan Payment Gateway** (Midtrans, Xendit, dll)
2. **Update PaymentController** untuk handle real payment
3. **Implement webhook/callback** untuk update status transaksi
4. **Add payment method selection** (Bank Transfer, E-wallet, dll)

### Payment Flow

#### DompetKu Payment
1. User memilih "DompetKu" sebagai payment method
2. System check wallet balance
3. Jika cukup, deduct dari wallet balance
4. Update order status ke "completed"
5. Clear cart

#### Payment Gateway
1. User memilih "Payment Gateway"
2. Redirect ke payment gateway
3. User complete payment
4. Payment gateway callback ke system
5. Update transaction dan order status

## Features Detail

### Search & Filter
- Search produk berdasarkan nama, game, atau deskripsi
- Filter berdasarkan game
- Pagination untuk performa

### Cart Management
- Add/remove products
- Update quantity
- Clear entire cart
- Real-time total calculation

### Order Management
- Order tracking dengan status
- Order history
- Order detail dengan items
- Payment method tracking

### Wallet System
- Internal wallet balance
- Top up melalui payment gateway
- Transaction history
- Balance validation

## Security Features

- **Authentication** - Laravel Auth dengan session
- **Authorization** - Middleware untuk protect routes
- **CSRF Protection** - Laravel CSRF tokens
- **Input Validation** - Request validation
- **SQL Injection Protection** - Eloquent ORM
- **XSS Protection** - Blade templating

## Development

### Code Structure
```
app/
├── Http/Controllers/     # Controllers
├── Models/              # Eloquent Models
├── Http/Middleware/     # Custom Middleware
database/
├── migrations/          # Database migrations
├── seeders/            # Database seeders
resources/
├── views/              # Blade templates
├── css/                # Stylesheets
├── js/                 # JavaScript
routes/
├── web.php             # Web routes
```

### Adding New Games
1. Add products melalui admin panel
2. Update seeder untuk game baru
3. Update filter options di home page

### Customization
- Update `resources/views/layouts/app.blade.php` untuk styling
- Modify controllers untuk business logic
- Add new routes sesuai kebutuhan

## Troubleshooting

### Common Issues

1. **Storage Link Error**
```bash
php artisan storage:link
```

2. **Permission Issues**
```bash
chmod -R 755 storage bootstrap/cache
```

3. **Database Connection**
- Check `.env` database configuration
- Ensure MySQL service is running

4. **Composer Issues**
```bash
composer install --no-dev --optimize-autoloader
```

## Contributing

1. Fork repository
2. Create feature branch
3. Commit changes
4. Push to branch
5. Create Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

Untuk support dan pertanyaan, silakan buat issue di repository ini.