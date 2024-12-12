<script setup>
import Avatar from "@/components/profile/Avatar.vue";

defineProps({
    user: Object
})
</script>

<template>
    <v-container>
        <v-row>
            <v-col>
                <Avatar
                    :avatar="user.avatar"
                    :size="120"
                />
            </v-col>
        </v-row>
            <v-col>
                {{ user.name }}
            </v-col>
        <v-row>
            <v-col>
                {{ user.email }}
            </v-col>
        </v-row>
    </v-container>
</template>
