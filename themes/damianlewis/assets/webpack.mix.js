const mix = require('laravel-mix')
const CompressionPlugin = require('compression-webpack-plugin')
require('mix-tailwindcss')
require('laravel-mix-purgecss')

let config = {
  srcPath: 'src',
  distPath: mix.inProduction() ? '' : 'development',
}

mix.js(`${config.srcPath}/js/navigation.js`, 'js').
  js(`${config.srcPath}/js/accordion_list.js`, 'js')

mix.extract(['vue'])

mix.sass(`${config.srcPath}/sass/main.scss`, 'css').
  tailwind().
  purgeCss({
    extensions: ['htm', 'vue'],
    folders: ['../'],
  })

if (mix.inProduction()) {
  mix.webpackConfig({
    plugins: [
      new CompressionPlugin(),
    ],
  })
}

mix.setPublicPath(config.distPath)

mix.browserSync({
  proxy: 'https://damianlewis.test',
  reloadOnRestart: true,
  notify: false,
  files: [
    '../**/*.+(htm|txt|css|js)',
    '../../../plugins/**/*.+(php|yaml|htm)',
  ],
})
