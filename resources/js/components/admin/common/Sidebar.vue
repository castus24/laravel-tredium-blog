<script setup>
import {useAuthStore} from "@/stores/auth.js"
import {computed} from "vue"

const authStore = useAuthStore()

const user = computed(() => authStore.userData)
</script>

<template>
    <v-layout style="border-top: 1px solid #673AB7">
        <v-list color="transparent" class="w-100">
            <v-list-item
                v-if="user"
                :prepend-avatar="user.avatar"
                :prepend-icon="!user.avatar ? 'mdi-account' : undefined"
                :subtitle="user.email"
                :title="user.name"
                class="mb-3"
            ></v-list-item>

            <v-divider></v-divider>
            <v-list>
                <v-list-item title="Articles" :to="{name: 'articlesCrud'}"/>
                <v-list-item title="Tags" :to="{name: 'tagsCrud'}"></v-list-item>
                <v-list-item title="Roles" :to="{name: 'rolesCrud'}"></v-list-item>
                <v-list-item title="Permissions" :to="{name: 'permissionsCrud'}"></v-list-item>
                <v-list-item title="Users" :to="{name: 'usersCrud'}"></v-list-item>
            </v-list>
        </v-list>
    </v-layout>
</template>
