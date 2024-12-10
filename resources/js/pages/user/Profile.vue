<script setup>
import {reactive} from "vue";

const user = reactive({
    name: null,
    email: null,
})
</script>

<template>
    <div>
        <h2 class="mb-4 primary--text headline">Your Profile</h2>

        <v-card>
            <v-card-text>
                <v-text-field
                    label="Name"
                    v-model="user.name"
                    filled
                    readonly
                    hide-details
                    class="mb-4"
                ></v-text-field>

                <v-text-field
                    label="Email"
                    v-model="user.email"
                    filled
                    readonly
                    hide-details
                ></v-text-field>
            </v-card-text>
        </v-card>
    </div>
</template>
