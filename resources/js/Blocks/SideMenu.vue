<script setup lang="ts">
import LogoFull from "@/Logo/LogoFull.vue";
import AsideMenu from "@/UI/Menus/AsideMenu.vue";
import WrenchIco from "@/UI/Icons/WrenchIco.vue";

interface IProps {
    className?: string;
}

const props = defineProps<IProps>()
</script>

<template>
    <aside class="page-aside" :class="props.className">
        <header class="page-aside__header">
            <LogoFull/>
        </header>

        <span class="page-aside__account-name">Название аккаунта</span>

        <AsideMenu :ico="WrenchIco" text="Отзывы"/>
    </aside>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";

.page-aside {
    padding: 15px;
    background-color: colors.$bg-elevated;

    min-height: 100vh;
    min-width: 280px;
    box-sizing: border-box;
    box-shadow: 0 4px 3px 0 #E5E5E5;


    &__header {
        margin: 15px 0 0 14px;
    }

    &__account-name {
        font-weight: 700;
        font-size: 16px;
        line-height: 20px;
        letter-spacing: 0.2px;
        vertical-align: middle;

        display: inline-block;
        margin-top: 14px;
        color: colors.$text-secondary
    }
}

.menu {
    display: flex;
    margin-top: 28px;
}
</style>
