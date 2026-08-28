module.exports = {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  // Ces polices importées depuis /font ne sont pas encore utilisées dans les vues :
  // sans safelist, le scan de contenu de Tailwind ne générerait pas ces classes tant
  // qu'aucun fichier ne les référence littéralement.
  safelist: [
    'font-technique',
    'font-technique-hollow',
    'font-technique-hollow-inverse',
    'font-technique-inverse',
    'font-natural',
  ],
  theme: {
    extend: {
      fontFamily: {
        'sans': ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        'display': ['"Space Grotesk"', 'Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        'mono': ['"JetBrains Mono"', 'ui-monospace', 'SFMono-Regular', 'monospace'],
        // Polices auto-hébergées importées depuis /font (voir @font-face dans app.css).
        'technique': ['"Technique"', '"Space Grotesk"', 'sans-serif'],
        'technique-hollow': ['"Technique Hollow"', '"Space Grotesk"', 'sans-serif'],
        'technique-hollow-inverse': ['"Technique Hollow Inverse"', '"Space Grotesk"', 'sans-serif'],
        'technique-inverse': ['"Technique Inverse"', '"Space Grotesk"', 'sans-serif'],
        'natural': ['"Natural Technologies"', 'cursive'],
      },
      colors: {
        // Tokens sémantiques de thème : la valeur change via les variables CSS
        // définies dans app.css (:root = clair, .dark = sombre). Toujours
        // préférer ces classes (bg-surface-*, text-ink-*) aux couleurs slate/white
        // codées en dur pour que le composant s'adapte aux deux thèmes.
        surface: {
          canvas: 'var(--surface-canvas)',
          raised: 'var(--surface-raised)',
          overlay: 'var(--surface-overlay)',
          sunken: 'var(--surface-sunken)',
        },
        ink: {
          primary: 'var(--text-primary)',
          secondary: 'var(--text-secondary)',
          muted: 'var(--text-muted)',
        },
        // Identité de marque Infinity WAB : palette officielle (Adobe Color) —
        // navy #012340, bleu acier #3B6D8C, cyan #5BC2D9, sauge #6BBFA0, gris #F2F2F2.
        // Échelle complète (50-900) pour couvrir aussi les usages "admin" (badges,
        // focus, fonds légers) sans retomber sur des couleurs Tailwind génériques
        // (indigo, blue, purple...) hors de la marque.
        mint: {
          50: '#f0f9f5',
          100: '#dcf0e6',
          200: '#b8e2cd',
          300: '#94d3b3',
          400: '#82cba6',
          500: '#6bbfa0', // exact palette
          600: '#52a687',
          700: '#3f8569',
          800: '#2f634f',
          900: '#234a3a',
        },
        azure: {
          50: '#eaf8fb',
          100: '#cdedf5',
          200: '#a3dfec',
          300: '#7dd2e2',
          400: '#5bc2d9', // exact palette
          500: '#4a9ab5',
          600: '#3b6d8c', // exact palette
          700: '#2c5268',
          800: '#1f3c4d',
          900: '#162a37',
        },
        dark: {
          50: '#fafafa',
          100: '#f4f4f5',
          200: '#e4e4e7',
          300: '#d4d4d8',
          400: '#a1a1aa',
          500: '#71717a',
          600: '#52525b',
          700: '#3f3f46',
          800: '#27272a',
          900: '#18181b',
          950: '#09090b',
        },
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
        'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
        'hero-pattern': "url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%239C92AC\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')",
        'mesh-gradient': 'linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #c471f5 75%, #667eea 100%)',
        'aurora': 'linear-gradient(135deg, #00d2ff 0%, #3a7bd5 50%, #00d2ff 100%)',
        'sunset': 'linear-gradient(135deg, #ff6b6b 0%, #feca57 50%, #48dbfb 100%)',
        'ocean': 'linear-gradient(135deg, #2e3192 0%, #1bffff 100%)',
        'forest': 'linear-gradient(135deg, #134e5e 0%, #71b280 100%)',
      },
      backdropBlur: {
        xs: '2px',
      },
      animation: {
        'fade-in': 'fadeIn 0.8s ease-out forwards',
        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
        'fade-in-down': 'fadeInDown 0.8s ease-out forwards',
        'slide-in-left': 'slideInLeft 0.8s ease-out forwards',
        'slide-in-right': 'slideInRight 0.8s ease-out forwards',
        'scale-in': 'scaleIn 0.6s ease-out forwards',
        'float': 'float 6s ease-in-out infinite',
        'float-delayed': 'float 8s ease-in-out infinite',
        'float-slow': 'float 10s ease-in-out infinite',
        'pulse-slow': 'pulse 4s ease-in-out infinite',
        'bounce-slow': 'bounce 3s ease-in-out infinite',
        'spin-slow': 'spin 8s linear infinite',
        'wiggle': 'wiggle 1s ease-in-out infinite',
        'gradient': 'gradient 3s ease infinite',
        'glow': 'glow 2s ease-in-out infinite alternate',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0', transform: 'translateY(20px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeInUp: {
          '0%': { opacity: '0', transform: 'translateY(40px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        fadeInDown: {
          '0%': { opacity: '0', transform: 'translateY(-40px)' },
          '100%': { opacity: '1', transform: 'translateY(0)' },
        },
        slideInLeft: {
          '0%': { opacity: '0', transform: 'translateX(-40px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        slideInRight: {
          '0%': { opacity: '0', transform: 'translateX(40px)' },
          '100%': { opacity: '1', transform: 'translateX(0)' },
        },
        scaleIn: {
          '0%': { opacity: '0', transform: 'scale(0.9)' },
          '100%': { opacity: '1', transform: 'scale(1)' },
        },
        float: {
          '0%, 100%': { transform: 'translateY(0px)' },
          '50%': { transform: 'translateY(-20px)' },
        },
        wiggle: {
          '0%, 100%': { transform: 'rotate(-3deg)' },
          '50%': { transform: 'rotate(3deg)' },
        },
        gradient: {
          '0%, 100%': { backgroundPosition: '0% 50%' },
          '50%': { backgroundPosition: '100% 50%' },
        },
        glow: {
          '0%': { boxShadow: '0 0 20px rgba(59, 130, 246, 0.5)' },
          '100%': { boxShadow: '0 0 30px rgba(59, 130, 246, 0.8)' },
        },
      },
      boxShadow: {
        'glow': '0 0 20px rgba(59, 130, 246, 0.5)',
        'glow-lg': '0 0 40px rgba(59, 130, 246, 0.6)',
        'inner-glow': 'inset 0 0 20px rgba(59, 130, 246, 0.3)',
      },
    },
  },
  plugins: [],
}
