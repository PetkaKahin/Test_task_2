<script setup lang="ts">

import BaseCard from "@/UI/Cards/BaseCard.vue";
import LocationIco from "@/UI/Icons/LocationIco.vue";
import StarLine from "@/Blocks/StarLine.vue";

interface IProps {
    data: string,
    username: string,
    phone: string,
    firm: string,
    reviewText: string,
    reviewNumber: number,
}

const props = defineProps<IProps>()
</script>

<template>
    <BaseCard>
        <article class="review-card">
            <header class="header">
                <div class="left-block">
                    <h3 class="header__text">{{props.data}}</h3>
                    <h3 class="header__text">{{props.firm}}</h3>
                </div>
                <div class="center-block">
                    <LocationIco/>
                </div>
                <div class="right-block">
                    <StarLine :review="props.reviewNumber" :sizeStar="14" :gap="9"/>
                </div>
            </header>

            <div class="body">
                <div class="contacts">
                    <h3 class="contacts__username">{{ props.username }}</h3>
                    <h3 class="contacts__phone">{{props.phone}}</h3>
                </div>
                <p class="body__text">{{ props.reviewText }}</p>
            </div>
        </article>
    </BaseCard>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";

.review-card {
    background-color: colors.$bg-elevated;
    border-radius: 12px;
    margin: 13px 0 13px 15px;
    padding: 6px 26px 17px 3px;
}

.header {
    display: grid;
    align-items: center;
    grid-template-columns: auto 1fr auto;
    gap: 10px;
    margin-bottom: 12px;

    &__text {
        font-weight: 700;
        font-size: 12px;
        line-height: 100%;
        letter-spacing: 0;
    }

    .left-block {
        display: flex;
        gap: 10px;
    }
}

.body {
    &__text {
        font-weight: 400;
        font-size: 12px;
        line-height: 100%;
        letter-spacing: 0;

        margin: 4px 0 0 0;
    }
}

.contacts {
    display: flex;
    align-items: center;
    gap: 12px;

    &__username {
        font-weight: 700;
        font-size: 12px;
        line-height: 100%;
        letter-spacing: 0;
    }

    &__phone {
        font-weight: 700;
        font-size: 10px;
        line-height: 100%;
        letter-spacing: 0;
    }
}

h3 {
    margin: 0;
}
</style>