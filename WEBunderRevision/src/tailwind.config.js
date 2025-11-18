/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./**/*.php", "./**/*.html"],
  theme: {
    extend: {},
  },
  safelist: [
    // Make sure these hover variants are never purged
    'group-hover:opacity-100',
    'group-hover:-translate-y-2',
  ],
  plugins: [],
};
