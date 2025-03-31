<script setup>
import {ref, reactive} from 'vue'
import {useToast} from "vue-toastification";
import axios from "@/plugins/axios";
import UpdateForm from "@/components/admin/crud/UpdateForm.vue";
import DeleteForm from "@/components/admin/crud/DeleteForm.vue";
import ShowForm from "@/components/admin/crud/ShowForm.vue";

const users = ref([])
const selectedUser = ref(null)
const itemsPerPage = ref(10)
const isLoading = ref(false)
const totalItems = ref(0)
const toast = useToast()

const headers = reactive([
    {title: "ID", key: "id", align: "start"},
    {title: "Name", key: "name", align: "start"},
    {title: "Email", key: "email", align: "start"},
    {title: "Role", key: "role", align: "start"},
    {title: "Show", key: "show", align: "center", sortable: false, width: "100px"},
    {title: "Edit", key: "edit", align: "center", sortable: false, width: "100px"},
    {title: "Delete", key: "delete", align: "center", sortable: false, width: "100px"},
]);

const modals = reactive({
    add: false,
    show: false,
    update: false,
    delete: false,
});

const formConfig = ref({
    title: '',
    fields: [],
});

const openModal = (type, user = null) => {
    selectedUser.value = user ? {...user} : null;
    modals[type] = true;
};

const closeModal = (type) => {
    selectedUser.value = null;
    modals[type] = false;
};

const loadUsers = async ({page, itemsPerPage, sortBy}) => {
    isLoading.value = true

    const sortParam = sortBy?.length
        ? sortBy.map((sort) => (sort.order === "desc" ? `-${sort.key}` : sort.key)).join(",")
        : "";

    const params = {
        page,
        itemsPerPage,
        sort: sortParam,
    };

    try {
        const response = await axios.get("/api/users/list", {params})
        const {data, meta} = response.data
        users.value = data.map(user => ({
            ...user,
            role: user.roles?.length ? user.roles.map(role => role.name).join(', ') : 'No Role'
        }));
        totalItems.value = meta.total
    } catch (error) {
        console.error("Error loading users:", error)
    } finally {
        isLoading.value = false
    }
};

const showUser = async (user) => {
    try {
        const {data} = await axios.get(`/api/users/${user.id}`)
        users.value = data.data
        closeModal('show')
        toast.success(data.message)
    } catch (error) {
        console.error("Error showing user:", error)
        const errorMessage = error.response?.error || 'Error showing user';
        toast.error(errorMessage)
    }
}

const updateUser = async (updatedUser) => {
    try {
        const {data} = await axios.put(`/api/users/${updatedUser.id}`, updatedUser)
        const index = users.value.findIndex((user) => user.id === updatedUser.id)
        if (index !== -1) users.value.splice(index, 1, data.data)
        closeModal('update')
        toast.success(data.message)

    } catch (error) {
        console.error("Error updating user:", error)
        const errorMessage = error.response?.error || 'Error updating user';
        toast.error(errorMessage)
    }
}

const deleteUser = async (userForDelete) => {
    try {
        const {data} = await axios.delete(`/api/users/${userForDelete.id}`)
        users.value = users.value.filter((user) => user.id !== userForDelete.id)
        closeModal('delete')
        toast.success(data.message)
    } catch (error) {
        console.error("Error deleting user:", error)
        const errorMessage = error.response?.error || 'Error deleting user';
        toast.error(errorMessage)
    }
}
</script>

<template>
    <v-container>
        <v-card elevation="5">
            <v-data-table-server
                v-model:items-per-page="itemsPerPage"
                :headers="headers"
                :items="users"
                :items-length="totalItems"
                :loading="isLoading"
                @update:options="loadUsers"
            >
                <template #item.show="{ item }">
                    <v-btn color="info"
                           variant="tonal"
                           @click="openModal('show', item)"
                    >
                        <v-icon>mdi-eye</v-icon>
                    </v-btn>
                </template>

                <template #item.edit="{ item }">
                    <v-btn
                        color="warning"
                        variant="tonal"
                        @click="openModal('update', item)"
                    >
                        <v-icon>mdi-pencil</v-icon>
                    </v-btn>
                </template>

                <template #item.delete="{ item }">
                    <v-btn
                        color="red"
                        variant="tonal"
                        @click="openModal('delete', item)"
                    >
                        <v-icon>mdi-delete</v-icon>
                    </v-btn>
                </template>
            </v-data-table-server>
        </v-card>

        <v-dialog v-model="modals.show" max-width="500">
            <ShowForm
                v-if="selectedUser"
                :entity="selectedUser"
                :titleKey="'title'"
                :contentKey="'content'"
                :imageKey="'main'"
                @close="closeModal('show')"
            />
        </v-dialog>

        <v-dialog v-model="modals.update" max-width="500">
            <UpdateForm
                v-if="selectedUser"
                :title="'Update User'"
                :entity="selectedUser"
                :fields="[
                    { model: 'title', label: 'Title', type: 'text' },
                    { model: 'content', label: 'Content', type: 'textarea' },
                ]"
                @save="updateUser"
                @close="closeModal('update')"
            />
        </v-dialog>

        <v-dialog v-model="modals.delete" max-width="500">
            <DeleteForm
                v-if="selectedUser"
                :title="'Delete User'"
                :entity="selectedUser"
                :entityTitleKey="'title'"
                :message="'Are you sure you want to delete the user:'"
                @delete="deleteUser"
                @close="closeModal('delete')"
            />
        </v-dialog>
    </v-container>
</template>
