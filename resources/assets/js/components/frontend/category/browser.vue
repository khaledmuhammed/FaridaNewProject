<template>
    <div class="col-xs-12 ">
        <div class="browser">
            <div class="title">
                {{$t("Categories")}}
            </div>
            <a class="category-container col-md-4" v-for="category in categories" :href="'/categories/'+category.id">
                <div class="category">
                    <img :src="category.thumbnail" loading="lazy"/>
                    <div class="name">
                        {{category.theName}}
                    </div>
                </div>
            </a>
            <div class="clearfix"></div>
        </div>
    </div>
</template>

<script>

    export default {
        props: ['categories'],
        mounted() {
            console.log(this.categories);
        }
    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"
        
    .browser
        margin-left : 150px
        margin-right : 150px
        margin-bottom : 100px

        .title
            margin-bottom: 20px
            font-weight: 900
            font-size: 24px   
            padding-right: 15px
        @media (max-width: 767px)
            margin-left : 25px
            margin-right : 25px
            margin-bottom : 50px
            padding: 0px
    .category-container
        margin-bottom: 15px
        line-height: 1.5
        
        
        padding: 10px
        .category
            padding: 10px
            box-shadow: rgba(154, 1, 32, 0.4) -5px 5px, rgba(154, 1, 32, 0.3) -10px 10px, rgba(154, 1, 32, 0.2) -15px 15px, rgba(154, 1, 32, 0.1) -20px 20px, rgba(154, 1, 32, 0.05) -25px 25px;
            border-radius: 25px
        img
            width : 100%
            height: 400px
            background-color: #eee 
            object-fit : cover
            border-radius: 25px
            @media (max-width: 767px)
                height: auto
        @media (max-width: 767px)
            margin: auto
            padding: 0
        .name
            padding: 10px
            font-size: 24px
            padding-top: 5px
            font-weight: 900
            text-align: center
            @media (max-width: 767px)
                margin-bottom: 50px

</style>
