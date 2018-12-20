<template>
    <form
        class="create-task-form"
        @submit.prevent="onSubmit"
    >
        <div class="create-task-form__element">
            <app-text-input
                :value="name"
                :placeholder="'Do something'"
                :mark-label-as-required="true"
                @on-change="onNameChanged"
            >
                Task name
            </app-text-input>
        </div>
        <div class="create-task-form__element">
            <app-date-input
                :value="start"
                :placeholder="'2018-12-19'"
                :mark-label-as-required="true"
                @on-change="onStartChanged"
            >
                Date
            </app-date-input>
        </div>
        <div class="create-task-form__element">
            <app-checkbox
                :is-checked="isRepeatable"
                @on-checked="isRepeatable = !isRepeatable"
            >
                Repeatable
            </app-checkbox>
        </div>
        <div
            v-if="isRepeatable"
            class="create-task-form__element"
        >
            <app-date-input
                :value="end"
                :placeholder="'2018-12-19'"
                @on-change="onEndChanged"
            >
                End date
            </app-date-input>
        </div>
        <input
            type="submit"
            value="Create new task"
            class="common-button create-task-form__submit-button"
        />
    </form>
</template>

<script>
    import AppCheckbox from '../AppCheckbox';
    import AppTextInput from '../AppTextInput';
    import AppDateInput from '../AppDateInput';

    export default {
        name: 'CreateTaskForm',
        components: {
            AppCheckbox,
            AppTextInput,
            AppDateInput,
        },
        data() {
            return {
                name: '',
                start: null,
                end: null, // сделать ограничение - end всегда должен быть больше start
                isRepeatable: false,
            };
        },
        methods: {
            onNameChanged(name) {
                this.name = name;
            },
            onStartChanged(start) {
                this.start = start;
            },
            onEndChanged(end) {
                this.end = end;
            },
            onSubmit() {
                console.log(this.name, this.start, this.end);
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .create-task-form {

        .flex(column, nowrap, flex-start, flex-start);
        width: 100%;

        &__element {

            .flex(row, nowrap, flex-start, flex-start);
            width: 100%;
            margin: 0 0 24px 0;

            &:last-child {
                margin: 0;
            }

        }

    }
</style>