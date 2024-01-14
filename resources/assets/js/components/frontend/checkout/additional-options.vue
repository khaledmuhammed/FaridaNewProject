<template>
    <div>
        <div class="step-header">
            <span class="step-num">2</span>
            <span class="step-title">خيارات إضافية</span>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" value="تغليف هدية" v-model="$store.state.checkout.extraOptions">تغليف هدية
                <span class="price">30 ريال </span></label>
        </div>
        <div class="checkbox">
            <label><input type="checkbox" value="خيار 2" v-model="$store.state.checkout.extraOptions">خيار 2
                <span class="price">30 ريال </span></label>
        </div>
        <div class="checkbox disabled">
            <label><input type="checkbox" value="خيار 3" v-model="$store.state.checkout.extraOptions">خيار 3
                <span class="price">30 ريال </span></label>
        </div>

    </div>
</template>

<script>

    export default {}
</script>
<style lang="sass" scoped>
    /*@import "~styles/frontend/variables"*/

    label
        width : 100%
        margin-top : 10px

        .price
            float : left

</style>