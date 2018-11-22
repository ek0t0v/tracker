<template>
    <div
        class="common-context-menu-item"
        :class="{ 'common-context-menu-item--danger': type === 'danger' }"
        @click.capture.prevent
    >
        <div class="common-context-menu-item__icon">
            <i :class="iconCssClass" />
        </div>
        <span class="common-context-menu-item__label">{{ label }}</span>
    </div>
</template>

<script>
    export default {
        name: 'CommonContextMenuItem',
        props: {
            iconCssClass: {
                type: String,
                default: '',
            },
            label: {
                type: String,
                default: '',
            },
            type: {
                type: String,
                default: '',
                validator: value => [
                    '',
                    'danger',
                ].indexOf(value) !== -1,
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .common-context-menu-item {

        .flex(row, nowrap, flex-start, center);
        padding: 5px 19px 5px 13px;
        cursor: pointer;
        color: @header_color;
        transition: .1s all ease-in-out;

        &:hover {
            background-color: rgba(82,89,117, .05);
        }

        &--danger {

            color: #D60000;

            &:hover {
                background-color: rgba(214,0,0,.05) !important;
            }

        }

        &__icon {

            .flex(row, nowrap, center, center);
            width: 18px;
            height: 18px;
            margin: 0 8px 0 0;
            border-radius: 3px;

            i {
                color: @header_color inherit;
                font-size: 15px;
            }

        }

        &__label {
            .font(@primary-font, 14px, 400, inherit);
            white-space: nowrap;
        }

    }
</style>