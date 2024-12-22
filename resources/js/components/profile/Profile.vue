<script setup>
import Avatar from "@/components/profile/Avatar.vue";

defineProps({
    user: Object
})
</script>

<template>
    <v-container>
        <v-col v-if="user.avatar">
            <Avatar
                :avatar="user.avatar"
                :size="120"
            />
        </v-col>
        <v-col>
            {{ user.name }}
        </v-col>
        <v-col>
            {{ user.email }}
        </v-col>
    </v-container>
</template>
