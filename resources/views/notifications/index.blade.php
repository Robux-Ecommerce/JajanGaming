@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">
                    <i class="fas fa-bell me-2"></i>Notifications
                </h2>
                @if($notifications->count() > 0)
                    <button class="btn btn-outline-primary" onclick="markAllAsRead()">
                        <i class="fas fa-check-double me-1"></i>Mark All as Read
                    </button>
                @endif
            </div>

            @if($notifications->count() > 0)
                <div class="notifications-container">
                    @foreach($notifications as $notification)
                        <div class="notification-item">
                            <div class="card notification-card {{ $notification->is_read ? 'read' : 'unread' }}" 
                                 data-notification-id="{{ $notification->id }}">
                                <div class="card-body">
                                    <div class="notification-header">
                                        <div class="notification-icon">
                                            @if($notification->type === 'order')
                                                <i class="fas fa-shopping-cart"></i>
                                            @elseif($notification->type === 'payment')
                                                <i class="fas fa-credit-card"></i>
                                            @elseif($notification->type === 'product')
                                                <i class="fas fa-cube"></i>
                                            @elseif($notification->type === 'wallet')
                                                <i class="fas fa-wallet"></i>
                                            @else
                                                <i class="fas fa-bell"></i>
                                            @endif
                                        </div>
                                        <div class="notification-content">
                                            <h6 class="notification-title">
                                                {{ $notification->title }}
                                            </h6>
                                            <p class="notification-message">
                                                {{ $notification->message }}
                                            </p>
                                        </div>
                                        <div class="notification-actions">
                                            @if(!$notification->is_read)
                                                <button class="btn btn-sm btn-outline-primary" 
                                                        onclick="markAsRead({{ $notification->id }})"
                                                        title="Mark as Read">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            @if($notification->order)
                                                @if(auth()->user()->isAdminOrSeller())
                                                    <a href="{{ route('admin.orders.show', $notification->order->id) }}" 
                                                       class="btn btn-sm btn-primary"
                                                       title="View Order"
                                                       target="_blank"
                                                       onclick="console.log('Admin/Seller viewing order: {{ $notification->order->id }}')">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('orders.show', $notification->order->id) }}" 
                                                       class="btn btn-sm btn-primary"
                                                       title="View Order"
                                                       target="_blank"
                                                       onclick="console.log('User viewing order: {{ $notification->order->id }}')">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                    <div class="notification-footer">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>
                                        @if($notification->order)
                                            <small class="text-muted">
                                                <i class="fas fa-hashtag me-1"></i>
                                                Order #{{ $notification->order->id }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-bell-slash fa-4x text-muted"></i>
                    </div>
                    <h4 class="text-muted">No Notifications</h4>
                    <p class="text-muted">You don't have any notifications yet.</p>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-tachometer-alt me-1"></i>Go to Dashboard
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Container untuk semua notifikasi */
.notifications-container {
    display: flex;
    flex-direction: column;
    gap: 1.5rem; /* Spacing yang lebih proporsional */
    padding: 1rem 0;
}

/* Item notifikasi individual */
.notification-item {
    width: 100%;
}

/* Card notifikasi */
.notification-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.notification-card.unread {
    border-left: 4px solid #007bff;
    background: linear-gradient(135deg, rgba(0, 123, 255, 0.05) 0%, rgba(0, 123, 255, 0.02) 100%);
    box-shadow: 0 4px 20px rgba(0, 123, 255, 0.15);
}

.notification-card.read {
    opacity: 0.9;
    background: #f8f9fa;
    border-left: 4px solid #e9ecef;
}

.notification-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.12);
}

/* Card body dengan padding yang lebih proporsional */
.notification-card .card-body {
    padding: 1.5rem;
}

/* Header notifikasi */
.notification-header {
    display: flex;
    align-items: flex-start;
    gap: 1rem; /* Spacing yang lebih proporsional */
    margin-bottom: 1rem;
}

/* Icon notifikasi */
.notification-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
}

.notification-card.unread .notification-icon {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
}

.notification-card.read .notification-icon {
    background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
}

/* Content notifikasi */
.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-title {
    font-weight: 600;
    color: #2c3e50;
    font-size: 1.1rem;
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.notification-message {
    color: #5a6c7d;
    line-height: 1.6;
    font-size: 0.95rem;
    margin-bottom: 0;
}

/* Actions notifikasi */
.notification-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    align-items: flex-end;
    min-width: 80px;
}

