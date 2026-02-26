<script setup lang="ts">
import BaseLayout from "@/Layouts/BaseLayout.vue";
import LocationIco from "@/UI/Icons/LocationIco.vue";
import {useAsideMenu} from "@/composables/useAsideMenu.ts";
import {onMounted} from "vue";
import AllReviewsCard from "@/UI/Cards/AllReviewsCard.vue";
import ReviewCard from "@/UI/Cards/ReviewCard.vue";
import BasePagination from "@/UI/Paginations/BasePagination.vue";
import {useYandexReviews} from "@/composables/useYandexReviews.ts";
import dayjs from 'dayjs'
import utc from 'dayjs/plugin/utc'
import timezone from 'dayjs/plugin/timezone'

dayjs.extend(utc)
dayjs.extend(timezone)

const {
    reviews,
    countReviews,
    rating,
    name,
    currentPage,
    totalPages,
    isLoading,
    fetchReviews,
    goToPage,
} = useYandexReviews()

const formatDate = (iso: string) => {
    return dayjs(iso).tz('Europe/Moscow').format('DD.MM.YYYY HH:mm')
}

onMounted(() => {
    useAsideMenu().setActiveItem('reviews')
    fetchReviews()
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
                <div class="none-review" v-if="isLoading">
                    <h1>Загружаем отзывы...</h1>
                </div>

                <template v-else>
                    <div class="none-review" v-if="countReviews == 0">
                        <h1>Не удалось загрузить отзывы :(</h1>
                    </div>

                    <ReviewCard
                        class="content__card"
                        v-for="(review, i) in reviews"
                        :key="i"
                        :data="formatDate(review.updatedTime)"
                        :username="review.author?.name ?? 'Аноним'"
                        :phone="review.author?.professionLevel ?? 'нет данных'"
                        :firm="name"
                        :reviewNumber="review.rating"
                        :reviewText="review.text"
                    />

                    <BasePagination
                        :current-page="currentPage"
                        :total-pages="totalPages"
                        @change="goToPage"
                    />
                </template>
            </main>

            <aside class="menu">
                <AllReviewsCard :avg-review="rating" :reviewCount="countReviews"/>
            </aside>
        </section>
    </BaseLayout>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";

.page {
    display: grid;
    grid-template-columns: 1fr auto;
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
    display: flex;
    flex-direction: column;
    gap: 20px;
    width: 100%;

    &__card {
        width: 100%;
    }
}

.aside {
    grid-area: aside;
}
</style>
