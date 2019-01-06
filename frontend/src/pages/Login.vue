<template>
    <form
        class="login-form"
        @submit.prevent="onSubmit"
    >
        <input
            v-model="email"
            class="login-form__input"
            type="text"
            placeholder="Email"
            required
        />
        <input
            v-model="password"
            class="login-form__input"
            type="password"
            placeholder="Password"
            required
        />
        <input
            class="login-form__submit"
            type="submit"
            value="Log in"
        />
    </form>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        name: 'Login',
        data() {
            return {
                email: '',
                password: '',
            };
        },
        methods: {
            ...mapActions('user', {
                userLogin: 'userLogin',
            }),
            onSubmit() {
                this.userLogin({
                    email: this.email,
                    password: this.password,
                });
            },
        },
    };
</script>

<style lang="less" scoped>
    @import '../less/style';

    .login-form {

        .flex(column, nowrap, flex-start, flex-start);
        width: 360px;
        padding: 32px;
        border-radius: 3px;
        background-color: #fff;
        box-sizing: border-box;

        &__input {
            .common-input;
            width: 100%;
            margin: 0 0 12px 0;
        }

        &__submit {
            .common-button;
            width: 100%;
        }

    }
</style>