.notification-actions .btn {
    width: 100%;
    border-radius: 8px;
    font-size: 0.85rem;
    padding: 0.4rem 0.8rem;
    font-weight: 500;
}

.notification-actions .btn-sm {
    padding: 0.3rem 0.6rem;
    font-size: 0.8rem;
}

/* Footer notifikasi */
.notification-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1rem;
    border-top: 1px solid rgba(0, 0, 0, 0.08);
    margin-top: 1rem;
}

.notification-footer small {
    font-size: 0.85rem;
    color: #6c757d;
    font-weight: 500;
}

/* Responsive Design */
@media (max-width: 768px) {
    .notifications-container {
        gap: 1rem;
    }
    
    .notification-card .card-body {
        padding: 1.25rem;
    }
    
    .notification-header {
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }
    
    .notification-icon {
        width: 45px;
        height: 45px;
        font-size: 1.3rem;
    }
    
    .notification-title {
        font-size: 1rem;
    }
    
    .notification-message {
        font-size: 0.9rem;
    }
    
    .notification-actions {
        flex-direction: row;
        justify-content: flex-end;
        margin-top: 0.75rem;
        min-width: auto;
        gap: 0.4rem;
    }
    
    .notification-actions .btn {
        width: auto;
        padding: 0.3rem 0.6rem;
    }
    
    .notification-footer {
        flex-direction: column;
        gap: 0.4rem;
        align-items: flex-start;
        padding-top: 0.75rem;
        margin-top: 0.75rem;
    }
}

@media (max-width: 576px) {
    .notifications-container {
        gap: 0.75rem;
    }
    
    .notification-card .card-body {
        padding: 1rem;
    }
    
    .notification-header {
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 0.75rem;
    }
    
    .notification-icon {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
    }
    
    .notification-title {
        font-size: 0.95rem;
    }
    
    .notification-message {
        font-size: 0.85rem;
    }
    
    .notification-actions {
        margin-top: 0.75rem;
        justify-content: center;
        width: 100%;
    }
    
    .notification-actions .btn {
        flex: 1;
        max-width: 100px;
    }
    
    .notification-footer {
        text-align: center;
        align-items: center;
    }
}
</style>

<script>
function markAsRead(notificationId) {
    // Show loading state
    const button = document.querySelector(`[onclick="markAsRead(${notificationId})"]`);
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
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const card = document.querySelector(`[data-notification-id="${notificationId}"]`);
            card.classList.remove('unread');
            card.classList.add('read');
            
            // Hide the mark as read button
            button.style.display = 'none';
            
            // Update notification count
            updateNotificationCount();
            
            // Show success message
            showNotification('Notification marked as read', 'success');
        } else {
            throw new Error(data.message || 'Failed to mark notification as read');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to mark notification as read: ' + error.message, 'error');
        
        // Restore button state
        button.innerHTML = originalContent;
        button.disabled = false;
    });
}

function markAllAsRead() {
    // Show loading state
    const button = document.querySelector('.btn-outline-primary');
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Marking All...';
    button.disabled = true;
    
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Mark all cards as read
            document.querySelectorAll('.notification-card').forEach(card => {
                card.classList.remove('unread');
                card.classList.add('read');
                
                // Hide all mark as read buttons
                const markButton = card.querySelector('[onclick^="markAsRead"]');
                if (markButton) {
                    markButton.style.display = 'none';
                }
            });
            
            // Update notification count
            updateNotificationCount();
            
            // Show success message
            showNotification('All notifications marked as read', 'success');
            
            // Hide the mark all button
            button.style.display = 'none';
        } else {
            throw new Error(data.message || 'Failed to mark all notifications as read');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to mark all notifications as read: ' + error.message, 'error');
        
        // Restore button state
        button.innerHTML = originalContent;
        button.disabled = false;
    });
}

// Update notification count function (reuse from layout)
function updateNotificationCount() {
    @auth
        @if(auth()->user()->isAdminOrSeller())
            fetch('{{ route("notifications.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const navbarBadge = document.getElementById('notificationBadge');
                    const sidebarBadge = document.getElementById('sidebarNotificationBadge');
                    
                    if (data.count > 0) {
                        navbarBadge.textContent = data.count;
                        navbarBadge.style.display = 'block';
                        sidebarBadge.textContent = data.count;
                        sidebarBadge.style.display = 'block';
                    } else {
                        navbarBadge.style.display = 'none';
                        sidebarBadge.style.display = 'none';
                    }
                })
                .catch(error => console.log('Error fetching notification count:', error));
        @endif
    @endauth
}

// Show notification function
function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to page
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}
</script>
@endsection
