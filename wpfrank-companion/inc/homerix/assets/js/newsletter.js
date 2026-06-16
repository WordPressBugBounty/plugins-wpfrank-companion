/**
 * Homerix Newsletter Form Handler
 *
 * Handles AJAX newsletter subscription form submissions.
 *
 * @package Homerix_Pro
 */

(function ($) {
  'use strict';

  /**
   * Initialize newsletter forms.
   */
  function initNewsletterForms() {
    // Handle all newsletter forms - check for data-newsletter-source attribute.
    $(document).on('submit', '.newsletter-form', function (e) {
      e.preventDefault();
      var source = $(this).data('newsletter-source') || 'footer';
      handleSubmit($(this), source);
    });
  }

  /**
   * Handle form submission.
   *
   * @param {jQuery} $form  The form element.
   * @param {string} source Subscription source.
   */
  function handleSubmit($form, source) {
    var $emailInput = $form.find('input[type="email"]');
    var $submitBtn = $form.find('button[type="submit"]');
    var email = $emailInput.val().trim();

    // Basic validation.
    if (!email || !isValidEmail(email)) {
      showMessage($form, HomerixNewsletter.strings.invalid, 'error');
      return;
    }

    // Disable form during submission.
    var originalBtnText = $submitBtn.text();
    $submitBtn.prop('disabled', true).text(HomerixNewsletter.strings.subscribing);

    // Send AJAX request.
    $.ajax({
      url: HomerixNewsletter.ajaxUrl,
      type: 'POST',
      data: {
        action: 'homerix_newsletter_subscribe',
        nonce: HomerixNewsletter.nonce,
        email: email,
        source: source
      },
      success: function (response) {
        if (response.success) {
          showMessage($form, response.data.message, 'success');
          $emailInput.val('');
        } else {
          showMessage($form, response.data.message, 'error');
        }
      },
      error: function () {
        showMessage($form, HomerixNewsletter.strings.error, 'error');
      },
      complete: function () {
        $submitBtn.prop('disabled', false).text(originalBtnText);
      }
    });
  }

  /**
   * Validate email format.
   *
   * @param {string} email Email to validate.
   * @return {boolean}
   */
  function isValidEmail(email) {
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
  }

  /**
   * Show message below form.
   *
   * @param {jQuery} $form    The form element.
   * @param {string} message  Message to display.
   * @param {string} type     Message type (success/error).
   */
  function showMessage($form, message, type) {
    // Remove any existing message.
    $form.next('.newsletter-message').remove();

    // Create message element.
    var bgColor = type === 'success' ? 'rgba(16, 185, 129, 0.9)' : 'rgba(239, 68, 68, 0.9)';
    var $message = $('<div class="newsletter-message" style="margin-top: 10px; padding: 10px 15px; border-radius: 4px; color: #fff; background: ' + bgColor + '; text-align: center; font-size: 14px;">' + message + '</div>');

    // Append AFTER the form instead of inside it.
    $form.after($message);

    setTimeout(function () {
      $message.fadeOut(300, function () {
        $(this).remove();
      });
    }, 5000);
  }

  // Initialize when DOM is ready.
  $(document).ready(function () {
    initNewsletterForms();
  });

})(jQuery);
