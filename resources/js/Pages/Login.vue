<script setup lang="ts">

import BaseInput from "@/UI/Inputs/BaseInput.vue";
import PrimaryButton from "@/UI/Buttons/PrimaryButton.vue";
import BaseCard from "@/UI/Cards/BaseCard.vue";
import {useForm} from "@inertiajs/vue3";
import {route} from "ziggy-js";

const form = useForm({
    name: '',
    password: '',
})

function submit() {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    })
}
</script>

<template>
    <main class="login">
        <BaseCard class="card">
            <form class="form" @submit.prevent="submit">
                <BaseInput v-model="form.name" class="input" id="login" type="text" placeholder="Логин"/>
                <BaseInput v-model="form.password" class="input" id="password" type="password" placeholder="Пароль"/>

                <PrimaryButton class="button" text="Войти"/>
            </form>

            <div v-if="form.errors" class="errors">
                <span v-for="error in form.errors" class="error">
                    {{error}}
                </span>
            </div>
        </BaseCard>
    </main>
</template>

<style scoped lang="scss">
.login {
    height: 100vh;
    width: 100vw;

    display: flex;
    align-items: center;
    justify-content: center;
}

.form {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;

    max-width: 200px;
    padding: 20px;
}

.card {
    margin-bottom: 200px;
}

.input {
    text-decoration: none;
}

.button {
    margin-top: 20px;
}

.errors {
    display: flex;
    flex-direction: column;

    .error {
        color: #cf2c2c;
    }
}
</style>