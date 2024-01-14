<template>
    <div>
        <div class="v-modal-mask">
            <div class="v-modal-wrapper">
                <div class="v-modal-container">

                    <div class="v-modal-header">
                        <slot name="header">
                            default header
                        </slot>
                    </div>

                    <div class="v-modal-body">
                        <slot name="body">
                            default body
                        </slot>
                    </div>

                    <div class="v-modal-footer">
                        <slot name="footer">
                            default footer
                            <button class="v-modal-default-button" @click="$emit('close')">
                                OK
                            </button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {}
</script>
<style lang="sass">
    .v-modal-container
        font-family : Light
        max-height : 90%
        overflow-y : auto
        .v-modal-header h3
            color : #444345
</style>