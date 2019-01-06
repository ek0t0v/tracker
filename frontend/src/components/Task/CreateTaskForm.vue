<template>
    <form
        class="create-task-form"
        @submit.prevent="onSubmit"
    >
        <!-- Name -->
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

        <!-- Start -->
        <div class="create-task-form__element">
            <app-date-input
                :value="start"
                :placeholder="$t('createTaskForm.start.placeholder')"
                :mark-label-as-required="true"
                :resettable="false"
                @on-change="onStartChange"
            >
                {{ $t('createTaskForm.start.label') }}
            </app-date-input>
        </div>

        <!-- Repeatable -->
        <div class="create-task-form__element">
            <app-checkbox
                :is-checked="repeatable"
                @on-checked="repeatable = !repeatable"
            >
                {{ $t('createTaskForm.repeatable') }}
            </app-checkbox>
        </div>

        <!-- End -->
        <div
            v-if="repeatable"
            class="create-task-form__element"
        >
            <app-date-input
                :value="end"
                :placeholder="$t('createTaskForm.end.placeholder')"
                @on-change="onEndChange"
            >
                {{ $t('createTaskForm.end.label') }}
            </app-date-input>
        </div>

        <!-- Repeat type -->
        <div
            v-if="repeatable"
            class="create-task-form__element"
        >
            <app-dropdown
                :label="$t('createTaskForm.repeatType.label')"
                :value="$t(repeatType.translation)"
                :mark-label-as-required="true"
                @on-change="onRepeatTypeChange"
            >
                <app-dropdown-item
                    :value="repeatTypeEnum.daily"
                    :icon-css-class="'fas fa-calendar-day'"
                />
                <app-dropdown-item
                    :value="repeatTypeEnum.week"
                    :icon-css-class="'fas fa-calendar-week'"
                    :disabled="true"
                />
                <app-dropdown-item
                    :value="repeatTypeEnum.month"
                    :icon-css-class="'fas fa-calendar'"
                    :disabled="true"
                />
                <app-dropdown-item
                    :value="repeatTypeEnum.weekday"
                    :icon-css-class="'fas fa-briefcase'"
                    :disabled="true"
                />
                <app-dropdown-item
                    :value="repeatTypeEnum.weekend"
                    :icon-css-class="'fas fa-couch'"
                    :disabled="true"
                />
                <app-dropdown-item
                    :value="repeatTypeEnum.custom"
                    :icon-css-class="'fas fa-table'"
                />
            </app-dropdown>
        </div>

        <!-- Custom repeat type input -->
        <div
            v-if="repeatable && repeatType === repeatTypeEnum.custom"
            class="create-task-form__element"
        >
            <custom-repeat-type-input
                :value="repeatValues[repeatTypeEnum.custom.value]"
                @on-change="onCustomRepeatTypeValueChange"
            />
        </div>

        <!-- Submit -->
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
    import { mapGetters, mapActions } from 'vuex';
    import AppDropdown from '../AppDropdown';
    import AppDropdownItem from '../AppDropdownItem';
    import RepeatTypeEnum from '../../enums/RepeatTypeEnum';
    import CustomRepeatTypeInput from '../Task/CustomRepeatTypeInput';

    export default {
        name: 'CreateTaskForm',
        components: {
            CustomRepeatTypeInput,
            AppDropdownItem,
            AppDropdown,
            AppCheckbox,
            AppTextInput,
            AppDateInput,
        },
        data() {
            return {
                repeatTypeEnum: RepeatTypeEnum,
                name: '',
                start: null,
                end: null,
                repeatable: false,
                repeatType: RepeatTypeEnum.custom,
                repeatValues: {
                    [RepeatTypeEnum.daily.value]: null,
                    [RepeatTypeEnum.week.value]: [1, 1, 1, 1, 1, 0, 0],
                    [RepeatTypeEnum.month.value]: [],
                    [RepeatTypeEnum.weekday.value]: null,
                    [RepeatTypeEnum.weekend.value]: null,
                    [RepeatTypeEnum.custom.value]: [1, 0, 0, 0],
                },
                validation: {
                    name: [],
                },
            };
        },
        computed: {
            ...mapGetters({
                currentDate: 'date',
            }),
        },
        mounted() {
            this.start = this.currentDate;
        },
        methods: {
            ...mapActions('task', {
                saveTask: 'create',
            }),
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
            onStartChange(start) {
                this.start = start;
            },
            onEndChange(end) {
                this.end = end;
            },
            onRepeatTypeChange(repeatType) {
                this.repeatType = repeatType;
            },
            onCustomRepeatTypeValueChange(repeatValue) {
                this.repeatValues[this.repeatTypeEnum.custom.value] = repeatValue;
            },
            onSubmit() {
                this.saveTask({
                    name: this.name,
                    start: this.start,
                    end: this.repeatable ? this.end : null,
                    repeatType: this.repeatable ? this.repeatType : null,
                    repeatValue: this.repeatable ? this.repeatValues[this.repeatType.value] : null,
                })
                    .then(() => this.$modal.close())
                ;
            },
        },
    }
</script>

<style lang="less" scoped>
    @import '../../less/style';

    .create-task-form {

        .flex(column, nowrap, flex-start, flex-start);
        width: 360px;

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