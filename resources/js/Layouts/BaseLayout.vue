<script setup lang="ts">

import Header from "@/Blocks/Header.vue";
import SideMenu from "@/Blocks/SideMenu.vue";
</script>

<template>
    <div class="base-layout">
        <SideMenu className="side-menu"/>
        <Header class="header"/>
        <main class="page">
            <slot/>
        </main>
    </div>
</template>

<style scoped lang="scss">
@use "@scss/base";
@use "@scss/variables/colors";

.base-layout {
    display: grid;
    grid-template-columns: auto 1fr;
    grid-template-rows: auto 1fr;
    grid-template-areas:
        "side-menu header"
        "side-menu page";
}

.header {
    grid-area: header;
}

.side-menu {
    grid-area: side-menu;
}

.page {
    grid-area: page;
}
</style>
