import {watch} from "vue"
import {pickBy, throttle} from "lodash";
import {Inertia} from "@inertiajs/inertia";

export default function useFilter(form, model) {

    const limitFilter = [10, 20, 50, 100];
    const onSort = (name) => {
        form.sort = name;
        form.order = form.order === "asc" ? 'desc' : 'asc';

    }
    const removeFilter = (filter) => {
        if (filter === "sort") {
            form.order = null
        }
        form[filter] = null

    }

    watch(() => form, () => {
        throttle(() => {
            Inertia.get(route(`${model}.index`), pickBy(form), {preserveState: true});
        }, 500)();
    }, {deep: true})

    return {
        onSort, removeFilter, limitFilter
    }
}
