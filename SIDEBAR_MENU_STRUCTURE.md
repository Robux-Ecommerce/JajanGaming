# 📋 Sidebar Menu Structure - JajanGaming

## 🎯 Overview
Setiap halaman menu utama kini dilengkapi dengan sidebar navigasi yang konsisten, responsif, dan modern.

---

## 📱 Menu Sections

### 1️⃣ Admin Panel (Only for Admins)
**Visible on:** Products, Orders, Users, Transactions pages
```
📦 Products
  ├─ Manage all products
  ├─ View inventory
  ├─ Badge: None
  └─ Icon: fas fa-box-open

🛍️ Orders
  ├─ Manage all orders
  ├─ Track shipments
  ├─ Badge: None
  └─ Icon: fas fa-shopping-bag

👥 Users
  ├─ Manage users
  ├─ View permissions
  ├─ Badge: None
  └─ Icon: fas fa-users

💱 Transactions
  ├─ All payment records
  ├─ Transaction history
  ├─ Badge: None
  └─ Icon: fas fa-exchange-alt
```

### 2️⃣ My Account (User Account Features)
**Visible on:** All authenticated user pages
```
💰 My Wallet
  ├─ View balance
  ├─ Transaction history
  ├─ Badge: Rp {balance} (formatted with comma)
  └─ Icon: fas fa-wallet

💳 Top Up
  ├─ Purchase Robux
  ├─ Multiple payment methods
  ├─ Badge: None
  └─ Icon: fas fa-credit-card

👤 Profile
  ├─ Edit profile info
  ├─ Change password
  ├─ Badge: None
  └─ Icon: fas fa-user-circle
```

### 3️⃣ Shopping
**Visible on:** All pages
```
🛒 Cart
  ├─ View shopping cart
  ├─ Manage items
  ├─ Badge: {count} (items in cart)
  └─ Icon: fas fa-shopping-cart

🏪 Browse Products
  ├─ View all products
  ├─ Search & filter
  ├─ Badge: None
  └─ Icon: fas fa-store
```

### 4️⃣ Activity
**Visible on:** All authenticated pages
```
🔔 Notifications
  ├─ Order updates
  ├─ Payment confirmations
  ├─ Badge: {unread_count} (red badge)
  └─ Icon: fas fa-bell
```

---

## 🎨 Active Menu Indicator

Ketika user berada di halaman tertentu, menu item akan menunjukkan state "active":

### Visual Indicators:
```
┌─────────────────────────────────────┐
│ █ Active Menu Item                  │  ← Left border 3px #64b5c6
│   Background: gradient teal          │
│   Icon color: #64b5c6                │
│   Text color: #ffffff (bold)         │
│   Chevron: visible                   │
└─────────────────────────────────────┘

Inactive:
┌─────────────────────────────────────┐
│   Inactive Menu Item                 │
│   Background: transparent             │
│   Icon color: rgba(100,160,180,0.7) │
│   Text color: rgba(255,255,255,0.65)│
│   Chevron: visible                   │
└─────────────────────────────────────┘
```

---

## 🏷️ Badge System

### Cart Badge
- **Show**: When cart has items
- **Value**: Item count (number)
- **Position**: Right side of menu text
- **Style**: `badge` class with teal background
- **Example**: `🛒 Cart 3`

### Wallet Badge
- **Show**: Always visible
- **Value**: User wallet balance (formatted Rp)
- **Position**: Right side of menu text
- **Style**: `badge` class with teal background
- **Example**: `💰 My Wallet Rp 500.000`

### Notification Badge
- **Show**: When has unread notifications
- **Value**: Unread count (number)
- **Position**: Right side of menu text
- **Style**: `badge` class with red background (notification style)
- **Example**: `🔔 Notifications 2`

---

## 🎯 Current Page Detection

Sidebar menggunakan `request()->routeIs()` untuk mendeteksi halaman aktif:

```php
// Products Page
{{ request()->routeIs('admin.products.index') ? 'active' : '' }}

// Orders Page
{{ request()->routeIs('admin.orders.index') ? 'active' : '' }}

// Users Page
{{ request()->routeIs('admin.users.index') ? 'active' : '' }}

// Transactions Page
{{ request()->routeIs('admin.transactions.index') ? 'active' : '' }}

// Wallet Page
{{ request()->routeIs('wallet.index') ? 'active' : '' }}

// Top Up Page
{{ request()->routeIs('topup') ? 'active' : '' }}

// Profile Page
{{ request()->routeIs('profile.index') ? 'active' : '' }}

// Notifications Page
{{ request()->routeIs('notifications.index') ? 'active' : '' }}

// Cart Page
{{ request()->routeIs('cart.index') ? 'active' : '' }}

// Home Page
{{ request()->routeIs('home') ? 'active' : '' }}
```

---

## 📐 Sidebar Dimensions

### Desktop (1024px+)
- **Width**: 240px
- **Height**: calc(100vh - 80px) = Full viewport height minus navbar
- **Position**: Sticky (follows scroll)
- **Display**: Always visible (inline with content)

