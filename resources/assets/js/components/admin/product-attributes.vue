<template>

    <div class="col-sm-6">
        <div class="box box-info collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {{$t('Attributes')}}
                </h3>
                <button type="button" :class="`btn btn-box-tool pull-${$t('direction_end')}`"
                        data-widget="collapse">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="box-body">
                <div v-for="(attributes,i) in grouped_attributes">
                    <div class="col-sm-12">
                        <div class="box box-solid">
                            <div class="box-body">
                                <h4 class="group-name">
                                    {{attributes[0].attribute_group.name}} </h4>
                                <div class="form-horizontal">
                                    <product-attribute-field v-for="attribute in attributes" :attribute="attribute"
                                                             :key="attribute.id"></product-attribute-field>
                                </div>
                            </div>
                            <hr v-if="i < grouped_attributes.length -1 ">
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div :class="`text-${$t('direction_end')}`">
                    <button class="btn btn-info" @click="add_attribute = !add_attribute">
                        {{$t('Add New Attribute')}}
                    </button>
                </div>
                <template v-if="add_attribute"><br>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="attribute_group" class="control-label col-sm-3">
                                {{$t('Attribute Group')}}
                            </label>
                            <div class="col-sm-9">
                                <select name="attribute_group" id="attribute_group" class="form-control"
                                        @change="updateAttributes" v-model="selected_group">
                                    <option v-for="group in attribute_groups" :value="group.id">{{group.name}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <template v-if="attributes" :class="{'has-error' : errors.attribute_id}">
                            <div class="form-group">
                                <label for="attribute" class="control-label col-sm-3">{{$t('Attribute')}}</label>
                                <div class="col-sm-9">
                                    <select name="attribute" id="attribute" class="form-control"
                                            v-model="selected_attribute">
                                        <option v-for="attribute in attributes"
                                                :disabled="isOldAttribute(attribute.id)"
                                                :value="attribute.id">
                                            {{attribute.name}}
                                        </option>
                                    </select>
                                    <span class="help-block"
                                          v-if="errors.attribute_id">{{errors.attribute_id[0]}}</span>

                                </div>
                            </div>
                            <div class="form-group" :class="{'has-error' : errors.text}">
                                <label for="attribute_value" class="control-label col-sm-3">{{$t('Value')}}</label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input v-model="attribute_value" id="attribute_value" class="form-control">
                                        <span class="input-group-btn">
                                            <button :class="`btn ${isFormValid ? 'btn-success':'disabled'}`"
                                                    @click="addNewAttribute">{{$t('Save')}}</button>
                                        </span>
                                        <span class="help-block" v-if="errors.text">{{errors.text[0]}}</span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                </template>
            </div>
            <div class="overlay" v-if="loading">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name    : "ProductAttribute",
        props   : ['action', 'initial_product', 'attribute_groups', 'initial_product_attributes', 'initial_grouped_attributes'],
        data() {
            return {
                add_attribute     : false,
                loading           : false,
                errors            : {},
                product_attributes: null,
                selected_group    : null,
                grouped_attributes: null,
                attributes        : null,
                selected_attribute: null,
                attribute_value   : null,
            }
        },
        mounted() {
            this.product_attributes = this.initial_product_attributes
            this.grouped_attributes = this.initial_grouped_attributes
        },
        computed: {
            isFormValid() {
                return this.attribute_value && this.selected_attribute && this.selected_group
            }
        },
        methods : {
            updateAttributes() {
                let attributes  = this.attribute_groups.find(item => item.id === this.selected_group).attributes
                this.attributes = attributes.length ? attributes : null
            },
            isOldAttribute(id) {
                return this.product_attributes.findIndex(item => item.id === id) > -1
            },
            addNewAttribute() {
                if (!this.loading) {
                    this.loading = true
                    if (this.isFormValid) {
                        axios.post(this.action, {
                            product_id  : this.initial_product.id,
                            attribute_id: this.selected_attribute,
                            text        : this.attribute_value
                        }).then(res => {
                            // console.log(res);
                            this.loading            = false
                            this.selected_group     = null
                            this.selected_attribute = null
                            this.attribute_value    = null
                            this.product_attributes = res.data.attributes
                            this.grouped_attributes = res.data.grouped_attributes
                        }).catch(res => {
                            this.loading = false
                            // console.log(res);
                            this.errors  = res.response.data.errors
                        })
                    } else {
                        this.loading = false

                    }
                }
            },
        },
    }
</script>

<style lang="scss" scoped>
    option:disabled {
        background : #ccc;
    }

    .group-name {
        background-color : #f7f7f7;
        font-size        : 18px;
        text-align       : center;
        padding          : 7px 10px;
        margin-top       : 0;
    }

</style>