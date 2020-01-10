import Vue from 'vue'
import Navigation from './components/Navigation'
import NavigationButton from './components/NavigationButton'
import AccordionList from './components/AccordionList'

Vue.component('navigation', Navigation)
Vue.component('navigation-button', NavigationButton)
Vue.component('accordion-list', AccordionList)

new Vue({
    el: '#page',

    data: {
        showNavigation: false,
    },
})
