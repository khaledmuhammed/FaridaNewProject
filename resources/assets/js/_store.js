import Vue                  from 'vue'
import Vuex                 from 'vuex'
import createPersistedState from "vuex-persistedstate";
import cart                 from "./cart-store";
import Cookies              from "js-cookie";
import axios                from "axios";

Vue.use(Vuex, axios, Cookies);

export default new Vuex.Store({

    state    : {

        checkout: {
            address     : null,
            shipping    : null,
            shippingDate: null,
            shippingTime: null,
            extraOptions: [],
            payment     : null,
            coupon      : null,
            guest_info  : {
                username        : null,
                email           : null,
                mobile          : null,
                address_owner   : null,
                address_details : null,
                district_id     : null,
                country_id      : null,
                city_id         : null,

            },
            receiver_info   : {
                another_reciver_checked : false,
                receiver_name           : null,
                receiver_mobile         : null,
                receiver_country_id     : null,
                receiver_city_id        : null,
                receiver_district_id    : null,
            } 
        },

        wishlist: []

    },
    mutations: {
        updatePayment(state, {value, price}) {
            state.checkout.payment    = value
            state.cart.prices.payment = price
        },
        updateShipping(state, {value, price}) {
            state.checkout.shipping    = value;
            state.cart.prices.shipping = price
        },
        updateCoupon(state, value) {
            state.checkout.coupon = value
        },
        addToWishlist(state, value) {
            state.wishlist.push(value)
        },
        removeFromWishlist(state, value) {
            state.wishlist.splice(value, 1)
        },
        syncWishlist(state,value) {
            state.wishlist = value
        },
    },
    actions  : {
        addToWishlist(context, product_id) {
            axios.post('/wishlist/' + product_id).then(() => {
                context.commit('addToWishlist',product_id)
                // context.state.wishlist.push(product_id)
                // myStorage.setItem('wishlist', JSON.stringify(context.state.wishlist))
            })
        },
        removeFromWishlist(context, product_id) {
            axios.post('/wishlist/' + product_id).then(() => {
                let index = context.state.wishlist.findIndex(item => {return item === product_id});
                context.commit('removeFromWishlist',index)
                // myStorage.setItem('wishlist', JSON.stringify(context.state.wishlist))
            })
        },
        syncWishlist(context) {
            axios.get('/getWishlist').then(res => {
                context.commit('syncWishlist',res.data)
            })
        },
    },
    getters  : {
        getShippingAddressId: state => {
            return state.checkout.address
        },
    },
    plugins  : [createPersistedState({
        key    : 'store',
        storage: {

            getItem   : key => Cookies.get(key), // Please see https://github.com/js-cookie/js-cookie#json, on how to
                                                 // handle JSON.
            setItem   : (key, value) => Cookies.set(key, value, {
                expires: 3, // secure : true
            }),
            removeItem: key => Cookies.remove(key)
        },
        paths  : ['wishlist', 'cart.items']
    })],
    modules  : {
        cart,
    },
});
