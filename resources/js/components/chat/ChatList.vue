<script setup>

const props = defineProps({
    users: {
        type: Object
    }
});

const emit = defineEmits(['selectedUser']);
</script>

<template>
    <div class="bg-slate-400 w-1/5">
        <div class="flex border" v-for="user in users">
            <button class="w-full p-2 bg-red-200 text-black" @click="$emit('selectedUser', user)">
                {{ user.name }}
            </button>
        </div>
    </div>
</template>