<script setup>
import Input from '../ui/input/Input.vue';
import Button from '../ui/button/Button.vue';
const props = defineProps({
    user: {
        type: [null, Object]
    }
});
</script>

<template>
    <div class="bg-slate-300 w-4/5 h-full flex flex-col">
        <div v-if="user">
            <div class="font-bold pl-5 border border-bottom-2">
                {{ user.name }} ({{ user.email }})
            </div>
            <div class="h-full">
                Body
            </div>
            <div class="flex gap-1 p-2">
                <Input/>
                <Button class="bg-slate-500">Send</Button>
            </div>
        </div>
        <div v-else class="mx-auto my-auto">
            Select someone to chat!
        </div>
    </div>
</template>