<template>
    <div>
        <div class="box box-inline-block-top">
            <div class="box-header">أمنياتي</div>
            <div class="box-content">
                <template v-if="products">
                    <div v-if="products.length">
                        <!-- <wishlisted-item v-for="(item,index) in products"
                                         :product="item.product"
                                         :key="'item'+index"></wishlisted-item> -->
                    </div>

                    <div v-if="products.length === 0" class="text-center">
                        لا يوجد
                    </div>
                </template>
                <div class="text-center">
                    <font-awesome-icon icon="spinner" v-if="loading" spin></font-awesome-icon>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props  : ['route'],
        data() {
            return {
                products: null,
                loading : true
            }
        },
        mounted() {
            this.getItems()
        },
        methods: {
            getItems() {
                this.loading = true
                axios.get(this.route).then(res => {
                    this.loading = false
                    if (res.data) {
                        this.products = res.data
                    }
                }).catch(error => {
                    this.loading = false

                })

            },
        }
    }
</script>
