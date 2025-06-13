<script setup>
import { ref, computed } from 'vue'
import TableRowsDetailsComponent from '@/components/TableRowsDetailsComponent.vue'
import AddCargoModal from '@/components/modals/AddCargoModal.vue'
import AppLayout from '@/layouts/AppLayout.vue'
import { usePage } from '@inertiajs/vue3'

// IMAGES
import cancel from '@/assets/images/icons/cancel.svg'
import arrowDown from '@/assets/images/icons/arrow_down.svg'
import arrowWhite from '@/assets/images/icons/arrow_white.svg'

// FILTERS
const isOpen = ref(false)
const toggle = () => {
    isOpen.value = !isOpen.value
}
// END FILTERS

const isCargoModalOpen = ref(false)
const openCargoModal = () => {
    isCargoModalOpen.value = true
}
const closeCargoModal = () => {
    isCargoModalOpen.value = false
}

const user = computed(() => usePage().props.auth.user)
const cargos = computed(() => usePage().props.cargos || [])

const filters = ref({
    loading_country: '',
    unloading_country: '',
    weight_from: null,
    weight_to: null,
    company_search: '',
    volume_from: null,
    volume_to: null,
    body_type: '',
    has_nds: null,
    has_prepayment: null,
})

const filteredCargos = computed(() => {
    return cargos.value.filter(cargo => {
        let match = true

        if (filters.value.loading_country && cargo.loading_country !== filters.value.loading_country) {
            match = false
        }

        if (filters.value.unloading_country && cargo.unloading_country !== filters.value.unloading_country) {
            match = false
        }

        if (filters.value.weight_from && cargo.weight_tons < filters.value.weight_from) {
            match = false
        }

        if (filters.value.weight_to && cargo.weight_tons > filters.value.weight_to) {
            match = false
        }

        if (filters.value.volume_from && cargo.volume_m3 < filters.value.volume_from) {
            match = false
        }

        if (filters.value.volume_to && cargo.volume_m3 > filters.value.volume_to) {
            match = false
        }

        if (filters.value.body_type && cargo.body_type !== filters.value.body_type) {
            match = false
        }

        if (filters.value.has_nds !== null && cargo.has_nds !== filters.value.has_nds) {
            match = false
        }

        if (filters.value.has_prepayment !== null && cargo.has_prepayment !== filters.value.has_prepayment) {
            match = false
        }

        if (filters.value.company_search && !cargo.company.name.includes(filters.value.company_search)) {
            match = false
        }

        return match
    })
})

const resetFilters = () => {
    filters.value = {
        loading_country: '',
        unloading_country: '',
        weight_from: null,
        weight_to: null,
        volume_from: null,
        volume_to: null,
        body_type: '',
        has_nds: null,
        has_prepayment: null,
    }
}
</script>

