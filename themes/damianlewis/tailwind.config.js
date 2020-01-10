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
    filter: {
      'grayscale-100': 'grayscale(100%)',
      'grayscale-0': 'grayscale(0%)',
    },
    fontFamily: {
      'heading': ['triplex-serif', 'serif'],
      'body': ['depot-new-web', 'sans-serif'],
      'button': ['circe', 'sans-serif'],
      'quote': ['Roboto Slab', 'serif'],
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
      68: '204px',
      82: '246px',
      88: '264px',
      94: '282px',
      132: '396px',
      138: '414px',
      160: '480px',
      172: '516px',
      248: '744px',
      380: '1140px'
    },
    transitionProperty: {
      'none': 'none',
      'bg': 'background-color',
      'opacity': 'opacity',
    },
    transitionDuration: {
      'default': '100ms',
    },
    transitionTimingFunction: {
      'default': 'ease',
    },
    transitionDelay: {},
    willChange: {},
    extend: {
      borderWidth: {
        3: '3px',
      },
      opacity: {
        20: '.2',
        30: '.3',
        35: '.35',
        40: '.4',
        45: '.45',
      },
      maxWidth: {
        380: '1140px'
      },
    },
  },
  variants: {
    filter: ['hover'],
    margin: ['responsive', 'last'],
  },
  plugins: [
    require('tailwindcss-filters')(),
    require('tailwindcss-transitions')(),
  ],
}
