<template>

    <div class="col-sm-12">
        <div class="box box-info ">
            <div class="box-header with-border">
                <h3 class="box-title col-sm-6">{{$t('Product Info')}}</h3>
                <div class="col-sm-6">
                    <a :href="`/products/`+product.id" target="_blank" class="btn btn-sm btn-success pull-left">معاينة</a>
                </div>
            </div><!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="form-horizontal">
                    <div class="col-sm-6">
                        <div class="form-group" :class="{'has-error' : errors.name}">
                            <label class="control-label col-sm-3">{{$t('Name')}}</label>
                            <div class="col-sm-9 no-padding">
                                <input v-model="product.name" class="form-control"/>
                                <span class="help-block" v-if="errors.name">{{errors.name[0]}}</span>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error' : errors.name_en}">
                            <label class="control-label col-sm-3">{{$t('English Name')}}</label>
                            <div class="col-sm-9 no-padding">
                                <input v-model="product.name_en" class="form-control"/>
                                <span class="help-block" v-if="errors.name_en">{{errors.name_en[0]}}</span>
                            </div>
                        </div>

                        <div class="form-group" :class="{'has-error' : errors.product_code}">
                            <label class="control-label col-sm-3">{{$t('Product Code')}}</label>
                            <div class="col-sm-9 no-padding">
                                <input v-model="product.product_code" class="form-control"/>
                                <span class="help-block" v-if="errors.product_code">{{errors.product_code[0]}}</span>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error' : errors.weight}">
                            <label class="control-label col-sm-3">{{$t('Product Weight')}}</label>
                            <div class="col-sm-9 no-padding">
                                <input v-model="product.weight" class="form-control"/>
                                <span class="help-block" v-if="errors.weight">{{errors.weight[0]}}</span>
                            </div>
                        </div>

                        <div v-if="!product.properties" class="form-group" :class="{'has-error' : errors.quantity}">
                            <label class="control-label col-sm-3">{{$t('Quantity')}}</label>
                            <div class="col-sm-9 no-padding">
                                <input type="number" v-model="product.quantity" class="form-control"/>
                                <span class="help-block" v-if="errors.quantity">{{errors.quantity[0]}}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3">{{$t('Product Properties')}}</label>
                            <div class="col-sm-9 no-padding">
                                <multiselect 
                                    v-model="product.properties"
                                    :options = "sortedProperties"
                                    track-by = "id"
                                    :label = " $t('direction_end') =='left' ? 'name' : 'name_en'"
                                    :show-labels = "false"
                                    :clear-on-select ="false"
                                    :allow-empty = "true"
                                    placeholder=""
                                />
                            </div>
                            <div v-if="product.properties" style="margin:10px 0;">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <label class="control-label">{{$t('Quantities:')}}</label>
                                    <div v-for="item in product.properties.values" :key="item.id" class="row" style="margin:5px 0;">
                                        <label v-if="product.properties.type == 'selection'" class="control-label col-sm-3">{{item.value}}</label>
                                        <label v-else :style="{border:'1px solid gray', background: item.value, margin:'0 10px', height:'35px'}" class="control-label col-sm-1"></label>
                                        <input type="number" v-model="item.stock" class="form-control col-sm-9">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="product.id" class="form-group" :class="{'has-error' : errors.availability}">
                            <label class="control-label col-sm-3">{{$t('Available?')}}</label>
                            <div class="col-sm-9 no-padding">
                                <toggle-button v-model="product.availability"
                                               :sync="true"
                                               :color="{checked: '#008d4c', unchecked: '#dd4b39', disabled: '#000'}"
                                               :labels="{checked: $t('Yes'), unchecked: $t('No')}"/>
                                <span class="help-block" v-if="errors.availability">{{errors.availability[0]}}</span>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error' : errors.not_sold_alone}">
                            <label class="control-label col-sm-3">لا يباع وحده</label>
                            <div class="col-sm-9 no-padding">
                                <toggle-button v-model="product.not_sold_alone"
                                               :sync="true"
                                               :color="{checked: '#008d4c', unchecked: '#dd4b39', disabled: '#000'}"
                                               :labels="{checked: $t('Yes'), unchecked: $t('No')}"/>
                                <span class="help-block" v-if="errors.not_sold_alone">{{errors.not_sold_alone[0]}}</span>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="form-group" :class="{'has-error' : errors.original_price}">
                            <label class="control-label col-sm-3">{{$t('Original Price')}}</label>
                            <div class="col-sm-9 no-padding">
                                <input type="number" v-model="product.original_price" class="form-control"/>
                                <span class="help-block"
                                      v-if="errors.original_price">{{errors.original_price[0]}}</span>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error' : errors.price_after_discount}">
                            <label class="control-label col-sm-3">{{$t('Price After Discount')}}</label>
                            <div class="col-sm-9 no-padding">
                                <input type="number" v-model="product.price_after_discount" class="form-control"/>
                                <span class="help-block"
                                      v-if="errors.price_after_discount">{{errors.price_after_discount[0]}}</span>
                            </div>
                        </div>

                        <div class="form-group" :class="{'has-error' : errors.category_id}">
                            <label class="control-label col-sm-3">{{$t('Category')}}</label>
                            <div class="col-sm-9 no-padding">
                                <multiselect v-model="product.categories"
                                             :options="categories"
                                             :clear-on-select="false"
                                             :placeholder="$t('Search')"
                                             :hide-selected="true"
                                             :close-on-select="false"
                                             track-by="name"
                                             label="name"
                                             :showLabels="false"
                                             :multiple="true"
                                             :searchable="true">
                                    <span slot="noResult">لا يوجد نتائج - no results</span>

                                </multiselect>

                                <input v-model="category_id" type="hidden"/>
                                <span class="help-block" v-if="errors.category_id">{{errors.category_id[0]}}</span>
                            </div>
                        </div>


                        <div v-if="labels" class="form-group" :class="{'has-error' : errors.label_id}">
                            <label class="control-label col-sm-3">{{$t('Labels')}}</label>
                            <div class="col-sm-9 no-padding">
                                <multiselect v-model="product.labels"
                                             :options="labels"
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

                                <input v-model="label_id" type="hidden"/>
                                <span class="help-block" v-if="errors.label_id">{{errors.label_id[0]}}</span>
                            </div>
                        </div>
                        <div class="form-group" :class="{'has-error' : errors.availability_date}">
                            <label class="control-label col-sm-3">{{$t('Availability Date')}}</label>
                            <div class="col-sm-9 no-padding">
                                <datepicker v-model="product.availability_date"
                                            :format="$root.dateFormatter"
                                            input-class="form-control not-readonly"
                                            :language="$root.lang[`${$t('locale')}`]"
                                ></datepicker>
                                <span class="help-block"
                                      v-if="errors.availability_date">{{errors.availability_date[0]}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer" :class="'text-'+$t('direction_end')">
                <button class="btn btn-success" @click="save">{{$t('Save')}}</button>
            </div>
            <div class="overlay" v-if="loading">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name    : "ProductDetails",
        props   : ['action', 'manufacturers', 'labels', 'categories', 'initial_product', 'properties'],
        data() {
            return {
                product: {
                    name                : '',
                    name_en             : '',
                    product_code        : '',
                    original_price      : '',
                    price_after_discount: '',
                    quantity            : '',
                    category_id         : '',
                    availability        : false,
                    availability_date   : '',
                    filter_options      : [],
                    manufacturer_id     : '',
                    labels              : [],
                    shipping_free       : false,
                    payment_free        : false,
                },
                loading: false,
                errors : {},
                sortedProperties: this.properties.map(p => {p.values.sort((a,b)=> a.sort_order-b.sort_order); return p;})
            }
        },
        mounted() {
            this.product               = this.initial_product ? this.initial_product : this.product
            this.product.availability  = this.initial_product ? this.initial_product.availability === 1 : false
            this.product.shipping_free = this.initial_product ? this.initial_product.shipping_free === 1 : false
            this.product.payment_free  = this.initial_product ? this.initial_product.payment_free === 1 : false
        },
        computed: {
            category_id() {
                let ids = []
                if (this.product.categories) {
                    this.product.categories.forEach(item => {
                        ids.push(item.id)
                    })
                }
                return ids
            },
            label_id() {
                let ids = []
                if (this.product.labels) {
                    this.product.labels.forEach(item => {
                        ids.push(item.id)
                    })
                }
                return ids
            },
        },
        methods : {
            save() {
                if (!this.loading) {
                    this.loading = true
                    let form     = this.validate()
                    if (Object.keys(this.errors).length === 0 && this.errors.constructor === Object) {
                        axios.post(this.action, form).then(res => {
                            this.loading = false
                            if (res.data.route) {
                                window.location.href = res.data.route
                            }
                            this.product = res.data.product
                        }).catch(res => {
                            this.loading = false
                            this.errors  = res.response.data.errors
                        })
                    } else {
                        this.loading = false
                    }
                }
            },
            validate() {
                let form    = {}
                let product = this.product
                this.errors = {}

                //1- product.name
                if (product && product.name) {
                    form.name = product.name
                } else {
                    this.errors.name = [this.$t('validation.required', {attribute: this.$t('Name')})]
                }

                // //1.5- product.name_en
                if (product.name_en) {
                    form.name_en = product.name_en
                } else {
                    this.errors.name_en = [this.$t('validation.required', {attribute: this.$t('English Name')})]
                }

                //2- product_code
                if (product.product_code) {
                    form.product_code = product.product_code
                } else {
                    this.errors.product_code = [this.$t('validation.required', {attribute: this.$t('product_code')})]
                }

                //3- original_price
                if (product.original_price && !Number.isNaN(product.original_price)) {
                    form.original_price = product.original_price
                } else {
                    if (product.original_price) {
                        this.errors.original_price = [this.$t('validation.required',
                            {attribute: this.$t('original_price')})]
                    } else {
                        this.errors.original_price = [this.$t('validation.numeric',
                            {attribute: this.$t('original_price')})]
                    }
                }

                //4- price_after_discount
                if (!Number.isNaN(product.price_after_discount)) {
                    form.price_after_discount = product.price_after_discount
                }
                if (product.price_after_discount && Number.isNaN(product.price_after_discount)) {
                    this.errors.price_after_discount = [this.$t('validation.numeric',
                        {attribute: this.$t('price_after_discount')})]
                }

                //5- quantity and properties-stock
                if(product.properties){
                    form.quantity = product.properties.values.map(x => x.stock == undefined ? 0 : +x.stock).reduce((a,b) => a+b)
                    form.properties = product.properties.values.filter(x => +x.stock).map( x => ({id:x.id, stock: +x.stock}) )
                }else{
                    if (product.quantity && !Number.isNaN(product.quantity)) {
                        form.quantity = product.quantity
                    } else {
                        if (product.quantity) {
                            this.errors.quantity = [this.$t('validation.required', {attribute: this.$t('quantity')})]
                        } else {
                            this.errors.quantity = [this.$t('validation.numeric', {attribute: this.$t('quantity')})]
                        }
                    }
                }

                //6- availability
                form.availability = product.availability

                //6- not_sold_alone
                form.not_sold_alone = product.not_sold_alone

                //7- availability_date
                if (product.availability_date) {
                    form.availability_date = this.$root.dateFormatter(product.availability_date)
                } else {
                    this.errors.availability_date = [this.$t('validation.required',
                        {attribute: this.$t('availability_date')})]
                }

                //8- availability
                form.weight = product.weight

                //9- category_id
                if (this.category_id.length) {
                    form.category_id = this.category_id
                } else {
                    this.errors.category_id = [this.$t('validation.required',
                        {attribute: this.$t('category_id')})]
                }

                //10- label_id
                if (this.label_id.length) {
                    form.label_id = this.label_id
                }

                //11- shipping free
                form.shipping_free = product.shipping_free

                //12- payment free
                form.payment_free = product.payment_free

                //SET ACTION METHOD
                form._method = this.product.id ? 'PUT' : 'POST'

                return form;
            }
        }
    }
</script>

<style lang="scss" scoped>
    @import "../../../../../node_modules/vue-multiselect/dist/vue-multiselect.min.css";

</style>