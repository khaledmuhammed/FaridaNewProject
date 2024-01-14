<template>
    <div>
        <div class="form-group">
            <label class="control-label col-sm-2">{{$t('Couponable Type')}}</label>
            <div class="col-sm-10">
                <select v-model="couponable_type" class="form-control">
                    <option v-for="type in types" :value="type.key">{{type.name}}</option>
                </select>
                <input type="hidden" name="couponable_type" :value="couponable_type"/>
            </div>
        </div>
        <div class="form-group" v-if="couponable_type === 'product'">
            <label class="control-label col-sm-2">{{$t('Products')}}</label>
            <div class="col-sm-10">
                <product-select name="product_id"
                                :multiple="true"
                                ref="products">
                </product-select>
            </div>
            <input v-for="id in $refs.products" name="product_id[]" :value="id" type="hidden"/>

        </div>
        <div class="form-group" v-if="couponable_type === 'category'">
            <label class="control-label col-sm-2">{{$t('Categories')}}</label>
            <div class="col-sm-10">
                <multiselect v-model="coupon.categories"
                             :options="categories"
                             :clear-on-select="false"
                             :placeholder="$t('Search')"
                             :hide-selected="true"
                             :close-on-select="false"
                             track-by="id"
                             label="name"
                             :showLabels="false"
                             :multiple="true"
                             :searchable="true">
                    <span slot="noResult">لا يوجد نتائج - no results</span>
                </multiselect>
                <input v-for="id in category_id" name="category_id[]" :value="id" type="hidden"/>
            </div>
        </div>
        <div class="form-group" v-if="couponable_type === 'manufacturer'">
            <label class="control-label col-sm-2">{{$t('Manufacturers')}}</label>
            <div class="col-sm-10">
                <multiselect v-model="coupon.manufacturers"
                             :options="manufacturers"
                             :clear-on-select="false"
                             :placeholder="$t('Search')"
                             :hide-selected="true"
                             :close-on-select="false"
                             track-by="id"
                             label="name"
                             :showLabels="false"
                             :multiple="true"
                             :searchable="true">
                    <span slot="noResult">لا يوجد نتائج - no results</span>
                </multiselect>
                <input v-for="id in manufacturer_id" name="manufacturer_id[]" :value="id" type="hidden"/>
            </div>
        </div>
        <div class="form-group" v-if="couponable_type === 'payment_method'">
            <label class="control-label col-sm-2">{{$t('Payment Method')}}</label>
            <div class="col-sm-10">
                <select v-model="coupon.payment_method" name="payment_method_id" class="form-control" required>
                    <template v-for="(payment_method, key) in payment_methods">
                        <option :key="key" :value="payment_method.id">{{payment_method.theName}}</option>
                    </template>
                </select>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props   : ['types', 'old', 'categories', 'manufacturers', 'payment_methods','old_product', 'old_category', 'old_manufacturer', 'old_payment_method'],
        name    : "CouponableType",
        data() {
            return {
                couponable_type: 'product',
                coupon         : {
                    products     : [],
                    categories   : [],
                    manufacturers: [],
                    payment_method: null
                }
            }
        },
        mounted() {
            this.couponable_type = this.old
            switch (this.couponable_type) {
                case "product":
                    this.coupon.products          = this.old_product.length ? this.old_product : this.coupon.products
                    this.$refs.products.selection = this.coupon.products
                    break
                case "category":
                    this.coupon.categories = this.old_category.length ? this.old_category : this.coupon.categories
                    break
                case "manufacturer":
                    this.coupon.manufacturers = this.old_manufacturer.length ? this.old_manufacturer : this.coupon.manufacturer
                    break
                case "payment_method":
                    this.coupon.payment_method = this.old_payment_method.length ? this.old_payment_method[0].id : null
                    break
                default:
            }
        },
        computed: {
            category_id() {
                let ids = []
                if (this.coupon.categories) {
                    this.coupon.categories.forEach(item => {
                        ids.push(item.id)
                    })
                }
                return ids
            },
            manufacturer_id() {
                let ids = []
                if (this.coupon.manufacturers) {
                    this.coupon.manufacturers.forEach(item => {
                        ids.push(item.id)
                    })
                }
                return ids
            },
        },
    }
</script>

<style scoped>

</style>