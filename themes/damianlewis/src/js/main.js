import Vue from 'vue'
import Navigation from './components/Navigation'
import NavigationButton from './components/NavigationButton'

Vue.component('navigation', Navigation)
Vue.component('navigation-button', NavigationButton)

new Vue({
    el: '#page',

    data: {
        showNavigation: false,
    },
})
