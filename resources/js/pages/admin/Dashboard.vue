<script setup>
import {ref} from "vue"
import {useRouter} from "vue-router"

const router = useRouter()

const items = ref([
    {title: 'Articles', route: {name: "articlesCrud"}},
    {title: 'Tags', route: {name: "tagsCrud"}},
    {title: 'Roles', route: {name: "rolesCrud"}},
    {title: 'Permissions', route: {name: "permissionCrud"}},
    {title: 'Users', route: {name: "usersCrud"}},
])

const navigate = (route) => {
    router.push(route)
}
</script>

<template>
    <v-container class="mt-3 mb-6">
        <v-row>
            <v-col
                cols="12"
                sm="4"
                v-for="(item, index) in items"
                :key="index"
            >
                <v-card>
                    <v-card-title>{{ item.title }}</v-card-title>

                    <v-card-text class="bg-surface-light pt-4">
                        <v-btn
                            class="ma-2"
                            color="primary"
                            @click="navigate(item.route)"
                        >
                            Go to {{ item.title }}
                            <v-icon
                                icon="mdi-arrow-right"
                                end
                            ></v-icon>
                        </v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
