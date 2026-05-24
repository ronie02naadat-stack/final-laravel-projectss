import './bootstrap';

// ============================================
// ADMIN DASHBOARD - Real-time Updates
// ============================================
$(document).ready(function() {
    console.log('📄 Document ready');
    
    // Initialize Admin Dashboard if present
    if ($('[data-admin-dashboard]').length) {
        console.log('✅ Found admin dashboard');
        initAdminDashboard();
    }
    
    // Initialize Admin Edit if present
    if ($('[data-admin-edit]').length) {
        console.log('✅ Found admin edit page');
        initAdminEdit();
    } else {
        console.log('⚠️  No admin edit page found');
    }
});

// ============================================
// ADMIN DASHBOARD FUNCTIONALITY
// ============================================
function initAdminDashboard() {
    // BroadcastChannels for real-time sync across tabs
    const deleteChannel = new BroadcastChannel('admin_user_delete');
    const updateChannel = new BroadcastChannel('admin_user_update');
    
    // Listen for delete events from other tabs
    deleteChannel.onmessage = function(event) {
        const { userId, userType } = event.data;
        
        // Remove the row from current tab without deleting via API
        const row = $(`tr[data-student-id="${userId}"], tr[data-teacher-id="${userId}"]`);
        if (row.length) {
            row.fadeOut(300, function() {
                $(this).remove();
                showNotification(`✅ ${userType.charAt(0).toUpperCase() + userType.slice(1)} was deleted from another tab`, 'info');
            });
        }
    };
    
    // Listen for update events from other tabs
    updateChannel.onmessage = function(event) {
        console.log('Received update message:', event.data);
        
        if (event.data.action === 'user_update') {
            const { id, name, email, user_type } = event.data.data;
            
            console.log('Looking for row with id:', id, 'type:', user_type);
            
            // Find the row by either student or teacher ID
            let row;
            if (user_type === 'student') {
                row = $(`tr[data-student-id="${id}"]`);
            } else if (user_type === 'teacher') {
                row = $(`tr[data-teacher-id="${id}"]`);
            }
            
            console.log('Found rows:', row.length);
            
            if (row.length > 0) {
                // Fetch fresh data from server
                $.ajax({
                    url: '/admin/user/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            // Update name cell (first td)
                            row.find('td').eq(0).text(response.name);
                            
                            // Update email cell (second td)
                            row.find('td').eq(1).text(response.email);
                            
                            console.log('Row updated successfully');
                            
                            // Flash the row to show it was updated
                            row.css('background-color', '#fef3c7').animate({backgroundColor: 'transparent'}, 1000);
                            
                            showNotification(`✅ ${response.user_type.charAt(0).toUpperCase() + response.user_type.slice(1)} information updated from another tab`, 'info');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching updated user data:', error);
                    }
                });
            } else {
                console.log('No row found for update');
            }
        }
    };
    
    // Delete user via AJAX
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault();
        
        const btn = $(this);
        const userId = btn.data('id');
        const userType = btn.data('type');
        const row = btn.closest('tr');
        
        if (!confirm('Are you sure you want to delete this ' + userType + '?')) {
            return false;
        }
        
        // Show loading state
        btn.text('Deleting...').prop('disabled', true).css('opacity', '0.6');
        
        $.ajax({
            url: '/admin/users/' + userId,
            type: 'DELETE',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    // Notify all other tabs about the deletion
                    deleteChannel.postMessage({
                        userId: userId,
                        userType: userType,
                        timestamp: new Date().getTime()
                    });
                    
                    // Fade out and remove row with animation
                    row.fadeOut(300, function() {
                        $(this).remove();
                        
                        // Show success message
                        showNotification('✅ ' + userType.charAt(0).toUpperCase() + userType.slice(1) + ' deleted successfully!', 'success');
                        
                        // Reload page after 1.5 second to update totals
                        setTimeout(() => location.reload(), 1500);
                    });
                } else {
                    showNotification('❌ Error: ' + (response.message || 'Failed to delete'), 'error');
                    btn.text('Delete').prop('disabled', false).css('opacity', '1');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', xhr.responseJSON);
                showNotification('❌ Error deleting ' + userType, 'error');
                btn.text('Delete').prop('disabled', false).css('opacity', '1');
            }
        });
        
        return false;
    });
    
    // Real-time polling for new entries
    let currentStudentCount = $('[data-student-total]').data('student-total');
    let currentTeacherCount = $('[data-teacher-total]').data('teacher-total');
    
    function checkForNewEntries() {
        $.ajax({
            url: $('[data-latest-counts-url]').data('latest-counts-url'),
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const studentCountChanged = response.studentCount !== currentStudentCount;
                const teacherCountChanged = response.teacherCount !== currentTeacherCount;
                
                if (studentCountChanged || teacherCountChanged) {
                    const oldStudentCount = currentStudentCount;
                    const oldTeacherCount = currentTeacherCount;
                    
                    currentStudentCount = response.studentCount;
                    currentTeacherCount = response.teacherCount;
                    
                    let message = '🔄 Updates detected! ';
                    if (studentCountChanged) {
                        const diff = response.studentCount - oldStudentCount;
                        message += (diff > 0 ? `+${diff} new student${diff !== 1 ? 's' : ''} ` : '');
                    }
                    if (teacherCountChanged) {
                        const diff = response.teacherCount - oldTeacherCount;
                        message += (diff > 0 ? `+${diff} new teacher${diff !== 1 ? 's' : ''} ` : '');
                    }
                    message += '- Refreshing...';
                    
                    showNotification(message, 'info');
                    
                    // Reload the page to show new entries
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error checking for updates:', error);
            }
        });
    }
    
    // Start polling every 5 seconds
    setInterval(checkForNewEntries, 5000);
}

