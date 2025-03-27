<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import ChatBox from '@/components/chat/ChatBox.vue';
import ChatList from '@/components/chat/ChatList.vue';
import { ref } from 'vue';

const props = defineProps({
    users: {
        type: Object
    }
});

const user = ref(null);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const setUser = (selectedUser) => {
    user.value = selectedUser;
}
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="w-full h-full flex flex-row">
                <ChatList :users="users" @selected-user="(selected_user) => setUser(selected_user)"/>
                <ChatBox :user="user"/>
            </div>
        </div>
    </AppLayout>
</template>
