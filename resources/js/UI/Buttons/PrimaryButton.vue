<script setup lang="ts">
interface IProps {
    text?: string;
    type?: 'button' | 'submit'
}

const props = defineProps<IProps>();
</script>

<template>
    <button class="button" :type="props.type">
        <span class="button__text">{{ props.text }}</span>
    </button>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";

.button {
    border: 1px solid colors.$button-primary;
    border-radius: 6px;
    background-color: colors.$button-primary;
    width: fit-content;
    cursor: pointer;

    &__text {
        font-family: 'inter', sans-serif;
        font-weight: 600;
        font-size: 14px;
        line-height: 100%;
        letter-spacing: 0;
        text-align: center;
        vertical-align: middle;
        color: colors.$text-inverse;

        display: inline-block;
        margin: 3px 26px 5px 26px;
    }
}
</style>
