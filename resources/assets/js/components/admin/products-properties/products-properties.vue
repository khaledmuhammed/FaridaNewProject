<template>
<div class="products-properties-component">
    <!-- if we add new item , or editing an exsited one -->
    <products-properties-item 
        v-if="adding_new_mode || editing_existed_item" 
        :item="editing_existed_item"
        @canceled = "adding_new_mode = false; editing_existed_item = null;"
        @new-added = "adding_new_mode = false; items.push($event)"
        @updated = "item_updated"
    />

    <!-- if showing the exsited items list (products properties) -->
    <div v-else>
        <div class="top-bar">
            <span>{{ $t('Properties List') }}</span>
            <div class="actions">
                <button class="add" title="Add" @click="add_new">
                    <i class="fa fa-plus-circle"></i>
                </button>
                <button class="delete" title="Delete Selected" @click="delete_items">
                    <i class="fa fa-trash"></i>
                </button>
            </div>
        </div>
        <div class="table">
            <div class="head" :class="{ltr}">
                <div style="flex: 0 0 40px"> <input type="checkbox" v-model="selectAll"></div>
                <div>{{ $t('Arabic Name') }}</div>
                <div>{{ $t('English Name') }}</div>
                <div>{{ $t('Edit') + '  /  ' + $t('Delete') }}</div>
            </div>
            <div class="body">
                <div v-for="(item,index) in items" :key="item.name + item.name_en" class="row" :class="{ltr, 'in-progress':item.in_progress}">
                    <div v-if="item.in_progress" class="progress-cover">
                        <i class="fa fa-spinner fa-spin fa-2x"></i>
                    </div>
                    <template v-else>
                        <div style="flex: 0 0 40px"> 
                            <input type="checkbox" v-model="items[index].checked">
                        </div>
                        <div>{{item.name}}</div>
                        <div>{{item.name_en}}</div>
                        <div class="actions">
                            <button class="edit" title="Edit" @click="editing_existed_item = item">
                                <i class="fa fa-pencil"></i>
                            </button>
                            <button class="delete" title="delete" @click="delete_item(index)">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props:{
        properties: String, // json string of: item object as:{'id','name','name_en','type', 'values'}
    },
    data(){
        return {
            items: JSON.parse( this.properties), // item object as:{'id','name','name_en','type', 'values'}
            adding_new_mode: false,
            editing_existed_item: null,
        }
    },
    computed:{
        ltr: () => document.documentElement.lang === "en" ,
        selectAll:{
            get(){
                return this.items.every(item => item.checked)
            },
            set(value){
                for(var i =0; i<this.items.length; ++i) this.$set(this.items[i], 'checked', value)
            }
        }
    },
    methods:{
        delete_item(i){
            var confirmed = window.confirm( this.$t("Do you want to delete it ?") + `\n${this.items[i].name} - ${this.items[i].name_en}`)
            if(confirmed){
                this.$set(this.items[i], 'in_progress', true)
                axios.delete(`/admin/products-properties/${this.items[i].id}`).then(res => {
                    if(res.data.success){
                        this.items.splice(i,1)
                    }else{
                        alert(res.data.message)
                    }
                }).then(() =>{
                    this.items[i].in_progress = false
                })
            }
        },
        delete_items(){
            var confirmed = window.confirm( this.$t("Do you want to delete it ?") )
            if(confirmed){
                var requests = []
                for(var i=0; i<this.items.length; ++i){
                    if(! this.items[i].checked) continue;
                    this.$set(this.items[i], 'in_progress', true)
                    requests.push( axios.delete(`/admin/products-properties/${this.items[i].id}`) )
                }
                axios.all(requests).then( axios.spread((...allResponses) => {
                    allResponses.forEach(res => {
                        if(res.data.success){
                            var deletedProp = this.items.find( item => item.id == res.data.id)
                            var deletedPropIndex = this.items.indexOf(deletedProp)
                            this.items.splice(deletedPropIndex, 1)
                        }
                    })
                }))
            }
        },
        add_new(){
            this.adding_new_mode = true
        },
        item_updated(e){
            let index = this.items.indexOf( this.editing_existed_item )
            this.items[index] = e
            this.editing_existed_item = null
        }
    }
}
</script>

<style lang="scss">

$border:#bdbdbd solid 1px;

.products-properties-component{
    // icons buttons utilities
    .delete{background-color: #e90202; &:hover{background-color: darken(#e90202, 10);}}
    .cancel{background-color: #e98d02; &:hover{background-color: darken(#e98d02, 10);}}
    .add, .edit, .save{background-color: #0294e9; &:hover{background-color: darken(#0294e9, 10);}}
    .add, .edit, .delete, .save, .cancel {
        color:white;
        border: none;
        outline: none;
        border-radius: 5px;
        font-size: 18px;
        width:35px;
        height:35px;
        display:inline-flex;
        justify-content: center;
        align-items: center;
    }

    // styling the component
    padding:10px;
    .top-bar{
        display:flex;
        justify-content: space-between;
        margin:20px 0;
    }
    .table{
        .head{
            display:flex;
            width: 100%;
            line-height:5rem;
            background-color: rgba(black,0.05);
            border:$border;
            > *{
                flex:1 0 0;
                text-align: center;
                font-weight: bold;
                font-size: 1.2em;
            }
            &.ltr > *:not(:last-child){ border-right: $border; }
            &:not(.ltr) > *:not(:last-child){ border-left: $border; }
        }
        .body{
            .row{
                line-height: 4.5rem;
                border: $border;
                display: flex;
                margin:5px 0;
                > *{
                    flex:1 0 0;
                    text-align: center;
                }
                &.ltr > *:not(:last-child){ border-right: $border;}
                &:not(.ltr) > *:not(:last-child){ border-left:$border; }

                .progress-cover{
                    line-height: 4em;
                    color:gray;
                    background-color: white;
                }
            }
        }
    }
}
</style>
