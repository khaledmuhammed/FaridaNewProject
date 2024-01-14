<template>
    <div>
        <multiselect v-model="city_id"
                     :options="cities"
                     :clear-on-select="false"
                     :placeholder="$t('Search')"
                     :hide-selected="true"
                     :close-on-select="false"
                     track-by="id"
                     label="name"
                     :showLabels="false"
                     :multiple="true"
                     :searchable="true">

            <span slot="noResult">لا يوجد نتائج - no results</span>

        </multiselect>

        <input v-for="city in city_id" name="city_id[]" :value="city.id" type="hidden"/>
    </div>

</template>

<script>

    export default {
        components: {},
        props     : ['old', 'cities'],
        data      : function () {
            return {
                city_id: []
            }
        },
        mounted() {
            this.city_id = this.old
        },
        methods   : {},
    }
</script>

<style>

</style>
