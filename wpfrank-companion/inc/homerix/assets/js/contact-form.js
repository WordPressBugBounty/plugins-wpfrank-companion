/**
 * Contact Form Handler
 *
 * Handles AJAX form submission with success/error modal.
 *
 * @package Homerix_Pro
 */

(function () {
  'use strict';

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  /**
   * Initialize contact form handler
   */
  function init() {
    const form = document.querySelector('.contact-form');
    if (!form) return;

    form.addEventListener('submit', handleFormSubmit);
  }

  /**
   * Handle form submission
   */
  function handleFormSubmit(e) {
    e.preventDefault();

    const form = e.target;
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalBtnText = submitBtn.textContent;

    // Disable button and show loading state
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';

    // Prepare form data
    const formData = new FormData(form);
    formData.append('action', 'submit_contact');

    // Send AJAX request
    fetch(HomerixContact.ajaxUrl, {
      method: 'POST',
      body: formData,
    })
      .then((response) => response.json())
      .then((result) => {
        if (result.success) {
          // Show success modal
          showSuccessModal(result.data.message);
          // Reset form
          form.reset();
        } else {
          // Show error modal
          showErrorModal(result.data.message || 'An error occurred. Please try again.');
        }
      })
      .catch((error) => {
        console.error('Contact form error:', error);
        showErrorModal('An error occurred. Please try again.');
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
      });
  }

  /**
   * Show success modal
   */
  function showSuccessModal(message) {
    const modal = document.createElement('div');
    modal.className = 'contact-modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.style.animation = 'fadeIn 0.3s ease-out';
    modal.innerHTML = `
      <div class="card-base rounded-xl p-8 max-w-md mx-4 shadow-2xl" style="animation: slideUp 0.3s ease-out;">
        <div class="text-center">
          <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
          </div>
          <h2 class="text-2xl font-bold mb-4" style="color: var(--homerix-heading-color, #1e293b);">Message Sent!</h2>
          <p class="text-muted mb-6">${escapeHtml(message)}</p>
          <button class="close-modal btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300">
            OK
          </button>
        </div>
      </div>
    `;

    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';

    // Add close handlers
    const closeBtn = modal.querySelector('.close-modal');
    closeBtn.addEventListener('click', () => closeModal(modal));
    modal.addEventListener('click', (e) => {
      if (e.target === modal) closeModal(modal);
    });
  }

  /**
   * Show error modal
   */
  function showErrorModal(message) {
    const modal = document.createElement('div');
    modal.className = 'contact-modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.style.animation = 'fadeIn 0.3s ease-out';
    modal.innerHTML = `
      <div class="card-base rounded-xl p-8 max-w-md mx-4 shadow-2xl" style="animation: slideUp 0.3s ease-out;">
        <div class="text-center">
          <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);">
            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
          </div>
          <h2 class="text-2xl font-bold mb-4" style="color: var(--homerix-heading-color, #1e293b);">Error</h2>
          <p class="text-muted mb-6">${escapeHtml(message)}</p>
          <button class="close-modal btn book-btn font-bold py-3 px-8 rounded-lg transition duration-300">
            OK
          </button>
        </div>
      </div>
    `;

    document.body.appendChild(modal);
    document.body.style.overflow = 'hidden';

    // Add close handlers
    const closeBtn = modal.querySelector('.close-modal');
    closeBtn.addEventListener('click', () => closeModal(modal));
    modal.addEventListener('click', (e) => {
      if (e.target === modal) closeModal(modal);
    });
  }

  /**
   * Close modal
   */
  function closeModal(modal) {
    modal.style.animation = 'fadeOut 0.2s ease-out';
    setTimeout(() => {
      modal.remove();
      document.body.style.overflow = '';
    }, 200);
  }

  /**
   * Escape HTML to prevent XSS
   */
  function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }
})();

// Add modal animations to head if not already present
(function () {
  if (!document.getElementById('contact-modal-styles')) {
    const style = document.createElement('style');
    style.id = 'contact-modal-styles';
    style.textContent = `
      @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
      }
      @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
      }
      @keyframes slideUp {
        from { 
          opacity: 0;
          transform: translateY(20px);
        }
        to { 
          opacity: 1;
          transform: translateY(0);
        }
      }
    `;
    document.head.appendChild(style);
  }
})();
