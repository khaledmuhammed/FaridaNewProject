<template>
    <div>
        <carousel :autoplay="true" dir="ltr"
                  :responsive="size != 12 ? {0:{items:2,nav:false},600:{items:3,nav:true},800:{items:4,nav:true}} : {0:{items:2,nav:false}}"
                  :loop="false"
                  :dots="false"
                  :stagePadding="size != 12 ? 0 : 0">
            <featured-product v-for="(product,index) in products" :key="index" v-if="show"
                              :product="product"></featured-product>
        </carousel>
        <sweet-modal icon="success" ref="modal">
            <h4>
                <span>{{$t('Has been added')}}
                    <span class="product-name" v-if="product">{{product.name}}</span> {{$t('to')}}
                    <span class="cart">{{$t('Cart')}}</span>
                </span>
            </h4>
            <div class="buttons margin-top">
                <button class="btn btn-info btn-lg" @click="closeModal">{{$t('Continue shopping')}}</button>
                <a class="btn btn-primary btn-lg" href="/checkout">{{$t('Checkout')}}</a>
            </div>
        </sweet-modal>

    </div>
</template>

<script>

    export default {
        props   : ['auth', 'size', 'items', 'category_id'],
        data() {
            return {
                products: this.items.sort((a,b) => b.id - a.id),
                product : null
            }
        },
        computed: {
            show() {
                return this.products.length
            },
            currentQuantity() {
                if (this.product) {
                    return this.$root.$refs.cart.getQuantity(this.product) + this.quantity
                } else {
                    return 0
                }
            }
        },
        methods : {
            addToCart(product, current_quantity) {
                if (product.options.length > 0) {
                    window.location = '/products/'+product.id
                    return;
                }

                let item = {
                    id          : product.id,
                    type        : 'product',
                    quantity    : 1,
                    option_id   : product.option_id ? product.option_id : '',
                    max_quantity: product.maxQuantity,
                }
                if (current_quantity < product.maxQuantity) {
                    this.$root.$refs.cart.addCartItem(item)
                    this.$store.dispatch('addToCart', item).then(() => {
                        this.product = product
                        this.$refs.modal.open()
                    })
                }
            },
            closeModal() {
                this.$refs.modal.close()
            },
            filterProducts(filterOptions) {
                axios.post('/categories/' + this.category_id, {'filter_options': filterOptions}).then(res => {
                    this.products = res.data.sort((a,b) => b.id - a.id);
                })
            }
        },
        mounted() {
        }

    }
</script>
<style lang="sass" scoped>

    .fade-enter-active, .fade-leave-active
        transition : opacity .5s

    .fade-enter, .fade-leave-to
        opacity : 0

    .slide-fade-enter-active
        transition : all .3s ease

    .slide-fade-leave-active
        transition : all .3s cubic-bezier(1.0, 0.5, 0.8, 1.0)

    .slide-fade-enter, .slide-fade-leave-t
        transform : translateX(10px)
        opacity : 0

</style>
