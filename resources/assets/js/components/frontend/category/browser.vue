<template>
    <div class="col-xs-12 ">
        <div class="browser">
            <a v-for="category in categories" :href="'/categories/'+category.id">
                <div class="col-xs-6 col-sm-3 col-md-2 text-center category">
                    <div class="img-wrapper">
                        <img :src="category.thumbnail"
                             :alt="category.theName"
                             onerror="this.src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAMAAAAJbSJIAAAAMFBMVEXp7vG6vsG3u77s8fTCxsnn7O/f5OfP09bFyczM0dO8wMPk6ezY3eDh5unJzdDR1tlr0sxZAAACVUlEQVR4nO3b23KDIBRA0QgmsaLx//+2KmPi/YJMPafZ6619sOzARJjq7QYAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAuJyN4+qMZcUri+BV3WQ22iIxSRTGFBITbRGpr218Ckx0EQPrxMfVPRP25QvNaT4xFTeJ1g/sJ4K8/aTuVxdNNJ99/Q0RQWlELtN7xGH9+8KYH1ZEX1hY770C9186Cm2R1TeONGj/paHQury7OwbsvzQUlp/9jakOJ2ooPLf/kl9on4Mtan50EhUUDvfgh8cqv/AxKlw+Cc3vPeUXjg+Kr4VCm+Vbl5LkeKHNTDKbKL9w3yr1B8q5RPmFu75puhPzTKKCwh13i2aJJguJ8gt33PG7GZxN1FC4tWvrB04TNRRu7Lw/S3Q2UUPh+ulpOIPTRB2FKyfgaeAoUUvhkvESnSYqL5ybwVGi7sKlwH6i6sL5JTpKVFZYlr0flmewTbyvX+piC8NyiXHvH9YD37OoqtA1v+wS15ZofxY1FTo/cJ+4NYNJd9BSVOi6kTeJOwLVFbrPyJ3dXqL6Cl1/7G7HDGordMOx7+hTVui2arQXBgVqKgwLVFQYGKinMDRQTWFwoJrC8AfcKLwUhRRSeL3vKkyDVaNLSdIf1snXEBQUyrlUTBQeIbPQD6uK8Zx3+yyHKbf/5N+y/gn78K/Rj/ZmY64Omhg9gHFaJu59i+EDGKf1/tshRxlxEoW+2uXS868EeflDYmDNltUzgkpqXyPGzULyK6QAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA8DV+AUrRI7QWHsWNAAAAAElFTkSuQmCC';">
                    </div>
                    <p><b>{{category.theName}}</b></p>
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
            // console.log(this.categories);
        }
    }
</script>
<style lang="sass" scoped>
    @import "~styles/frontend/variables"

    .browser
        // background-color : #fff 
        // border-radius : 5px
        // box-shadow : 0 0 7px -2px #9f9f9f
        // margin-top : 20px
        a, a:hover, a:visited, a:focus, a:active
            text-decoration : none
            color : $text-color
        .category
            height : 225px
            display : flex
            align-content : stretch
            align-items : center
            flex-direction : column
            justify-content : space-between
            transition : all .3s
            &:hover
                background : #f1f3f9
            margin-top : 20px
            .img-wrapper
                flex-grow : 1
                justify-self : stretch
                display : flex
                align-items : center
                img
                    width : 88%
                    margin : 0 auto
                    vertical-align : middle
            p
                flex-basis : 25px
                margin : 0

</style>
