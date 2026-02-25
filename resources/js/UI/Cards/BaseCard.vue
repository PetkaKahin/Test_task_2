<script setup lang="ts">

</script>

<template>
    <div class="card">
        <slot/>
    </div>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";

.card {
    border: 1px solid colors.$border-primary;
    border-radius: 12px;
    background-color: colors.$bg-base;
    box-shadow: 0 1px 6px 0 colors.$shadow-primary;

    width: fit-content;
}
</style>