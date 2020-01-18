import Vue from 'vue'
import Navigation from './components/Navigation'
import NavigationButton from './components/NavigationButton'

new Vue({
  el: '#navigation',

  components: {
    'navigation': Navigation,
    'navigation-button': NavigationButton,
  },

  data: {
    showNavigation: false,
  },
})