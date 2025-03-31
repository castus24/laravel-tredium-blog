<script setup>
const props = defineProps({
    entity: {
        type: Object,
        required: true,
    },
    entityTitleKey: {
        type: String,
        default: 'title',
    },
    title: {
        type: String,
        default: 'Confirm Deletion',
    },
    message: {
        type: String,
        default: 'Are you sure you want to delete this item?',
    },
});

const emit = defineEmits(['delete', 'close']);

const confirmDelete = () => {
    emit('delete', props.entity);
};
</script>

<template>
    <v-card>
        <v-card-title class="text-h5">{{ title }}</v-card-title>
        <v-card-text>
            {{ message }}
            <strong>{{ entity?.[entityTitleKey] }}</strong>?
        </v-card-text>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="red" @click="confirmDelete">Delete</v-btn>
            <v-btn color="blue-grey" @click="$emit('close')">Cancel</v-btn>
        </v-card-actions>
    </v-card>
</template>
