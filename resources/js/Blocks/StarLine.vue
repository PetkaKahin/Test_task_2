<script setup lang="ts">

import VoidStarIco from "@/UI/Icons/VoidStarIco.vue";
import StarIco from "@/UI/Icons/StarIco.vue";

interface IProps {
    review: number
    sizeStar?: number
    gap?: number
}

const props = defineProps<IProps>()
</script>

<template>
    <article class="star-line">
        <div
            v-for="i in 5"
            :key="i"
            class="star-line__item"
            :style="{ gap: props.gap || '9px' }"
        >
            <StarIco v-if="props.review >= i" :size="props.sizeStar"/>
            <VoidStarIco v-else :size="props.sizeStar"/>
        </div>
    </article>
</template>

<style scoped lang="scss">
.star-line {
    display: flex;
    align-items: flex-end;

    &__item {
        height: fit-content;
    }
}
</style>