<template>
    <div class="input-group-btn">
      <button id="dLabel" class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        {{selected.name}}
        <span class="caret"></span>
      </button>
      <ul class="dropdown-menu" aria-labelledby="dLabel">
        <li v-for="(option, key) in options"><a @click="select(option, key)">{{option.name}}</a></li>
      </ul>
      <input type="hidden" :name="name" v-model="selected.id" >
    </div>
</template>

<script>
    export default {
        name: "",
        props : {
            options: {
                  default: () => {},
                  type: Object,
            },
            name: {
                  default: "",
                  type: String
            },
            placeholder: {
                  default: "",
                  type: String
            },
            value: String
        },
        data() {
            return {
              selected: {id:"",name: this.placeholder}
            }
        },
        methods:{
          select: function(option, key){
            this.$emit('input', key)
          },
        },
        watch:{
          value: function (){
            if(this.value===""){
              this.selected = {id:"",name: this.placeholder}
            } else {
              this.selected = {id: this.value,name: this.options[this.value].name}
            }
          }
        }
    }
</script>

<style>
.dropdown-menu a{
  cursor: pointer;
}
</style>
