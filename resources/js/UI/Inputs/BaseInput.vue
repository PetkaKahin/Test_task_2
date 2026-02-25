<script setup lang="ts">
interface Props {
    name?: string,
    id?: string,
    type?: "text" | "password",
    string?: string,
    placeholder?: string,
}

const props: Props = defineProps<Props>()
const model = defineModel<string>()
</script>

<template>
    <input v-model="model" class="input" :type="props.type" :id="props.id" :name="props.name" :placeholder="props.placeholder"/>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";

.input {
    font-weight: 400;
    font-size: 12px;
    line-height: 100%;
    letter-spacing: 0;
    vertical-align: middle;
    text-decoration: underline;
    text-decoration-style: solid;
    text-decoration-thickness: 0;
    text-decoration-skip-ink: auto;

    border: 1px solid colors.$border-primary;
    border-radius: 6px;
    padding: 5px 14px;
    color: colors.$text-secondary;
    outline: none;
}
</style>
