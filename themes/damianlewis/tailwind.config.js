module.exports = {
  theme: {
    colors: {
      white: '#FFF',
      black: {
        default: '#000',
        90: 'rgba(0,0,0, 0.9)',
      },
      red: {
        100: '#FBF9F9',
        500: '#CF2017',
        700: '#A71D15',
      },
      grey: {
        100: '#FEFEFE',
        300: '#CFCFCF',
        400: '#A7A1A1',
        600: '#4A4A4A',
        700: '#333030',
        800: '#2B2929',
        900: '#161616',
      },
    },
    fontFamily: {
      'heading': ['triplex-serif', 'serif'],
      'body': ['depot-new-web', 'sans-serif'],
      'button': ['circe', 'sans-serif'],
    },
    fontSize: {
      '3xs': '12px',
      '2xs': '13px',
      'xs': '14px',
      'sm': '16px',
      'base': '17px',
      'lg': '18px',
      'xl': '19px',
      '2xl': '21px',
      '3xl': '24px',
      '4xl': '28px',
      '5xl': '36px',
      '6xl': '48px',
    },
    letterSpacing: {
      tightest: '-0.075',
      tighter: '-0.05em',
      tight: '-0.025em',
      normal: '0',
      wide: '0.025em',
      wider: '0.05em',
      widest: '0.075em',
    },
    lineHeight: {
      tightest: 1.125,
      tighter: 1.25,
      tight: 1.375,
      normal: 1.5,
      loose: 1.625,
      looser: 1.75,
      loosest: 1.875,
    },
    spacing: {
      0: '0',
      1: '3px',
      2: '6px',
      4: '12px',
      6: '18px',
      8: '24px',
      12: '36px',
      16: '48px',
      18: '54px',
      20: '60px',
      24: '72px',
      28: '84px',
      32: '96px',
      36: '108px',
      40: '120px',
      50: '150px',
      88: '264px',
    },
    extend: {
      borderWidth: {
        3: '3px'
      }
    },
  },
  variants: {
    margin: ['responsive', 'last']
  },
  plugins: [],
}
