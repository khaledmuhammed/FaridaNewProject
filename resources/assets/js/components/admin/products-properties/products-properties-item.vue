<template>
    <div class="products-properties-item-component">
        <div v-if="saving_progress" class="saving-in-progress">
            <i class="fa fa-spinner fa-spin fa-5x"></i>
        </div>
        <template v-else>
            <div class="top-bar">
                <span>{{title}}</span>
                <div class="actions">
                    <button class="save" title="Save" @click="save">
                        <i class="fa fa-save"></i>
                    </button>
                    <button class="cancel" title="Cancel" @click="$emit('canceled')">
                        <i class="fa fa-reply"></i>
                    </button>
                </div>
            </div>
            <div class="panel">
                <div class="panel-body inputs">
                    <div class="input-group">
                        <span class="input-group-addon">{{$t('Arabic Name')}}</span>
                        <input class="form-control" type="text" v-model="name">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">{{ $t('English Name') }}</span>
                        <input type="text" class="form-control" v-model="name_en">
                    </div>
                    <div class="input-group type-input">
                        <p>{{ $t('type') }}:</p>
                        <input type="radio" v-model="type" value="color" id="type-color">
                        <label for="type-color">{{$t('a color')}}</label>
                        <br>
                        <input type="radio" v-model="type" value="selection" id="type-selection">
                        <label for="type-selection">{{$t('selection')}}</label>
                    </div>
                    <div class="table item-values">
                        <div class="head" :class="{ltr}">
                            <div style="flex: 0 0 40px"></div>
                            <template v-if= "type == 'selection'">
                                <div>{{$t('Arabic Value')}}</div>
                                <div>{{$t('English Value')}}</div>
                            </template>
                            <div v-else>{{$t('Color')}}</div>
                            <div style="flex: 0 0 80px"></div>
                        </div>
                        <div class="body">
                            <div class="row item-row" v-for="(item, index) in values" :key="index"
                                 draggable="true"
                                 @dragover.prevent
                                 @dragstart= "rowDragStart(index)"
                                 @dragenter = "rowDragEnter($event,item)"
                                 @dragleave = "rowDragLeave($event,item)"
                                 @drop = "rowDragDrop($event,item,index)"
                            >
                                <div v-if="item.in_progress" class="progress-cover">
                                    <i class="fa fa-spinner fa-spin fa-2x"></i>
                                </div>
                                <template v-else>
                                    <div style="flex: 0 0 40px">
                                        <i class="fa fa-bars"></i>
                                    </div>
                                    <template v-if= "type == 'selection'">
                                        <div> <input type="text" v-model="item.value"></div>
                                        <div> <input type="text" v-model="item.value_en"></div>
                                    </template>
                                    <div v-else> <input type="color" :value="item.value" @input="$set(item,'value',$event.target.value); $set(item,'value_en',$event.target.value)"> </div>
                                    <div style="flex: 0 0 80px">
                                        <button class="delete" @click="item.id ? delete_value(item,index) : values.splice(index, 1) ">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                            <div class="row">
                                <div></div>
                                <div class="actions" style="flex:0 0 80px">
                                    <button class="add" title="Add" @click="add_new_value">
                                        <i class="fa fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>
export default {
    props:{
        item:{
            /**
             * item object as:{'id','name','name_en','type', 'values'} ,
             * where values is array of objects of: {'id','value','value_en','sort_order'}
             */
            type: Object,
            required: false
        }
    },
    changedIndex:undefined,
    data(){
        return {
            name: this.item ? this.item.name : '',
            name_en: this.item ? this.item.name_en : '',
            type: this.item ? this.item.type : 'selection',
            values: this.item ? this.item.values.map(v => {v.counter = 0; return v;}).sort((a,b) => a.sort_order-b.sort_order) : [],
            saving_progress : false,
        }
    },
    computed:{
        title(){
            if(! this.item) return this.$t("Adding New")
            else return `${this.$t("Edit")} :${this.item.name} - ${this.item.name_en}`
        },
        ltr: () => document.documentElement.lang === "en" ,
    },
    methods:{
        save(){
            if(!this.name || !this.name_en || !this.type || !this.values || this.values.length == 0) return ;
            let payload = {
                    name:this.name,
                    name_en: this.name_en,
                    type: this.type,
                    values : this.values
                }
            if(this.item){ // if we update an existed product property
                this.saving_progress = true
                axios.put(`/admin/products-properties/${this.item.id}`, payload).then(res => {
                    if(res.data.success) this.$emit('updated', res.data.updated_property)
                }).then(() => this.saving_progress = false)
            }else{ // if we add new product property
                this.saving_progress = true
                axios.post("/admin/products-properties", payload).then(res => {
                    if(res.data.success){
                        this.$emit('new-added', res.data.new_property)
                    }
                }).then(() => this.saving_progress = false)
            }
        },
        add_new_value(){
            if(this.type == 'color'){
                this.values.push({value:'#ffffff', value_en:'#ffffff', sort_order: this.values.length, counter:0})
            }else{
                this.values.push({value:'', value_en:'', sort_order: this.values.length, counter:0})
            }
        },
        delete_value(item,i){
            var confirmed = window.confirm(this.$t("This value is stored in the Database\n") + this.$t("Do you want to delete it ?"))
            if(! confirmed) return;
            this.$set(item, 'in_progress', true)
            axios.delete(`/admin/products-properties/values/${item.id}`).then(res => {
                if(res.data.success){
                    this.values.splice(i,1)
                }else{
                    alert(res.data.message)
                }
            }).then(() => {item.in_progress = false})
        },
        rowDragStart(index){
            this.$options.changedIndex = index
        },
        rowDragEnter(e,item){
            ++item.counter
            e.target.closest(".item-row").classList.add("over")
        },
        rowDragLeave(e,item){
            --item.counter
            if(item.counter == 0)
                e.target.closest(".item-row").classList.remove("over")
        },
        rowDragDrop(e,item,destinationIndex){
            item.counter=0
            e.target.closest(".item-row").classList.remove("over")
            
            this.values[ this.$options.changedIndex ].sort_order = destinationIndex
            if(this.$options.changedIndex > destinationIndex){
                for(var i = destinationIndex; i < this.$options.changedIndex; ++i){
                    this.values[i].sort_order = i+1
                }
            }
            if(this.$options.changedIndex < destinationIndex){
                for(var i = this.$options.changedIndex +1; i <= destinationIndex; ++i){
                    this.values[i].sort_order = i-1
                }
            }
            this.values.sort((a,b) => a.sort_order - b.sort_order)
        }
    }
}
</script>

<style lang="scss">
$thin-border: 1px solid #d2d6de;

.products-properties-item-component{
    .saving-in-progress{
        min-height: 200px;
        display: flex;
        justify-content: center;
        align-items: center;
        color:gray;
        background-color: white;
    }

    .inputs{
        label {margin:0 10px}
        > *{
            margin:10px 0;
        }
        .type-input{
            border: $thin-border;
            border-radius:5px;
            width: 100%;
            padding:10px;
        }
    }

    .item-values{
        margin-top:15px;
        padding: 15px 25px;
        border:$thin-border;
        border-radius: 5px;
        input[type=text]{
            border: $thin-border;
            border-radius: 5px;
            height:35px;
            min-width:80%;
            text-align: center;
        }
    }
    .item-row{
        &.over{
            background-color: #d6d6d6;
        }
    }
}
</style>