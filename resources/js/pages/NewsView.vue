<script setup>
import AppLayout from '@/layouts/AppLayout.vue'
import AddNewsModal from '@/components/modals/AddNewsModal.vue'
import { usePage, router } from '@inertiajs/vue3'
import { computed, ref } from 'vue'

// IMAGES
import placeholder_news from '@/assets/images/placeholder_news.webp'

const user = computed(() => usePage().props.auth.user)
const news = computed(() => usePage().props.news || [])

const formatDate = (dateString) => {
    const date = new Date(dateString)
    const today = new Date()
    if (date.toDateString() === today.toDateString()) {
        return 'Сегодня'
    }
    const yesterday = new Date(today)
    yesterday.setDate(yesterday.getDate() - 1)
    if (date.toDateString() === yesterday.toDateString()) {
        return 'Вчера'
    }

    return `${date.getDate()}.${date.getMonth() + 1}.${date.getFullYear()}`
}

const formatTime = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
}

const isNewsModalOpen = ref(false)

const openNewsModal = () => {
    isNewsModalOpen.value = true
}
const closeNewsModal = () => {
    isNewsModalOpen.value = false
}
const deleteNews = (newsItemId) => {
    if (confirm('Вы уверены, что хотите удалить эту новость?')) {
        router.delete(route('news.destroy', newsItemId), {
            onSuccess: () => { console.log('success') },
            onError: (errors) => {
                console.error(errors)
            }
        })
    }
}
</script>

<template>
    <AppLayout
        class="flex flex-col items-start ml-[20%] max-xl:ml-[25%] w-[80%] max-xl:w-3/4 max-lg:max-xl:w-full max-lg:ml-0">
        <AddNewsModal :is-news-modal-open="isNewsModalOpen" v-if="isNewsModalOpen" @close="closeNewsModal" />

        <section class="w-full flex flex-col p-12 max-sm:gap-8 max-sm:p-6 gap-12">
            <div class="flex max-lg:flex-col justify-start max-lg:items-end max-lg:text-end gap-6 items-center">
                <button @click="openNewsModal" v-if="user?.is_admin"
                    class="bg-dark-blue hover:border-dark-blue font-semibold hover:bg-transparent border-transparent border-2 hover:text-dark-border transition-all duration-300 ease-in-out cursor-pointer text-white w-auto px-4 py-2 rounded-xl shadow-xl shadow-black/25 text-base flex items-center justify-between gap-4">
                    Добавить Новость
                    <span class="text-2xl">+</span>
                </button>
                <h1 class="text-3xl font-normal">Новости и отрасли грузоперевозок</h1>
            </div>
            <div class="flex max-sm:flex-col justify-between items-start gap-6">
                <img class="w-1/2 max-sm:w-full h-auto object-center object-cover max-h-[320px] shadow-xl shadow-accent/50 rounded-lg"
                    :src="placeholder_news" alt="placeholder_news" />
                <div class="flex flex-col w-1/3 max-sm:w-full gap-4">
                    <h2 class="text-3xl font-normal">Сейчас читают</h2>
                    <hr class="min-h-px border border-light-gray" />
                    <ul v-for="newsItem in news" :key="newsItem.id" class="gap-4 flex flex-col">
                        <li>{{ newsItem.title }}</li>
                    </ul>
                </div>
            </div>
            <div v-for="newsItem in news" :key="newsItem.id"
                class="flex max-sm:flex-col gap-10 items-start justify-start">
                <img class="object-cover object-center w-auto h-auto max-w-1/3 max-sm:max-w-full rounded-lg shadow-xl shadow-accent/50"
                    :src="newsItem.avatar ? '/storage/' + newsItem.avatar : placeholder_news" :alt="newsItem.title" />
                <div class="flex flex-col items-start w-1/3 max-lg:w-1/2 max-sm:w-full gap-4">
                    <div class="flex justify-between gap-6 items-center">
                        <h2 class="text-3xl font-normal">
                            {{ newsItem?.created_at ? formatDate(newsItem.created_at) : '' }}
                        </h2>
                        <p class="text-2xl font-normal">
                            {{ newsItem?.created_at ? formatTime(newsItem.created_at) : '' }}
                        </p>
                    </div>
                    <h3 class="text-2xl">{{ newsItem.title }}</h3>
                    <p class="text-base">{{ newsItem.description }}</p>
                    <button v-if="user?.is_admin" :id="newsItem.id" @click="deleteNews(newsItem.id)"
                        class="px-4 py-1 text-accent border border-accent outline-none rounded-2xl cursor-pointer">Удалить
                        новость</button>
                </div>
            </div>
        </section>
    </AppLayout>
</template>