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

        <!-- Repeat type input -->
        <div
            v-if="repeatable && currentRepeatTypeInputComponent"
            class="create-task-form__element"
        >
            <component
                :is="currentRepeatTypeInputComponent"
                v-if="currentRepeatTypeInputComponent"
                @on-change="onRepeatTypeValueChange"
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
    import { mapActions } from 'vuex';
    import AppDropdown from '../AppDropdown';
    import AppDropdownItem from '../AppDropdownItem';
    import RepeatTypeEnum from '../../enums/RepeatTypeEnum';
    import CustomRepeatTypeInput from '../Task/CustomRepeatTypeInput';

    export default {
        name: 'CreateTaskForm',
        components: {
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
                start: new Date(),
                end: null,
                repeatable: false,
                repeatType: RepeatTypeEnum.custom,
                repeatValue: null,
                validation: {
                    name: [],
                },
            };
        },
        computed: {
            // todo: Может не использовать динамические компоненты, а разместить по-отдельности, с v-if?
            currentRepeatTypeInputComponent() {
                this.resetRepeatValue();

                switch (this.repeatType) {
                    case this.repeatTypeEnum.daily:
                        return false;
                    case this.repeatTypeEnum.week:
                        return false;
                    case this.repeatTypeEnum.weekday:
                        return false;
                    case this.repeatTypeEnum.weekend:
                        return false;
                    case this.repeatTypeEnum.custom:
                        return CustomRepeatTypeInput;
                }
            },
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
            onStartChange(start) {
                this.start = start;
            },
            onEndChange(end) {
                this.end = end;
            },
            onRepeatTypeChange(repeatType) {
                this.repeatType = repeatType;
            },
            onRepeatTypeValueChange(repeatValue) {
                this.repeatValue = repeatValue;
            },
            onSubmit() {
                this.create({
                    name: this.name,
                    start: this.start,
                    end: this.end,
                    repeatType: this.repeatType,
                    repeatValue: this.repeatValue,
                });
            },
            resetRepeatValue() {
                this.repeatValue = null;
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