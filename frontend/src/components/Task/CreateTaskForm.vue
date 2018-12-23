<template>
    <form
        class="create-task-form"
        @submit.prevent="onSubmit"
    >
        <div class="create-task-form__element">
            <app-text-input
                :value="name"
                :placeholder="$t('name.placeholder')"
                :mark-label-as-required="true"
                :on-blur="validateName"
                :validation-errors="validation.name"
                @on-change="onNameChanged"
            >
                {{ $t('name.label') }}
            </app-text-input>
        </div>
        <div class="create-task-form__element">
            <app-date-input
                :value="start"
                :placeholder="'2018-12-19'"
                :mark-label-as-required="true"
                @on-change="onStartChanged"
            >
                {{ $t('start.label') }}
            </app-date-input>
        </div>
        <div class="create-task-form__element">
            <app-checkbox
                :is-checked="isRepeatable"
                @on-checked="isRepeatable = !isRepeatable"
            >
                {{ $t('repeatable') }}
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
            :value="$t('submit')"
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
        i18n: {
            messages: {
                en: {
                    name: {
                        label: 'Task name',
                        placeholder: 'Do something',
                        validation: {
                            empty: 'Enter task name.',
                        },
                    },
                    start: {
                        label: 'Date',
                    },
                    repeatable: 'Repeatable',
                    submit: 'Create new task',
                },
                ru: {
                    name: {
                        label: 'Название задачи',
                        placeholder: 'Сделать что-то',
                        validation: {
                            empty: 'Введите название задачи.',
                        },
                    },
                    start: {
                        label: 'Дата начала',
                    },
                    repeatable: 'Повтор',
                    submit: 'Создать задачу',
                },
            },
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
                        this.$t('name.validation.empty'),
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