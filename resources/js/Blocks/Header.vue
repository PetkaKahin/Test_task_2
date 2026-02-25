<script setup lang="ts">
import ExitIco from "@/UI/Icons/ExitIco.vue";
import {Link} from "@inertiajs/vue3";
import {route} from "ziggy-js";

interface IProps {
    className?: string;
}

const props = defineProps<IProps>()
</script>

<template>
    <header class="page-header" :class="props.className">
        <Link class="logout" :href="route('logout')">
            <ExitIco class="logout__ico"/>
        </Link>
    </header>
</template>

<style scoped lang="scss">
@use "@scss/variables/colors";

.page-header {
    display: flex;
    justify-content: flex-end;

    height: 75px;
    border-bottom: 1px solid colors.$border-primary;
}

.logout {
    margin: 17px 46px 17px;
}
</style>
