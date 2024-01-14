<template>
    <div class="col-sm-12">
        <div class="box box-info collapsed-box">
            <div class="box-header with-border">
                <h3 class="box-title">{{$t('Product Description')}}</h3>
                <div class="box-tools ">
                    <button class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i
                            class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                <div class="col-sm-12 no-padding">
                    <h4>الوصف</h4>
                  <!--  <textarea-editor :content="initial_product.description" ref="description"></textarea-editor> -->
                </div>
                <div class="col-sm-12 no-padding">
                    <h4>الوصف الإنجليزي</h4>
                  <!--    <textarea-editor :content="initial_product.description_en" ref="description_en"></textarea-editor> -->
                </div>
            </div>
            <div class="overlay" v-if="loading">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
            <div class="box-footer" :class="'text-'+$t('direction_end')">
                <button class="btn btn-success" @click="save">{{$t('Save')}}</button>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name   : "ProductDescription",
        props  : ['action', 'initial_product'],
        data() {
            return {
                sub_description: '',
                loading    : false,
                errors     : {},
            }
        },
        mounted() {

        },
        methods: {
            save() {
                if (!this.loading) {
                    this.loading = true
                    axios.post(this.action, {description: this.$refs.description.theContent.getHTML(), description_en: this.$refs.description_en.theContent.getHTML()}).then(res => {
                        // console.log(res);
                        this.loading     = false
                        // this.description = res.data.description
                        // this.sub_description = res.data.sub_description
                    }).catch(res => {
                        this.loading = false
                        // console.log(res);
                        this.errors  = res.response.data.errors
                    })
                }
            }
        },
    }
</script>

<style lang="scss" scoped>
    .editor__content {
    }
</style>