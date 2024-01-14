<template>
    <div class="custom-multiselect">
        <multiselect v-model="selection"
                     :options="options"
                     :loading="isLoading"
                     :internal-search="false"
                     :clear-on-select="false"
                     :placeholder="$t('Search')"
                     :hide-selected="true"
                     :close-on-select="false"
                     track-by="name"
                     :limit="5"
                     ref="select"
                     label="name"
                     :showLabels="false"
                     :multiple="multiple"
                     :options-limit="50"
                     :searchable="true"
                     @input="updateTotalPrice"
                     @search-change="getProducts">

            <template slot="option" slot-scope="props">
                <img class="option__image" :src="props.option.thumbnail"
                     onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';">
                <div class="option__desc">
                    <span class="option__title">{{ props.option.name }}</span>
                    <span class="option__small">{{ props.option.original_price }}</span>
                </div>
            </template>
            <template slot="clear" slot-scope="props">
                <div class="multiselect__clear" v-if="options.length"
                     @mousedown.prevent.stop="clearAll(props.search)"></div>
            </template>
            <span slot="noResult">
                <span v-if="text.length < 3">
                    النص قصير
                </span>
                <span v-else>
                    لا يوجد نتائج
                </span>
            </span>
        </multiselect>
        <template v-for="(product, index) in selection">
            <div class="col-sm-12 no-padding margin-top" :key="index">
                <div class="col-sm-3 no-padding">{{product.theName}}</div>
                <div class="col-sm-9">الكمية <input type="tel" v-model="product.into_package_quantity" @keyup="updateTotalPrice(selection)" /></div>
            </div>
        </template>

        <input v-for="product in products" type="hidden" name="products[]" :value="product" />
    </div>
</template>

<script>
    export default {
        name    : "PackageProductSelect",
        props   : ['name', 'selected', 'multiple', 'calc_total'],
        data() {
            return {
                selection: [],
                options  : [],
                isLoading: false,
                text     : '',
                products : []
            }
        },
        mounted() {
            if (this.selected) {
                this.selection = this.selected
            }
            if (this.calc_total) {
                this.updateTotalPrice(this.selection)
            }
        },
        computed: {

        },
        methods : {
            getProducts(query) {
                this.text = query
                if (query.length > 1) {
                    this.isLoading = true
                    axios.get('/admin/products?name=' + query).then(res => {
                        this.options   = res.data.products
                        this.isLoading = false
                    }).catch(res => {
                        // console.log(res.response.data);
                    })
                }
            },
            clearAll() {
                this.selection = []
            },
            updateTotalPrice(value, id) {
                if (this.calc_total) {
                    let vm = this
                    this.products = []
                    let total = 0
                    value.map(item => {
                        if (!item.into_package_quantity) {
                            item.into_package_quantity = 1
                        }
                        total += parseFloat(item.original_price * item.into_package_quantity)
                        vm.products[vm.products.length] = '{"product_id": '+ item.id +', "into_package_quantity": '+ item.into_package_quantity +'}'
                    })
                    this.$root.totalProductPrice = total
                }
            }
        }
    }
</script>

<style lang="scss" scoped>
    .margin-top {
        margin-top: 10px;
    }
</style>