### Tablet (768px - 1024px)
- **Width**: 240px
- **Height**: calc(100vh - 70px)
- **Position**: Sticky
- **Display**: Always visible

### Mobile (<768px)
- **Width**: 280px or 100%
- **Height**: 100vh (full screen)
- **Position**: Fixed (from left: -280px)
- **Display**: Toggleable (hidden by default)
- **Animation**: Slide from left (transition: left 0.3s ease)

---

## 🔄 Mobile Sidebar Behavior

### Toggle Behavior
```
Initial State: HIDDEN
├─ Position: left: -280px
├─ Opacity: Not visible
└─ Z-index: 998 (below modals)

Click Hamburger Button:
├─ Position: left: 0
├─ Opacity: Visible with backdrop
├─ Animation: Slide in 0.3s ease
└─ Backdrop: Dark overlay for UX

Click Menu Item / Backdrop / Close Button / Esc Key:
├─ Position: left: -280px
├─ Animation: Slide out 0.3s ease
└─ Close: Automatic
```

### Close Methods
1. **Close Button** (X icon di header)
2. **Menu Item Click** (Auto-close on navigation)
3. **Backdrop Click** (Click outside sidebar)
4. **ESC Key** (Keyboard shortcut)

---

## 🔑 Key Route Names

```php
// Admin Routes
route('admin.products.index')
route('admin.orders.index')
route('admin.users.index')
route('admin.transactions.index')
route('admin.dashboard')

// User Routes
route('wallet.index')
route('topup')
route('admin.profile.index')

// Shopping Routes
route('cart.index')
route('home')

// Notification Routes
route('notifications.index')
```

---

## 💻 Integration Example

```blade
@extends('layouts.app')

@section('title', 'Page Title - JajanGaming')

@section('content')
<!-- Page Container with Sidebar -->
<div style="display: flex; min-height: calc(100vh - 80px);">
    <!-- Page Sidebar Component -->
    <x-page-sidebar :sidebarTitle="'Page Name'" />
    
    <!-- Main Content Area -->
    <div style="flex: 1; overflow-y: auto;">
        <!-- Your page content here -->
        <div class="container-fluid px-4">
            <!-- Content -->
        </div>
    </div>
</div>
@endsection
```

---

## 🎨 Color Scheme

### Sidebar Colors
```css
Background:
  Primary: rgba(30, 42, 56, 0.95)    /* Dark blue-gray */
  Darker:  rgba(25, 35, 48, 0.95)    /* Even darker */
  
Accents:
  Primary Color: #64b5c6             /* Soft Teal */
  Primary Light: #7ab8c8             /* Lighter Teal */
  
Text:
  Main: #ffffff                       /* White */
  Muted: rgba(255, 255, 255, 0.65)  /* Gray */
  Dimmed: rgba(255, 255, 255, 0.4)  /* Dark Gray */
  
Borders:
  Default: rgba(100, 160, 180, 0.15) /* Subtle Teal */
  Active: rgba(100, 160, 180, 0.5)   /* Strong Teal */

Badges:
  Teal: rgba(100, 160, 180, 0.2)     /* Teal background */
  Red: rgba(231, 76, 60, 0.3)        /* Red for notifications */
```

---

## ⚙️ Customization

### Change Sidebar Width
```php
// In page-sidebar.blade.php CSS
.page-sidebar {
    width: 300px; /* Change from 280px */
}
```

### Change Active Color
```php
// Change all #64b5c6 to your color
// Example: Change to #4a9eb0
```

### Add Custom Badge
```blade
<li class="menu-item">
    <a href="{{ route('example.index') }}" class="menu-link">
        <i class="fas fa-example"></i>
        <span>Example</span>
        <span class="menu-badge">{{ $count }}</span>
    </a>
</li>
```

---

## 📝 Section Labels

Sidebar sections memiliki labels yang jelas:

```
ADMIN PANEL          (hanya untuk admin)
MY ACCOUNT          (untuk semua user terlogin)
SHOPPING            (untuk semua user)
ACTIVITY            (untuk semua user terlogin)
```

Labels styling:
- **Font Size**: 0.7rem
- **Weight**: 700 (Bold)
- **Transform**: uppercase
- **Letter Spacing**: 0.5px
- **Color**: rgba(100, 160, 180, 0.6)
- **Margin Bottom**: 0.5rem

---

## 🚀 Performance Notes

✅ **CSS-only animations** (no heavy JS)
✅ **GPU accelerated** (transforms & opacity)
✅ **Minimal reflow** (flexbox layout)
✅ **Custom scrollbar** (lightweight)
✅ **No external dependencies** (vanilla JS)
✅ **Mobile optimized** (touch-friendly)

---

## 📱 Tested On

✅ Desktop (Chrome, Firefox, Edge, Safari)
✅ Tablet (iPad Air, iPad Pro)
✅ Mobile (iPhone, Android)
✅ Responsive breakpoints (320px, 480px, 768px, 1024px, 1200px)

---

**Last Updated**: December 17, 2025
**Status**: ✅ PRODUCTION READY
