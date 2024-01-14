<template>
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-info ">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{edit_label}}
                    </h3>
                </div>
                <div class="box-body form-horizontal">
                    <div class="form-group" :class="{'has-error' : errors.name}">
                        <label class="control-label col-sm-3">{{label}}</label>
                        <div class="col-sm-7">
                            <input v-model="name" class="form-control"/>
                            <span class="help-block" v-if="errors.name">{{errors.name[0]}}</span>
                        </div>
                        <div class="col-sm-2">
                            <button @click="updateGroupName" class="btn btn-info btn-block btn-md">{{save}}</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"> {{attributes_label}}
                    </h3>
                </div>
                <div class="box-body">
                    <div class="col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                        <template v-if="attributes_errors.name">
                            <h4 class="text-red">{{attributes_errors.name[0]}}</h4>
                        </template>
                        <template v-for="(attribute , index) in attributes">
                            <div class="input-group">
                                <input type="text" :value="attribute.name" :data-id="attribute.id" class="form-control"
                                       ref="attributes">
                                <div class="input-group-btn">
                                    <button class="btn btn-success flat" type="button" @click="updateAttribute(index)">
                                        {{save}}
                                    </button>
                                    <button class="btn btn-danger" type="button" @click="removeAttribute(attribute.id)">
                                        {{delete_label}}
                                    </button>
                                </div>
                            </div>
                        </template>
                        <div class="input-group">
                            <input type="text" class="form-control" ref="new_attribute">
                            <div class="input-group-btn">
                                <button class="btn btn-info" @click="addAttribute" type="button">{{add}}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props  : ['label', 'add', 'save', 'delete_confirm', 'delete_label', 'edit_label', 'update_group_action', 'update_group_attribute_action', 'store_group_attribute_action', 'attribute_group', 'attribute', 'attributes_label', 'add_attribute'],
        name   : "AttributeGroup",
        data() {
            return {
                name             : '',
                attributes       : [],
                attributes_errors: {},
                errors           : {}
            }
        },
        mounted() {
            this.name       = this.attribute_group.name
            this.attributes = this.attribute_group.attributes
        },
        methods: {
            updateGroupName() {
                axios.post(this.update_group_action, {
                    name     : this.name,
                    '_method': 'PUT'
                }).then(res => {
                    // console.log(res);
                }).catch(res => {
                    this.errors = res.response.data.errors
                })
            },
            addAttribute() {
                let el   = this.$refs.new_attribute
                let name = el.value
                if (name.length) {
                    axios.post(this.store_group_attribute_action, {
                        attribute_group_id: this.attribute_group.id,
                        name              : name,
                    }).then(res => {
                        this.attributes                = res.data.attributes
                        this.$refs.new_attribute.value = ''
                    }).catch(res => {
                        this.attributes_errors = res.response.data.errors
                    })
                }
            },
            updateAttribute(index) {
                let el   = this.$refs.attributes[index]
                let id   = el.dataset.id
                let name = el.value
                axios.post(this.update_group_attribute_action + '/' + id, {
                    name     : name,
                    '_method': 'PUT'
                }).then(res => {
                    this.attributes = res.data.attributes
                }).catch(res => {
                    this.attributes_errors = res.response.data.errors
                })
            },
            removeAttribute(id) {
                let r = confirm(this.delete_confirm)
                if (r) {
                    axios.post('/admin/attributes/' + id, {
                        "_method": 'DELETE',
                    }).then(res => {
                        this.attributes = res.data.attributes
                    }).catch(res => {
                        this.attributes_errors = res.response.data.errors
                    })
                }
            },
        }
    }
</script>

<style scoped>

</style>