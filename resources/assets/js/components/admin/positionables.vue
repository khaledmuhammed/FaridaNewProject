<template>
    <div class="form-horizontal">
        <div class="form-group" v-for="(item,index) in items" :key="index*100" ref="x">
            <label class="col-sm-2 control-label"> {{$t('Element')}} {{ index +1}}</label>
            <div class="col-xs-8">
                <select class="form-control" name="positionables[]" v-model="items[index].positionable_id">
                    <optgroup v-for="(positionable,key) in positionables" :label="key">
                        <option v-for="row in positionable" :value="row.id+'-'+key">{{row.title}}</option>
                    </optgroup>
                </select>
            </div>
            <div class="col-xs-4 col-sm-2">
                <span class="btn btn-danger" @click="items.splice(index,1)" v-if="index < items.length">-</span>
                <span class="btn btn-success" @click="items.push({positionable_id:null})"
                      v-if="index === items.length-1">+</span>
            </div>
        </div>
        <span class="btn btn-success" v-if="!items.length"
              @click="items.push({positionable_id:null})">{{$t('Add')}} {{$t('Element')}}</span>

    </div>
</template>

<script>
    export default {
        props  : ['position'],
        data() {
            return {
                positionables: [],
                items        : [],
            }
        },
        mounted() {
            axios.get('/admin/positionables').then(respond => {
                console.log(respond.data);
                this.positionables = respond.data
            })
            axios.get('/positionables/' + this.position.name).then(res => {
                if (res.data[0]) {
                    res.data.forEach(item => {
                        //we need slice to remove "App\Models\" from the beginning of positionable_type
                        this.items.push(
                            {positionable_id: item.positionable_id + "-" + item.positionable_type.slice(11)})
                    })
                }
            })

        },
        methods: {}
    }
</script>
