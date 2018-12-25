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
                :is-checked="isRepeatable"
                @on-checked="isRepeatable = !isRepeatable"
            >
                {{ $t('createTaskForm.repeatable') }}
            </app-checkbox>
        </div>

        <!-- End -->
        <div
            v-if="isRepeatable"
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
            v-if="isRepeatable"
            class="create-task-form__element"
        >
            <app-dropdown
                :label="$t('createTaskForm.repeatType.label')"
                :value="$t(repeatType.translation)"
                @on-change="onRepeatTypeChange"
            >
                <app-dropdown-item
                    :value="repeatTypeEnum.daily"
                    :icon-css-class="'fas fa-calendar-day'"
                />
                <app-dropdown-item
                    :value="repeatTypeEnum.week"
                    :icon-css-class="'fas fa-calendar-week'"
                />
                <app-dropdown-item
                    :value="repeatTypeEnum.sequence"
                    :icon-css-class="'fas fa-table'"
                />
                <app-dropdown-item
                    :value="repeatTypeEnum.workingDays"
                    :icon-css-class="'fas fa-briefcase'"
                    :disabled="true"
                />
                <app-dropdown-item
                    :value="repeatTypeEnum.weekend"
                    :icon-css-class="'fas fa-couch'"
                    :disabled="true"
                />
            </app-dropdown>
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
                name: '',
                start: new Date(),
                end: null,
                isRepeatable: false,
                repeatTypeEnum: RepeatTypeEnum,
                repeatType: RepeatTypeEnum.daily,
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
            onStartChange(start) {
                this.start = start;
            },
            onEndChange(end) {
                this.end = end;
            },
            onRepeatTypeChange(repeatType) {
                this.repeatType = repeatType;
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