<template>
    <AppLayout class="flex flex-col items-start">
        <AddCargoModal :is-modal-open="isCargoModalOpen" v-if="isCargoModalOpen" @close="closeCargoModal" />

        <section
            class="flex flex-col gap-8 p-10 pt-12 max-lg:p-6 ml-[20%] max-xl:ml-[25%] w-[80%] max-xl:w-3/4 max-lg:max-xl:w-full max-lg:ml-0">
            <div
                class="flex max-md:flex-col-reverse justify-between w-full max-w-1/2 max-lg:justify-center max-lg:gap-4 max-lg:max-w-full items-center font-bold">
                <button @click="openCargoModal"
                    class="bg-dark-blue hover:border-dark-blue hover:bg-transparent border-transparent border-2 hover:text-dark-border transition-all duration-300 ease-in-out cursor-pointer text-white w-auto px-4 py-2 rounded-xl shadow-xl shadow-black/25 text-base flex items-center justify-between gap-4">
                    Добавить Груз
                    <span class="text-2xl">+</span>
                </button>
                <h1 class="font-bold text-3xl text-light-gray text-center font-alumini">Поиск груза</h1>
            </div>

            <div class="flex max-xl:flex-col max-2xl:flex-wrap max-xl:items-center gap-2 max-sm:w-full">
                <div class="flex flex-col justify-end gap-2 max-xl:w-3/4 max-sm:w-full">
                    <p>Загрузка</p>
                    <select v-model="filters.loading_country"
                        class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer">
                        <option value="">Выберите страну</option>
                        <option value="Россия">Россия</option>
                        <option value="Украина">Украина</option>
                        <option value="Грузия">Грузия</option>
                        <option value="Беларусь">Беларусь</option>
                        <option value="Литва">Литва</option>
                        <option value="Армения">Армения</option>
                    </select>
                </div>

                <div class="flex flex-col justify-end gap-2 max-xl:w-3/4 max-sm:w-full">
                    <select v-model="filters.loading_city"
                        class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer">
                        <option value="">Выберите город</option>
                        <option value="Москва">Москва</option>
                        <option value="Киев">Киев</option>
                        <option value="Тбилиси">Тбилиси</option>
                        <option value="Минск">Минск</option>
                        <option value="Вильнюс">Вильнюс</option>
                        <option value="Ереван">Ереван</option>
                    </select>
                </div>

                <div class="flex flex-col justify-end">
                    <div class="bg-accent rounded-full w-auto h-auto gap-1 px-1.5 py-2 -z-10">
                        <img :src="arrowWhite" alt="arrowWhite" />
                        <img class="rotate-180" :src="arrowWhite" alt="arrowWhite" />
                    </div>
                </div>

                <div class="flex flex-col justify-end gap-2 max-xl:w-3/4 max-sm:w-full">
                    <p>Разгрузка</p>
                    <select v-model="filters.unloading_country"
                        class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer">
                        <option value="">Выберите страну</option>
                        <option value="Россия">Россия</option>
                        <option value="Украина">Украина</option>
                        <option value="Грузия">Грузия</option>
                        <option value="Беларусь">Беларусь</option>
                        <option value="Литва">Литва</option>
                        <option value="Армения">Армения</option>
                    </select>
                </div>

                <div class="flex flex-col justify-end gap-2 max-xl:w-3/4 max-sm:w-full">
                    <select v-model="filters.body_type"
                        class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer"
                        name="#">
                        <option value="">Выберите тип кузова</option>
                        <option value="Открытый кузов">Открытый кузов</option>
                        <option value="Закрытый кузов">Закрытый кузов</option>
                        <option value="Холодильный контейнер">Холодильный контейнер</option>
                    </select>
                </div>

                <div class="flex gap-3 pt-2 max-sm:flex-col max-sm:items-center">
                    <div @click="resetFilters" class="flex items-end gap-2 cursor-pointer">
                        <img class="pb-2" :src="cancel" alt="cancel" />
                        <p class="pb-1">Сбросить</p>
                    </div>
                    <div class="flex items-end">
                        <div class="flex justify-center items-center gap-3">
                            <button @click="applyFilters"
                                class="px-4 py-1 text-accent border border-accent outline-none rounded-2xl cursor-pointer">Применить</button>
                            <hr class="w-full min-w-12 min-h-px text-light-gray" />
                            <button @click="toggle"
                                class="filter-bttn flex gap-1 whitespace-nowrap text-light-gray cursor-pointer items-center">
                                <p>Все фильтры</p>
                                <img class="transition-all duration-500 ease-in-out" :class="{ 'rotate-180': isOpen }"
                                    :src="arrowDown" alt="arrowDown" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILTERS -->

            <div ref="content" :class="{
                'max-h-[1200px] py-5 opacity-100': isOpen,
                'max-h-0 py-0 opacity-0': !isOpen
            }"
                class="filter-content overflow-hidden transition-all duration-500 ease-in-out border-t border-light-gray grid grid-cols-[1fr_1fr_0.5fr_1fr] max-xl:grid-cols-2 max-sm:grid-cols-1 gap-4 mt-4">

                <div class="flex flex-col gap-3 h-auto items-start justify-start w-full">
                    <div class="flex items-end gap-3 w-full">
                        <div class="flex flex-col justify-end gap-2">
                            <p>Дата загрузки</p>
                            <input name="search"
                                class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase min-w-40 max-sm:min-w-36"
                                type="date" />
                        </div>
                        <input name="search"
                            class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase min-w-40 max-sm:min-w-36"
                            type="date" />
                    </div>
                    <div class="flex flex-col justify-end gap-2 w-full">
                        <p>Тип загрузки</p>
                        <select v-model="filters.loading_type"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer w-full"
                            name="#">
                            <option value="">Выберите тип загрузки</option>
                            <option value="Платформа">Платформа</option>
                            <option value="Фура">Фура</option>
                            <option value="Шасси">Шасси</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-3 h-auto items-start justify-start w-full">
                    <div class="flex items-end gap-3 w-full">
                        <div class="flex flex-col justify-end gap-2">
                            <p>Дата разгрузки</p>
                            <input name="search"
                                class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase min-w-40 max-sm:min-w-36"
                                type="date" />
                        </div>
                        <input name="search"
                            class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none uppercase min-w-40 max-sm:min-w-36"
                            type="date" />
                    </div>
                    <div class="flex flex-col justify-end gap-2 w-full">
                        <p>Тип кузова</p>
                        <select v-model="filters.body_type"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer w-full"
                            name="#">
                            <option value="">Выберите тип кузова</option>
                            <option value="Открытый кузов">Открытый кузов</option>
                            <option value="Закрытый кузов">Закрытый кузов</option>
                            <option value="Холодильный контейнер">Холодильный контейнер</option>
                        </select>
                    </div>
                    <form class="flex flex-col justify-end gap-1 w-full">
                        <p>Дополнительные параметры</p>
                        <label class="flex items-center gap-2" for="attribute2">
                            <input class="rounded-full" type="radio" name="attribute1" id="attribute2"
                                v-model="filters.load_type" value="догруз" />
                            Догруз
                        </label>
                        <label class="flex items-center gap-2" for="attribute3">
                            <input class="rounded-full" type="radio" name="attribute1" id="attribute3"
                                v-model="filters.load_type" value="отдельная машина" />
                            Отдельная машина
                        </label>
                    </form>
                </div>

                <div class="flex flex-col gap-3 h-auto items-start justify-start">
                    <div class="flex flex-col items-start justify-start gap-3">
                        <div class="flex flex-col justify-end gap-2">
                            <p>Вес, т</p>
                            <div class="flex gap-3">
                                <input placeholder="От" v-model.number="filters.weight_from"
                                    class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none capitalize max-w-16 px-1"
                                    type="number" />
                                <input placeholder="До" v-model.number="filters.weight_to"
                                    class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none capitalize max-w-16 px-1"
                                    type="number" />
                            </div>
                        </div>
                        <div class="flex flex-col justify-end gap-2">
                            <p>Объём, м³</p>
                            <div class="flex gap-3">
                                <input placeholder="От" v-model.number="filters.volume_from"
                                    class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none capitalize max-w-16 px-1"
                                    type="number" />
                                <input placeholder="До" v-model.number="filters.volume_to"
                                    class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none capitalize max-w-16 px-1"
                                    type="number" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col gap-3 h-auto items-start justify-start">
                    <div class="flex flex-col justify-end gap-2 w-full">
                        <p>Название компании / ИНН / ID</p>
                        <input v-model="filters.company_search" placeholder="Поиск компании по названию, ИНН или ID"
                            type="text"
                            class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none w-full"
                            name="#" />
                    </div>
                    <div class="flex flex-col justify-end gap-2 w-full">
                        <p>Ставка</p>
                        <div class="p-2 flex flex-col justify-end gap-2 w-full">
                            <p>Цена</p>
                            <div class="flex gap-2">
                                <input placeholder="От" v-model.number="filters.price_from"
                                    class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none capitalize max-w-16 px-1"
                                    type="number" />
                                <input placeholder="До" v-model.number="filters.price_to"
                                    class="text-light-gray border border-light-gray rounded-lg py-0.5 outline-none capitalize max-w-16 px-1"
                                    type="number" />
                                <select v-model="filters.currency"
                                    class="text-light-gray border border-light-gray rounded-lg px-2 py-1 outline-none cursor-pointer w-full uppercase"
                                    name="#">
                                    <option value="">Валюта</option>
                                    <option value="RUB">RUB</option>
                                    <option value="USD">USD</option>
                                </select>
                            </div>
                            <div class="flex items-start gap-4">
                                <form class="flex flex-col justify-end gap-1 w-full">
                                    <p>НДС</p>
                                    <label class="flex items-center gap-2" for="attribute5">
                                        <input class="rounded-full" type="radio" name="#" id="attribute5"
                                            v-model="filters.has_nds" value="true" />
                                        С НДС
                                    </label>
                                    <label class="flex items-center gap-2" for="attribute6">
                                        <input class="rounded-full" type="radio" name="#" id="attribute6"
                                            v-model="filters.has_nds" value="false" />
                                        Без НДС
                                    </label>
                                </form>
                                <form class="flex flex-col justify-end gap-1 w-full">
                                    <p>Предоплата</p>
                                    <label class="flex items-center gap-2" for="attribute8">
                                        <input class="rounded-full" type="radio" name="#" id="attribute8"
                                            v-model="filters.has_prepayment" value="true" />
                                        Да
                                    </label>
                                    <label class="flex items-center gap-2" for="attribute9">
                                        <input class="rounded-full" type="radio" name="#" id="attribute9"
                                            v-model="filters.has_prepayment" value="false" />
                                        Нет
                                    </label>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- END FILTERS -->

            <div>
                <table class="w-full max-xl:w-3/4 divide-y-2 divide-black/25 max-xl:hidden">
                    <thead class="text-dark-blue">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                ID</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Место загрузки</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Место разгрузки</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Информация о грузе</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Цена</th>
                            <th scope="col"
                                class="px-6 py-3 text-start text-xs font-medium uppercase tracking-wider whitespace-nowrap">
                                Заказчик</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-[#B2B2B2] overflow-y-auto text-[#424242]">
                        <tr v-for="cargo in filteredCargos" :key="cargo.id">
                            <td class="px-6 py-2 whitespace-nowrap text-sm">00{{ cargo.id }}</td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm">
                                <p><b>{{ cargo.loading_country }}.</b> {{ cargo.loading_city }}</p>
                                <p>{{ cargo.loading_date }}</p>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm">
                                <p><b>{{ cargo.unloading_country }}.</b> {{ cargo.unloading_city }}</p>
                                <p>{{ cargo.unloading_date }}</p>
                            </td>
                            <TableRowsDetailsComponent :cargo="cargo" />
                            <td class="px-6 py-2 whitespace-nowrap text-sm">
                                <p class="font-semibold">{{ cargo.price }} {{ cargo.currency }} RUB</p>
                                <p class="text-light-gray">{{ cargo.has_nds ? 'С НДС' : 'Без НДС' }}</p>
                                <p class="text-light-gray">{{ cargo.has_prepayment ? 'С предоплатой' : 'Без предоплаты'
                                    }}</p>
                            </td>
                            <td class="px-6 py-2 whitespace-nowrap text-sm">
                                <p class="font-semibold">{{ cargo.company.name }}</p>
                                <p class="text-light-gray">{{ cargo.company.phone }}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="grid grid-cols-3 max-sm:grid-cols-1 gap-4 xl:hidden w-full">
                    <div v-for="cargo in filteredCargos" :key="cargo.id"
                        class="flex flex-col items-start justify-center bg-light p-4 rounded-2xl">
                        <p class="font-semibold">ID</p>
                        <p>00{{ cargo.id }}</p>

                        <p class="font-semibold mt-2">Место загрузки</p>
                        <p><b>{{ cargo.loading_country }}.</b> {{ cargo.loading_city }}</p>
                        <p class="text-light-gray">{{ cargo.loading_date }}</p>

                        <p class="font-semibold mt-2">Место разгрузки</p>
                        <p><b>{{ cargo.unloading_country }}.</b> {{ cargo.unloading_city }}</p>
                        <p class="text-light-gray">{{ cargo.unloading_date }}</p>

                        <p class="font-semibold mt-2">Информация о грузе</p>
                        <p>{{ cargo.weight_tons }}т. {{ cargo.volume_m3 }}м³</p>
                        <p class="text-light-gray">{{ cargo.body_type }}</p>
                        <p class="text-light-gray">{{ cargo.loading_type }}</p>
                        <p class="text-light-gray">Дополнительная информация:</p>
                        <p class="text-light-gray text-xs whitespace-normal">{{ cargo.additional_info }}</p>

                        <p class="font-semibold mt-2">Цена</p>
                        <p class="font-semibold">{{ cargo.price }} {{ cargo.currency }}</p>
                        <p class="text-light-gray">{{ cargo.has_nds ? 'С НДС' : 'Без НДС' }}</p>
                        <p class="text-light-gray">{{ cargo.has_prepayment ? 'С предоплатой' : 'Без предоплаты' }}</p>

                        <p class="font-semibold mt-2">Заказчик</p>
                        <p class="font-semibold">{{ cargo.company.name }}</p>
                        <p class="text-light-gray">{{ cargo.company.phone }}</p>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>