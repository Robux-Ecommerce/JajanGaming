@extends('layouts.app')

@section('title', 'Notifications')

@section('content')<!-- Page Container with Sidebar -->
<div style="display: flex; min-height: calc(100vh - 80px);">
    @include('partials.sidebar', ['sidebarTitle' => 'Notifications'])
    
    <!-- Main Content -->
    <div style="flex: 1; overflow-y: auto;"><div class="notifications-page">
    <!-- Header Section -->
    <div class="notifications-header">
        <div class="header-content">
            <div class="header-icon">
                <i class="fas fa-bell"></i>
                @if($notifications->where('is_read', false)->count() > 0)
                    <span class="unread-indicator"></span>
                @endif
            </div>
            <div class="header-text">
                <h1>Notifications</h1>
                <p>Stay updated with your orders and activities</p>
            </div>
        </div>
        @if($notifications->count() > 0)
            <button class="btn-mark-all" onclick="markAllAsRead()">
                <i class="fas fa-check-double"></i>
                <span>Mark All Read</span>
            </button>
        @endif
    </div>

    <!-- Stats Summary -->
    <div class="notification-stats">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="fas fa-inbox"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $notifications->total() }}</span>
                <span class="stat-label">Total</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon unread">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value" id="unreadCount">{{ $notifications->where('is_read', false)->count() }}</span>
                <span class="stat-label">Unread</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orders">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $notifications->where('type', 'order')->count() }}</span>
                <span class="stat-label">Orders</span>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon wallet">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="stat-info">
                <span class="stat-value">{{ $notifications->where('type', 'wallet')->count() }}</span>
                <span class="stat-label">Wallet</span>
            </div>
        </div>
    </div>

    <!-- Notifications List -->
    @if($notifications->count() > 0)
        <div class="notifications-list">
            @foreach($notifications as $notification)
                <div class="notification-card {{ $notification->is_read ? 'read' : 'unread' }}" 
                     data-notification-id="{{ $notification->id }}">
                    
                    <!-- Notification Icon -->
                    <div class="notification-icon {{ $notification->type }}">
                        @if($notification->type === 'order')
                            <i class="fas fa-shopping-cart"></i>
                        @elseif($notification->type === 'payment')
                            <i class="fas fa-credit-card"></i>
                        @elseif($notification->type === 'product')
                            <i class="fas fa-cube"></i>
                        @elseif($notification->type === 'wallet')
                            <i class="fas fa-wallet"></i>
                        @elseif($notification->type === 'rating')
                            <i class="fas fa-star"></i>
                        @else
                            <i class="fas fa-bell"></i>
                        @endif
                    </div>

                    <!-- Notification Content -->
                    <div class="notification-content">
                        <div class="notification-main">
                            <h4 class="notification-title">
                                {{ $notification->title }}
                                @if(!$notification->is_read)
                                    <span class="new-badge">NEW</span>
                                @endif
                            </h4>
                            <p class="notification-message">{{ $notification->message }}</p>
                            
                            <!-- Meta Info -->
                            <div class="notification-meta">
                                <span class="notification-time">
                                    <i class="fas fa-clock"></i>
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                @if($notification->order)
                                    <span class="notification-order">
                                        <i class="fas fa-hashtag"></i>
                                        Order #{{ $notification->order->id }}
                                    </span>
                                @endif
                                <span class="notification-type-badge {{ $notification->type }}">
                                    {{ ucfirst($notification->type) }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="notification-actions">
                            @if(!$notification->is_read)
                                <button class="btn-action mark-read" 
                                        onclick="markAsRead({{ $notification->id }})"
                                        title="Mark as Read">
                                    <i class="fas fa-check"></i>
                                </button>
                            @endif
                            @if($notification->order)
                                @if(auth()->user()->isAdminOrSeller())
                                    <a href="{{ route('admin.orders.show', $notification->order->id) }}" 
                                       class="btn-action view-order"
                                       title="View Order">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @else
                                    <a href="{{ route('orders.show', $notification->order->id) }}" 
                                       class="btn-action view-order"
                                       title="View Order">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="notifications-pagination">
            {{ $notifications->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-bell-slash"></i>
            </div>
            <h3>No Notifications Yet</h3>
            <p>When you receive notifications about orders, payments, or other activities, they'll appear here.</p>
            <a href="{{ route('home') }}" class="btn-browse">
                <i class="fas fa-home"></i>
                Back to Home
            </a>
        </div>
    @endif
</div>

<style>
/* ===================================================================
   NOTIFICATIONS PAGE - Soft Teal Gaming Theme
=================================================================== */
.notifications-page {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

/* Header Section */
.notifications-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: linear-gradient(135deg, rgba(30, 42, 56, 0.95) 0%, rgba(25, 35, 48, 0.9) 100%);
    border-radius: 16px;
    border: 1px solid rgba(100, 160, 180, 0.15);
}

.header-content {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.header-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.2) 0%, rgba(100, 160, 180, 0.1) 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.header-icon i {
    font-size: 1.5rem;
    color: #64b5c6;
}

.header-icon .unread-indicator {
    position: absolute;
    top: 8px;
    right: 8px;
    width: 12px;
    height: 12px;
    background: #e74c3c;
    border-radius: 50%;
    border: 2px solid #1e2a38;
    animation: pulse 2s infinite;
}

.header-text h1 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 0.25rem 0;
}

.header-text p {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.6);
    margin: 0;
}

.btn-mark-all {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.2rem;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.15) 0%, rgba(100, 160, 180, 0.08) 100%);
    border: 1px solid rgba(100, 160, 180, 0.3);
    border-radius: 10px;
    color: #a8e0eb;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-mark-all:hover {
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.25) 0%, rgba(100, 160, 180, 0.15) 100%);
    border-color: rgba(100, 160, 180, 0.5);
    transform: translateY(-2px);
}