// ============================================
// ADMIN EDIT FUNCTIONALITY
// ============================================
function initAdminEdit() {
    console.log('🔧 initAdminEdit() function called');
    
    const updateChannel = new BroadcastChannel('admin_user_update');
    
    // Handle form submission via AJAX
    $('#edit-form').on('submit', function(e) {
        console.log('📝 Edit form submitted');
        e.preventDefault();
        
        const userId = $('#user-id').val();
        const userType = $('#user-type').val();
        const formData = $(this).serialize();
        
        console.log('User ID:', userId);
        console.log('User Type:', userType);
        console.log('Form Data:', formData);
        
        const $saveBtn = $('#save-btn');
        $saveBtn.text('Saving...').prop('disabled', true).css('opacity', '0.6');
        
        $.ajax({
            url: '/admin/update/' + userId,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                console.log('✅ Update successful:', response);
                // Get updated data from form
                const updatedData = {
                    id: userId,
                    name: $('input[name="name"]').val(),
                    email: $('#email').val(),
                    user_type: userType,
                    timestamp: new Date().getTime()
                };
                
                console.log('Broadcasting update:', updatedData);
                
                // Broadcast to other tabs
                updateChannel.postMessage({
                    action: 'user_update',
                    data: updatedData
                });
                
                // Show success message
                showNotification('✅ User updated successfully! Syncing across all tabs...', 'success');
                
                // Wait a moment to ensure broadcast is sent, then redirect
                setTimeout(() => {
                    window.location.href = '/admin-dashboard';
                }, 2000);
            },
            error: function(xhr, status, error) {
                console.error('❌ AJAX Error:', error);
                console.error('Response:', xhr.responseJSON);
                const errors = xhr.responseJSON?.errors || { general: [error] };
                let errorHTML = '<strong>❌ Error:</strong><ul style="margin: 10px 0 0 0; padding-left: 20px;">';
                
                Object.keys(errors).forEach(key => {
                    errors[key].forEach(msg => {
                        errorHTML += '<li>' + msg + '</li>';
                    });
                });
                
                errorHTML += '</ul>';
                
                $('#error-container').html('<div style="background: #fee2e2; color: #991b1b; padding: 16px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid #ef4444;">' + errorHTML + '</div>');
                
                $saveBtn.text('✅ Save Changes').prop('disabled', false).css('opacity', '1');
            }
        });
        
        return false;
    });
}

// ============================================
// UTILITY FUNCTIONS
// ============================================
function showNotification(message, type) {
    let bgColor, textColor, borderColor;
    
    if (type === 'success') {
        bgColor = '#d1fae5';
        textColor = '#065f46';
        borderColor = '#10b981';
    } else if (type === 'error') {
        bgColor = '#fee2e2';
        textColor = '#991b1b';
        borderColor = '#ef4444';
    } else if (type === 'info') {
        bgColor = '#dbeafe';
        textColor = '#0c4a6e';
        borderColor = '#0284c7';
    }
    
    const notification = $(`
        <div style="background: ${bgColor}; color: ${textColor}; padding: 16px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid ${borderColor}; position: fixed; top: 20px; right: 20px; z-index: 9999; max-width: 400px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); animation: slideIn 0.3s ease;">
            ${message}
        </div>
    `);
    
    $('body').append(notification);
    
    setTimeout(() => {
        notification.fadeOut(300, function() { $(this).remove(); });
    }, type === 'info' ? 4000 : 3000);
}

// Add animation CSS
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .delete-btn:hover {
        background: #dc2626 !important;
        transform: scale(1.05);
    }
`;
document.head.appendChild(style);
