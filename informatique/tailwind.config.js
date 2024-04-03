/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./api/**/*.php"],
  future: {
    hoverOnlyWhenSupported: true,
  },
  theme: {
    extend: {
      colors: {
        eventit: {
          50: "#f5fdfd",
          100: "#ebfafc",
          200: "#cff4f5",
          300: "#b3eded",
          400: "#4fc6cb",
          500: "#38a2a7",
          600: "#2e8186",
          700: "#235e64",
          800: "#183c43",
          900: "#0c1a21",
        },
      },
    },
  },
  plugins: [],
};
