<template>
    <div class="col-sm-6">
        <div class="box box-info collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {{$t('Product Filters')}}
                </h3>
                <button type="button" :class="`btn btn-box-tool pull-${$t('direction_end')}`"
                        data-widget="collapse">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="box-body">
                <template v-for="filter in filters">
                    <div class="col-sm-12">
                        <div class="box box-solid">
                            <div class="box-body">
                                <h4 class="group-name">{{filter.name_ar}}</h4>
                                <div class="form-horizontal">
                                    <div class="checkbox" v-for="option in filter.options">
                                        <label>
                                            <input type="checkbox" :value="option.id" v-model="checkedFilters">
                                            {{option.name_ar}}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
            <div class="box-footer">
                <div :class="`text-${$t('direction_end')}`">
                    <button class="btn btn-info" @click="updateFilters">
                        {{$t('Save')}}
                    </button>
                </div>
            </div>
            <div class="overlay" v-if="loading">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name    : "ProductFilter",
        props   : ['filters', 'action', 'initial_product'],
        data() {
            return {
                loading       : false,
                checkedFilters: []
            }
        },
        mounted() {
            this.checked()
        },
        computed: {},
        methods : {
            updateFilters() {
                if (!this.loading) {
                    this.loading = true

                    axios.post(this.action, {
                        product_id    : this.initial_product.id,
                        filter_options: this.checkedFilters
                    }).then(res => {
                        this.loading = false
                    }).catch(res => {
                        this.loading = false

                    })

                }
            },
            checked() {
                this.filters.forEach(filter => {
                    filter.options.forEach(option => {
                        let index = this.initial_product.filter_options.findIndex(item => item.id === option.id)
                        if (index > -1) {
                            this.checkedFilters.push(option.id)
                        }
                    })
                })

            }
        }
    }
</script>

<style scoped>
    .group-name {
        background-color : #f7f7f7;
        font-size        : 18px;
        text-align       : center;
        padding          : 7px 10px;
        margin-top       : 0;
    }

</style>