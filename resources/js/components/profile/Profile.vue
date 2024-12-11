<script setup>
defineProps({
    user: Object
})
</script>

<template>
    <v-container>
        <v-row>
            <v-col>
                <v-avatar size="120">
                    <v-img
                        :src="user.avatar"
                        alt="User Avatar"
                        cover
                    />
                </v-avatar>
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
