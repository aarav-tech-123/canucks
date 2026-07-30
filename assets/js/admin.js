/**
 * Admin Panel - Vanilla JavaScript
 * All functions namespaced to avoid conflicts
 */

(function() {
    'use strict';

    // Wait for DOM to be ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAdminPanel);
    } else {
        initAdminPanel();
    }

    function initAdminPanel() {
        // --- Form Validation ---
        const paymentForm = document.getElementById('apPaymentForm');
        if (paymentForm) {
            paymentForm.addEventListener('submit', function(e) {
                const name = document.getElementById('apCustomerName');
                const email = document.getElementById('apCustomerEmail');
                const paymentLink = document.getElementById('apPaymentLink');
                let isValid = true;

                // Clear previous errors
                document.querySelectorAll('.ap-form-control.ap-error').forEach(el => {
                    el.classList.remove('ap-error');
                });

                // Validate Name
                if (!name.value.trim()) {
                    name.classList.add('ap-error');
                    isValid = false;
                    showError('apNameError', 'Name is required');
                } else {
                    hideError('apNameError');
                }

                // Validate Email
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email.value.trim()) {
                    email.classList.add('ap-error');
                    isValid = false;
                    showError('apEmailError', 'Email is required');
                } else if (!emailPattern.test(email.value.trim())) {
                    email.classList.add('ap-error');
                    isValid = false;
                    showError('apEmailError', 'Please enter a valid email address');
                } else {
                    hideError('apEmailError');
                }

                // Validate Payment Link
                if (!paymentLink.value.trim()) {
                    paymentLink.classList.add('ap-error');
                    isValid = false;
                    showError('apLinkError', 'Payment link is required');
                } else {
                    hideError('apLinkError');
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });
        }

        // --- Helper functions for error messages ---
        function showError(id, message) {
            const el = document.getElementById(id);
            if (el) {
                el.textContent = message;
                el.style.display = 'block';
            }
        }

        function hideError(id) {
            const el = document.getElementById(id);
            if (el) {
                el.textContent = '';
                el.style.display = 'none';
            }
        }

        // --- Auto-hide alerts after 5 seconds ---
        const alerts = document.querySelectorAll('.ap-alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.style.display = 'none';
                }, 500);
            }, 5000);
        });

        // --- Reset form button ---
        const resetBtn = document.getElementById('apResetBtn');
        if (resetBtn) {
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const form = document.getElementById('apPaymentForm');
                if (form) {
                    form.reset();
                    // Clear error states
                    document.querySelectorAll('.ap-form-control.ap-error').forEach(el => {
                        el.classList.remove('ap-error');
                    });
                    document.querySelectorAll('.ap-error-message').forEach(el => {
                        el.textContent = '';
                        el.style.display = 'none';
                    });
                }
            });
        }

        // --- Confirm delete (optional) ---
        const deleteButtons = document.querySelectorAll('.ap-delete-btn');
        deleteButtons.forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Are you sure you want to delete this record?')) {
                    e.preventDefault();
                }
            });
        });

        console.log('Admin Panel initialized successfully.');
    }
})();