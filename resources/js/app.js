/**
 * Application entry point for Precious Real Estate theme
 * Contains global utilities, API helpers, and form handlers
 */

// ============================================================================
// CSRF Token Setup
// ============================================================================

/**
 * Get CSRF token from meta tag
 */
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

// ============================================================================
// API Client Utilities
// ============================================================================

/**
 * Global API client for making requests
 */
window.api = {
    /**
     * Get common headers for all requests
     */
    _getHeaders(options = {}) {
        return {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': getCsrfToken(),
            ...options.headers
        };
    },

    /**
     * Make a GET request
     */
    get(url, options = {}) {
        return fetch(url, {
            method: 'GET',
            headers: this._getHeaders(options),
            ...options
        }).then(this._handleResponse);
    },

    /**
     * Make a POST request
     */
    post(url, data = {}, options = {}) {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                ...this._getHeaders(options)
            },
            body: JSON.stringify(data),
            ...options
        }).then(this._handleResponse);
    },

    /**
     * Make a PUT request
     */
    put(url, data = {}, options = {}) {
        return fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                ...this._getHeaders(options)
            },
            body: JSON.stringify(data),
            ...options
        }).then(this._handleResponse);
    },

    /**
     * Make a DELETE request
     */
    delete(url, options = {}) {
        return fetch(url, {
            method: 'DELETE',
            headers: this._getHeaders(options),
            ...options
        }).then(this._handleResponse);
    },

    /**
     * Handle API response
     */
    async _handleResponse(response) {
        const data = response.ok ? await response.json() : await response.json().catch(() => ({}));

        if (!response.ok) {
            const error = new Error(data.message || `HTTP ${response.status}: ${response.statusText}`);
            error.status = response.status;
            error.data = data;
            throw error;
        }

        return data;
    }
};

// ============================================================================
// Form Utilities
// ============================================================================

/**
 * Global form utilities
 */
window.formUtils = {
    /**
     * Validate email format
     */
    isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    },

    /**
     * Validate phone format (basic)
     */
    isValidPhone(phone) {
        return phone && phone.length >= 7;
    },

    /**
     * Clear form errors
     */
    clearErrors(formElement) {
        const errorElements = formElement.querySelectorAll('[data-error]');
        errorElements.forEach(el => el.textContent = '');
    },

    /**
     * Display form error
     */
    setError(fieldName, message, formElement = document) {
        const errorElement = formElement.querySelector(`[data-error="${fieldName}"]`);
        if (errorElement) {
            errorElement.textContent = message;
        }
    }
};

// ============================================================================
// Query Parameter Utilities
// ============================================================================

/**
 * Global URL/Query utilities
 */
window.urlUtils = {
    /**
     * Get query parameter value
     */
    getQueryParam(name) {
        const params = new URLSearchParams(window.location.search);
        return params.get(name);
    },

    /**
     * Get all query parameters as object
     */
    getQueryParams() {
        const params = new URLSearchParams(window.location.search);
        const result = {};
        params.forEach((value, key) => {
            result[key] = value;
        });
        return result;
    },

    /**
     * Build query string from object
     */
    buildQueryString(params) {
        return new URLSearchParams(params).toString();
    }
};

// ============================================================================
// Storage Utilities
// ============================================================================

/**
 * Global storage utilities (localStorage wrapper)
 */
window.storage = {
    /**
     * Set item in localStorage
     */
    set(key, value, expiresIn = null) {
        const item = {
            value: value,
            expires: expiresIn ? Date.now() + expiresIn * 1000 : null
        };
        localStorage.setItem(key, JSON.stringify(item));
    },

    /**
     * Get item from localStorage
     */
    get(key) {
        const item = localStorage.getItem(key);
        if (!item) return null;

        const parsed = JSON.parse(item);

        // Check if expired
        if (parsed.expires && Date.now() > parsed.expires) {
            localStorage.removeItem(key);
            return null;
        }

        return parsed.value;
    },

    /**
     * Remove item from localStorage
     */
    remove(key) {
        localStorage.removeItem(key);
    },

    /**
     * Clear all localStorage
     */
    clear() {
        localStorage.clear();
    }
};

// ============================================================================
// Notifications
// ============================================================================
// 2026-09-08: removed a second, unused, ad-hoc toast implementation that
// lived here (window.notify — top-right, DOM-built on every call, zero call
// sites anywhere in the app). The one real toast system is
// window.showToast(), defined by <x-shared.toast-container> (bottom-right,
// Alpine-driven, included once in both layouts/app.blade.php and
// layouts/cms.blade.php) — use that instead.

// ============================================================================
// Double-Submit Guard
// ============================================================================

/**
 * Disables a form's submit button the instant it's submitted, so a fast
 * double-click (or a slow network response) can't fire the same form twice.
 * Scoped to plain server-rendered forms only — an Alpine-driven form
 * (x-data + @submit.prevent) already manages its own isSubmitting/:disabled
 * state, and this would just fight that reactive binding. Applies
 * automatically to every form site-wide (public + CMS): the CMS especially
 * had a lot of plain POST forms (create/edit screens, login) with no
 * guard at all.
 */
document.addEventListener('submit', (event) => {
    const form = event.target;
    if (!(form instanceof HTMLFormElement)) return;
    if (form.hasAttribute('x-data')) return; // Alpine form — has its own guard
    if (form.checkValidity && !form.checkValidity()) return; // invalid — browser will block submission, don't lock the button

    const button = form.querySelector('button[type="submit"], input[type="submit"]');
    if (!button || button.disabled) return;

    button.disabled = true;
    button.classList.add('opacity-50', 'cursor-not-allowed');
}, true);

// ============================================================================
// Array & Object Utilities
// ============================================================================

/**
 * Global utility functions
 */
window.utils = {
    /**
     * Debounce function calls
     */
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    /**
     * Throttle function calls
     */
    throttle(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    },

    /**
     * Format currency
     */
    formatCurrency(amount, currency = 'MWK') {
        return `${currency} ${parseFloat(amount).toLocaleString()}`;
    },

    /**
     * Format date
     */
    formatDate(date, format = 'DD/MM/YYYY') {
        const d = new Date(date);
        const day = String(d.getDate()).padStart(2, '0');
        const month = String(d.getMonth() + 1).padStart(2, '0');
        const year = d.getFullYear();

        return format
            .replace('DD', day)
            .replace('MM', month)
            .replace('YYYY', year);
    },

    /**
     * Deep clone object
     */
    deepClone(obj) {
        return JSON.parse(JSON.stringify(obj));
    }
};

// ============================================================================
// Initialize on DOM Ready
// ============================================================================

document.addEventListener('DOMContentLoaded', () => {
    // Add any initialization code here
    console.log('Precious Real Estate app initialized');
});

Alpine.start()
