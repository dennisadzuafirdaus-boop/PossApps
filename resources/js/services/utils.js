/**
 * Common Utilities
 * Shared utility functions across the application
 */

/**
 * Format currency to Indonesian Rupiah
 * @param {number} amount
 * @returns {string}
 */
export function formatCurrency(amount) {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(amount);
}

/**
 * Format date to Indonesian format
 * @param {string|Date} date
 * @returns {string}
 */
export function formatDate(date) {
  const d = new Date(date);
  return new Intl.DateTimeFormat('id-ID', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }).format(d);
}

/**
 * Show toast notification
 * @param {string} message
 * @param {string} type - 'success', 'error', 'info', 'warning'
 */
export function showToast(message, type = 'info') {
  const toastClass = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : type}`;
  const toast = document.createElement('div');
  toast.className = toastClass;
  toast.innerHTML = message;
  toast.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';

  document.body.appendChild(toast);

  setTimeout(() => {
    toast.remove();
  }, 5000);
}

/**
 * Debounce function for event handlers
 * @param {function} func
 * @param {number} wait
 * @returns {function}
 */
export function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

/**
 * Throttle function for event handlers
 * @param {function} func
 * @param {number} limit
 * @returns {function}
 */
export function throttle(func, limit) {
  let inThrottle;
  return function (...args) {
    if (!inThrottle) {
      func.apply(this, args);
      inThrottle = true;
      setTimeout(() => (inThrottle = false), limit);
    }
  };
}

/**
 * Safely parse JSON
 * @param {string} json
 * @param {*} fallback
 * @returns {*}
 */
export function parseJSON(json, fallback = null) {
  try {
    return JSON.parse(json);
  } catch (e) {
    console.error('JSON parse error:', e);
    return fallback;
  }
}

/**
 * Check if element is in viewport
 * @param {HTMLElement} element
 * @returns {boolean}
 */
export function isInViewport(element) {
  const rect = element.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}

/**
 * Get element by ID (safe version)
 * @param {string} id
 * @returns {HTMLElement|null}
 */
export function getElement(id) {
  return document.getElementById(id);
}

/**
 * Get elements by selector
 * @param {string} selector
 * @returns {NodeList}
 */
export function getElements(selector) {
  return document.querySelectorAll(selector);
}

export default {
  formatCurrency,
  formatDate,
  showToast,
  debounce,
  throttle,
  parseJSON,
  isInViewport,
  getElement,
  getElements,
};
