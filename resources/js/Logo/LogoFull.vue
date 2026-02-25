<script setup lang="ts">

import LogoIco from "@/UI/Icons/LogoIco.vue";
import LogoText from "@/Logo/LogoText.vue";
</script>

<template>
    <article class="logo">
        <LogoIco/>
        <LogoText/>
    </article>
</template>

<style scoped lang="scss">
.logo {
    display: flex;
    gap: 10px;
    align-items: flex-end;
}
</style>
