<script setup lang="ts">

import BaseCard from "@/UI/Cards/BaseCard.vue";
import VoidStarIco from "@/UI/Icons/VoidStarIco.vue";
import StarIco from "@/UI/Icons/StarIco.vue";
import StarLine from "@/Blocks/StarLine.vue";

interface IProps {
    avgFeedback: number,
    feedbackCount: number,
}

const props = defineProps<IProps>()
</script>

<template>
    <BaseCard>
        <div class="all-feedbacks-card">
            <header class="header">
                <span class="header__text">{{props.avgFeedback}}</span>

                <StarLine :feedback="4.7"/>
            </header>

            <div class="body">
                <span class="body__text">Всего отзывов: {{feedbackCount}}</span>
            </div>
        </div>
    </BaseCard>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";

.all-feedbacks-card {
    padding: 18px 16px;
}

.header {
    display: flex;
    gap: 10px;
    border-bottom: 2px solid colors.$border-card;
    padding-bottom: 9px;

    &__text {
        font-weight: 500;
        font-size: 40px;
        line-height: 100%;
        letter-spacing: 0;
    }
}

.body {
    margin: 16px 0 47px 0;

    &__text {
        font-weight: 700;
        font-size: 12px;
        line-height: 100%;
        letter-spacing: 0;
    }
}
</style>