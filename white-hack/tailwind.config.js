import forms from '@tailwindcss/forms'
import typography from '@tailwindcss/typography'

export default {
  content: [
    "./resources/views/**/*.blade.php",
    "./resources/js/**/*.js",
  ],
  darkMode: 'class',
  theme: {
    extend: {
      colors: {
        brand: {
          50:"#E8FFF9",100:"#C9FFF1",200:"#93FBE2",300:"#5CEFD0",
          400:"#2DD7BD",500:"#12BBA5",600:"#0F9687",700:"#0D776C",
          800:"#0C5F58",900:"#0A4D49",
        },
        base: {
          bg:"#0B1220", surface:"#121A2A", border:"#1E293B",
          text:"#E2E8F0", muted:"#94A3B8"
        }
      },
      boxShadow:{
        soft:'0 8px 30px rgba(0,0,0,0.25)'
      },
      maxWidth: { prose: '72ch' }
    }
  },
  plugins:[typography, forms],
}
