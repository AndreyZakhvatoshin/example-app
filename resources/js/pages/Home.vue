<template>
    <div class="container mx-auto p-4">
        <h1>Доступные услуги</h1>
        <ul>
            <li v-for="service in services" :key="service.id">
                <a :href="`/service/${service.id}/calendar`">{{ service.title }} ({{ service.duration_minutes }} мин)</a>
            </li>
        </ul>
        <Modal v-if="showModal" @close="closeModal">
            {{ successMessage }}
        </Modal>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import Modal from '../components/Modal.vue';

const props = defineProps({ services: Array });

// Читаем данные из сессии (флаг успеха)
const { props: pageProps } = usePage();
const showModal = ref(!!pageProps.success);
const successMessage = ref(pageProps.success || '');

const closeModal = () => {
    showModal.value = false;
};
</script>
