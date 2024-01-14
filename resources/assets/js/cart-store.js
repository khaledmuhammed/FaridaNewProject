function findItemIndex(state, item) {
    return state.items.findIndex(i => {
        return (item.id === i.id && item.type === i.type && (item.option_id ? item.option_id === i.option_id : true))
    });
}

function findItemWithPropertyInex(state, item){
    return state.items.findIndex(i => item.id === i.id && item.type === i.type && item.property_value_id === i.property_value_id)
}

function hasPackage(state, product) {
    return findItemIndex(state, {
        id  : product.product_package_id,
        type: 'package'
    })
}


// initial state
// shape: [{ id, quantity }]

const state = {
    items : [],
    prices: {
        totalPrice       : 0,
        additionalOptions: 0,
        shipping         : 0,
        payment          : 0,
        discount         : 0,
        vat              : 0
    },

};

// getters
const getters = {
    getGrossPrice: state => {
        return (state.prices.shipping + state.prices.payment + state.prices.additionalOptions + state.prices.totalPrice)
    },
    getTotalPrice: state => {
        return state.prices.totalPrice
    }

};


// mutations
const mutations = {
    removeCartItem(state, item) {
        let i = item.property_value_id ?  findItemWithPropertyInex(state, item):  findItemIndex(state, item); //find item index
        state.items.splice(i, 1) //delete it
    },
    clearCart(state) {
        state.prices.totalPrice = 0;
        state.items             = []
    },

    updateCart(state, item) {

        let i = item.property_value_id ? findItemWithPropertyInex(state, item): findItemIndex(state, item);
        // if item was new to cart so push it directly
        if (i === -1) {
            state.items.push({
                id          : item.id,
                quantity    : item.quantity ? item.quantity : 1,
                type        : item.type,
                option_id   : item.option_id,
                maxQuantity : item.maxQuantity,
                delivery_time : item.delivery_time,
                delivery_day  : item.delivery_day,
                property_value_id : item.property_value_id ? item.property_value_id : null
            })
        } else { // increase the quantity
            state.items[i].quantity = state.items[i].quantity + item.quantity
        }

    },
    increaseQuantity(state, item) {
        let i = findItemIndex(state, item);

        state.items[i].quantity = state.items[i].quantity++
    },
    decreaseQuantity(state, item) {
        let i                   = findItemIndex(state, item);
        state.items[i].quantity = state.items[i].quantity--
    },
    updateTotalPrice(state, total) {
        state.prices.totalPrice = total
    },
    updateTotalVAT(state, totalVAT) {
        state.prices.vat = totalVAT
    },
    updateDiscount(state, discount) {
        state.prices.discount = discount
    },
};
// actions
const actions   = {
    addToCart(context, item) {
        context.commit('updateCart', item)
    },
    increaseQuantity(context, item) {
        context.commit('increaseQuantity', item)
    },
    decreaseQuantity(context, item) {
        context.commit('decreaseQuantity', item)
    },
    removeFromCart(context, item) {
        context.commit('removeCartItem', item)
    },
    clearCart(context) {
        context.commit('clearCart')
    },
};
export default {
    state,
    getters,
    actions,
    mutations
}