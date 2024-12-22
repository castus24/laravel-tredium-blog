<script setup>
defineProps({
    avatar: String,
    size: Number
})
</script>

<template>
    <v-avatar :size="size">
        <v-img
            :src="avatar"
            cover
        />
    </v-avatar>
</template>
