<template>
    <div v-if="visible" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="w-full max-w-md rounded-lg bg-white p-6 shadow-xl">
            <div class="text-center">
                <slot></slot>
            </div>
            <button
                @click="$emit('close')"
                class="mt-4 w-full rounded-md bg-blue-500 px-4 py-2 text-white hover:bg-blue-600">
                Закрыть
            </button>
        </div>
    </div>
</template>
<script setup>
defineProps({
    visible: Boolean
});
defineEmits(['close']);
</script>
