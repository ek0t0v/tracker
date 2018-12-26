<template>
    <div class="custom-repeat-type-input">
        <div class="custom-repeat-type-input__content">
            <div class="custom-repeat-type-input__buttons">
                <div class="custom-repeat-type-input__button-pads" />
                <button
                    class="custom-repeat-type-input__button custom-repeat-type-input__button--decrease"
                    @click="decreaseCellsCount"
                >
                    <i class="fas fa-minus" />
                </button>
                <button
                    class="custom-repeat-type-input__button custom-repeat-type-input__button--increase"
                    @click="increaseCellsCount"
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
        data() {
            return {
                cellsCount: 2,
                value: [1,0],
            };
        },
        methods: {
            increaseCellsCount() {
                this.value.push(0);
                this.cellsCount++;
            },
            decreaseCellsCount() {
                if (this.value.length > 1) {
                    this.value.pop();
                    this.cellsCount--;
                }
            },
            toggleCell(index) {
                let newValue = this.value[index] === 0 ? 1 : 0;

                this.value.splice(index, 1, newValue);

                this.$emit('on-change', this.value);
            },
            isCellActive(index) {
                return this.value[index] === 1;
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

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
            color: @blue_1;
            border-radius: 3px;
            background-color: @blue_1;
            position: absolute;
            top: 0;
            cursor: pointer;
            z-index: 1;

            &--increase {
                right: 0;
            }

            &--decrease {
                left: 0;
            }

            i {
                color: #fff;
                font-size: 8px;
            }

        }

    }
</style>