/**
 * Booking Form Handler
 *
 * Handles multi-step form navigation, data collection, and review population
 *
 * @package Homerix_Pro
 */

(function () {
  'use strict';

  // Form state
  const formState = {
    currentStep: 1,
    selectedService: null,
    selectedTimeType: null,
    selectedTimeSlot: null,
    selectedTechnicianName: null,
    selectedTechnicianSpecialty: null,
    formData: {},
  };

  // DOM Elements
  const form = document.getElementById('booking-form');
  const steps = document.querySelectorAll('.form-step');
  const nextButtons = document.querySelectorAll('.next-step');
  const prevButtons = document.querySelectorAll('.prev-step');
  const serviceOptions = document.querySelectorAll('.service-option');
  const timeTypeButtons = document.querySelectorAll('.time-type-btn');
  const timeSlots = document.querySelectorAll('.time-slot');

  /**
   * Initialize form
   */
  function init() {
    // Service selection
    serviceOptions.forEach((option) => {
      option.addEventListener('click', selectService);
    });

    // Time type selection
    timeTypeButtons.forEach((btn) => {
      btn.addEventListener('click', selectTimeType);
    });

    // Time slot selection
    timeSlots.forEach((slot) => {
      slot.addEventListener('click', selectTimeSlot);
    });

    // Navigation buttons
    nextButtons.forEach((btn) => {
      btn.addEventListener('click', goToNextStep);
      // Disable all next buttons by default
      btn.disabled = true;
    });

    prevButtons.forEach((btn) => {
      btn.addEventListener('click', goToPreviousStep);
    });

    // Form submission
    if (form) {
      form.addEventListener('submit', handleFormSubmit);
      // Disable submit button by default ONLY if reCAPTCHA is enabled AND widget exists
      const submitBtn = form.querySelector('button[type="submit"]');
      const recaptchaWidget = document.querySelector('.g-recaptcha');
      if (submitBtn && HomerixBooking.recaptchaEnabled && recaptchaWidget) {
        submitBtn.disabled = true;
      }
    }

    // Add event listeners to form fields for Step 3 validation
    const formFields = form.querySelectorAll('input[required], textarea[required]');
    formFields.forEach((field) => {
      field.addEventListener('input', checkStep3Validation);
      field.addEventListener('change', checkStep3Validation);
    });

    // Read technician data from URL params (if coming from Find Technician page)
    const urlParams = new URLSearchParams(window.location.search);
    const technicianName = urlParams.get('technician');
    const technicianSpecialty = urlParams.get('specialty');
    if (technicianName) {
      formState.selectedTechnicianName = decodeURIComponent(technicianName);
    }
    if (technicianSpecialty) {
      formState.selectedTechnicianSpecialty = decodeURIComponent(technicianSpecialty);
    }
  }

  /**
   * Select service
   */
  function selectService(e) {
    const option = e.currentTarget;
    const serviceName = option.getAttribute('data-service');

    // Remove previous selection
    serviceOptions.forEach((opt) => {
      opt.classList.remove('selected');
    });

    // Add selection to current option
    option.classList.add('selected');

    // Update form state
    formState.selectedService = serviceName;

    // Enable next button
    const nextBtn = steps[0].querySelector('.next-step');
    if (nextBtn) {
      nextBtn.disabled = false;
    }
  }

  /**
   * Select time type
   */
  function selectTimeType(e) {
    const btn = e.currentTarget;
    const timeType = btn.getAttribute('data-type');

    // Remove previous selection
    timeTypeButtons.forEach((b) => {
      b.classList.remove('selected');
    });

    // Add selection to current button
    btn.classList.add('selected');

    // Update form state
    formState.selectedTimeType = timeType;
  }

  /**
   * Select time slot
   */
  function selectTimeSlot(e) {
    const slot = e.currentTarget;
    const slotTime = slot.getAttribute('data-slot');

    // Remove previous selection
    timeSlots.forEach((s) => {
      s.classList.remove('selected');
    });

    // Add selection to current slot
    slot.classList.add('selected');

    // Update form state
    formState.selectedTimeSlot = slotTime;

    // Enable next button
    const nextBtn = steps[1].querySelector('.next-step');
    if (nextBtn) {
      nextBtn.disabled = false;
    }
  }

  /**
   * Check Step 3 validation and enable/disable next button
   */
  function checkStep3Validation() {
    // Only check if we're on step 3
    if (formState.currentStep !== 3) {
      return;
    }

    // Get all required fields in step 3
    const step3 = steps[2]; // Step 3 is index 2
    const requiredFields = step3.querySelectorAll('input[required], textarea[required]');

    // Check if all required fields are filled
    let allFilled = true;
    for (const field of requiredFields) {
      if (!field.value.trim()) {
        allFilled = false;
        break;
      }
    }

    // Enable or disable next button based on validation
    const nextBtn = step3.querySelector('.next-step');
    if (nextBtn) {
      nextBtn.disabled = !allFilled;
    }
  }

  /**
   * Go to next step
   */
  function goToNextStep(e) {
    e.preventDefault();
    e.stopPropagation();

    // Validate current step
    const isValid = validateStep(formState.currentStep);
    if (!isValid) {
      // Validation failed, do not proceed
      return false;
    }

    // Collect form data
    collectFormData();

    // Move to next step
    if (formState.currentStep < steps.length) {
      showStep(formState.currentStep + 1);
      formState.currentStep++;

      // Populate review if on step 4
      if (formState.currentStep === 4) {
        populateReview();
      }
    }

    return false;
  }

  /**
   * Go to previous step
   */
  function goToPreviousStep(e) {
    e.preventDefault();

    if (formState.currentStep > 1) {
      showStep(formState.currentStep - 1);
      formState.currentStep--;
    }
  }

  /**
   * Show specific step
   */
  function showStep(stepNumber) {
    steps.forEach((step, index) => {
      if (index + 1 === stepNumber) {
        step.classList.remove('hidden');
      } else {
        step.classList.add('hidden');
      }
    });

    // Update progress indicator
    updateProgressIndicator(stepNumber);

    // Check Step 3 validation when entering Step 3
    if (stepNumber === 3) {
      checkStep3Validation();
    }
  }

  /**
   * Update progress indicator
   */
  function updateProgressIndicator(stepNumber) {
    const indicators = document.querySelectorAll('.step-indicator');
    const stepWrappers = document.querySelectorAll('.step-wrapper');
    const progressLine = document.querySelector('.progress-line');

    // Update step indicators
    indicators.forEach((indicator, index) => {
      const indicatorStep = index + 1;

      // Remove all state classes first
      indicator.classList.remove('active', 'completed');

      if (indicatorStep < stepNumber) {
        // Previous steps are completed
        indicator.classList.add('completed');
        indicator.textContent = ''; // Text hidden by CSS ::after
      } else if (indicatorStep === stepNumber) {
        // Current step is active
        indicator.classList.add('active');
        indicator.textContent = indicatorStep;
      } else {
        // Future steps are inactive
        indicator.textContent = indicatorStep;
      }
    });

    // Update step labels
    stepWrappers.forEach((wrapper, index) => {
      const label = wrapper.querySelector('.step-label');
      if (label) {
        if (index + 1 <= stepNumber) {
          label.classList.remove('step-label-inactive');
          label.classList.add('step-label-active');
        } else {
          label.classList.remove('step-label-active');
          label.classList.add('step-label-inactive');
        }
      }
    });

    // Update progress line width (0%, 33%, 66%, 100%)
    if (progressLine) {
      const progressPercentage = ((stepNumber - 1) / 3) * 100;
      progressLine.style.width = progressPercentage + '%';
    }
  }

  /**
   * Create toast container if it doesn't exist
   */
  function getToastContainer() {
    let container = document.querySelector('.homerix-toast-container');
    if (!container) {
      container = document.createElement('div');
      container.className = 'homerix-toast-container';
      document.body.appendChild(container);
    }
    return container;
  }

  /**
   * Get icon HTML for toast type
   */
  function getToastIcon(type) {
    const icons = {
      error: '<i class="fas fa-times"></i>',
      warning: '<i class="fas fa-exclamation"></i>',
      success: '<i class="fas fa-check"></i>',
      info: '<i class="fas fa-info"></i>',
    };
    return icons[type] || icons.info;
  }

  /**
   * Show toast notification
   * @param {string} message - The message to display
   * @param {string} type - Type: 'error', 'warning', 'success', 'info'
   * @param {number} duration - Auto-dismiss duration in ms (default: 8000)
   */
  function showToast(message, type = 'error', duration = 8000) {
    const container = getToastContainer();

    // Create toast element
    const toast = document.createElement('div');
    toast.className = `homerix-toast toast-${type}`;
    toast.innerHTML = `
			<span class="homerix-toast-icon">${getToastIcon(type)}</span>
			<span class="homerix-toast-content">${message}</span>
			<button type="button" class="homerix-toast-close" aria-label="Close">&times;</button>
		`;

    // Add close button functionality
    const closeBtn = toast.querySelector('.homerix-toast-close');
    closeBtn.addEventListener('click', () => dismissToast(toast));

    // Add to container
    container.appendChild(toast);

    // Auto-dismiss
    if (duration > 0) {
      setTimeout(() => dismissToast(toast), duration);
    }

    return toast;
  }

  /**
   * Dismiss a toast notification
   */
  function dismissToast(toast) {
    if (!toast || !toast.parentNode) return;

    toast.classList.add('toast-removing');
    setTimeout(() => {
      if (toast.parentNode) {
        toast.parentNode.removeChild(toast);
      }
    }, 300);
  }

  /**
   * Add shake animation to button
   */
  function shakeButton(button) {
    button.classList.add('shake');
    setTimeout(() => button.classList.remove('shake'), 400);
  }

  /**
   * Validate current step
   */
  function validateStep(stepNumber) {
    const currentStepEl = steps[stepNumber - 1];
    const nextBtn = currentStepEl ? currentStepEl.querySelector('.next-step') : null;

    switch (stepNumber) {
      case 1:
        if (!formState.selectedService) {
          showToast('Please select a service to continue', 'warning');
          if (nextBtn) shakeButton(nextBtn);
          return false;
        }
        break;
      case 2:
        if (!formState.selectedTimeSlot) {
          showToast('Please choose a time slot before continuing', 'warning');
          if (nextBtn) shakeButton(nextBtn);
          return false;
        }
        break;
      case 3:
        // Validate required fields in step 3 only
        const step3 = steps[2];
        const requiredFields = step3.querySelectorAll('input[required], textarea[required]');
        for (const field of requiredFields) {
          if (!field.value.trim()) {
            showToast('Please fill in all required fields', 'warning');
            field.focus();
            if (nextBtn) shakeButton(nextBtn);
            return false;
          }
        }
        break;
      case 4:
        // Validate reCAPTCHA if enabled AND widget exists on page
        const recaptchaWidget = document.querySelector('.g-recaptcha');
        if (HomerixBooking.recaptchaEnabled && recaptchaWidget) {
          const recaptchaVerified = document.getElementById('recaptcha-verified');
          if (!recaptchaVerified || recaptchaVerified.value !== '1') {
            showToast('Please verify that you are not a robot', 'error');
            return false;
          }
        }
        // Validate terms checkbox if present
        const termsCheckbox = form.querySelector('input[name="terms"]');
        if (termsCheckbox && termsCheckbox.required && !termsCheckbox.checked) {
          showToast('Please agree to the terms and conditions', 'warning');
          return false;
        }
        break;
    }
    return true;
  }

  /**
   * Collect form data
   */
  function collectFormData() {
    const inputs = form.querySelectorAll('input, textarea');
    inputs.forEach((input) => {
      if (input.type === 'checkbox') {
        formState.formData[input.name] = input.checked;
      } else if (input.type !== 'hidden') {
        formState.formData[input.name] = input.value;
      }
    });
  }

  /**
   * Populate review section
   */
  function populateReview() {
    const fieldConfig = HomerixBooking.fieldConfig || {};

    // Helper to safely set text content and show/hide row
    const setReviewField = (elementId, value, isEnabled) => {
      const element = document.getElementById(elementId);
      if (element) {
        if (isEnabled) {
          element.textContent = value || '-';
          const row = element.closest('div');
          if (row) row.style.display = '';
        } else {
          element.textContent = '';
          const row = element.closest('div');
          if (row) row.style.display = 'none';
        }
      }
    };

    // Service and time are always shown
    document.getElementById('review-service').textContent = formState.selectedService || '-';
    document.getElementById('review-time').textContent = formState.selectedTimeSlot || '-';

    // Address - conditional
    setReviewField('review-address', formState.formData.address, fieldConfig.address);

    // Build name from enabled fields
    let nameParts = [];
    if (fieldConfig.firstName && formState.formData.first_name) {
      nameParts.push(formState.formData.first_name);
    }
    if (fieldConfig.lastName && formState.formData.last_name) {
      nameParts.push(formState.formData.last_name);
    }
    const fullName = nameParts.length > 0 ? nameParts.join(' ') : '-';

    // Show name if at least one name field is enabled
    const showName = fieldConfig.firstName || fieldConfig.lastName;
    setReviewField('review-name', fullName, showName);

    // Email - conditional
    setReviewField('review-email', formState.formData.email, fieldConfig.email);

    // Phone - conditional
    setReviewField('review-phone', formState.formData.phone, fieldConfig.phone);

    // Show requested technician if present
    const technicianReview = document.getElementById('review-technician');
    if (technicianReview && formState.selectedTechnicianName) {
      technicianReview.textContent = formState.selectedTechnicianName + (formState.selectedTechnicianSpecialty ? ' (' + formState.selectedTechnicianSpecialty + ')' : '');
      // Show the technician row if it exists
      const technicianRow = technicianReview.closest('.review-row');
      if (technicianRow) {
        technicianRow.style.display = '';
      }
    }
  }
  /**
   * Handle form submission
   */
  function handleFormSubmit(e) {
    e.preventDefault();

    // Validate step 4
    if (!validateStep(4)) {
      return;
    }

    // Collect all form data
    collectFormData();

    // Add booking data
    formState.formData.service = formState.selectedService;
    formState.formData.time_type = formState.selectedTimeType;
    formState.formData.time_slot = formState.selectedTimeSlot;

    // Add technician data if present
    if (formState.selectedTechnicianName) {
      formState.formData.technician_name = formState.selectedTechnicianName;
    }
    if (formState.selectedTechnicianSpecialty) {
      formState.formData.technician_specialty = formState.selectedTechnicianSpecialty;
    }

    // Submit booking
    submitBooking(formState.formData);
  }

  /**
   * Submit booking via AJAX
   */
  function submitBooking(data) {
    // Disable submit button
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.textContent = 'Processing...';

    // Prepare AJAX data
    const ajaxData = new FormData(form);
    ajaxData.append('action', 'submit_booking');
    ajaxData.append('booking_data', JSON.stringify(data));

    // Send AJAX request
    fetch(HomerixBooking.ajaxUrl, {
      method: 'POST',
      body: ajaxData,
    })
      .then((response) => response.json())
      .then((result) => {
        if (result.success) {
          // Show success or warning modal based on email status
          const message = result.data.message || 'Booking submitted successfully!';
          const bookingId = result.data.booking_id || '';
          const emailError = result.data.email_error || false;

          if (emailError) {
            showWarningModal(message, bookingId);
          } else {
            showSuccessModal(message, bookingId);
          }

          // Reset form
          form.reset();
          formState.currentStep = 1;
          showStep(1);
        } else {
          showToast(result.data.message || 'Error submitting booking', 'error');
        }
      })
      .catch((error) => {
        console.error('Error:', error);
        showToast('Error submitting booking. Please try again.', 'error');
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = 'Confirm Booking';
      });
  }

  /**
   * Show success modal
   */
  function showSuccessModal(message, bookingId) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
			<div class="card-base rounded-lg p-8 max-w-md mx-auto">
				<div class="text-center">
					<div class="text-5xl text-success mb-4">?</div>
					<h2 class="text-2xl font-bold mb-4">Success!</h2>
					<p class="text-muted mb-6">${message}</p>
					${bookingId ? `<p class="text-muted mb-4"><strong>Booking ID:</strong> #${bookingId}</p>` : ''}
					<button class="book-btn bg-success hover-bg-success-dark hero-text font-bold py-2 px-6 rounded-lg" onclick="location.reload()">
						OK
					</button>
				</div>
			</div>
		`;
    document.body.appendChild(modal);
  }

  /**
   * Show warning modal (for email failures)
   */
  function showWarningModal(message, bookingId) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
    modal.innerHTML = `
			<div class="card-base rounded-lg p-8 max-w-md mx-auto">
				<div class="text-center">
					<div class="text-5xl mb-4" style="color: #f59e0b;">?</div>
					<h2 class="text-2xl font-bold mb-4">Booking Saved!</h2>
					<p class="text-muted mb-4">${message}</p>
					${bookingId ? `<p class="mb-4" style="background: #fef3c7; padding: 12px; border-radius: 8px; border: 1px solid #f59e0b;"><strong>?? Your Booking ID:</strong> #${bookingId}</p>` : ''}
					<button class="book-btn font-bold py-2 px-6 rounded-lg" style="background: #f59e0b; color: white;" onclick="location.reload()">
						OK
					</button>
				</div>
			</div>
		`;
    document.body.appendChild(modal);
  }

  // Initialize when DOM is ready
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();

/**
 * reCAPTCHA callback when verification succeeds
 */
function onRecaptchaSuccess() {
  const recaptchaVerified = document.getElementById('recaptcha-verified');
  if (recaptchaVerified) {
    recaptchaVerified.value = '1';
  }
  // Enable submit button when reCAPTCHA is verified
  const submitBtn = document.querySelector('button[type="submit"]');
  if (submitBtn) {
    submitBtn.disabled = false;
  }
}

/**
 * reCAPTCHA callback when verification expires
 */
function onRecaptchaExpired() {
  const recaptchaVerified = document.getElementById('recaptcha-verified');
  if (recaptchaVerified) {
    recaptchaVerified.value = '0';
  }
  // Disable submit button when reCAPTCHA expires
  const submitBtn = document.querySelector('button[type="submit"]');
  if (submitBtn) {
    submitBtn.disabled = true;
  }
}

