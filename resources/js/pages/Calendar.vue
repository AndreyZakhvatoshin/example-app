<template>
    <div class="container mx-auto p-4">
        <h1>Календарь для {{ service.title }}</h1>
        <div class="grid grid-cols-6 gap-4">
            <div v-for="day in days" :key="day.date" @click="selectDay(day.date)" class="cursor-pointer border p-2">
                {{ day.label }}
            </div>
        </div>
        <div v-if="selectedDate">
            <h2>Слоты на {{ selectedDate }}</h2>
            <ul>
                <li v-for="slot in slots" :key="slot" @click="selectSlot(slot)" class="cursor-pointer">
                    {{ slot }}
                </li>
            </ul>
        </div>
        <div v-if="selectedSlot">
            <form @submit.prevent="book">
                <input v-model="form.name" placeholder="Имя" required class="border p-2 mb-2" />
                <input v-model="form.phone" placeholder="Телефон" required class="border p-2 mb-2" />
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
                    Бронировать
                </button>
            </form>
        </div>
        <Modal v-if="showModal" @close="closeModal" :visible="showModal">
            {{ successMessage }}
        </Modal>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import Modal from '../components/Modal.vue';

const props = defineProps({ service: Object, days: Array });

const selectedDate = ref(null);
const slots = ref([]);
const selectedSlot = ref(null);
const showModal = ref(false);
const successMessage = ref('');
const form = ref({ name: '', phone: '' });

const selectDay = async (date) => {
    selectedDate.value = date;
    selectedSlot.value = null;
    const response = await fetch(`/api/service/${props.service.id}/slots/${date}`);
    slots.value = (await response.json()).slots;
};

const selectSlot = (slot) => {
    selectedSlot.value = slot;
};

const book = async () => {
    try {
        const response = await fetch('/api/book', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                service_id: props.service.id,
                date: selectedDate.value,
                slot: selectedSlot.value,
                name: form.value.name,
                phone: form.value.phone,
            })
        });

        const data = await response.json();

        if (response.ok && data.success) {
            showModal.value = true;
            successMessage.value = data.message || 'Бронирование успешно создано!';
        } else {
            alert('Ошибка: ' + (data.error || 'Не удалось забронировать'));
        }
    } catch (error) {
        alert('Ошибка сети: ' + error.message);
    }
};

const closeModal = () => {
    showModal.value = false;
    Inertia.visit('/');
};

</script>