/* Stats Summary */
.notification-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: linear-gradient(135deg, rgba(30, 42, 56, 0.8) 0%, rgba(25, 35, 48, 0.7) 100%);
    border-radius: 12px;
    border: 1px solid rgba(100, 160, 180, 0.1);
    transition: all 0.3s ease;
}

.stat-card:hover {
    border-color: rgba(100, 160, 180, 0.25);
    transform: translateY(-2px);
}

.stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
}

.stat-icon.total {
    background: rgba(100, 160, 180, 0.15);
    color: #64b5c6;
}

.stat-icon.unread {
    background: rgba(231, 76, 60, 0.15);
    color: #e74c3c;
}

.stat-icon.orders {
    background: rgba(46, 204, 113, 0.15);
    color: #2ecc71;
}

.stat-icon.wallet {
    background: rgba(241, 196, 15, 0.15);
    color: #f1c40f;
}

.stat-info {
    display: flex;
    flex-direction: column;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #ffffff;
    line-height: 1;
}

.stat-label {
    font-size: 0.75rem;
    color: rgba(255, 255, 255, 0.5);
    margin-top: 0.25rem;
}

/* Notifications List */
.notifications-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.notification-card {
    display: flex;
    gap: 1rem;
    padding: 1.25rem;
    background: linear-gradient(135deg, rgba(30, 42, 56, 0.9) 0%, rgba(25, 35, 48, 0.85) 100%);
    border-radius: 14px;
    border: 1px solid rgba(100, 160, 180, 0.1);
    transition: all 0.3s ease;
}

.notification-card:hover {
    border-color: rgba(100, 160, 180, 0.25);
    transform: translateX(4px);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.notification-card.unread {
    border-left: 3px solid #64b5c6;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.08) 0%, rgba(30, 42, 56, 0.9) 100%);
}

.notification-card.read {
    opacity: 0.75;
}

.notification-card.read:hover {
    opacity: 1;
}

/* Notification Icon */
.notification-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 1.1rem;
}

