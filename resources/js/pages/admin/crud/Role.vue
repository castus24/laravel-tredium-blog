<script setup>
import {ref, reactive} from 'vue'
import {useToast} from "vue-toastification";
import AddForm from "@/components/admin/crud/AddForm.vue";
import UpdateForm from "@/components/admin/crud/UpdateForm.vue";
import DeleteForm from "@/components/admin/crud/DeleteForm.vue";

const roles = ref([])
const selectedRole = ref(null)
const itemsPerPage = ref(10)
const isLoading = ref(false)
const totalItems = ref(0)
const toast = useToast()

const headers = reactive([
    {title: "ID", key: "id", align: "start"},
    {title: "Name", key: "name", align: "start"},
    {title: "Guard", key: "guard_name", align: "start"},
    {title: "Edit", key: "edit", align: "center", sortable: false},
    {title: "Delete", key: "delete", align: "center", sortable: false},
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

const openModal = (type, tag = null) => {
    selectedRole.value = tag ? { ...tag } : null;
    modals[type] = true;

    if (type === 'add') {
        formConfig.value = {
            title: 'Add Role',
            fields: [
                { model: 'name', label: 'Name', type: 'text' },
                { model: 'guard_name', label: 'Guard', type: 'text' },
            ],
        };
    }
};

const closeModal = (type) => {
    selectedRole.value = null;
    modals[type] = false;
};

const loadRoles = async ({page, itemsPerPage, sortBy}) => {
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
        const response = await axios.get("/api/roles/list", {params})
        const {data, meta} = response.data
        roles.value = data
        totalItems.value = meta.total
    } catch (error) {
        console.error("Error loading roles:", error)
    } finally {
        isLoading.value = false
    }
};

const addRole = async (role) => {
    try {
        const {data} = await axios.post(`/api/roles`, role)
        roles.value.push(data.data)
        closeModal('add')
        toast.success(data.message)
    } catch (error) {
        console.error("Error adding role:", error)
        const errorMessage = error.response?.error || 'Error adding role';
        toast.error(errorMessage)
    }
}

const updateRole = async (updatedRole) => {
    try {
        const {data} = await axios.put(`/api/roles/${updatedRole.id}`, updatedRole)
        const index = roles.value.findIndex((role) => role.id === updatedRole.id)
        if (index !== -1) roles.value.splice(index, 1, data.data)
        closeModal('update')
        toast.success(data.message)

    } catch (error) {
        console.error("Error updating role:", error)
        const errorMessage = error.response?.error || 'Error updating role';
        toast.error(errorMessage)
    }
}

const deleteRole = async (roleForDelete) => {
    try {
        const {data} = await axios.delete(`/api/roles/${roleForDelete.id}`)
        roles.value = roles.value.filter((role) => role.id !== roleForDelete.id)
        closeModal('delete')
        toast.success(data.message)
    } catch (error) {
        console.error("Error deleting role:", error)
        const errorMessage = error.response?.error || 'Error deleting role';
        toast.error(errorMessage)
    }
}
</script>

<template>
    <v-container>
        <v-btn
            color="success"
            variant="tonal"
            class="mb-5"
            @click="openModal('add')"
        >
            Add Role
        </v-btn>

        <v-card elevation="5">
            <v-data-table-server
                v-model:items-per-page="itemsPerPage"
                :headers="headers"
                :items="roles"
                :items-length="totalItems"
                :loading="isLoading"
                @update:options="loadRoles"
            >
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

        <v-dialog v-model="modals.add" max-width="500px">
            <AddForm
                :title="formConfig.title"
                :fields="formConfig.fields"
                @save="addRole"
                @close="closeModal('add')"
            />
        </v-dialog>

        <v-dialog v-model="modals.update" max-width="500px">
            <UpdateForm
                v-if="selectedRole"
                :title="'Update Role'"
                :entity="selectedRole"
                :fields="[
                    { model: 'name', label: 'Name', type: 'text' },
                    { model: 'guard_name', label: 'Guard', type: 'text' },
                ]"
                @save="updateRole"
                @close="closeModal('update')"
            />
        </v-dialog>

        <v-dialog v-model="modals.delete" max-width="500px">
            <DeleteForm
                v-if="selectedRole"
                :title="'Delete Role'"
                :entity="selectedRole"
                :entityTitleKey="'name'"
                :message="'Are you sure you want to delete the role:'"
                @delete="deleteRole"
                @close="closeModal('delete')"
            />
        </v-dialog>
    </v-container>
</template>

