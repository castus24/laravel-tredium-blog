<script>
export default {
    data() {
        return {
            chips: [],
            tags: [],
        }
    },
    mounted() {
        this.loadTags();
    },
    methods: {
        async loadTags() {
            try {
                const response = await axios.get('api/tags');
                this.tags = response.data.data.map((tag) => tag.label);
            } catch (error) {
                console.log('Tags loading error: ', error)
            }
        },
        remove(tag) {
            this.chips.splice(this.chips.indexOf(tag), 1)
        },
    },
}
</script>

<template>
    <v-combobox
        v-model="chips"
        :items="tags"
        variant="solo"
        chips
        clearable
        multiple
        placeholder="Add tags"
    >
        <template v-slot:selection="{ attrs, tag, select, selected }">
            <v-chip
                v-bind="attrs"
                :model-value="selected"
                closable
                @click="select"
                @click:close="remove(tag)"
            >
                <strong>{{ tag }}</strong>
                <span>(interest)</span>
            </v-chip>
        </template>
    </v-combobox>
</template>

<style scoped>

</style>
