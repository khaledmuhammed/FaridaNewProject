<template>
    <div class="form-group">
        <div v-for='(image,index) in images' class="col-sm-10 col-sm-offset-2 b-img"
             :key="'img-'+image.id" ref="image">
            <div class="input-group margin-bottom">
                <label class="input-group-addon flat" :for="'img-'+image.id">{{$t('Select')}} {{$t('Image')}}</label>
                <input :id="'img-'+image.id" required="required" name="imgs[]" accept="image/*" type="file"
                       class="form-control file flat" @change="handleFileChange">
                <span class="input-group-addon" id="basic-addon2">{{$t('Image Link')}}</span>
                <input required="required" name="link[]" v-model="image.link" type="text" class="form-control flat"
                       aria-describedby="basic-addon2">

                <span class="input-group-addon flat" id="basic-addon3">{{$t('Sort')}}</span>
                <input required="required" name="sort[]" type="number" class="form-control flat" v-model="image.sort"
                       aria-describedby="basic-addon3">
                <a @click="removeImage(image.id,index)" class="btn btn-danger input-group-addon flat"><span
                        class="glyphicon glyphicon-trash"></span>
                </a>
            </div>
        </div>
        <div class="col-sm-2 col-sm-offset-2 margin-bottom">
            <a class="btn btn-success form-control" @click='addImage'>{{$t('Add')}} {{$t('Image')}}</a>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                counter: 0,
                images : [],
            }
        },
        methods: {
            addImage() {
                this.images.push({
                    id  : this.counter++,
                    file: {name: ''},
                    link: null,
                    sort: 0
                });
            },
            removeImage: function (id, index) {
                console.log(id);
                console.log(this.$refs.image[index].remove());
                this.images.splice(index, 1)
            },
            handleFileChange(e) {
                this.$emit('input', e.target.files[0])
            }
        }
    }
</script>
