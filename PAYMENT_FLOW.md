# 🔄 Alur Pembayaran JajanGaming - Sistem E-commerce Top Up Game

## 📋 Overview Sistem Pembayaran

Sistem ini mengimplementasikan dua metode pembayaran dengan logika yang berbeda:

### 1. 💰 **DompetKu (Internal Wallet)**
### 2. 🌐 **Payment Gateway (Online)**

---

## 🔄 **Alur Pembayaran DompetKu**

### **Step 1: User Memilih DompetKu**
- User memilih "DompetKu" sebagai payment method di cart
- Sistem melakukan validasi saldo wallet

### **Step 2: Validasi Saldo**
```php
if ($user->wallet_balance < $total) {
    // Redirect ke wallet page dengan pesan error
    return redirect()->route('wallet.index')
        ->with('error', 'Insufficient wallet balance! Please top up your wallet first.')
        ->with('required_amount', $total);
}
```

### **Step 3A: Jika Saldo Cukup**
1. ✅ **Buat Order** dengan status "pending"
2. ✅ **Kurangi Stok Produk** secara real-time
3. ✅ **Deduct Saldo Wallet** user
4. ✅ **Buat Transaction Record** dengan status "success"
5. ✅ **Update Order Status** ke "completed"
6. ✅ **Clear Cart** user
7. ✅ **Redirect** ke order detail dengan success message

### **Step 3B: Jika Saldo Tidak Cukup**
1. ❌ **Redirect ke Wallet Page** dengan pesan error
2. 💡 **Tampilkan Required Amount** untuk top up
3. 🔗 **Link Quick Top Up** dengan amount yang dibutuhkan
4. 🔙 **Tombol Back to Cart** untuk kembali

---

## 🌐 **Alur Pembayaran Gateway**

### **Step 1: User Memilih Payment Gateway**
- User memilih "Payment Gateway" sebagai payment method
- Sistem membuat order dengan status "pending"

### **Step 2: Proses Order**
1. ✅ **Buat Order** dengan status "pending"
2. ✅ **Kurangi Stok Produk** (reserved)
3. ✅ **Buat Transaction Record** dengan status "pending"
4. 🔄 **Redirect ke Payment Gateway**

### **Step 3: Payment Gateway Processing**
- User diarahkan ke halaman simulasi payment gateway
- User dapat memilih "Success" atau "Failed" untuk testing

### **Step 4A: Jika Payment Success**
1. ✅ **Update Transaction** status ke "success"
2. ✅ **Update Order Status** ke "completed"
3. ✅ **Clear Cart** user
4. ✅ **Redirect** ke order detail

### **Step 4B: Jika Payment Failed**
1. ❌ **Update Transaction** status ke "failed"
2. ❌ **Update Order Status** ke "cancelled"
3. 🔄 **Restore Stok Produk** (kembalikan stok)
4. ❌ **Redirect** dengan error message

---

## 🗄️ **Database Transactions & Stock Management**

### **DompetKu Payment (Immediate)**
```php
DB::beginTransaction();
try {
    // 1. Create order
    $order = Order::create([...]);
    
    // 2. Create order items & reduce stock
    foreach ($carts as $cart) {
        OrderItem::create([...]);
        $cart->product->decrement('quantity', $cart->quantity);
    }
    
    // 3. Deduct wallet balance
    $user->update(['wallet_balance' => $user->wallet_balance - $total]);
    
    // 4. Create successful transaction
    Transaction::create([
        'status' => 'success',
        'type' => 'purchase',
        'payment_method' => 'wallet'
    ]);
    
    // 5. Complete order
    $order->update(['status' => 'completed']);
    
    // 6. Clear cart
    Cart::where('user_id', Auth::id())->delete();
    
    DB::commit();
} catch (\Exception $e) {
    DB::rollback();
}
```

### **Payment Gateway (Deferred)**
```php
// Order Creation
DB::beginTransaction();
try {
    // 1. Create order
    $order = Order::create([...]);
    
    // 2. Create order items & reduce stock
    foreach ($carts as $cart) {
        OrderItem::create([...]);
        $cart->product->decrement('quantity', $cart->quantity);
    }
    
    // 3. Create pending transaction
    Transaction::create([
        'status' => 'pending',
        'type' => 'purchase',
        'payment_method' => 'gateway'
    ]);
    
    DB::commit();
    
    // 4. Redirect to payment gateway
    return redirect()->route('payment.process', $order->id);
} catch (\Exception $e) {
    DB::rollback();
}
```

### **Payment Callback Handling**
```php
// Success Callback
if ($status === 'success') {
    $transaction->update(['status' => 'success']);
    $transaction->order->update(['status' => 'completed']);
    Cart::where('user_id', $transaction->user_id)->delete();
}

// Failed Callback
if ($status === 'failed') {
    $transaction->update(['status' => 'failed']);
    $order = $transaction->order;
    $order->update(['status' => 'cancelled']);
    
    // Restore stock
    foreach ($order->orderItems as $item) {
        $item->product->increment('quantity', $item->quantity);
    }
}
```

---

## 🎯 **Key Features Implemented**

### ✅ **Stock Management**
- Real-time stock reduction saat order dibuat
- Stock restoration jika payment failed
- Stock validation sebelum checkout

### ✅ **Wallet Integration**
- Automatic wallet balance check
- Seamless redirect ke top up jika saldo kurang
- Required amount calculation dan display

### ✅ **Transaction Tracking**
- Complete transaction history
- Status tracking (pending, success, failed)
- Payment method differentiation

### ✅ **Error Handling**
- Database rollback pada error
- User-friendly error messages
- Graceful failure handling

### ✅ **User Experience**
- Clear payment method selection
- Real-time balance display
- Quick top up links
- Status notifications

---

## 🔧 **Testing Scenarios**

### **Scenario 1: DompetKu - Saldo Cukup**
1. Add products to cart
2. Select "DompetKu" payment
3. ✅ Order completed immediately
4. ✅ Wallet balance deducted
5. ✅ Stock reduced
6. ✅ Cart cleared

### **Scenario 2: DompetKu - Saldo Tidak Cukup**
1. Add products to cart
2. Select "DompetKu" payment
3. ❌ Redirect to wallet page
4. 💡 Show required amount
5. 🔗 Quick top up link

### **Scenario 3: Payment Gateway - Success**
1. Add products to cart
2. Select "Payment Gateway"
3. 🔄 Redirect to payment page
4. Click "Simulate Success"
5. ✅ Order completed
6. ✅ Stock reduced
7. ✅ Cart cleared

### **Scenario 4: Payment Gateway - Failed**
1. Add products to cart
2. Select "Payment Gateway"
3. 🔄 Redirect to payment page
4. Click "Simulate Failed"
5. ❌ Order cancelled
6. 🔄 Stock restored
7. ❌ Cart remains

---

## 🚀 **Ready to Use**

Sistem ini sudah siap digunakan dengan:
- ✅ Complete payment flow implementation
- ✅ Database transaction safety
- ✅ Stock management
- ✅ Error handling
- ✅ User-friendly interface
- ✅ Testing simulation

**Server berjalan di:** `http://localhost:8000`

**Admin Account:** admin@jajangaming.com / admin123
