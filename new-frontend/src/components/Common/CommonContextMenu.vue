<template>
    <div
        v-show="show"
        class="common-context-menu"
        @click="onClick"
    >
        <slot :data="data" />
    </div>
</template>

<script>
    export default {
        name: 'CommonContextMenu',
        data () {
            return {
                top: null,
                left: null,
                show: false,
                data: null,
            };
        },
        methods: {
            onClick() {},
            open(event, data) {
                this.data = data;
                this.show = true;

                this.$nextTick(() => {
                    this.positionMenu(event.clientY, event.clientX);
                    this.$el.focus();
                    this.$emit('open', event, this.data, this.top, this.left);
                });
            },
            positionMenu(top, left) {
                const largestHeight = window.innerHeight - this.$el.offsetHeight - 25;
                const largestWidth = window.innerWidth - this.$el.offsetWidth - 25;

                if (top > largestHeight) {
                    top = largestHeight;
                }

                if (left > largestWidth) {
                    left = largestWidth;
                }

                this.top = top;
                this.left = left;
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .common-context-menu {
        .noselect;
        padding: 8px 0;
        top: 50%;
        transform: translateY(-50%);
        right: 39px;
        margin: auto;
        z-index: 9999999999;
        position: absolute;
        background-color: #fff;
        border-radius: 3px;
        /*box-shadow: 0 4px 16px rgba(0,0,0,.25);*/
        will-change: transform;
        box-shadow: 0 0 0 1px rgba(29,44,76,.1), 0 4px 8px rgba(0,0,0,.15);
        overflow: hidden;
    }
</style>