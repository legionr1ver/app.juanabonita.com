/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'primary': '#984061',
        'on-primary': '#ffffff',
        'primary-container': '#ffd9e2',
        'on-primary-container': '#3e001d',
        'secondary': '#74565f',
        'on-secondary': '#ffffff',
        'secondary-container': '#ffd9e2',
        'on-secondary-container': '#2b151c',
        'tertiary': '#7c5635',
        'on-tertiary': '#ffffff',
        'tertiary-container': '#ffdcc2',
        'on-tertiary-container': '#2e1500',
        'surface': '#fffbff',
        'on-surface': '#201a1b',
        'surface-variant': '#f2dde2',
        'on-surface-variant': '#514347',
        'outline': '#837377',
        'error': '#ba1a1a',
        'on-error': '#ffffff',
        'error-container': '#ffdad6',
        'on-error-container': '#410002',
      },
    },
  },
  plugins: [],
}

