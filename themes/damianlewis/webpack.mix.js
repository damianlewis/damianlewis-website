const mix = require('laravel-mix')
require('mix-tailwindcss')

let config = {
  srcPath: 'src',
  distPath: mix.inProduction() ? 'assets' : 'assets/development',
}

mix.js(`${config.srcPath}/js/main.js`, 'js')

mix.extract(['vue'])

mix.sass(`${config.srcPath}/sass/main.scss`, 'css').
  tailwind().
  setPublicPath(config.distPath)

mix.browserSync({
  proxy: 'https://damianlewis.test',
  reloadOnRestart: true,
  notify: false,
  files: [
    './**/*.+(htm|txt|css|js)',
    '../../plugins/**/*.+(php|yaml|htm)',
  ],
})
