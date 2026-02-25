<script setup lang="ts">
import BaseLayout from "@/Layouts/BaseLayout.vue";
import LocationIco from "@/UI/Icons/LocationIco.vue";
import {useAsideMenu} from "@/composables/useAsideMenu.ts";
import {onMounted} from "vue";
import AllFeedbacksCard from "@/UI/Cards/AllFeedbacksCard.vue";
import FeedbackCard from "@/UI/Cards/FeedbackCard.vue";

onMounted(() => {
    useAsideMenu().setActiveItem('feedback')
})
</script>

<template>
    <BaseLayout>
        <section class="page">
            <header class="header">
                <LocationIco class="header__ico"/>
                <span class="header__text">Яндекс Карты</span>
            </header>

            <main class="content">
                <FeedbackCard
                    data="12.09.2022 14:22"
                    username="Наталья"
                    phone="+7 900 540 40 40"
                    firm="Филиал 1"
                    :feedbackNumber="5"
                    feedbackText="Так, с чего начать... Разнообразная алкогольная продукция, множество закусок и обычных блюд. Кухня вкусная и
Разнообразная, от супа и салатов до мясных продуктов. Персонал молодые девушки, общительная и доброжелательные,
всегда подскажут, вовремя принесут и вызовут такси. Отдыхали на летней веранде, свежо и тепло, в общем самое то в
жаркую погоду. Сами залы не сильно рассмотрел, но видел что они удобные и просторные. "
                />
            </main>

            <aside class="menu">
                <AllFeedbacksCard :avg-feedback="4.7" :feedbackCount="1145"/>
            </aside>
        </section>
    </BaseLayout>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";

.page {
    display: grid;
    grid-template-columns: auto auto;
    grid-template-rows: auto auto;
    grid-template-areas:
    "header header"
    "content aside";
    gap: 20px;
    margin: 17px 26px;
}

.header {
    grid-area: header;
    display: flex;
    align-items: center;

    border: 1px solid colors.$border-primary;
    border-radius: 8px;
    width: fit-content;

    &__ico {
        margin: 6px 0 3px 6px;
    }

    &__text {
        font-weight: 500;
        font-size: 12px;
        line-height: 100%;
        letter-spacing: 0;

        padding: 5px;
    }
}

.content {
    grid-area: content;
}

.aside {
    grid-area: aside;
}
</style>
