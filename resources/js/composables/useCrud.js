import {ref, reactive} from 'vue';
import {useToast} from 'vue-toastification';

export function useCrud(apiEndpoint) {
    const items = ref([]);
    const selectedItem = ref(null);
    const itemsPerPage = ref(10);
    const isLoading = ref(false);
    const totalItems = ref(0);
    const toast = useToast();

    const modals = reactive({
        add: false,
        show: false,
        update: false,
        delete: false,
    });

    const openModal = (type, item = null) => {
        selectedItem.value = item ? {...item} : null;
        modals[type] = true;
    };

    const closeModal = (type) => {
        selectedItem.value = null;
        modals[type] = false;
    };

    const loadItems = async ({page, itemsPerPage, sortBy}) => {
        isLoading.value = true;
        const sortParam = sortBy?.length
            ? sortBy.map((sort) => (sort.order === 'desc' ? `-${sort.key}` : sort.key)).join(',')
            : '';
        const params = {page, itemsPerPage, sort: sortParam};
        try {
            const {data} = await axios.get(apiEndpoint, {params});
            items.value = data.data;
            totalItems.value = data.meta.total;
        } catch (error) {
            console.error(`Error loading items from ${apiEndpoint}:`, error);
        } finally {
            isLoading.value = false;
        }
    };

    const addItem = async (newItem) => {
        try {
            const {data} = await axios.post(apiEndpoint, newItem);
            items.value.push(data.data);
            closeModal('add');
            toast.success(data.message);
        } catch (error) {
            console.error(`Error adding item to ${apiEndpoint}:`, error);
            toast.error(error.response?.data?.message || 'Error adding item');
        }
    };

    const updateItem = async (updatedItem) => {
        try {
            const {data} = await axios.put(`${apiEndpoint}/${updatedItem.id}`, updatedItem);
            const index = items.value.findIndex((item) => item.id === updatedItem.id);
            if (index !== -1) items.value.splice(index, 1, data.data);
            closeModal('update');
            toast.success(data.message);
        } catch (error) {
            console.error(`Error updating item in ${apiEndpoint}:`, error);
            toast.error(error.response?.data?.message || 'Error updating item');
        }
    };

    const deleteItem = async (id) => {
        try {
            const {data} = await axios.delete(`${apiEndpoint}/${id}`);
            items.value = items.value.filter((item) => item.id !== id);
            closeModal('delete');
            toast.success(data.message);
        } catch (error) {
            console.error(`Error deleting item from ${apiEndpoint}:`, error);
            toast.error(error.response?.data?.message || 'Error deleting item');
        }
    };

    return {
        items,
        selectedItem,
        itemsPerPage,
        isLoading,
        totalItems,
        modals,
        openModal,
        closeModal,
        loadItems,
        addItem,
        updateItem,
        deleteItem,
    };
}
