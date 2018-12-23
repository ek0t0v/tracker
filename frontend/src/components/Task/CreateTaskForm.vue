<template>
    <form
        class="create-task-form"
        @submit.prevent="onSubmit"
    >
        <div class="create-task-form__element">
            <app-text-input
                :value="name"
                :placeholder="$t('createTaskForm.name.placeholder')"
                :mark-label-as-required="true"
                :on-blur="validateName"
                :validation-errors="validation.name"
                @on-change="onNameChanged"
            >
                {{ $t('createTaskForm.name.label') }}
            </app-text-input>
        </div>
        <div class="create-task-form__element">
            <app-date-input
                :value="start"
                :placeholder="$t('createTaskForm.start.placeholder')"
                :mark-label-as-required="true"
                @on-change="onStartChanged"
            >
                {{ $t('createTaskForm.start.label') }}
            </app-date-input>
        </div>
        <div class="create-task-form__element">
            <app-checkbox
                :is-checked="isRepeatable"
                @on-checked="isRepeatable = !isRepeatable"
            >
                {{ $t('createTaskForm.repeatable') }}
            </app-checkbox>
        </div>
        <div
            v-if="isRepeatable"
            class="create-task-form__element"
        >
            <app-date-input
                :value="end"
                :placeholder="$t('createTaskForm.end.placeholder')"
                @on-change="onEndChanged"
            >
                {{ $t('createTaskForm.end.label') }}
            </app-date-input>
        </div>
        <input
            type="submit"
            :value="$t('createTaskForm.submit')"
            class="common-button create-task-form__submit-button"
        />
    </form>
</template>

<script>
    import AppCheckbox from '../AppCheckbox';
    import AppTextInput from '../AppTextInput';
    import AppDateInput from '../AppDateInput';
    import moment from 'moment';
    import { mapActions } from 'vuex';

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
                start: moment().format('YYYY-MM-DD'),
                end: null, // сделать ограничение - end всегда должен быть больше start
                isRepeatable: false,
                validation: {
                    name: [],
                },
            };
        },
        methods: {
            ...mapActions('task', [
                'create',
            ]),
            onNameChanged(name) {
                this.name = name;
            },
            validateName() {
                this.validation.name = [];

                if (this.name === '') {
                    this.validation.name = [
                        this.$t('createTaskForm.name.validation.empty'),
                    ];
                }
            },
            onStartChanged(start) {
                this.start = start;
            },
            onEndChanged(end) {
                this.end = end;
            },
            onSubmit() {
                this.create({
                    name: this.name,
                    start: this.start,
                    end: this.end,
                });
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .create-task-form {

        .flex(column, nowrap, flex-start, flex-start);
        width: 512px;

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