<template>
    <div class="testimonials col-xs-12">
        <div class="card" v-for="(testimonial,index) in testimonials" :key="'t-'+index">
            <h3>{{testimonial.title}}</h3>
            <h5>{{testimonial.comment}}</h5>
            <h4 class="text-left">- {{testimonial.username}}</h4>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['testimonials'],

    }
</script>
<style scoped lang="scss">
    @import "~styles/frontend/variables";

    .testimonials {
        display        : flex;
        flex-direction : row;
        flex-wrap      : wrap;
        .card {
            width           : calc(100% / 3 - 30px);
            flex-direction  : column;
            justify-content : space-between;
            align-items     : stretch;
        }
    }

    @media #{$mobile}{
        .testimonials {
            flex-direction : column;
            .card {
                width : calc(100% - 30px);
            }
        }
    }

</style>