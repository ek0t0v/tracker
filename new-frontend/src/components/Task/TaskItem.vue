<template>
    <div
        class="task-item"
        :class="{
            'task-item--active': active,
            'task-item--done': done
        }"
    >
        <div class="task-item__column">
            <div
                v-menu="menu"
                class="task-item__menu-button"
                @click="onMenuOpened"
            >
                <span>
                    <img />
                </span>
                <transition name="fade">
                    <CommonContextMenu v-show="menu">
                        <CommonContextMenuItem
                            :label="'Edit'"
                            :icon-css-class="'far fa-edit'"
                            @click="onEdit"
                        />
                        <CommonContextMenuItem
                            :label="'Duplicate'"
                            :icon-css-class="'far fa-clone'"
                        />
                        <CommonContextMenuItem
                            :label="'Mark as important'"
                            :icon-css-class="'far fa-star'"
                        />
                        <CommonContextMenuItem
                            :label="'Create notification'"
                            :icon-css-class="'far fa-bell'"
                        />
                        <CommonContextMenuDivider />
                        <CommonContextMenuItem
                            :label="'Remove'"
                            :icon-css-class="'far fa-trash-alt'"
                            :type="'danger'"
                        />
                    </CommonContextMenu>
                </transition>
            </div>
            <div class="task-item__checkbox">
                <div
                    class="checkbox"
                    :class="{
                        'checkbox--checked': done,
                        'checkbox--active': active,
                    }"
                    @click="onChecked"
                >
                    <span />
                </div>
            </div>
            <div class="task-item__name">{{ name }}</div>
        </div>
        <div class="task-item__column"></div>
    </div>
</template>

<script>
    import CommonContextMenu from '../Common/CommonContextMenu';
    import CommonContextMenuItem from '../Common/CommonContextMenuItem';
    import CommonContextMenuDivider from '../Common/CommonContextMenuDivider';

    export default {
        name: 'TaskItem',
        components: {
            CommonContextMenu,
            CommonContextMenuItem,
            CommonContextMenuDivider,
        },
        props: {
            id: {
                type: Number,
                default: null,
            },
            name: {
                type: String,
                default: '',
            },
            important: Boolean,
        },
        data() {
            return {
                active: false,
                done: false,
                menu: {
                    actions: [],
                },
            };
        },
        methods: {
            onChecked() {
                this.done = !this.done;
            },
            onEdit() {
                this.$router.push('create-task');
            },
            onMenuOpened(e) {
                this.$contextMenu.open();
                // console.log(this);
                // контейнер с меню должен быть общий для всех меню
                // компонент определяет содержимое меню
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .task-item {

        width: 100%;
        height: 40px;
        position: relative;

        &:hover:not(&--active) {


            .task-item__menu-button {
                .flex(row, nowrap, center, center);

                span {
                    opacity: 1;
                }
            }
        }

        &--active:hover {
            .task-item__menu-button {
                .flex(row, nowrap, center, center);
                width: 33px;
                span {
                    opacity: 1;
                }
            }
        }

        &--important {
            background-color: @red_3;
        }

        &--active {
            background-color: @yellow_3;
            .task-item__name {
                color: @yellow_1;
            }
        }

        &--done {
            .task-item__name {
                opacity: .3;
                text-decoration: line-through;
            }
        }

        &__column {
            .flex(row, nowrap, flex-start, center);
            height: 40px;
        }

        &__menu-button {
            position: absolute;
            top: 8px;
            left: -19px;
            transition: .1s all linear;
            span {
                .flex(row, nowrap, center, center);
                width: 24px;
                height: 24px;
                /*display: block;*/
                opacity: 0;
                cursor: pointer;
                border-radius: 3px;
                transition: .1s all linear;

                &:hover {
                    background-color: @blue_4;
                }

                img {
                    fill: red;
                    width: 8px;
                    height: 13px;
                    background: url(/drag.svg);
                }

                svg {
                    display: block;
                    width: 8px;
                    height: 13px;
                    /*background-color: #ddd;*/
                }
            }
        }

        &__checkbox {
            .flex(row, nowrap, center, center);
            width: 40px;
            height: 40px;
        }

        &__name {
            .font(@primary-font, 16px, 400, @blue_1);
            line-height: 16px;
        }

    }

    .checkbox {
        .flex(row, nowrap, center, center);
        width: 14px;
        height: 14px;
        border-radius: 3px;
        border: 2px solid @blue_2;
        cursor: pointer;
        &--checked {
            border-color: @blue_3;
            span {
                opacity: 1 !important;
                background-color: @blue_3;
            }
        }
        &--active {
            border-color: @yellow_2;
            span {
                background-color: @yellow_2;
            }
        }
        span {
            width: 10px;
            height: 10px;
            border-radius: 1px;
            display: block;
            opacity: 0;

        }
    }
</style>