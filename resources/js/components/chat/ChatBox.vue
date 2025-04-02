<script setup lang="ts">
import Input from '../ui/input/Input.vue';
import Button from '../ui/button/Button.vue';
import { useDebounceFn } from '@vueuse/core';
import { router } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    receiver: {
        type: [null, Object]
    },
    messages: {
        type: [null, Object]
    }
});

const page = usePage();
const message = ref('');
const isTyping = ref(false);
const typingUserId = ref(null);
const user_messages = ref(props.messages);

const submit = () => {
    router.visit(route('chat.store', props.receiver.id), {
        method: 'post',
        data: {
            message: message.value
        },
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => message.value = ''
    });

    isTyping.value = false;
}

onMounted(() => {
    Echo.channel('chat.' + props.receiver.id + '_' + page.props.auth.user.id)
        .listen('ChatUserBroadcast', (e) => {
            pushMessage(e.message);
        })
        .listen('ChatTyping', (e) => {
            isTyping.value = e.typing;
            typingUserId.value = e.receiver_id;
        });
})

const pushMessage = (message) => {
    user_messages.value.push(message);
}

const typing = useDebounceFn(() => {
    router.visit(route('chat.typing', props.receiver.id), {
        method: 'patch',
        data: {
            typing: message.value.length ? true : false
        },
        preserveState: true,
        preserveScroll: true
    });
}, 500);

</script>

<template>
    <div class="bg-slate-300 w-4/5 h-full flex flex-col">
        <div v-if="props.receiver">
            <div class="font-bold pl-5 border border-bottom-2">
                {{ props.receiver.name }} ({{ props.receiver.email }})
            </div>
            <div class="h-full flex flex-col">
                <template v-for="message in user_messages" :key="message.id">
                    <div :class="[message.sender_id == $page.props.auth.user.id ? 'text-end' : 'text-start']">
                        {{ message.message }}
                    </div>
                </template>
                <div v-if="isTyping && $page.props.auth.user.id == typingUserId" class="text-start text-slate-500">
                    Typing...
                </div>
            </div>
            <div class="flex gap-1 p-2">
                <Input v-model="message" @input="typing()"/>
                <Button class="bg-slate-500" @click="submit()">Send</Button>
            </div>
        </div>
        <div v-else class="mx-auto my-auto">
            Select someone to chat!
        </div>
    </div>
</template>