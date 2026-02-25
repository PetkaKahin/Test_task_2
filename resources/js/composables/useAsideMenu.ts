import {ref} from "vue";
import {route} from "ziggy-js";

const items = ref<IItem[]>([
    {
        key: 'reviews',
        text: "Отзывы",
        url: route('reviews.show'),
        isActive: false,
    },
    {
        key: 'settings',
        text: "Настройка",
        url: route('settings.show'),
        isActive: false,
    }
])

export interface IItem {
    key: string
    text: string
    url: string
    isActive: boolean
}

export const useAsideMenu = () => {
    function setActiveItem(key: string) {
        const itemActive = items.value.find(item => item.key === key)
        const oldItemActive = items.value.find(item => item.isActive === true)

        if (oldItemActive) oldItemActive.isActive = false
        if (itemActive) itemActive.isActive = true
    }

    return {
        items,
        setActiveItem,
    }
}
