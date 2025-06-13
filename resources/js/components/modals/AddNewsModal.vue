<script setup>
import { ref, onMounted } from 'vue'
import { useForm } from '@inertiajs/vue3'

// IMAGES
import closeWhite from '@/assets/images/icons/close_white.svg'
import editForm from '@/assets/images/icons/edit_form.svg'
import addImage from '@/assets/images/icons/add_image.svg'

const emit = defineEmits(['close', 'submit'])
defineProps(['isNewsModalOpen'])

const form = useForm({
    title: '',
    description: '',
    avatar: null,
})

const previewImage = ref('')
const onAvatarChange = (event) => {
    const file = event.target.files[0]
    if (file) {
        const reader = new FileReader()
        reader.onload = (e) => {
            previewImage.value = e.target.result
        }
        reader.readAsDataURL(file)
        form.avatar = file
    }
}
const submitForm = () => {
    const componentEmit = emit;

    form.post(route('news.store'), {
        preserveScroll: true,
        onSuccess: () => {
            clearForm();
            componentEmit('close');
        },
        onError: (e) => {
            console.error('Ошибка:', e)
        }
    });
}
const clearForm = () => {
    form.reset()
    previewImage.value = ''
}
const saveFormToLocalStorage = () => {
    const formWithoutFile = { ...form }
    delete formWithoutFile.avatar

    localStorage.setItem('newsFormData', JSON.stringify(formWithoutFile))
    alert('Форма сохранена как черновик')
}
onMounted(() => {
    const savedData = localStorage.getItem('newsFormData');
    if (savedData) {
        const parsedData = JSON.parse(savedData);
        for (const key in form) {
            if (parsedData.hasOwnProperty(key)) {
                form[key] = parsedData[key];
            }
        }
    }
});
</script>

<template>
    <teleport to="body">
        <div class="fixed bg-black/75 items-center justify-center flex inset-0 z-[9999] w-screen min-h-dvh"
            @click.self="$emit('close')">
            <transition name="modal">
                <div v-show="isNewsModalOpen"
                    class="bg-white z-[10000] rounded-2xl shadow-2xl shadow-black/50 max-w-1/3 max-lg:max-w-[90%] min-h-[90dvh] max-lg:min-h-auto w-full transform scale-95 opacity-0 transition-all duration-500 relative flex flex-col"
                    :class="{ 'scale-100 opacity-100': true }">
                    <div class="flex w-full justify-between items-center p-4 bg-dark-blue rounded-t-2xl">
                        <p class="text-[#EAEAEA] text-xs uppercase font-semibold tracking-wider">Добавить новость</p>
                        <button @click="$emit('close')"
                            class="text-gray-500 hover:text-gray-700 focus:outline-none cursor-pointer">
                            <img :src="closeWhite" alt="closeWhite" />
                        </button>
                    </div>

                    <div class="flex gap-4 justify-center items-center p-6 max-lg:overflow-scroll">
                        <form @submit.prevent="submitForm"
                            class="flex flex-col gap-3 h-auto items-start justify-start w-full">
                            <p class="text-xs uppercase font-normal tracking-wider">Новая запись</p>
                            <div class="flex items-end gap-3 w-full">
                                <div class="flex flex-col justify-end gap-2 w-full">
                                    <p>
                                        Заголовок новости
                                        <sup class="text-red-500 text-sm">*</sup>
                                    </p>
                                    <input v-model="form.title" required
                                        class="text-light-gray border border-light-gray rounded-lg py-1 outline-none px-2"
                                        type="text" />
                                </div>
                            </div>
                            <div class="flex flex-col justify-end gap-2 w-full">
                                <p>
                                    Описание к новости
                                    <sup class="text-red-500 text-sm">*</sup>
                                </p>
                                <textarea v-model="form.description" rows="8" required
                                    class="text-light-gray border resize-none border-light-gray rounded-lg py-2 outline-none px-3"
                                    type="text"></textarea>
                            </div>
                            <div class="flex max-lg:flex-col gap-3 items-center w-3/4">
                                <div
                                    class="relative w-full rounded-2xl min-h-20 max-h-20 overflow-hidden flex justify-center items-center border-2 transition-all duration-500 ease-in-out hover:border-accent border-black cursor-pointer">
                                    <img :src="previewImage || addImage" alt="Аватар"
                                        :class="previewImage ? 'size-full' : 'size-6'"
                                        class="object-cover object-center" />
                                    <input required type="file" @change="onAvatarChange" accept="image/*"
                                        class="w-full h-full absolute top-0 left-0 opacity-0 cursor-pointer" />
                                </div>
                                <p>Добавить фото</p>
                            </div>
                            <div class="flex justify-end w-full">
                                <div class="flex max-lg:flex-col max-lg:items-center pt-12 justify-end gap-4">
                                    <button type="button" @click="clearForm"
                                        class="w-auto text-xs text-accent transition-all duration-500 ease-in-out hover:border-accent border-b border-transparent text-center whitespace-nowrap cursor-pointer">Очистить
                                        форму</button>
                                    <button type="button" @click="saveFormToLocalStorage"
                                        class="px-4 py-2 text-accent border border-accent outline-none flex gap-2 rounded-full cursor-pointer whitespace-nowrap items-center">
                                        <img class="w-auto h-[1.5cap]" :src="editForm" alt="editForm" />
                                        <span class="text-xs">Сохранить как черновик</span>
                                    </button>
                                    <button type="submit"
                                        class="w-auto px-6 py-3 text-xs text-white bg-accent rounded-full text-center whitespace-nowrap cursor-pointer">Опубликовать</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </transition>
        </div>
    </teleport>

</template>