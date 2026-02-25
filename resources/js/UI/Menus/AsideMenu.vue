<script setup lang="ts">
import type {Component} from "vue";
import {Link} from "@inertiajs/vue3";
import {useAsideMenu} from "@/composables/useAsideMenu.ts";

interface IProps {
    ico: Component
    text: string
}

const {items, setActiveItem} = useAsideMenu()
const props = defineProps<IProps>()
</script>

<template>
    <div class="aside-menu">
        <header class="header selector">
            <component class="header__ico" :is="props.ico"/>
            <h3 class="header__text">{{ props.text }}</h3>
        </header>

        <ul class="aside-menu__list">
            <li
                class="aside-menu__item item"
                v-for="(item, i) in items"
                :key="i"
            >
                <Link
                    class="item__link"
                    :class="{
                        'item__link--active selector': item.isActive,
                    }"
                    :href="item.url"
                    @click.prevent="setActiveItem(i)"
                >
                    <span class="item__text">{{ item.text }}</span>
                </Link>
            </li>
        </ul>
    </div>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";
@use "@scss/mixins/mixins";

.aside-menu {
    margin-top: 28px;

    &__list {
        margin: 12px 0 0 0;
        padding: 0;
    }
}

.header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 16px 14px;

    &__text {
        font-weight: 500;
        font-size: 16px;
        line-height: 100%;
        letter-spacing: 0;
        margin: 0;
    }
}

.item {
    list-style-type: none;
    margin-top: 2px;

    &:hover {
        @include mixins.selector;
    }

    &__link {
        text-decoration: none;
        display: block;
    }

    &__text {
        display: block;
        padding: 4px 50px;

        font-weight: 500;
        font-size: 12px;
        line-height: 100%;
        letter-spacing: 0;
    }
}
</style>
