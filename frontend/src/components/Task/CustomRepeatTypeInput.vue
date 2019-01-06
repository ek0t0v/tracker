<template>
    <div class="custom-repeat-type-input">
        <div class="custom-repeat-type-input__content">
            <div class="custom-repeat-type-input__buttons">
                <div class="custom-repeat-type-input__button-pads" />
                <button
                    class="custom-repeat-type-input__button custom-repeat-type-input__button--decrease"
                    :class="{ 'custom-repeat-type-input__button--disabled': leftButtonDisabled }"
                    @click.prevent="decreaseCellsCount"
                >
                    <i class="fas fa-minus" />
                </button>
                <button
                    class="custom-repeat-type-input__button custom-repeat-type-input__button--increase"
                    :class="{ 'custom-repeat-type-input__button--disabled': rightButtonDisabled }"
                    @click.prevent="increaseCellsCount"
                >
                    <i class="fas fa-plus" />
                </button>
            </div>
            <div class="custom-repeat-type-input__cells-wrapper">
                <div style="height: 28px;" />
                <div class="custom-repeat-type-input__cells">
                    <div
                        v-for="(cell, index) in cellsCount"
                        :key="index"
                        :class="{ 'custom-repeat-type-input__cell--active': isCellActive(index) }"
                        class="custom-repeat-type-input__cell"
                        @click="toggleCell(index)"
                    >
                        <span>{{ cell }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'CustomRepeatTypeInput',
        props: {
            value: {
                type: Array,
                default: () => [1, 0, 0, 0],
                validator: v => v.every(item => item === 0 || item === 1),
            },
            minCellsCount: {
                type: Number,
                default: 2,
                validator: v => typeof v === 'number' && v > 1,
            },
            maxCellsCount: {
                type: Number,
                default: 32,
                validator: v => typeof v === 'number',
            },
        },
        data() {
            return {
                localValue: this.value,
            };
        },
        computed: {
            cellsCount() {
                return this.localValue.length;
            },
            leftButtonDisabled() {
                return this.cellsCount <= this.minCellsCount;
            },
            rightButtonDisabled() {
                return this.cellsCount >= this.maxCellsCount;
            },
        },
        methods: {
            increaseCellsCount() {
                if (this.localValue.length >= this.maxCellsCount) {
                    return;
                }

                this.localValue.push(0);

                this.$emit('on-change', this.value);
            },
            decreaseCellsCount() {
                if (this.localValue.length <= this.minCellsCount) {
                    return;
                }

                this.localValue.pop();

                this.$emit('on-change', this.localValue);
            },
            toggleCell(index) {
                this.localValue.splice(index, 1, this.localValue[index] === 0 ? 1 : 0);

                this.$emit('on-change', this.localValue);
            },
            isCellActive(index) {
                return this.value[index] === 1;
            },
        },
    }
</script>

<style lang="less" scoped>
    @import (reference) '../../less/style';

    .custom-repeat-type-input {

        .noselect;
        .flex(column, nowrap, flex-start, flex-start);
        width: 100%;
        margin: 0 0 -2px 0;
        overflow: hidden;

        &__content {
            width: 100%;
            background-color: #fff;
        }

        &__cells-wrapper {
            position: relative;
            width: 100%;
            padding: 0 0 2px 0;
            overflow-x: scroll;
            overflow-y: hidden;
        }

        &__cells {

            .flex(row, nowrap, flex-start, flex-start);
            position: absolute;
            left: 0;
            top: 0;

            &:before,
            &:after {
                content: '';
                width: 30px;
            }

        }

        &__cell {

            .flex(row, nowrap, center, center);
            width: 28px;
            height: 28px;
            margin: 0 2px 0 0;
            color: @blue_1;
            border-radius: 3px;
            background-color: @blue_5;
            cursor: pointer;

            &:last-child {
                margin: 0;
            }

            &--active {
                color: #fff;
                background-color: @blue_1;
            }

            span {
                .font(@primary-font, 12px, 400, inherit);
            }

        }

        &__buttons {
            position: relative;
            z-index: 1;
        }

        &__button-pads {

            &:before,
            &:after {
                content: '';
                width: 6px;
                height: 28px;
                background-color: #fff;
                position: absolute;
                top: 0;
                z-index: 0;
            }

            &:before {
                left: 0;
            }

            &:after {
                right: 0;
            }

        }

        &__button {

            .flex(row, nowrap, center, center);
            width: 28px;
            height: 28px;
            border-radius: 3px;
            background-color: @blue_1;
            position: absolute;
            top: 0;
            cursor: pointer;
            z-index: 1;
            color: #fff;
            transition: all .1s ease-in-out;

            &--disabled {

                color: @blue_1;
                background-color: @blue_5;
                cursor: default;
                filter: grayscale(100%);

                i {
                    opacity: .25;
                }

            }

            &--increase {
                right: 0;
            }

            &--decrease {
                left: 0;
            }

            i {
                color: inherit;
                font-size: 8px;
            }

        }

    }
</style>