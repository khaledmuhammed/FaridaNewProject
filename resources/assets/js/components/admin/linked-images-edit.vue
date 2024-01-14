<template>
    <div>
        <div class="banner-images col-sm-10 col-sm-offset-2">
            <div v-for='(image,index) in images' :key="'img-'+image.id"
                 ref="image">

                <div class=" image flex">
                    <div class="img">
                        <img :src="`${image.url}`" class="img-responsive img-thumbnail">
                    </div>
                    <div class="form-controls flex">
                        <div class="input-group ">
                            <span class="input-group-addon flat" id="basic-addon1">{{$t('Image Link')}}</span>
                            <input required="required" type="text" class="form-control flat" ref="link" disabled
                                   :value="image.custom_properties.link" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon flat" id="basic-addon2">{{$t('Sort')}}</span>
                            <input required="required" type="number" class="form-control flat" ref="sort" disabled
                                   :value="image.custom_properties.sort" aria-describedby="basic-addon2">
                        </div>
                        <div class="btn-group">
                            <a @click="allowEdit(index)" class="btn btn-info flat" ref="edit">
                                <span class="glyphicon glyphicon-edit"></span> {{$t('Edit')}}</a>
                            <a @click="updateImageDetails(index,image)" class="btn btn-success hidden flat" ref="update">
                                <span class="glyphicon glyphicon-arrow-up"></span>{{$t('Update')}} </a>
                            <a @click="removeImage(index,image)" class="btn btn-danger flat"><span
                                    class="glyphicon glyphicon-trash"></span>{{$t('Delete')}}</a>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>
</template>

<script>

    let data = {
        editables: []
    }

    export default {

        props: ['images'],

        data() {
            return {
                data   : data,
                counter: 0,
            }
        },
        mounted() {

        },
        methods: {
            removeImage(index, image) {
                let r = confirm("Delete this image ?")
                r ? this.$refs.image[index].remove() : null
                axios.get(`media/${image.id}/delete`).then(res => {
                    console.log(res);
                })
            },
            allowEdit(index) {
                this.$refs.link[index].removeAttribute('disabled')
                this.$refs.sort[index].removeAttribute('disabled')
                this.$refs.edit[index].classList.toggle('hidden')
                this.$refs.update[index].classList.toggle("hidden")
            },
            updateImageDetails(index, image) {
                let link = this.$refs.link[index].value
                let sort = this.$refs.sort[index].value
                console.log(link);
                console.log(sort);
                axios.post(`/admin/banners/${image.model_id}/media/${image.id}`, {
                    link: link,
                    sort: sort
                }).then((res) => {
                    console.log(res)
                })

                this.$refs.link[index].setAttribute('disabled', true)
                this.$refs.sort[index].setAttribute('disabled', true)
                this.$refs.edit[index].classList.toggle('hidden')
                this.$refs.update[index].classList.toggle("hidden")

            }
        }
    }
</script>
<style lang="sass" scoped>
    .image.flex
        display : flex
        margin-bottom : 20px
        .img
            flex : 1
            text-align : center
        .form-controls
            flex : 5
        .flex
            padding-left : 15px
            display : flex
            flex : 2
            flex-direction : column
            justify-content : flex-end
            & > div
                padding-bottom : 10px
        .img-thumbnail
            max-height : 150px

</style>