<template>
    <div
        class="common-checkbox"
        :class="classModifier ? 'common-checkbox--' + classModifier : ''"
        @click="onCheck"
    >
        <div class="common-checkbox__checkbox">
            <span>

            </span>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CommonCheckbox',
        props: {
            classModifier: {
                type: String,
                default: '',
                validator: value => [
                    '',
                    'important',
                    'active',
                ].indexOf(value) !== -1,
            },
        },
        methods: {
            onCheck() {

            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .common-checkbox {

        width: 14px;
        height: 14px;
        border-radius: 3px;
        border: 2px solid @blue_2;

        &--important {
            border-color: @red_2 !important;
        }

        &__checkbox {

        }
    }
</style>