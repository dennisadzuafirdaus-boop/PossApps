/**
 * Login Form Service
 * Handles all login form interactions and animations
 */

export class LoginFormService {
  constructor() {
    this.passwordInput = '#password';
    this.toggleButton = '.toggle-password';
    this.loginForm = '#loginForm';
    this.loginButton = '#btnLogin';
    this.formControl = '.form-control';
  }

  /**
   * Initialize all login form handlers
   */
  init() {
    this.setupPasswordToggle();
    this.setupFormSubmit();
    this.setupInputFocus();
  }

  /**
   * Setup password visibility toggle
   */
  setupPasswordToggle() {
    document.addEventListener('click', (e) => {
      if (e.target.closest(this.toggleButton)) {
        const passwordInput = document.querySelector(this.passwordInput);
        const icon = e.target.closest(this.toggleButton).querySelector('i');

        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          passwordInput.type = 'password';
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      }
    });
  }

  /**
   * Setup form submit animation
   */
  setupFormSubmit() {
    const form = document.querySelector(this.loginForm);
    if (!form) return;

    form.addEventListener('submit', () => {
      const btn = document.querySelector(this.loginButton);
      btn.classList.add('loading');
      btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
    });
  }

  /**
   * Setup input focus animations
   */
  setupInputFocus() {
    const inputs = document.querySelectorAll(this.formControl);

    inputs.forEach((input) => {
      input.addEventListener('focus', () => {
        const icon = input.parentElement.querySelector('i');
        if (icon) {
          icon.style.transform = 'translateY(-50%) scale(1.2)';
        }
      });

      input.addEventListener('blur', () => {
        const icon = input.parentElement.querySelector('i');
        if (icon) {
          icon.style.transform = 'translateY(-50%) scale(1)';
        }
      });
    });
  }
}

export default LoginFormService;
