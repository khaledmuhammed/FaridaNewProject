/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue')

import VueInternationalization from 'vue-i18n'
import Locale                  from './vue-i18n-locales.generated'
import Multiselect             from 'vue-multiselect'
import Datepicker              from 'vuejs-datepicker';
import * as languages          from "vuejs-datepicker/src/locale";
import moment                  from 'moment';
import ToggleButton            from 'vue-js-toggle-button/src/Button'

Vue.use(VueInternationalization, Multiselect, Datepicker, languages, moment, ToggleButton)

const lang = document.documentElement.lang.substr(0, 2);

const i18n = new VueInternationalization({
    locale  : lang,
    messages: Locale
});

Vue.component('multiselect', Multiselect);
Vue.component('datepicker', Datepicker);
Vue.component('toggle-button', ToggleButton);

/*
 // global components
 Vue.component('v-media', require('./components/Media.vue'));
 Vue.component('v-color', require('./components/ColorPicker'));
 Vue.component('attribute-group', require('./components/attribute-group/AttributeGroup'));
 Vue.component('toggler', require('./components/Toggler'));
 Vue.component('product-details', require('./components/products/admin/product-details'));
 Vue.component('product-description', require('./components/products/admin/product-description'));
 Vue.component('product-attributes', require('./components/products/admin/product-attributes'));
 Vue.component('product-attribute-field', require('./components/products/admin/product-attribute-field'));
 Vue.component('product-filter', require('./components/products/admin/product-filter'));
 Vue.component('related-products', require('./components/products/admin/related-products'));
 Vue.component('city-select', require('./components/CitySelect'));
 Vue.component('product-select', require('./components/products/admin/product-select'));
 Vue.component('couponables', require('./components/coupon/admin/CouponableType'));
 Vue.component('linked-images', require('./components/linked-images'));
 Vue.component('linked-images-edit', require('./components/linked-images-edit'));
 Vue.component('positionables', require('./components/positionables'));
 */

const files = require.context('./components/admin/', true, /\.vue$/i)
files.keys().map(key => {
    const name = _.last(key.split('/')).split('.')[0]
    return Vue.component(name, files(key))
})

const app = new Vue({
    el      : '#app',
    i18n,
    data() {
        return {
            token            : document.head.querySelector('meta[name="csrf-token"]').content,
            lang             : languages,
            totalProductPrice: 0
        }
    },
    mounted() {},
    methods : {
        dateFormatter(date) {
            return moment(date, "YYYY-MM-DD").format('YYYY-MM-DD');
        }
    },
    computed: {},
});