.notification-icon.order {
    background: linear-gradient(135deg, rgba(46, 204, 113, 0.2) 0%, rgba(46, 204, 113, 0.1) 100%);
    color: #2ecc71;
}

.notification-icon.payment {
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.2) 0%, rgba(52, 152, 219, 0.1) 100%);
    color: #3498db;
}

.notification-icon.product {
    background: linear-gradient(135deg, rgba(155, 89, 182, 0.2) 0%, rgba(155, 89, 182, 0.1) 100%);
    color: #9b59b6;
}

.notification-icon.wallet {
    background: linear-gradient(135deg, rgba(241, 196, 15, 0.2) 0%, rgba(241, 196, 15, 0.1) 100%);
    color: #f1c40f;
}

.notification-icon.rating {
    background: linear-gradient(135deg, rgba(243, 156, 18, 0.2) 0%, rgba(243, 156, 18, 0.1) 100%);
    color: #f39c12;
}

/* Notification Content */
.notification-content {
    flex: 1;
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    min-width: 0;
}

.notification-main {
    flex: 1;
    min-width: 0;
}

.notification-title {
    font-size: 1rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.new-badge {
    font-size: 0.6rem;
    font-weight: 700;
    background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
    color: #ffffff;
    padding: 0.2rem 0.5rem;
    border-radius: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.notification-message {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.7);
    margin: 0 0 0.75rem 0;
    line-height: 1.5;
}

/* Meta Info */
.notification-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
    align-items: center;
}

.notification-time,
.notification-order {
    font-size: 0.8rem;
    color: rgba(255, 255, 255, 0.5);
    display: flex;
    align-items: center;
    gap: 0.35rem;
}

.notification-time i,
.notification-order i {
    font-size: 0.7rem;
}

.notification-type-badge {
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.2rem 0.6rem;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.notification-type-badge.order {
    background: rgba(46, 204, 113, 0.15);
    color: #2ecc71;
}

.notification-type-badge.payment {
    background: rgba(52, 152, 219, 0.15);
    color: #3498db;
}

.notification-type-badge.product {
    background: rgba(155, 89, 182, 0.15);
    color: #9b59b6;
}

.notification-type-badge.wallet {
    background: rgba(241, 196, 15, 0.15);
    color: #f1c40f;
}

.notification-type-badge.rating {
    background: rgba(243, 156, 18, 0.15);
    color: #f39c12;
}

/* Actions */
.notification-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    flex-shrink: 0;
}

.btn-action {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-action.mark-read {
    background: rgba(46, 204, 113, 0.15);
    color: #2ecc71;
}

.btn-action.mark-read:hover {
    background: rgba(46, 204, 113, 0.25);
    transform: scale(1.1);
}

.btn-action.view-order {
    background: rgba(100, 160, 180, 0.15);
    color: #64b5c6;
}

.btn-action.view-order:hover {
    background: rgba(100, 160, 180, 0.25);
    transform: scale(1.1);
}

/* Pagination */
.notifications-pagination {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: linear-gradient(135deg, rgba(30, 42, 56, 0.9) 0%, rgba(25, 35, 48, 0.85) 100%);
    border-radius: 16px;
    border: 1px solid rgba(100, 160, 180, 0.1);
}

.empty-icon {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.1) 0%, rgba(100, 160, 180, 0.05) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}

.empty-icon i {
    font-size: 2.5rem;
    color: rgba(100, 160, 180, 0.5);
}

.empty-state h3 {
    font-size: 1.25rem;
    font-weight: 600;
    color: #ffffff;
    margin: 0 0 0.5rem 0;
}

.empty-state p {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.5);
    margin: 0 0 1.5rem 0;
    max-width: 400px;
    margin-left: auto;
    margin-right: auto;
}

