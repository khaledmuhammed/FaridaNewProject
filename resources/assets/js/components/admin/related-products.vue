<template>
    <div class="col-sm-6">
        <div class="box box-info collapsed-box">
            <div class="box-header with-border">
                <div class="box-title">
                    {{$t('Related Products')}}
                </div>
                <button type="button" :class="`btn btn-box-tool pull-${$t('direction_end')}`"
                        data-widget="collapse">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="box-body">
                <product-select name="product_id"
                                :selected="selected"
                                :multiple="true"
                                ref="products">
                </product-select>
            </div>
            <div class="box-footer">
                <div :class="`text-${$t('direction_end')}`">
                    <button class="btn btn-info" @click="save">
                        {{$t('Save')}}
                    </button>
                </div>
            </div>
            <div class="overlay" v-if="isLoading">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name    : "RelatedProducts",
        props   : ['name', 'selected', 'product'],
        data() {
            return {
                selection: [],
                options  : [],
                isLoading: false,
                text     : ''
            }
        },
        mounted() {

        },
        computed: {},
        methods : {
            save() {
                if (!this.isLoading) {
                    this.isLoading = true
                    let ids        = []
                    this.$refs.products.selection.forEach(item => {
                        ids.push(item.id)
                    })
                    axios.post('/admin/products/related/' + this.product.id, {products: ids}).then(res => {
                        console.log(res.data);
                        this.isLoading = false
                    }).catch(res => {
                        this.isLoading = false

                    })
                }
            }
        }
    }
</script>

<style lang="scss" scoped>

</style>