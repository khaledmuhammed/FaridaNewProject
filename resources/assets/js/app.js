/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./plugins/magiczoomplus');
require('./plugins/magicscroll');

window.Vue = require('vue');

import VueInternationalization from 'vue-i18n'
import Locale                  from './vue-i18n-locales.generated'
import * as languages          from "vuejs-datepicker/src/locale";
import {mapGetters}          from 'vuex'
import VueMoment             from 'vue-moment'
import {SweetModal}          from 'sweet-modal-vue'
import FontAwesomeIcon       from '@fortawesome/vue-fontawesome'
import brands                from '@fortawesome/fontawesome-free-brands'
import VueTippy              from 'vue-tippy'
import store                 from './store'
import checkbox              from 'vue-material-checkbox'
import checkView             from 'vue-check-view'
import carousel              from 'v-owl-carousel'
import {library}             from '@fortawesome/fontawesome-svg-core'
import {faSpinner, faCoffee} from '@fortawesome/free-solid-svg-icons'
import { Datetime }          from "vue-datetime";
import { Settings }          from "luxon";
import "vue-datetime/dist/vue-datetime.css";

library.add(faSpinner, faCoffee)
Vue.use(VueInternationalization, languages, VueMoment, SweetModal, FontAwesomeIcon, brands, checkbox, carousel);
Vue.use(checkView);
Vue.use(VueTippy, {
    flipDuration : 0,
    popperOptions: {
        modifiers: {
            preventOverflow: {
                enabled: true
            }
        }
    }
});

const lang = document.documentElement.lang.substr(0, 2);

const i18n = new VueInternationalization({
    locale  : lang,
    messages: Locale,
    silentTranslationWarn: true
});

Settings.defaultLocale = lang; // for checkout date & time pickers 

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.component('datetime', Datetime);
Vue.component('vue-stars', require('vue-stars').default);
Vue.component('sweet-modal', SweetModal);
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('checkbox', checkbox);
Vue.component('carousel', carousel);

/*
 // global components
 Vue.component('countdown', require('./components/countdown'));

 // product's components
 Vue.component('actions', require('./components/products/actions.vue'));
 Vue.component('media', require('./components/products/media.vue'));
 Vue.component('attributes', require('./components/products/attributes.vue'));
 Vue.component('also-purchased', require('./components/products/also-purchased.vue'));
 Vue.component('free-items', require('./components/products/free-items.vue'));
 Vue.component('packages', require('./components/products/packages.vue'));
 Vue.component('related', require('./components/products/related.vue'));
 Vue.component('rating', require('./components/products/rating.vue'));
 Vue.component('sticky-bar', require('./components/products/sticky-bar'));

 // checkout's components
 Vue.component('v-address', require('./components/checkout/v-address.vue'));
 Vue.component('shipping', require('./components/checkout/shipping.vue'));
 Vue.component('additional-options', require('./components/checkout/additional-options.vue'));
 Vue.component('payment', require('./components/checkout/payment.vue'));
 Vue.component('v-summary', require('./components/checkout/summary.vue'));
 Vue.component('cart', require('./components/cart/cart.vue'));
 Vue.component('code-checker', require('./components/coupon/CodeChecker'));
 // Vue.component('card', require('vue-credit-card'));

 // category's components
 Vue.component('v-product', require('./components/category/product.vue'));
 Vue.component('v-filter', require('./components/category/filter.vue'));
 Vue.component('categories-list', require('./components/category/categories-list.vue'));
 Vue.component('browser', require('./components/category/browser.vue'));

 // Positioning
 Vue.component('position', require('./components/position/position.vue'));
 Vue.component('featured-products', require('./components/position/featured-products.vue'));
 Vue.component('banner', require('./components/position/banner.vue'));

 //search
 Vue.component('search', require('./components/Search.vue'));

 Vue.component('position', require('./components/position.vue'));
 Vue.component('user-orders', require('./components/user-orders'));
 Vue.component('user-addresses', require('./components/user-addresses'));
 Vue.component('user-wishlist', require('./components/user-wishlist'));
 Vue.component('modal', require('./components/modal'));
 Vue.component('banner', require('./components/banner.vue'));
 Vue.component('login', require('./components/login'));
 Vue.component('register', require('./components/register'));
 */

var SocialSharing = require('vue-social-sharing');
Vue.use(SocialSharing);

const files = require.context('./components/frontend/', true, /\.vue$/i)

files.keys().map(key => {
    const name = _.last(key.split('/')).split('.')[0]
    return Vue.component(name, files(key))
})

// const API_URL = "http://qstore.test/api/"
// let myStorage = window.sessionStorage


const app = new Vue({
    el      : '#app',
    i18n,
    data() {
        return {
            success_order: false,
            displayBar   : false,
            e            : {},
            showRegister : false,
            showLogin    : false,
            lang         : languages,
        }
    },
    store,
    updated() {
        if (this.success_order) {
            this.clearCart()
        }
    },
    mounted() {
        this.initializeCart()
        
        // Check if user logged In
        let el_logout = document.getElementById('logout-form')
        if (el_logout) {
            this.initializeWishlist()
        }

        let el = document.getElementById("completeOrder");
        if (el) {
            this.showSweetAlert()
            this.clearCart()
        }
    },
    methods : {
        initializeCart() {
            if (store.state.cart.items.length) {
                store.state.cart.items.forEach(item => {

                    this.$refs.cart.addCartItem(item)
                })
            }
        },
        initializeWishlist() {
            this.$store.dispatch('syncWishlist')
        },
        clearCart() {
            this.$store.dispatch('clearCart');
            this.$refs.cart.clearCart()
        },
        viewScroller(e) {
            this.displayBar = e.percentTop < 0
        },
        showSweetAlert() {
            this.$refs.modal.open()
        }
    },
    computed: {
        ...mapGetters({
            totalPrice: 'getTotalPrice'
        }),


    }
});
