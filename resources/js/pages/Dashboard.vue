<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import ChatBox from '@/components/chat/ChatBox.vue';
import ChatList from '@/components/chat/ChatList.vue';
import { ref } from 'vue';

const props = defineProps({
    users: {
        type: Object
    },
    receiver: {
        type: [null, Object]
    },
    messages: {
        type: [null, Object]
    }
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const setUser = (selectedUser) => {
    router.visit(route('chat.get', selectedUser.id), {
        method: 'get',
        preserveScroll: true
    });
}
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="w-full h-full flex flex-row">
                <ChatList :users="props.users" @selected-user="(selected_user) => setUser(selected_user)"/>
                <ChatBox :receiver="props.receiver" :messages="props.messages"/>
            </div>
        </div>
    </AppLayout>
</template>
