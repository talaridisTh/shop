import {reactive, ref} from "vue"

export default function useDelete() {

    const confirm = reactive({
        delete: false,
        restore: false
    });
    const onClose = (value, action) => {
        confirm[action] = value
    }
    const selectedModel = ref(null);
    const selectedModelToAction = (user, action) => {
        selectedModel.value = user
        confirm[action] = true;
    }

    return {
        confirm,
        onClose,
        selectedModel,
        selectedModelToAction
    }
}