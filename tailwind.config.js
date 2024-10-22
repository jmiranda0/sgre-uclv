import preset from './vendor/filament/support/tailwind.config.preset'

export default {
   // presets: [preset],
    
    content: [
        './app/Filament/**/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],
     darkMode: 'class',
    theme: {
        extend: {
          backgroundImage: {
            "gradient-radial": "radial-gradient(var(--tw-gradient-stops))",
            "gradient-conic":
              "conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))",
            'gradient-animation': 'linear-gradient(270deg,var(--tw-gradient-stops))',
          },
          keyframes: {
            'dynamic-gradient': {
              '0%, 100%': { 'background-position': '0% 50%', 'background-size': '200% 200%' },
              '50%': { 'background-position': '100% 50%', 'background-size': '300% 300%' },
            },
          },
          animation: {
            'dynamic-gradient': 'dynamic-gradient 6s ease-in-out infinite',
          },
        },
      },
}
