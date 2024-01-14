<template>
    <div class="form-group">
        <label class="control-label col-sm-3">{{attribute.name}}</label>
        <div class="col-sm-9">
            <div class="input-group">
                <input type="text" v-model="text" class="form-control" :readonly="!editable">
                <span class="input-group-btn">
                    <button v-if="!editable" @click="editable =!editable" class="edit btn btn-primary flat">{{$t('Edit')}}</button>
                    <button v-if="editable" @click="updateAttribute"
                            class="save btn btn-info flat">{{$t('Save')}}</button>
                    <button @click="deleteAttribute"
                            class="btn btn-danger ">{{$t('Delete')}}</button>
                    </span>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name   : "product-attribute-field",
        props  : ['attribute'],
        data() {
            return {
                text    : null,
                editable: false
            }
        },
        mounted() {
            this.text = this.attribute.pivot.text
        },
        methods: {
            updateAttribute() {
                if (!this.$parent.loading) {
                    this.$parent.loading = true

                    if (this.text) {
                        axios.post('/admin/product/show/updateAttr', {
                            product_id  : this.attribute.pivot.product_id,
                            attribute_id: this.attribute.id,
                            text        : this.text
                        }).then(res => {
                            this.editable        = false
                            this.$parent.loading = false
                        }).catch(res => {
                            this.$parent.loading = false

                        })
                    } else {
                        this.$parent.loading = false
                    }

                }
            },
            deleteAttribute() {
                if (!this.$parent.loading) {

                    let r = confirm(this.$t('Do you want to delete it ?'))
                    if (r) {
                        this.$parent.loading = true
                        axios.post('/admin/product/show/destroy', {
                            product_id  : this.attribute.pivot.product_id,
                            attribute_id: this.attribute.id
                        }).then(res => {
                            this.editable                   = false
                            this.$parent.product_attributes = res.data.attributes
                            this.$parent.grouped_attributes = res.data.grouped_attributes
                            this.$parent.loading            = false

                        }).catch(res => {
                            this.$parent.loading = false

                        })
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>