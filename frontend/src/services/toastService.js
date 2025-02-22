import {useToast} from "vue-toastification";

function toastHandler(type, title=null) {
    const toast = useToast();
    if (type == 'success')
        toast.success(this.$t('success'));
    else if (type == 'error')
        toast.error(this.$t('errors'));
    else
        toast.info(title);
}

export default toastHandler;
