const mix = require('laravel-mix')
require('mix-tailwindcss')

let config = {
  srcPath: 'src',
  distPath: mix.inProduction() ? 'assets' : 'assets/development',
}

mix.js(`${config.srcPath}/js/navigation.js`, 'js').
  js(`${config.srcPath}/js/accordion_list.js`, 'js')

mix.extract(['vue'])

mix.sass(`${config.srcPath}/sass/main.scss`, 'css').
  tailwind()

mix.setPublicPath(config.distPath)

mix.browserSync({
  proxy: 'https://damianlewis.test',
  reloadOnRestart: true,
  notify: false,
  files: [
    './**/*.+(htm|txt|css|js)',
    '../../plugins/**/*.+(php|yaml|htm)',
  ],
})
