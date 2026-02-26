import {ref} from "vue";
import {apiRequest} from "@/shared/api/apiRequest.ts";
import {route} from "ziggy-js";

export interface IReview {
    author?: {
        name?: string
        professionLevel?: string
    }
    text: string
    updatedTime: string
    rating: number
}

interface IPagination {
    current_page: number
    total_pages: number
}

interface IReviewsResponse {
    reviews: IReview[]
    count_reviews: number
    rating: number
    name: string
    pagination: IPagination
}

const PAGE_SIZE = 50

function getPageFromUrl(): number {
    const param = new URLSearchParams(window.location.search).get('page')
    const parsed = parseInt(param ?? '', 10)
    return parsed > 0 ? parsed : 1
}

function setPageInUrl(page: number) {
    const url = new URL(window.location.href)
    url.searchParams.set('page', String(page))
    history.replaceState(null, '', url.toString())
}

export const useYandexReviews = () => {
    const reviews = ref<IReview[]>([])
    const countReviews = ref<number>(0)
    const rating = ref<number>(0)
    const name = ref<string>('')
    const currentPage = ref<number>(1)
    const totalPages = ref<number>(1)
    const isLoading = ref<boolean>(false)

    async function fetchReviews(page: number = getPageFromUrl()) {
        isLoading.value = true

        try {
            const response = await apiRequest.get<IReviewsResponse>(
                route('yandex_reviews.index', {page, page_size: PAGE_SIZE})
            )

            const data = response.data
            reviews.value = data.reviews ?? []
            countReviews.value = data.count_reviews ?? 0
            rating.value = data.rating ?? 0
            name.value = data.name ?? ''
            currentPage.value = data.pagination?.current_page ?? currentPage.value
            totalPages.value = data.pagination?.total_pages ?? totalPages.value

            setPageInUrl(currentPage.value)
        } finally {
            isLoading.value = false
        }
    }

    function goToPage(page: number) {
        if (page < 1 || page > totalPages.value || page === currentPage.value) return
        fetchReviews(page)
    }

    return {
        reviews,
        countReviews,
        rating,
        name,
        currentPage,
        totalPages,
        isLoading,
        fetchReviews,
        goToPage,
    }
}
