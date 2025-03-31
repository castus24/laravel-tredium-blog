<script setup>
import { reactive } from "vue";

const props = defineProps({
    user: Object,
});

const emit = defineEmits(["update-user", "close"]);

const editedUser = reactive({ ...props.user });

const saveChanges = () => {
    emit("update-user", editedUser);
    emit("close");
};
</script>

<template>
    <v-container>
        <v-card
            prepend-icon="mdi-account"
            title="Edit Profile"
        >
            <v-card-text>
                <v-form>
                    <v-text-field v-model="editedUser.name" label="Name"></v-text-field>
                    <v-text-field v-model="editedUser.email" label="Email"></v-text-field>
                </v-form>
            </v-card-text>

            <v-divider></v-divider>

            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    text="Close"
                    variant="plain"
                    @click="$emit('close')"
                ></v-btn>

                <v-btn
                    color="blue-darken-3"
                    text="Save"
                    variant="tonal"
                    @click="saveChanges"
                ></v-btn>
            </v-card-actions>
        </v-card>
    </v-container>
</template>
