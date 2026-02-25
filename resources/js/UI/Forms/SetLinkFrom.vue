<script setup lang="ts">

import BaseInput from "@/UI/Inputs/BaseInput.vue";
import PrimaryButton from "@/UI/Buttons/PrimaryButton.vue";
</script>

<template>
<form class="form">
    <div class="form__title">
        <span class="form__text">Укажите ссылку на Яндекс, пример</span>
        <span class="form__text form__link">https://yandex.ru/maps/org/samoye_populyarnoye_kafe/1010501395/reviews/</span>
    </div>

    <BaseInput type="text" id="url" name="url"/>
    <PrimaryButton class="submit" type="submit" text="Сохранить"/>
</form>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";

.form {
    display: flex;
    flex-direction: column;
    gap: 9px;

    &__title {
        display: flex;
        gap: 7px;
        align-items: center;
    }

    &__text {
        font-weight: 600;
        font-size: 12px;
        line-height: 20px;
        letter-spacing: 0.2px;
    }

    &__link {
        font-weight: 400;
        font-size: 12px;
        line-height: 100%;
        letter-spacing: 0;
        vertical-align: middle;
        text-decoration: underline;
        text-decoration-style: solid;
        text-decoration-thickness: 0;
        text-decoration-skip-ink: auto;
    }

    &__text, &__text {
        color: colors.$text-secondary;
    }

    &__input {
        min-width: 480px;
        border: 1px solid colors.$border-primary;
        border-radius: 6px;
        padding: 5px 14px;
        color: colors.$text-secondary;

        outline: none;
    }
}

.submit {
    margin-top: 9px;
}
</style>
