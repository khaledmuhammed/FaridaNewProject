<template>
    <div>
        <toggle-button v-model="toggle"
                       :sync="true"
                       :color="{checked: '#008d4c', unchecked: '#dd4b39', disabled: '#000'}"
                       :labels="{checked: $t('Yes'), unchecked: $t('No')}"/>

        <input type="radio" :name="name" :checked="!toggle" value="0" class="hidden"/>
        <input type="radio" :name="name" :checked="toggle" value="1" class="hidden"/>
    </div>

</template>

<script>

    export default {
        name : 'Toggler',
        props: ['name', 'old'],
        data : function () {
            return {
                toggle: false
            }
        },
        mounted() {
            this.toggle = parseInt(this.old) === 1
        },
    }
</script>

<style>

</style>
