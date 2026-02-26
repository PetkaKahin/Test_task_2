<script setup lang="ts">
import {computed} from "vue";

type PageItem = number | '...'

interface IProps {
    currentPage: number
    totalPages: number
    maxVisible?: number
}

const props = withDefaults(defineProps<IProps>(), {
    maxVisible: 7,
})

const emit = defineEmits<{
    (e: 'change', page: number): void
}>()

const pages = computed<PageItem[]>(() => {
    if (props.totalPages <= props.maxVisible) {
        return Array.from({length: props.totalPages}, (_, i) => i + 1)
    }

    const side = Math.floor((props.maxVisible - 3) / 2)

    let winStart = Math.max(2, props.currentPage - side)
    let winEnd = Math.min(props.totalPages - 1, props.currentPage + side)

    // компенсируем сжатие у краёв
    const targetWindowSize = props.maxVisible - 2 // минус first и last
    // если левый ellipsis есть — он занимает 1 слот, иначе 0
    const leftEllipsis = winStart > 2 ? 1 : 0
    const rightEllipsis = winEnd < props.totalPages - 1 ? 1 : 0
    const numbersNeeded = targetWindowSize - leftEllipsis - rightEllipsis

    if (winEnd - winStart + 1 < numbersNeeded) {
        if (winStart === 2) {
            // прижаты к левому краю — расширяем вправо
            winEnd = Math.min(props.totalPages - 1, winStart + numbersNeeded - 1)
        } else if (winEnd === props.totalPages - 1) {
            // прижаты к правому краю — расширяем влево
            winStart = Math.max(2, winEnd - numbersNeeded + 1)
        }
    }

    const result: PageItem[] = [1]

    if (winStart > 2) result.push('...')
    for (let i = winStart; i <= winEnd; i++) result.push(i)
    if (winEnd < props.totalPages - 1) result.push('...')

    result.push(props.totalPages)

    return result
})

const hasPrev = computed(() => props.currentPage > 1)
const hasNext = computed(() => props.currentPage < props.totalPages)

function onPage(page: number) {
    if (page === props.currentPage) return
    emit('change', page)
}
</script>

<template>
    <nav class="pagination" v-if="totalPages > 1">
        <button
            class="pagination__button pagination__button--arrow"
            :disabled="!hasPrev"
            @click="onPage(currentPage - 1)"
        >
            &lsaquo;
        </button>

        <template v-for="(item, i) in pages" :key="i">
            <span v-if="item === '...'" class="pagination__ellipsis">…</span>
            <button
                v-else
                class="pagination__button"
                :class="{'pagination__button--active': item === currentPage}"
                @click="onPage(item)"
            >
                {{ item }}
            </button>
        </template>

        <button
            class="pagination__button pagination__button--arrow"
            :disabled="!hasNext"
            @click="onPage(currentPage + 1)"
        >
            &rsaquo;
        </button>
    </nav>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";

.pagination {
    display: flex;
    align-items: center;
    width: fit-content;
    gap: 4px;
    margin: 0 auto;

    &__button {
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border: 1px solid colors.$border-primary;
        border-radius: 6px;
        background-color: colors.$bg-base;
        color: colors.$text-primary;
        font-family: 'Mulish', sans-serif;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: background-color 0.15s, color 0.15s, border-color 0.15s;

        &:hover:not(:disabled):not(.pagination__button--active) {
            background-color: colors.$gray-25;
            border-color: colors.$gray-100;
        }

        &--active {
            background-color: colors.$button-primary;
            border-color: colors.$button-primary;
            color: colors.$text-inverse;
            cursor: default;
        }

        &--arrow {
            font-size: 18px;
            line-height: 1;
        }

        &:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }
    }

    &__ellipsis {
        min-width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: colors.$text-secondary;
        font-size: 13px;
        user-select: none;
    }
}
</style>