.btn-browse {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    background: linear-gradient(135deg, rgba(100, 160, 180, 0.9) 0%, rgba(80, 140, 165, 0.9) 100%);
    color: #ffffff;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.9rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-browse:hover {
    background: linear-gradient(135deg, rgba(110, 170, 190, 0.95) 0%, rgba(90, 150, 175, 0.95) 100%);
    transform: translateY(-2px);
    color: #ffffff;
    text-decoration: none;
}

/* Responsive */
@media (max-width: 768px) {
    .notifications-page {
        padding: 1rem 0.75rem;
    }
    
    .notifications-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
    
    .header-content {
        flex-direction: column;
    }
    
    .notification-stats {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .notification-card {
        flex-direction: column;
    }
    
    .notification-icon {
        width: 40px;
        height: 40px;
    }
    
    .notification-content {
        flex-direction: column;
    }
    
    .notification-actions {
        flex-direction: row;
        justify-content: flex-end;
    }
}

@media (max-width: 480px) {
    .notification-stats {
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }
    
    .stat-card {
        padding: 0.75rem;
    }
    
    .stat-icon {
        width: 36px;
        height: 36px;
        font-size: 0.9rem;
    }
    
    .stat-value {
        font-size: 1.1rem;
    }
}

/* Animation */
@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.1); opacity: 0.8; }
}
</style>

<script>
function markAsRead(notificationId) {
    const card = document.querySelector(`[data-notification-id="${notificationId}"]`);
    const button = card.querySelector('.btn-action.mark-read');
    
    // Show loading state
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;
    
    fetch(`/notifications/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => {
        if (!response.ok) throw new Error('Failed to mark as read');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update card styling
            card.classList.remove('unread');
            card.classList.add('read');
            
            // Remove NEW badge
            const newBadge = card.querySelector('.new-badge');
            if (newBadge) newBadge.remove();
            
            // Hide the button
            button.style.display = 'none';
            
            // Update notification count in navbar
            if (typeof updateNotificationCount === 'function') {
                updateNotificationCount();
            }
            
            // Update stats
            updateStats();
            
            showToast('Notification marked as read', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        button.innerHTML = originalContent;
        button.disabled = false;
        showToast('Failed to mark notification as read', 'error');
    });
}

function markAllAsRead() {
    const btn = document.querySelector('.btn-mark-all');
    const originalContent = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    btn.disabled = true;
    
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => {
        if (!response.ok) throw new Error('Failed to mark all as read');
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update all cards
            document.querySelectorAll('.notification-card.unread').forEach(card => {
                card.classList.remove('unread');
                card.classList.add('read');
                
                const newBadge = card.querySelector('.new-badge');
                if (newBadge) newBadge.remove();
                
                const markReadBtn = card.querySelector('.btn-action.mark-read');
                if (markReadBtn) markReadBtn.style.display = 'none';
            });
            
            // Hide unread indicator
            const indicator = document.querySelector('.unread-indicator');
            if (indicator) indicator.style.display = 'none';
            
            // Update notification count
            if (typeof updateNotificationCount === 'function') {
                updateNotificationCount();
            }
            
            // Update stats
            updateStats();
            
            showToast('All notifications marked as read', 'success');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('Failed to mark all as read', 'error');
    })
    .finally(() => {
        btn.innerHTML = originalContent;
        btn.disabled = false;
    });
}

function updateStats() {
    const unreadCount = document.querySelectorAll('.notification-card.unread').length;
    const unreadStat = document.getElementById('unreadCount');
    if (unreadStat) unreadStat.textContent = unreadCount;
}

function showToast(message, type) {
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    toast.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
        <span>${message}</span>
    `;
    
    // Style the toast
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        padding: 1rem 1.5rem;
        background: ${type === 'success' ? 'linear-gradient(135deg, #2ecc71 0%, #27ae60 100%)' : 'linear-gradient(135deg, #e74c3c 0%, #c0392b 100%)'};
        color: white;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        z-index: 9999;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(toast);
    
    // Remove after 3 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Add animation keyframes
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(100%); opacity: 0; }
    }
`;
document.head.appendChild(style);
</script>
    </div>
</div>
@endsection
