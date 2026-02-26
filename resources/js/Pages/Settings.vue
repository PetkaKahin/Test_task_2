<script setup lang="ts">
import BaseLayout from "@/Layouts/BaseLayout.vue";
import SetLinkFrom from "@/UI/Forms/SetLinkFrom.vue";
import {onMounted} from "vue";
import {useAsideMenu} from "@/composables/useAsideMenu.ts";

onMounted(() => {
    useAsideMenu().setActiveItem('settings')
})

interface IProps {
    url?: string;
}

const props = defineProps<IProps>()
</script>

<template>
    <BaseLayout>
        <section class="page">
            <header class="header">
                <h2 class="header__text">Подключить Яндекс</h2>
            </header>

            <SetLinkFrom :defaultUrl="props.url" />
        </section>
    </BaseLayout>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";

.page {
    display: flex;
    flex-direction: column;
    gap: 15px;

    margin: 18px 35px;
}

.header {
    &__text {
        font-weight: 600;
        font-size: 16px;
        line-height: 20px;
        letter-spacing: 0.2px;
        margin: 0;

        color: colors.$text-darker;
    }
}
</style>
