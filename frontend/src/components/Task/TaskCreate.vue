<template>
    <div class="new-task-form">
        <input
            v-model="name"
            class="new-task-form__name"
            type="text"
            placeholder="Create new task..."
            @keyup.enter="newTask"
        />
    </div>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'TaskCreate',
        data() {
            return {
                name: '',
            };
        },
        methods: {
            ...mapActions('task', [
                'taskAdd',
            ]),
            newTask() {
                this.taskAdd({
                    name: this.name,
                });

                this.clear();
            },
            clear() {
                this.name = '';
            },
        },
    };
</script>

<style lang="less" scoped>
    .new-task-form {

        background-color: #f5f5f5;
        padding: 14px 48px;
        border-bottom: 1px solid rgba(0,0,0,.05);

        &__name {

            width: 35%;
            margin: 0 48px 0 0;
            padding: 3px 0;
            background-color: rgba(0,0,0,0);
            border-bottom: 2px solid rgba(0,0,0,0);

            &:focus {
                border-bottom: 2px solid rgba(0,0,0,.15);
            }

        }

    }
</style>